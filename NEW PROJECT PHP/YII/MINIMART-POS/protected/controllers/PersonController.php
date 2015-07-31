<?php

class PersonController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $prvvalue = 1;
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
//            array( 'allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array( 'index', 'view' ),
//                'users' => array( '*' ),
//            ),
            array( 'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array( 'create', 'update'),
                'users' => array( '@' ),
            ),
            array( 'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array( 'admin', 'delete', 
                    Helper::CONST_employeeadmin, Helper::CONST_salesadmin,
                    Helper::CONST_customeradmin, Helper::CONST_supplieradmin,
                    Helper::CONST_contractoradmin,
                    Helper::CONST_employeecreate, Helper::CONST_salescreate,
                    Helper::CONST_customercreate, Helper::CONST_suppliercreate,
                    Helper::CONST_contractorcreate,
                    Helper::CONST_employeeupdate, Helper::CONST_salesupdate,
                    Helper::CONST_customerupdate, Helper::CONST_supplierupdate,
                    Helper::CONST_contractoradmin, ),
                'users' => array( 'admin', 'su' ),
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
        $this->pageTitle = 'View ' . get_class( Person::model() );
        $this->render( 'view', array(
            'model' => $this->loadModel( $id ),
        ) );
    }      
    private function getAddress(&$model)
    {
        $addresses = $model->personaddresses;                
        if(!empty($addresses) && !empty($addresses[0]))
        {
            $tmpaddr = $addresses[0];
            foreach($model->myaddresses as $myaddr)
            {
                if($myaddr->id === $tmpaddr->location_id)
                {
                    $address = $myaddr;
                    $addresstype = $tmpaddr->type;
                    break;
                }
            }
            $model->address = $address;
            $model->addresstype = $addresstype;
        }else{
            $model->address = new Location;
            $model->addresstype = "";
        }
    }
    private function setrelationalModels($model)
    {
        if(empty($model->logins) 
                || empty($model->logins[0])
        )
        {
            $model->login = new Login;
        }
        else
        {
            $model->login = $model->logins[0];
        }
        $model->editpassword = 0;
        $this->getAddress($model);
    }    
    public function getDefaultObject($rolename)
    {
        $model = new Person;
        $rolename = (!empty($rolename)?$rolename:'');
        $model->role_id = Role::model()->getRoleId( $rolename , true );
        $model->rolename = $rolename;
        $model->enablelogin = false;
        $model->register_id = Register::model()->getDefaultRegisterId();
        $this->setrelationalModels($model);
        $this->setPeopleConfigs($model);
        return $model;
    }
    private function loadObject($id, $fromdelete = false)
    {
        $model = $this->loadModel( $id );
        $model->role_id = $model->roles[0]->id;
        $model->rolename = Role::model()->getRoleName( $model->role_id );
        if(!$fromdelete)
        {
            $this->setrelationalModels($model);   
        }
        return $model;
    }      
    public function saveOrUpdate($id, $rolename)
    {
        if(empty($id))
        {
            $view = 'create';
            $model = $this->getDefaultObject($rolename);
            $this->setTitle($model->rolename, 'Create ');
        }
        else
        {
            $view = 'update';
            $model = $this->loadObject($id);           
            $this->setTitle($model->rolename, 'Update ');
        }
        $this->checkForContact($model);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
              
        

       if ( isset( $_POST['Person'] ) )
        {
            $extroleid = $model->role_id;
            $model->attributes = $_POST['Person'];
            //$model->role_id = $_POST['Person']['role_id'];
            $model->rolename = Role::model()->getRoleName($model->role_id);
            $this->checkForContact($model);
            if(!empty($_POST['Location']))
            {
                $model->address->attributes = $_POST['Location'];
            }
            
            $isnew = empty($model->id);
            $rtn = false;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model->code = $this->getPeopleCode($model);
                if($isnew)
                {                   
                    $model->created_at = new CDbExpression('NULL'); 
                    $model->updated_at = new CDbExpression('NULL');                
                }
                else
                {

                    $model->updated_at = new CDbExpression('NULL');
                }
               $curr_name=strtolower(trim($model->firstname));
               $curr_contact=strtolower(trim($model->name));
               $curr_code=strtolower(trim($model->code));
               $curr_mail=strtolower(trim($model->mail));
               $curr_mobile=strtolower(trim($model->mobile));
               $curr_chkid=$model->id;
               $current_actionid=Yii::app()->controller->action->id;
               if ($current_actionid=='supplierupdate'||$current_actionid=='suppliercreate' ) {
                   $curr_roleid=8;
               }
               else {$curr_roleid=7;}

                if($curr_chkid!="")
                {
               $rowsql="SELECT p.name from people p,personcompanyroles pcr,roles r where p.id=pcr.person_id and r.id=pcr.role_id and LCASE(p.name)='$curr_contact' and pcr.role_id='$curr_roleid' and p.id!='$curr_chkid'";
                }
                else{
                     $rowsql="SELECT p.name from people p,personcompanyroles pcr,roles r where p.id=pcr.person_id and r.id=pcr.role_id and LCASE(p.name)='$curr_contact' and pcr.role_id='$curr_roleid'";
                }
                $result = Yii::app()->db->createCommand( $rowsql )->queryAll();
               if(empty($result))
               {
                    if ( $model->save() )
                    {
                       $rtn = $this->postProcessForPersonSave($model, $extroleid, $isnew);
                    }
                }
               }
            catch (Exception $e)
            {
                $rtn = false;
                Yii::log("Error occurred while saving/activating person. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
            }
            
            if($rtn)
            {
                $trans->commit();
                if(empty($rolename))
                {
                    $this->redirect($this->createUrl('admin'));
                }
                else
                {
                    $this->redirect($this->createUrl(strtolower($rolename).'admin'));
                }
            }
            else
            {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Error occurred");
                if(!empty($result))
               {
               echo "Full Name  Already exists";
               }
            }
        }
         $this->render( $view, array(
            'model' => $model
        ) );
    }
        /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->saveOrUpdate(null, null);
    }
    public function actionUpdate( $id )
    {
        $this->saveOrUpdate($id, null);
    }
    public function actionSalesCreate()
    {
        $this->saveOrUpdate(null, Helper::CONST_Sales);
    }
    public function actionSalesUpdate( $id )
    {
        $this->saveOrUpdate($id, Helper::CONST_Sales);
    }
    public function actionEmployeeCreate()
    {
        $this->saveOrUpdate(null, Helper::CONST_Employee);
    }
    public function actionEmployeeUpdate( $id )
    {
        $this->saveOrUpdate($id, Helper::CONST_Employee);
    }
    public function actionCustomerCreate()
    {
        $this->saveOrUpdate(null, Helper::CONST_Customer);
    }
    public function actionCustomerUpdate( $id )
    {
        $this->saveOrUpdate($id, Helper::CONST_Customer);
    }
    public function actionSupplierCreate()
    {
        $this->saveOrUpdate(null, Helper::CONST_Supplier);
    }
    public function actionSupplierUpdate( $id )
    {
        $this->saveOrUpdate($id, Helper::CONST_Supplier);
    }
    public function actionContractorCreate()
    {
        $this->saveOrUpdate(null, Helper::CONST_Contractor);
    }
    public function actionContractorUpdate( $id )
    {
        $this->saveOrUpdate($id, Helper::CONST_Contractor);
    }
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
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
            $model = $this->loadObject($id, true);
            $model->status = 0;
            $rtn = $model->save();
            //$errors = $model->getErrors();
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if ( !isset( $_GET['ajax'] ) )
                $this->redirect( isset( $_POST['returnUrl'] ) ? $_POST['returnUrl'] : array( 'admin' )  );
        }
        else
            throw new CHttpException( 400, 'Invalid request. Please do not repeat this request again.' );
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $criteria = Yii::app()->controller->getPeopleCriteria(null, false);
        $options = array( 'criteria' => $criteria, );
        $dataProvider = new CActiveDataProvider( 'Person', $options );
        $this->render( 'index', array(
            'dataProvider' => $dataProvider,
        ) );
    }
    private function setTitle($rolename, $prefix = '')
    {
        if( empty( $rolename ) )
        {
            $this->pageTitle = $prefix . get_class( Person::model() );
        }
        else
        {
            $this->pageTitle = $prefix . $rolename;
        }
    }
    private function commonadmin($rolename = null)
    {
        $model = new Person( 'search' );
        $model->unsetAttributes();  // clear any default values
        $model->role_id = Role::model()->getRoleId( $rolename , false);
        $model->rolename = $rolename;
        $this->setTitle($rolename);
        
        if ( isset( $_GET['Person'] ) )
            $model->attributes = $_GET['Person'];

        $this->render( 'admin', array(
            'model' => $model, 'isroleparam' =>  !(empty($rolename))
        ) );
    }
    private function commonadmin1($rolename = null)
    {
        $model = new Person( 'search' );
        $model->unsetAttributes();  // clear any default values
        $model->role_id = Role::model()->getRoleId( $rolename , false);
        $model->rolename = $rolename;
        $this->setTitle($rolename);
        
        if ( isset( $_GET['Person'] ) )
            $model->attributes = $_GET['Person'];

        $this->render( 'admin1', array(
            'model' => $model, 'isroleparam' =>  !(empty($rolename))
        ) );
    }
    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $rolename = isset($_REQUEST['type'])?$_REQUEST['type']:'';
        $this->commonadmin($rolename);
    }

    public function actionEmployeeadmin()
    {
        $this->commonadmin( Helper::CONST_Employee );        
    }
    
    public function actionSalesadmin()
    {
        $this->commonadmin( Helper::CONST_Sales );        
    }
    
    public function actionCustomeradmin()
    {
        $this->commonadmin1( Helper::CONST_Customer );        
    }
    
    public function actionSupplieradmin()
    {
        $this->commonadmin( Helper::CONST_Supplier );        
    }
    
    public function actionContractoradmin()
    {
        $this->commonadmin( Helper::CONST_Contractor );        
    }
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel( $id )
    {
        $model = Person::model()->findByPk( $id );
        if ( $model === null )
            throw new CHttpException( 404, 'The requested page does not exist.' );
        return $model;
    }
    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    
    public function loadcustomernameModel()
    {
        $criteria=new CDbCriteria;
        
        $model = Person::model()->findAll($criteria);
                
        return $model;
            
    }
    protected function performAjaxValidation( $model )
    {
        if ( isset( $_POST['ajax'] ) && $_POST['ajax'] === 'person-form' )
        {
            $model->role_id = $_POST['Person']['role_id'];
            $model->rolename = Role::model()->getRoleName($model->role_id);
            $this->checkForContact($model);
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }
    }
    public function DisplayMessage()
    {
    $tmparray = Person::model()->findAll();
    print_r($tmparray);
    exit;
    }
}