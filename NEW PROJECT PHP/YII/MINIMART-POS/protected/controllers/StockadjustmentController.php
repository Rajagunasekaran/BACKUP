<?php

class StockadjustmentController extends Controller
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
				'actions'=>array('create','update','Adjsearch','posStockAdjustment','StockAdjustmentList','Refduplicatecheck'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','Adjsearch','posStockAdjustment','StockAdjustmentList'),
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
		$model=new Stockadjustment;

		if(isset($_POST['Stockadjustment']))
		{
			$model->attributes=$_POST['Stockadjustment'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->sno));
		}
		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['Stockadjustment']))
		{
			$model->attributes=$_POST['Stockadjustment'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->sno));
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
		$dataProvider=new CActiveDataProvider('Stockadjustment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Stockadjustment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Stockadjustment']))
			$model->attributes=$_GET['Stockadjustment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        public function actionAdjsearch()
	{               
                $id=$_GET['id'];
                
                            $model=Subproductprice::model()->findByPk($id);
          		$this->render('Adjsearch',array(
			'model'=>$model,
		));               
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Stockadjustment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Stockadjustment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    
        public function actionPosStockAdjustment()
        {
            $postedData = $this->getPostedData();
             if ( isset( $_POST['Subproductprice'] ) )
               {
            $this->redirect( Yii::app()->createUrl('subproductprice/admin') );
               }
            try
            {
            $id=$postedData['product_id'];
            $refno=$postedData['refno'];
            $date=$postedData['date'];
            $code=$postedData['code'];
            $sku=$postedData['sku'];
            $stock=$postedData['stock'];
            $finalstock=$postedData['final_stock'];
            $remarks=$postedData['Remarks'];
            $updatequery="update subproductprices set `stock`=`stock`+'$finalstock',`initial_stock`=`initial_stock`+'$finalstock' where `sku`='$sku'";
            Yii::app()->db->createCommand( $updatequery )->execute();
            $insertQuery="insert into stockadjustment(product_id,referenceno,dateofadjustment,code,sku,stock,stock_adjustment,Remarks)values('$id','$refno','$date','$code','$sku','$stock','$finalstock','$remarks')";
            $rtn=Yii::app()->db->createCommand( $insertQuery )->execute();
            $rowsqlquery = "select `sno` from `poslogreport` where `barcode`='$sku' and `log_status`=0";
            $resultset = Yii::app()->db->createCommand( $rowsqlquery )->queryScalar();
            if($resultset=="")
            {
            $insertrowsql = "insert into `poslogreport`(`date`,`barcode`,`previous_stock`,`current_stock`,`stock_adjustment`) values(CURDATE(),'$sku','$stock','$stock','$finalstock')";
            Yii::app()->db->createCommand( $insertrowsql )->execute();    
            }
            else 
            {
            $logupdatequery="update `poslogreport` set `stock_adjustment`='$finalstock' where `barcode`='$sku' and `log_status`=0";
            Yii::app()->db->createCommand( $logupdatequery)->execute();
            }
            }
            catch(Exception $e)
            {
              $rtn=false;  
            }
            if($rtn)
            {           
            $RetCode = Helper::CONST_Error_None;
            $message = '$result';
            $data = Yii::app()->createUrl('/subproductprice/admin');
            }
          else
            {
            $trans->rollback();
            $RetCode = Helper::CONST_Error;
            $message = 'Error';
            $data = array();
            }
            $this->returnJsonResponse($RetCode, $data, $message); 
        }

	/**
	 * Performs the AJAX validation.
	 * @param Stockadjustment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='stockadjustment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        public function actionStockAdjustmentList()
        {  
            $model = new Stockadjustment();
            if ( isset( $_GET['Stockadjustment'] ) )
                $model->attributes = $_GET['Stockadjustment'];
            if(!empty( $_GET['actionid'] ) && $_GET['actionid'] == Helper::CONST_PDF)
            {
                $html = $this->renderPartial('stockadjustmentlist', array(
                            'model' => $model,
                        ),true );
                $this->writeToPdf( $html );
            }
            else
            {
              $this->render('stockadjustmentlist', array(
                 'model' => $model,
               ));
            }
        }
        
        public function actionRefduplicatecheck()
        {
        $postedData = $this->getPostedData();
        $refno = $postedData['refno'];
//        echo $refno;
//        exit();
        $criteria = new CDbCriteria();
        $criteria->condition = 'referenceno=:referenceno';
        $criteria->params = array(':referenceno'=>$refno);
        if (Stockadjustment::model()->exists($criteria)) 
        {
            $message = 'true';
        } else {
            $message = 'false';
        }
        echo $message;  
        }
}
