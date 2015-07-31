<?php

class AccountController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array( 'allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array( 'index', 'view' ),
                'users' => array( '*' ),
            ),
            array( 'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array( 'create', 'update', 
                    Helper::CONST_updateaccountsurcharge,
                    Helper::CONST_updateaccountordersamount,
                    Helper::CONST_invoicepdf,
                    Helper::CONST_ae_loadPartyOrdersOrTasks,
                    Helper::CONST_ae_loadParties,
                    ),
                'users' => array( '@' ),
            ),
            array( 'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array( 'admin', 'delete' ),
                'users' => array( 'admin' ),
            ),
            array( 'deny', // deny all users
                'users' => array( '*' ),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView( $id )
    {
        $this->render( 'view', array(
            'model' => $this->loadModel( $id ),
        ) );
    }
    public function actionLoadParties()
    {
        $data = "<option value=''></option>";
        $accounttype = isset($_POST['accounttype'])?$_POST['accounttype']:null;
        if(empty($accounttype))
        {
            $this->returnJsonResponseII($data);
        }
        
        $tmparray = array();
        if($accounttype === Helper::CONST_Receivables)
        {
           $rolename = Helper::CONST_Customer;            
        }
        else
        {
            $rolename = Helper::CONST_Contractor;
        }
        $role = Role::model()->getRoleByName($rolename);
        if(empty($role))
        {
            $this->returnJsonResponseII($data);            
        }
        $role_id = $role->id;
        $criteria = new CDbCriteria;
        $criteria = Yii::app()->controller->getPeopleCriteria($role_id, false);
        $tmparray = Person::model()->findAll($criteria);
        //$data = CHtml::listData($tmparray, 'id', 'name');
        $i = 0;
        foreach($tmparray as $single)
        {
            $tmp = "<option "; 
            if($i === 0)
            {
                $tmp .= " selected = 'selected'";
            }
            $i++;
            $tmp .= " value='" . $single->id ."'>" . $single->name .  "</option>";
            $data .= $tmp;
        }
        $this->returnJsonResponseII($data);
    }
    public function actionLoadPartyOrdersOrTasks()
    {
        
        $data = "<option value=''></option>";
        $partyId = isset($_POST['party_id'])?$_POST['party_id']:null;
        $person = Person::model()->findByPk($partyId);
        if(empty($person))
        {
            $this->returnJsonResponseII($data);            
        }
        $accounttype = isset($_POST['accounttype'])?$_POST['accounttype']:null;
        $tmparray = array();
        $i = 0;
        if($accounttype === Helper::CONST_Receivables)
        {
            $tmparray = $person->customerorders;
            foreach($tmparray as $single)
            {        
                if(strtolower($single->invstatus) 
                        === strtolower(Helper::CONST_INVSTS_UNINVOICED))
                {
                    $tmp = "<option "; 
                    if($i === 0)
                    {
                        $tmp .= " selected = 'selected'";
                    }
                    $i++;
                    $tmp .= " value='" . $single->id ."'>" . $single->name ."</option>";
                    $data .= $tmp;
                }                
            }
        }
        else
        {
            $tmparray = $person->contractorordertasks;
            foreach($tmparray as $single)
            {
                if(strtolower($single->invstatus) 
                        === strtolower(Helper::CONST_INVSTS_UNINVOICED))
                {
                    $tmp = "<option "; 
                    if($i === 0)
                    {
                        $tmp .= " selected = 'selected'";
                    }
                    $i++;
                    $tmp .= " value='" . $single->id ."'>" . $single->order->name . "[ " . $single->task->name . " ]" ."</option>";
                    $data .= $tmp;
                }                
            }
        }
        $this->returnJsonResponseII($data);
    }
    public function actionUpdateaccountordersamount()
    {
        $accountId = isset($_POST['Account']['id'])?$_POST['Account']['id']:null;        
        $rtn = !empty($accountId);        
        if($rtn)
        {
            $orderIds = isset($_POST['Account']['Order'])?$_POST['Account']['Order']:array();
            
            $account = $this->loadModel( $accountId );
            $rtn = !empty($account);
            if($rtn)
            {
                $sumOfOrdersAmount = 0;
                $sumoforderamountdiffs = 0;
                foreach($orderIds as $orderId => $postedOrderAmount)
                {
                    $order = Order::model()->findByPk($orderId);
                    if(empty($order)) continue;

                    $sumOfOrdersAmount += $postedOrderAmount;

                    $existingOrderAmount = $order->amount;
                    $order->amount = $postedOrderAmount;
                    $this->calculateOrderDiscount($order, $existingOrderAmount,
                                $postedOrderAmount, $sumoforderamountdiffs);                    
                    $rtn = $order->save(false);
                    if(!$rtn) break;
                }
                if($rtn)
                {
                    if($this->getAccountamountfrom() == 1)
                    {
                        $account->amount = $sumOfOrdersAmount;
                        $account->discount = $sumoforderamountdiffs;
                        $account->scamount = 0;
                        $rtn = $account->save(false);
                    }
                }
            }
        }
        if($rtn)
        {
            $RetCode = 0;
            $data = $account->amount;
            $message = 'Updated';
        }
        else
        {
            $RetCode = 1;
            $data = '';
            $message = 'Failed';    
        }
        $this->returnJsonResponse($RetCode, $data, $message);        
    }
    public function printToPdf($config, $myData = null)
    {
        $this->pdfobj = new InvoicePDF($config, $myData);
        $this->pdfobj->writeOutput(false);
    }
    public function actionInvoicepdf()
    {
        $accountId = isset($_POST['Account']['id'])?$_POST['Account']['id']:null;
        $rtn = !empty($accountId);
        if($rtn)
        {
            $account = $this->loadModel( $accountId );
            $rtn = !empty($account);
            if($rtn)
            {
                $this->printToPdf(null, $account);
            }
        }
        if(!$rtn)
        {
            $RetCode = 1;
            $data = '';
            $message = 'Failed';
            $this->returnJsonResponse($RetCode, $data, $message);
        }
    }
    public function actionUpdateaccountsurcharge()
    {
        $accountId = isset($_POST['Account']['id'])?$_POST['Account']['id']:null;
        $rtn = !empty($accountId);        
        if($rtn)
        {
            $account = $this->loadModel( $accountId );
            $rtn = !empty($account);
            if($rtn)
            {
                $oldamount = $account->amount - $account->scamount;
                $isSurcharge = isset($_POST['Account']['isapplysurcharge'])?$_POST['Account']['isapplysurcharge']:false;
                $postsurchageamount = isset($_POST['Account']['scamount'])?$_POST['Account']['scamount']:Helper::CONST_Default_SC_Amount;
                if(!$isSurcharge)
                {
                    $postsurchageamount = 0;
                }
                $newamount = $oldamount + $postsurchageamount;
                $account->amount = $newamount;
                $account->scamount = $postsurchageamount;
                $rtn = $account->save(false);
            }
        }
        if($rtn)
        {
            $RetCode = 0;
            $data = $account->amount;
            $message = 'Updated';
        }
        else
        {
            $RetCode = 1;
            $data = '';
            $message = 'Failed';    
        }
        $this->returnJsonResponse($RetCode, $data, $message);
    }
    private function saveOrUpdateAccountOrders($account)
    {
        $condition = 'account_id=' . $account->id;       
        $condition .= ' AND ordertask_id<=0';
        $criteria = new CDbCriteria;
        $criteria->condition = $condition;
        $result = Accountorder::model()->findAll($criteria);
        $foundOrders = array();
        foreach($result as $record)
        {
            $found = null;
            foreach($account->orders as $order)
            {
                if($record->order_id === $order->id)
                {
                    $found = $order;
                    break;
                }
            }
            if(empty($found))
            {
                $prvorderid = $record->order_id;                
                $rtn = $record->delete();
                if(!$rtn) return $rtn;
                $prvorder = Order::model()->findByPk($prvorderid);
                if(!empty($prvorder))
                {
                    $prvorder->invstatus = Helper::CONST_INVSTS_UNINVOICED;
                    $rtn = $prvorder->save(false);
                    if(!$rtn) return $rtn;
                }
            }
            else
            {
                $foundOrders[$found->id] = $found;
            }
        }
        foreach($account->orders as $order)
        {
            if( !in_array($order->id, array_keys($foundOrders)) )
            {
                $accountorder = new Accountorder;
                $accountorder->account_id = $account->id;
                $accountorder->order_id = $order->id;
                $accountorder->ordertask_id = 0;
                $rtn = $accountorder->save();
                if(!$rtn) return $rtn;
                $order->invstatus = Helper::CONST_INVSTS_INVOICED;
                $rtn = $order->save(false);
                if(!$rtn) return $rtn;
            }
        }
        return true;
    }
    private function saveOrUpdateAccountOrdertasks($account)
    {
        $condition = 'account_id=' . $account->id;
        $condition .= ' AND ordertask_id>0';
        $criteria = new CDbCriteria;
        $criteria->condition = $condition;
        $result = Accountorder::model()->findAll($criteria);
        $foundOrdertasks = array();
        foreach($result as $record)
        {
            $found = null;
            foreach($account->ordertasks as $ordertask)
            {
                if($record->ordertask_id === $ordertask->id)
                {
                    $found = $ordertask;
                    break;
                }
            }
            if(empty($found))
            {
                $prvordertaskid = $record->ordertask_id;
                $rtn = $record->delete();
                if(!$rtn) return $rtn;
                $prvordertask = Ordertask::model()->findByPk($prvordertaskid);
                if(!empty($prvordertask))
                {
                    $prvordertask->invstatus = Helper::CONST_INVSTS_UNINVOICED;
                    $rtn = $prvordertask->save(false);
                    if(!$rtn) return $rtn;
                }
            }
            else
            {
                $foundOrdertasks[$found->id] = $found;
            }
        }
        foreach($account->ordertasks as $ordertask)
        {
            if( !in_array($ordertask->id, array_keys($foundOrdertasks)) )
            {
                $accountorder = new Accountorder;
                $accountorder->account_id = $account->id;
                $accountorder->order_id = $ordertask->order->id;
                $accountorder->ordertask_id = $ordertask->id;
                $rtn = $accountorder->save();
                if(!$rtn) return $rtn;
                $ordertask->invstatus = Helper::CONST_INVSTS_INVOICED;
                $rtn = $ordertask->save(false);
                if(!$rtn) return $rtn;
            }
        }
        return true;
    }
    private function createAccountFromOrders($model)
    {
        $rtn = false;                        
        try
        {
            $orderids = $_POST['Account']['Order'];
            $partyWiseOrdersAmount = array();
            foreach($orderids as $postedOrderId => $postedValue)
            {
                list($postedPartyId,$postedOrderAmount) = explode(':', $postedValue);                
                if(  !key_exists( $postedPartyId, $partyWiseOrdersAmount ))
                {
                    $partyWiseOrdersAmount[$postedPartyId] = array();
                }
                $partyWiseOrdersAmount[$postedPartyId][$postedOrderId] = $postedOrderAmount;                
            }
            $isIncominModelUsed = false;
            foreach($partyWiseOrdersAmount as $partyId => $partyOrders)
            {
                $accountsTobeprocessed = array();                
                $accountwiseOrders = array();
                $ordersWithoutAccount = array();
                foreach($partyOrders as $postedOrderId => $postedOrderAmount)
                {
                    $orderModel = Order::model()->findByPk($postedOrderId);
                    if(empty($orderModel)) continue;
                    $existingaccount = $orderModel->araccount;
                    if(!empty($existingaccount))
                    {
                        if(strtolower($existingaccount->accounttype) !== strtolower(Helper::CONST_Receivables)) continue;
                        $existingaccount->party_id = $partyId;
                        if(empty($accountsTobeprocessed[$existingaccount->id]))
                        {
                            $accountsTobeprocessed[$existingaccount->id] = array();                                
                        }
                        $accountsTobeprocessed[$existingaccount->id] = $existingaccount;                        
                        if(empty($accountwiseOrders[$existingaccount->id]))
                        {
                            $accountwiseOrders[$existingaccount->id] = $existingaccount->orders;
                        }
                        $found = false;
                        foreach($accountwiseOrders[$existingaccount->id] as $tmporder)
                        {
                            if($orderModel->id === $tmporder->id)
                            {
                                $found = true;
                                break;
                            }
                        }
                        if(!$found)
                        {
                            $accountwiseOrders[$existingaccount->id][] = $orderModel;
                        }                        
                    }
                    else
                    {
                        $ordersWithoutAccount[] = $orderModel;
                    }                    
                }
                foreach($accountwiseOrders as $accountId => $orders)
                {
                    if(empty($accountsTobeprocessed[$accountId])) continue;
                    $accountsTobeprocessed[$accountId]->orders = $accountwiseOrders[$accountId];
                }
                if(!empty($ordersWithoutAccount))
                {
                    if($partyId === $model->party_id || $model->party_id == 0)
                    {
                        $tmpmodel = $model;
                        $tmpmodel->party_id = $partyId;
                        $tmpmodel->save(false);
                        $isIncominModelUsed = true;//incoming model always new.
                    }
                    else
                    {
                        $tmpmodel = $this->getNewModel();
                        $tmpmodel->party_id = $partyId;
                        $rtn = $this->saveTheAccountModel($tmpmodel);
                        if(!$rtn) continue;
                    }
                    $tmpmodel->orders=$ordersWithoutAccount;
                    $accountsTobeprocessed[$tmpmodel->id] = $tmpmodel;
                }                
                foreach($accountsTobeprocessed as $accountId => $account)
                {
                    $rtn = $this->updateAmounts($account, $partyId, $partyWiseOrdersAmount);
                    if(!$rtn) return $rtn;
                    $rtn = $this->saveOrUpdateAccountOrders($account);//join table
                    if(!$rtn) return $rtn;
                }
            }
            if(!$isIncominModelUsed)
            {
                $model->delete();
            }
        }
        catch(Exception $e)
        {
            Yii::log("Error occurred while saving/activating account. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
            $rtn = false;
        }
        return $rtn;
    }
    private function updateAmounts(&$account, $partyId, $partyWiseOrdersAmount)
    {
        $sumOfOrdersAmount = 0;
        $sumoforderamountdiffs = 0;
        foreach($account->orders as $order)
        {
            $orderId = $order->id;
            $postedOrderAmount = $partyWiseOrdersAmount[$partyId][$orderId];
            $sumOfOrdersAmount += $postedOrderAmount;                        
            $existingOrderAmount = $order->amount;
            $order->amount = $postedOrderAmount;
            $this->calculateOrderDiscount($order, $existingOrderAmount,
                    $postedOrderAmount, $sumoforderamountdiffs);
            $rtn =  $order->save(false);
            if(!$rtn) return $rtn;
        }
        if($this->getAccountamountfrom() == 1)
        {
            $account->amount = $sumOfOrdersAmount;
            $account->discount = $sumoforderamountdiffs;
            $account->scamount = 0;
            $rtn = $account->save(false);
            if(!$rtn) return $rtn;
        }
        return true;
    }
    private function calculateOrderDiscount(&$order, $existingOrderAmount, $postedOrderAmount, &$sumoforderamountdiffs)
    {
        $orderamountdiff = ($existingOrderAmount - $postedOrderAmount);                        
        if($existingOrderAmount > 0 && $orderamountdiff != 0)
        {
            if($order->amount>0)
            {
                $order->disc = $orderamountdiff;
                $sumoforderamountdiffs += $orderamountdiff;
            }
            else
            {                                
                $order->disc = 0;
            }
            $order->discper = 0;
            if($order->disc > 0)
            {
                $order->discper = $order->disc / $existingOrderAmount * 100.0;
            }
        }
    }
    private function saveTheAccountModel($model)
    {
        $isnew = empty($model->id);
        $isautogenerated = false;
        $type = $model->type;
        $gnrtdId = $this->getOrderAutoId($type, $isnew, $model->acnt_no, $isautogenerated);
        if($isautogenerated)
        {
            $model->acnt_no = $gnrtdId;
        }
        $rtn = $model->save();
        if ( $rtn )
        {
            $model->refresh();
            $rtn = !$isautogenerated;
            if($isautogenerated)
            {
                $rtn = $this->updateOrderAutoId($model->acnt_no);
            }
        }
        return $rtn;
    }
    public function saveToDB($model)
    {
        $rtn = false;
        $trans = Yii::app()->db->beginTransaction();
        try 
        {
            if($this->getMoperinvoice())
            {
                $rtn = $this->saveTheAccountModel($model);
                if($rtn)
                {
                    $rtn = $this->createAccountFromOrders($model);
                }
            }
            else
            {
                $orderorotid = $model->order_or_ot_id;
                $curAccountType = $model->accounttype;
                $rtn = false;
                switch(strtolower($curAccountType))
                {
                    case strtolower(Helper::CONST_Receivables):
                        $order = Order::model()->findByPk($orderorotid);
                        $rtn = !empty($order);
                        if($rtn)
                        {
                            $orders[] = $order;
                            $existingaccount = $order->araccount;
                            if(!empty($existingaccount))
                            {
                                $existingaccount->amount = $model->amount;
                                $existingaccount->acnt_date = $model->acnt_date;
                                $model = $existingaccount;
                            }
                            $rtn = $this->saveTheAccountModel($model);
                            if($rtn)
                            {
                                $model->orders = $orders;
                                $rtn = $this->saveOrUpdateAccountOrders($model);//join table
                            }
                        }
                        break;
                    case strtolower(Helper::CONST_Payables):
                        $ordertask = Ordertask::model()->findByPk($orderorotid);
                        $rtn = !empty($ordertask);                        
                        if($rtn)
                        {
                            $ordertasks[] = $ordertask;
                            $existingaccount = $ordertask->apaccount;                            
                            if(!empty($existingaccount))
                            {
                                $existingaccount->amount = $model->amount;
                                $existingaccount->acnt_date = $model->acnt_date;
                                $model = $existingaccount;
                            }
                            $rtn = $this->saveTheAccountModel($model);
                            if($rtn)
                            {
                                $model->ordertasks = $ordertasks;
                                $rtn = $this->saveOrUpdateAccountOrdertasks($model);//join table
                            }
                        }
                        break;
                }
            }
        }
        catch (Exception $e) 
        {
            Yii::log("Error occurred while saving/activating order. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
            $rtn = false;
        }
        if($rtn)
        {
            $trans->commit();
        }
        else
        {
            $trans->rollback();
            Yii::app()->user->setFlash('error', "Error occurred");
        }
        return $rtn;
    }
    private function getNewModel()
    {
        $model = new Account;
        $model->type = Helper::CONST_Invoice;
        $model->accounttype = Helper::CONST_Receivables;
        $model->person_id = Yii::app()->user->person->id;
        $model->status = Helper::CONST_PENDING;
        $model->party_id = 0;
        $model->amount = 0;
        $model->acnt_date = date($this->datetimemysqlformatDMY);
        $model->acnt_no = null;
        return $model;
    }
    private function setTitle($type, $prefix = '')
    {
        if( empty( $type ) )
        {
            $tmp = get_class( Account::model() );
        }
        else
        {
            $tmp = $type;            
        }
        $tmp = $this->getMenuLabels( $tmp );
        $this->pageTitle = $prefix . $tmp;
    }
    public function saveOrUpdateinvoice($model)
    {        
        $isnew = empty($model->id);
        $view = ($isnew)?'create':'update';
        $isOk = true;
        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);
        $model->attributes = $_POST['Account'];
        $isOk = $this->saveToDB($model);
        return $isOk;
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {   
        $model = $this->getNewModel();
        $this->performAjaxValidation($model);
        $accoutordersearch = new Order;
        $accoutordersearch->unsetAttributes();
        $accoutordersearch->acnt_no = $model->acnt_no;
        
        if ( isset( $_POST['Account'] ) )
        {
            $this->saveAndRedirect($model);
        }
        else
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                echo 'Nothing to save';
                Yii::app()->end();
            }
        }
        $this->render( 'create', array(
            'model' => $model, 'accoutordersearch' => $accoutordersearch,
        ) );
    }
    public function saveAndRedirect($model)
    {
        $rtn =  $this->saveOrUpdateinvoice($model);
        if($rtn)
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                $message =  'Invoice Saved';
                $RetCode = 0;
                $data = Yii::app()->createUrl('account/admin');
                $this->returnJsonResponse($RetCode, $data, $message);
            }
            else
            {
                $this->redirect(Yii::app()->createUrl('account/admin'));
            }
        }
        else
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                $message = Helper::CONST_Updation_Failed;
                $error = CActiveForm::validate($model);
                if($error!='[]')
                    echo $error;
                Yii::app()->end();
            }
        }
    }
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate( $id )
    {
        $model = $this->loadModel( $id );
        $model->scamount = Helper::CONST_Default_SC_Amount;
        $this->performAjaxValidation($model);
        $accoutordersearch = new Order;
        $accoutordersearch->unsetAttributes();
        $accoutordersearch->acnt_no = $model->acnt_no;
        
        if ( isset( $_POST['Account'] ) )
        {
            $this->saveAndRedirect($model);
        }
//        else
//        {
//            if (Yii::app()->request->isAjaxRequest)
//            {
//                echo 'Nothing to save';
//                Yii::app()->end();
//            }
//        }
        $this->render( 'update', array(
                'model' => $model, 'accoutordersearch' => $accoutordersearch,
            ) );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete( $id )
    {
        if ( Yii::app()->request->isPostRequest )
        {
// we only allow deletion via POST request
            $model = $this->loadModel( $id );
            if(empty($model->payments))
            {
                foreach($model->accountorders as $single)
                {
                    $orderid = $single->order_id;
                    $ordertaskid = $single->ordertask_id;
                    $ordertask = Ordertask::model()->findByPk($ordertaskid);
                    if(!empty($ordertask))
                    {
                        $ordertask->invstatus = Helper::CONST_INVSTS_UNINVOICED;
                        $rtn = $ordertask->save();
                    }
                    else
                    {
                        $order = Order::model()->findByPk($orderid);
                        if(!empty($order))
                        {
                            $order->invstatus = Helper::CONST_INVSTS_UNINVOICED;
                            $rtn = $order->save();
                        }
                    }
                    if($rtn)
                    {
                        $rtn = $single->delete();
                    }                    
                    if(!$rtn) break;
                }
                if($rtn)
                {
                   foreach($model->accountpurchases as $single)
                    {
                        $rtn = $single->delete();
                        if(!$rtn) break;
                    }
                }
                if($rtn)
                {
                    $rtn = $model->delete();
                }
                if($rtn)
                {
                    $message = 'Invoice Deleted';                    
                }
                else
                {
                    $message = 'Invoice delete Failed';
                }
            }
            else
            {
                $message = 'Delete all Payments first';
            }
            if (Yii::app()->request->isAjaxRequest)
            {
                if ( !isset( $_GET['ajax'] ) )
                {
                    $RetCode = 0;
                    $data = Yii::app()->createUrl('account/admin');
                    $this->returnJsonResponse($RetCode, $data, $message);
                }
            }
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if ( !isset( $_GET['ajax'] ) )
                $this->redirect( isset( $_POST['returnUrl'] ) ? $_POST['returnUrl'] : array( 'admin' ) );
        }
        else
            throw new CHttpException( 400, 'Invalid request. Please do not repeat this request again.' );
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider( 'Account' );
        $this->render( 'index', array(
            'dataProvider' => $dataProvider,
        ) );
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Account( 'search' );
        $model->unsetAttributes();  // clear any default values        
        if ( isset( $_GET['Account'] ) )
            $model->attributes = $_GET['Account'];

        $this->render( 'admin', array(
            'model' => $model,
        ) );
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel( $id )
    {
        $model = Account::model()->findByPk( $id );
        if ( $model === null )
            throw new CHttpException( 404, 'The requested page does not exist.' );
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation( $model )
    {
        if ( isset( $_POST['ajax'] ) && $_POST['ajax'] === 'account-form' )
        {
            $errors = CActiveForm::validate( $model );
            echo $errors;
            Yii::app()->end();
        }
    }
}