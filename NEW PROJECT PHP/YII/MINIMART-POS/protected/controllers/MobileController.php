<?php

class MobileController extends Controller
{    
    public $username;
    public $password;
    public $isPassencoded;
    public $rolename;
    public $hash_id;
    public function actionIndex()
    {
        $this->returnJsonResponse(Helper::CONST_InternalServerError, array(), Helper::CONST_Request_Not_Allowed);
    }    
    public function actionLogin()
    {
        $postedData = $this->getPostedData();
        if(empty($postedData['login']))
        {
            $this->username = '';
        }
        else
        {
            $this->username = $postedData['login'];
        }
        if(empty($postedData['pass']))
        {
            $this->password = '';
        }
        else
        {
            $this->password = $postedData['pass'];
        }
        $this->isPassencoded = 0;//(isset($postedData['isPassencoded'])?$postedData['isPassencoded']:false);
        $this->doAuthenticate();
    }
    public function doAuthenticate()
    {
        $rtn = Yii::app()->controller->checkForLogin($this->username, $this->password, $this->isPassencoded, $appConfigs, Helper::CONST_Non_su, $rtnisnonsu);
        if(!is_a($rtn, 'Personcompanyrole'))        
        {
            if ( $rtn === Helper::CONST_InternalServerError )
            {
                $msg = Helper::CONST_INVALID_CONFIG;
            }
            else
            {
                $msg = Helper::CONST_WRONG_USER_PWD;
            }
            $this->returnJsonResponse(Helper::CONST_InternalServerError, array(), $msg);
        }
        else
        {
            $rec = array();
            $rec['user']['id'] = $rtn->person->id;
            $rec['user']['hash_id'] = $rtn->login->hash_id;
            $rec['user']['login'] = $rtn->login->login;
            $rec['user']['role'] = $rtn->role->role;
            $rec['user']['geo_update_frq'] = $rtn->person->geo_update_frq;            
            $this->returnJsonResponse(Helper::CONST_Error_None, $rec, Helper::CONST_LOGIN_SUCCESS);
        }
    }
    public function actionGeolocations()
    {
        $rtn = false;
        $trans = Yii::app()->db->beginTransaction();
        try
        {
            $postedData = $this->getPostedData();
            if(empty($postedData[0]))
            {//single object one job-onestatus
                $postedData =array($postedData);
            }
            else
            {
                //multiple as array of jobid=status
            }
            foreach($postedData as $single)
            {
                $longitude = (isset($single['lng'])?$single['lng']:null);
                $latitude = (isset($single['lat'])?$single['lat']:null);
                $capturedat = (isset($single['captured_at'])?$single['captured_at']:null);
                $capturedat = Yii::app()->controller->getMysqlFormattedDatetime($capturedat);
                if(empty($capturedat))
                {
                    $capturedat = date('Y-m-d H:i:s');
                }
                $person_id = $this->mobileUser->person->id;
                $model = new Geolocation;
                $model->lng = $longitude;
                $model->lat = $latitude;
                $model->captured_at = $capturedat;
                $model->person_id = $person_id;
                $rtn = $model->save();
                if(!$rtn) break;
            }
        }
        catch (Exception $e)
        {
            $rtn = false;
        }
        if($rtn)
        {
            $trans->commit();
            $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_PERSON_GPS_SAVED;
        }
        else
        {
            $trans->rollback();
            $rtnCode = Helper::CONST_SaveError;
            $message = Helper::CONST_PERSON_GPS_SAVE_FAIL;
        }
        $this->returnJsonResponse($rtnCode, array(), $message);
    }
    public function actionUpdatejobstatus()
    {
        $rtn = false;
        $trans = Yii::app()->db->beginTransaction();
        try
        {
            $postedData = $this->getPostedData();
            if(empty($postedData[0]))
            {//single object one job-onestatus
                $postedData =array($postedData);
            }
            else
            {
                //multiple as array of jobid=status
            }
            $jobstatusesarray = array();
            $jobidsarray = array();
            foreach($postedData as $single)
            {
                $orderid = (isset($single['job_id'])?$single['job_id']:null);
                $newsts = (isset($single['status'])?$single['status']:null);
                if(empty($orderid) || empty($newsts)) continue;
                $jobidsarray[] = $orderid;
                if(isset($newsts))
                {
                    $newsts = Yii::app()->controller->getStatusIdFromName($newsts,1);
                }
                $jobstatusesarray[$orderid] = $newsts;
            }
            if(!empty($jobstatusesarray)) 
            {
                if(empty($jobidsarray)) $jobidsarray = null;
            
                $result = $this->getMyOrders(null, null, $jobidsarray);
                $curemp = $this->mobileUser->person->id;
                foreach($result as $model)
                {
                    $prvemp = $model->employee_id;
                    $prvct = $model->addnlinfo1;
                    $prvsts = $model->status;


                    $curct = $model->addnlinfo1;
                    $newsts = $jobstatusesarray[$model->id];
                    if(!isset($newsts))
                    {
                        $newsts = $prvsts;
                    }
                    $pickedupid = Yii::app()->controller->getStatusIdFromName(Helper::CONST_PICKEDUP,1);
                    $closedid = Yii::app()->controller->getStatusIdFromName(Helper::CONST_CLOSED,1);
                    if($newsts === $pickedupid)
                    {
                        $pickedup_at = (isset($single['pickedup_at'])?$single['pickedup_at']:null);
                        if(empty($pickedup_at))
                        {
                            $pickedup_at = date('Y-m-d H:i:s');
                        }
                        $model->started_at = $pickedup_at;
                    }
                    if($newsts === $closedid)
                    {
                        $delvered_at = (isset($single['delivered_at'])?$single['delivered_at']:null);
                        if(empty($delvered_at))
                        {
                            $delvered_at = date('Y-m-d H:i:s');
                        }
                        $model->closed_at = $delvered_at;
                    }
                    $rtn = $this->updateOrderStatus($model, $prvct, $curct, $prvsts , $newsts, $prvemp, $curemp);
                    if(!$rtn) break;
                }
            }           
        }
        catch (Exception $e)
        {
            $rtn = false;
        }
        if($rtn)
        {
            $trans->commit();
            $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_ORDER_STS_SAVED;
        }
        else
        {
            $trans->rollback();
            $rtnCode = Helper::CONST_SaveError;
            $message = Helper::CONST_ORDER_STS_SAVE_FAIL;
        }
        $this->returnJsonResponse($rtnCode, array(), $message);
    }
    public function actionUpdatedevicetoken()
    {
        $rtn = false;
        $trans = Yii::app()->db->beginTransaction();
        try{
            $postedData = $this->getPostedData();        
            $deviceToken = (!empty($postedData['deviceToken'])?$postedData['deviceToken']:null);
            $person_id = $this->mobileUser->person->id;
//            $criteria = new CDbCriteria();
//            $criteria->condition = 'id = :id';
//            $criteria->params = array('id' => $person_id);
//            $attributes= array('devicetoken' => $deviceToken);
//            Person::model()->updateAll(array('devicetoken' => 1), "id = $person_id");
            
            $person = Person::model()->findByPk($person_id);                        
            $person->devicetoken = $deviceToken;
            $rtn = $person->save(false);
        }catch(Exception $e)
        {
            $rtn = false;
            echo $e;
        }
        if($rtn)
        {
            $trans->commit();
            $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_DVCTKN_SAVED;            
        }
        else
        {
            $trans->rollback();
            $rtnCode = Helper::CONST_SaveError;
            $message = Helper::CONST_DVCTKN_SAVE_FAIL;
        }
        $this->returnJsonResponse($rtnCode, array(), $message);
    }
    public function getMyOrders($orderstatus = null, $forthedate = null, $orderids = null)
    {
        
        $criteria=new CDbCriteria(array(
                            'order'=>'t.addnlinfo1 desc',
                            'with' => array('people', 'statusmaster')));

        $this->addDateSearch($criteria, null,
                        $forthedate, true);

        $this->addOrderStatusCriteria($criteria, $orderstatus);
        
        if(!empty($orderids))
        {
            if(!is_array($orderids)) $orderids = array($orderids);
            $criteria->addInCondition('t.id', $orderids);
        }
        
        $this->alwaysApplyCriteria($criteria);
        $result = Order::model()->findAll($criteria);
        return $result;
    }
    public function alwaysApplyCriteria(&$criteria)
    {
        $person_id = $this->mobileUser->person->id;
        $person_type = $this->mobileUser->role->role;
        $criteria->compare('orderpeople.person_id',$person_id,true);
        $criteria->compare('LCASE(orderpeople.type)',strtolower($person_type));        
        $criteria->addCondition('LCASE(qoi_id) != "dummy"');
        $criteria->together = true;
    }
    public function actionJobs()
    {
        $result = null;
        try
        {
            $orderstatus = Helper::CONST_ExceptOpenRejected;
            $forthedate = (!empty($postedData['slotdate'])?$postedData['slotdate']:null);
            $result = $this->getMyOrders($orderstatus, $forthedate);
            if(!empty($result))
            {
                $json = new CArJSON;
                // Define which relations do you want to load
                $relations = array('ordrcustomers', 'blngaddresses', 'shpngaddresses', 'ordrreceivers' , 'statusmaster');
                // Define which attributes, foreach relations do you want to load
                // root denote attributes for the main model
                $attributes = array(
                    'root' => array('id', 'type', 'qoi_id', 'name', 'desc'
                        , 'addnlinfo', 'addnlinfo1', 'addnlinfo3', 'addnlinfo4', 'remarks','status'),
                    'ordrcustomers' => array('id', 'name', 'firstname', 'lastname', 'mobile'),
                    'blngaddresses' => array( 'id', 'street', 'pincode' ),
                    'shpngaddresses' => array( 'id', 'street', 'pincode' ),                    
                    'ordrreceivers' => array( 'name', 'mobile' ),
                    'statusmaster' => array( 'display'),
                );
//blngaddresses shpngaddresses ordrcustomers ordrreceivers
                $isarray = true;
                $data = $json->toJSON($result, $relations, $attributes, $isarray);
                $rtnCode = Helper::CONST_Error_None;
                $message = Helper::CONST_ORDER_LIST;
                $this->returnJsonResponse($rtnCode, $data, $message);                
            }
        }
        catch(Exception $e)
        {
            $result = null;
        }
        $rtnCode = Helper::CONST_InternalServerError;
        $message = Helper::CONST_ORDER_FETCH_FAIL;
        $data = array();
        $this->returnJsonResponse($rtnCode, $data, $message);
    }
            // update the rows matching the specified condition
//        Post::model()->updateAll($attributes,$condition,$params);
//        // update the rows matching the specified condition and primary key(s)
//        Post::model()->updateByPk($pk,$attributes,$condition,$params);
//        // update counter columns in the rows satisfying the specified conditions
//        Post::model()->updateCounters($counters,$condition,$params);

//          In the above, $attributes is an array of column values indexed by column names; $counters is an array of incremental values indexed by column names; and $condition and $params are as described in the previous subsection.
}