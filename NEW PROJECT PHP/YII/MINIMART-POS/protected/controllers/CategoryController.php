<?php

class CategoryController extends Controller
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
                'actions' => array( 'admin', 'delete',
                    Helper::CONST_sectionadmin ,
                    Helper::CONST_sectioncreate,
                    Helper::CONST_sectionupdate,
                    ),
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
    public function actionSectioncreate()
    {
        $this->commonCreate(true);
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->commonCreate(false);
    }
    public function commonCreate($root = false)
    {
        $model = new Category;
        if(empty($root))
        {
            $model->parent_id = Category::model()->getCategoryId( Helper::CONST_General_Section , true, true );
        }
        else
        {
            $model->parent_id = 0;
        }
        $oldimgpath = $model->imagepath;
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if ( isset( $_POST['Category'] ) )
        {
            $model->attributes = $_POST['Category'];
            $this->saveModel($model, $root, $oldimgpath, true);
        }

        $this->render( 'create', array(
            'model' => $model,
        ) );
    }
    public function actionSectionUpdate( $id )
    {
        $this->actionCommonUpdate($id, true);
    }
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate( $id )
    {
        $this->actionCommonUpdate($id, false);
    }
    
    public function actionCommonUpdate($id, $root = false)
    {
        $model = $this->loadModel( $id );
        
        $oldimgpath = $model->imagepath;
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if ( isset( $_POST['Category'] ) )
        {
            $model->attributes = $_POST['Category'];
            $this->saveModel($model, $root, $oldimgpath, false);
        }

        $this->render( 'update', array(
            'model' => $model,
        ) );
    }
    public function saveModel(&$model, $root, $oldimgpath, $isnew)
    {        
        $trans = Yii::app()->db->beginTransaction();
        $rtn = false;
        try
        {
            $rtn = $model->save();
            if($rtn)
            {
                $uploadedFile=CUploadedFile::getInstance($model,'imagepath'); 
                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $fileName = $uploadedFile->name;
                    $model->imagepath = $fileName;
                    $rtn = $model->save();
                    $uploadedFile->saveAs($this->imageRealPath . $fileName);
                }
                else
                {
                    if(!$isnew)
                    {
                        $model->imagepath = $oldimgpath;
                        $rtn = $model->save();
                    }
                }
            }
        }catch(Exception $e){
            $rtn = false;
        }
        if($rtn)
        {
            $trans->commit();
            if(empty($root))
            {
                Yii::app()->controller->setCategoriesLookupInState();
                $this->redirect($this->createUrl('admin'));
            }
            else
            {
                Yii::app()->controller->setRootCategoriesLookupInState();
                $this->redirect($this->createUrl(Helper::CONST_sectionadmin));
            }
        }else
        {
            $trans->rollback();
        }
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
            $this->loadModel( $id )->delete();

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
        $dataProvider = new CActiveDataProvider( 'Category' );
        $this->render( 'index', array(
            'dataProvider' => $dataProvider,
        ) );
    }
    public function actionSectionadmin()
    {
        $this->commonsectionAdmin(true);
    }
    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $this->commonAdmin(false);
    }
    public function commonAdmin($root = false)
    {
        $this->pageTitle = get_class( Category::model() );
        $model = new Category( 'search' );
        $model->unsetAttributes();  // clear any default values        
        if ( isset( $_GET['Category'] ) )
            $model->attributes = $_GET['Category'];
        if($root)
        {
           $model->parent_id = Helper::CONST_RootCategory;
        }
        else
        {
            $model->parent_id = Helper::CONST_Category;
        }
        
        $this->render( 'admin', array(
            'model' => $model,
        ) );
    }
    public function commonsectionAdmin($root = false)
    {
        $this->pageTitle = get_class( Category::model() );
        $model = new Category( 'search' );
        $model->unsetAttributes();  // clear any default values        
        if ( isset( $_GET['Category'] ) )
            $model->attributes = $_GET['Category'];
        if($root)
        {
           $model->parent_id = Helper::CONST_RootCategory;
        }
        else
        {
            $model->parent_id = Helper::CONST_Category;
        }
        
        $this->render( 'admin1', array(
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
        $model = Category::model()->findByPk( $id );
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
        if ( isset( $_POST['ajax'] ) && $_POST['ajax'] === 'category-form' )
        {
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }
    }

}
