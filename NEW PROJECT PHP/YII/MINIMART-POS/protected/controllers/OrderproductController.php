<?php

class OrderproductController extends Controller
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
                'actions' => array( 'create', 'update' ),
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

    public function getDefaultObject()
    {
        $model = new Orderproduct;
        $model->quantity = 1;
        return $model;
    }
    public function saveOrUpdate($id = null)
    {
        $redirectView = 'view';
        if(empty($id))
        {
            $view = 'create';
            $model = $this->getDefaultObject();
        }
        else
        {
            $model = $this->loadModel( $id );
            $view = 'update';
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if ( isset( $_POST['Orderproduct'] ) )
        {
            $model->attributes = $_POST['Orderproduct'];            
            if ( $model->save() )
            {
                $order_id = $model->order_id;
                $amount = 0;
                $this->updateOrder($order_id, $amount);
                $this->redirect( array( $redirectView, 'id' => $model->id ) );
            }
        }

        $this->render( $view, array(
            'model' => $model,
        ) );
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->saveOrUpdate(null);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate( $id )
    {
        $this->saveOrUpdate($id);
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
            $order_id = $model->order_id;
            $model->delete();
            $amount = 0;
            $this->updateOrder($order_id, $amount);

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if ( !isset( $_GET['ajax'] ) )
            {
                $this->redirect( isset( $_POST['returnUrl'] ) ? $_POST['returnUrl'] : array( 'admin' ) );   
            }
            else
            {
                $RetCode = 0;
                $data = $amount;
                $message = 'product removed';
                $rtndata = array('RetCode' => $RetCode, 'data' => $data, 'message' => $message);
                header('Content-type: application/json');
                echo json_encode($rtndata);
            }
        }
        else
            throw new CHttpException( 400, 'Invalid request. Please do not repeat this request again.' );
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider( 'Orderproduct' );
        $this->render( 'index', array(
            'dataProvider' => $dataProvider,
        ) );
    }

    /**
     * Manages all models.
     */
   public function actionAdmin()
    {
        $model = new Orderproduct();
        $model->unsetAttributes();  // clear any default values
        if ( isset( $_GET['Orderproduct'] ) )
            $model->attributes = $_GET['Orderproduct'];
             $id=$_GET['id'];
        $this->render( 'admin', array(
            'model' => $model,'id'=>$id,
        ) );
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel( $id )
    {
        $model = Orderproduct::model()->findByPk( $id );
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
        if ( isset( $_POST['ajax'] ) && $_POST['ajax'] === 'orderproduct-form' )
        {
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }
    }

}
