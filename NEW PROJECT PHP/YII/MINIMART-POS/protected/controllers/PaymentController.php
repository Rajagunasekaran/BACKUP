<?php

class PaymentController extends Controller
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
                                Helper::CONST_ae_loadParties,
                                Helper::CONST_ae_loadPartyOrdersOrTasks,
                                Helper::CONST_ae_loadPartyAccounts,
                                Helper::CONST_ae_loadAccountDetails,
                                Helper::CONST_customeradmin,
                                Helper::CONST_supplieradmin,
                                Helper::CONST_contractoradmin
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
        $direction = isset($_POST['direction'])?$_POST['direction']:null;
        if(empty($direction))
        {
            $this->returnJsonResponseII($data);
        }
        
        $tmparray = array();
        if(strtolower($direction) === strtolower(Helper::CONST_Inwards))
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
        $direction = isset($_POST['direction'])?$_POST['direction']:null;
        $tmparray = array();
        $i = 0;
        if(strtolower($direction) === strtolower(Helper::CONST_Inwards))
        {
            $tmparray = $person->customerorders;
            foreach($tmparray as $single)
            {
                if(strtolower($single->invstatus) 
                        === strtolower(Helper::CONST_INVSTS_INVOICED))
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
                        === strtolower(Helper::CONST_INVSTS_INVOICED))
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
    public function actionLoadPartyAccounts()
    {
        $data = "<option value=''></option>";
        $partyId = isset($_POST['party_id'])?$_POST['party_id']:null;
        $person = Person::model()->findByPk($partyId);
        if(empty($person))
        {
            $this->returnJsonResponseII($data);
        }
        $direction = isset($_POST['direction'])?$_POST['direction']:null;
        $tmparray = array();
        $i = 0;
        if(strtolower($direction) === strtolower(Helper::CONST_Inwards))
        {
            $tmparray = $person->araccounts;
            foreach($tmparray as $single)
            {
                if(strtolower($single->status) 
                        !== strtolower(Helper::CONST_CLOSED))
                {
                    $tmp = "<option "; 
                    if($i === 0)
                    {
                        $tmp .= " selected = 'selected'";
                    }
                    $i++;
                    $tmp .= " value='" . $single->id ."'>" . $single->acnt_no ."</option>";
                    $data .= $tmp;
                }
            }
        }
        else
        {
            $tmparray = $person->apaccounts;
            foreach($tmparray as $single)
            {
                if(strtolower($single->status) 
                        !== strtolower(Helper::CONST_CLOSED))
                {
                    $tmp = "<option "; 
                    if($i === 0)
                    {
                        $tmp .= " selected = 'selected'";
                    }
                    $i++;
                    $tmp .= " value='" . $single->id ."'>" . $single->acnt_no . "</option>";
                    $data .= $tmp;
                }                
            }
        }
        $this->returnJsonResponseII($data);
    }
    public function actionLoadAccountDetails()
    {
        $data = array('order'=>'','ordertask'=>'','amount'=>'','paid'=>'');
        $accountId = isset($_POST['account_id'])?$_POST['account_id']:null;
        $account = Account::model()->findByPk($accountId);
        if(empty($account))
        {
            $this->returnJsonResponseII($data);
        }
        if(strtolower($account->accounttype) === strtolower(Helper::CONST_Receivables))
        {
            $data['order_or_ot_id'] = $account->orders[0]->id;
            $data['ordername'] = $account->orders[0]->name;
        }
        else
        {
            $data['order_or_ot_id'] = $account->ordertasks[0]->id;
            $data['ordername'] = $account->orders[0]->name . '[ ' . $account->ordertasks[0]->task->name . ' ]';
        }
        $data['amount'] = $account->amount;
        $data['paid'] = $account->paid;
        $this->returnJsonResponseII($data);
    }
    private function getNewModel()
    {
        $model = new Payment;
        $model->type = Helper::CONST_Cash;
        $model->direction = Helper::CONST_Inwards;
        $model->person_id = Yii::app()->user->person->id;
        $model->status = Helper::CONST_Payment_Collected;
        $model->party_id = 0;
        $model->account_id = 0;
        $model->amount = 0;
        $model->payment_at = date($this->datetimemysqlformatDMY);
        return $model;
    }
    public function saveToDB($model, $oldpayment)
    {
        $rtn = false;
        $trans = Yii::app()->db->beginTransaction();
        try 
        {                                    
            $orderid = $model->order_or_ot_id;
            $ordertaskid = 0;
            $curdirection = $model->direction;
            $rtn = true;
            if(strtolower($curdirection) === strtolower(Helper::CONST_Outwards))
            {
                $ordertask = Ordertask::model()->findByPk($orderid);
                $rtn = !empty($ordertask);
                if($rtn)
                {
                    $ordertaskid = $ordertask->id;
                    $orderid = $ordertask->order->id;
                }
            }
            if($rtn)
            {
                $model->order_id = $orderid;
                $model->ordertask_id = $ordertaskid;
                $rtn = $model->save();
                if($rtn)
                {
                    $accountid = $model->account_id;
                    $rtn = $this->updateAccountPaid($oldpayment, $model->amount, $accountid);
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
    public function updateAccountPaid($oldpayment, $newpayment, $accountid)
    {        
        $account = Account::model()->findByPk($accountid);
        $rtn = !empty($account);
        if($rtn)
        {
            $account->paid = $account->paid - $oldpayment + $newpayment;
            if($account->paid >= $account->amount)
            {
                $account->status = Helper::CONST_CLOSED;
                //$account->paid = $account->amount;
            }
            else
            {
                $account->status = Helper::CONST_PENDING;
            }
            $account->closed_at = null;
            $rtn = $account->save();
        }
        return $rtn;
    }
    public function saveOrUpdatepayment($model)
    {        
        $isnew = empty($model->id);
        $view = ($isnew)?'create':'update';
        $isOk = true;
        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);
        $oldpayment = $model->amount;
        $model->attributes = $_POST['Payment'];
        $isOk = $this->saveToDB($model, $oldpayment);
        return $isOk;
    }
    public function saveAndRedirect($model)
    {
        $rtn =  $this->saveOrUpdatepayment($model);
        $this->replyMessage( $rtn, $model );
    }
    public function replyMessage($rtn, $model = null)
    {
        if($rtn)
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                if(!empty($model))
                {
                    $message =  'Payment Saved';
                }
                else
                {
                    $message =  'Payment Deleted';
                }
                $RetCode = 0;
                $data = Yii::app()->createUrl('payment/admin');
                $this->returnJsonResponse($RetCode, $data, $message);
            }
            else
            {
                $this->redirect(Yii::app()->createUrl('payment/admin'));
            }
        }
        else
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                if(!empty($model))
                {
                    $message = Helper::CONST_Updation_Failed;
                    $error = CActiveForm::validate($model);
                    if($error!='[]')
                        echo $error;
                    Yii::app()->end();
                }
                else
                {
                    $this->redirect(Yii::app()->createUrl('payment/admin'));
                }
            }
        }
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = $this->getNewModel();

// Uncomment the following line if AJAX validation is needed
    $this->performAjaxValidation($model);
        if ( isset( $_POST['Payment'] ) )
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
            'model' => $model,
        ) );
    }
    
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate( $id )
    {
        $model = $this->loadModel( $id );

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if ( isset( $_POST['Payment'] ) )
        {
            $this->saveAndRedirect($model);
        }

        $this->render( 'update', array(
            'model' => $model,
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
            $rtn = false;
            $trans = Yii::app()->db->beginTransaction();
            try 
            {
    // we only allow deletion via POST request
                $model = $this->loadModel( $id );
                $accountid = $model->account_id;
                $rtn = $this->updateAccountPaid($model->amount, 0, $accountid);                
                if($rtn)
                {
                    $rtn = $model->delete();
                }
            }
            catch(Exception $e)
            {
                
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
            $this->replyMessage($rtn);
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
        $dataProvider = new CActiveDataProvider( 'Payment' );
        $this->render( 'index', array(
            'dataProvider' => $dataProvider,
        ) );
    }
    public function actionCustomeradmin()
    {
        $this->commonAdmint(Helper::CONST_Customer);
    }
    public function actionSupplieradmin()
    {
        $this->commonAdmint(Helper::CONST_Supplier);
    }
    public function actionContractoradmin()
    {
        $this->commonAdmint(Helper::CONST_Contractor);
    }
    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $this->commonAdmint(null);
    }
    public function commonAdmint($partyrole)
    {
        $model = new Payment( 'search' );
        $model->unsetAttributes();  // clear any default values
        if ( isset( $_GET['Payment'] ) )
            $model->attributes = $_GET['Payment'];
        //$model->party_id = $partyrole;
        
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
        $model = Payment::model()->findByPk( $id );
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
        if ( isset( $_POST['ajax'] ) && $_POST['ajax'] === 'payment-form' )
        {
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }
    }

}