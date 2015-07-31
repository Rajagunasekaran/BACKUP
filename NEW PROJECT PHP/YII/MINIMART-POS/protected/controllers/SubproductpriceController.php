<?php

class SubproductpriceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','adminproduct','getstockcnt','getcode','getsku',' Adjsearch'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Subproductprice;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Subproductprice']))
		{
			$model->attributes=$_POST['Subproductprice'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

 //CHECK UNIQUE CODE 
public function actiongetcode()
{
       $postedData = $this->getPostedData();
        $code = strtolower(trim($postedData['code'])); 
        $codeid = trim($postedData['id']);
         if(!empty($codeid))
        {
                $sql = "SELECT code from subproductprices where LCASE(code)='$code' and id!='$codeid'";

        }
        else{
                    $sql = "SELECT code from subproductprices where LCASE(code)='$code'";
        }
      $command = Yii::app()->db->createCommand($sql);
      $result = $command->queryAll(); 
      if(count($result)>0)
               {
             $message = 'true';
         } else {
             $message = 'false';
         }
         echo $message; 
  }
 //CHECK UNIQUE BARCODE
  public function actiongetsku()
   {
        $postedData = $this->getPostedData();
        $sku =strtolower(trim($postedData['sku'])); 
        $codeid = trim($postedData['id']);
         if(!empty($codeid))
        {
                $sql = "SELECT sku from subproductprices where LCASE(sku)='$sku' and id!='$codeid'";

        }
        else{
                    $sql = "SELECT sku from subproductprices where LCASE(sku)='$sku'";
        }
      $command = Yii::app()->db->createCommand($sql);
      $result = $command->queryAll(); 
      if(count($result)>0)
               {
             $message = 'true';
         } else {
             $message = 'false';
         }
         echo $message; 
  }
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Subproductprice']))
		{
			$model->attributes=$_POST['Subproductprice'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Subproductprice');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Subproductprice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Subproductprice']))
			$model->attributes=$_GET['Subproductprice'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	//Get the stock and purchase price
	
public function actionGetstockcnt()
	{	
	$postedData = $this->getPostedData();
	$model=Subproductprice::model();
	$model->id=$postedData['id'];$model->sku=$postedData['sku'];	
        $rowsql = "select initial_stock,unit_cp,invno,invdate from subproductprices where sku='".$postedData['sku']."'"; 
       $stockPrice = Yii::app()->db->createCommand( $rowsql )->queryAll();
	echo json_encode($stockPrice);
	}
        
        	public function actionAdminproduct()
	{
		$model=new Subproductprice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Subproductprice']))
			$model->attributes=$_GET['Subproductprice'];

		$this->render('adminproduct',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Subproductprice the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Subproductprice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Subproductprice $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='subproductprice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        public function actionAdjsearch()
	{
		$model=new Subproductprice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Subproductprice']))
			$model->attributes=$_GET['Subproductprice'];

		$this->render('Adjsearch',array(
			'model'=>$model,
		));
	}
}
