<?php

class ProductpriceController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    
    public function actions()
    {
        return array(
                Helper::CONST_toggle => array(
                        'class'=>'booster.actions.TbToggleAction',
                        'modelName' => 'Productprice',
                        )
                );
    }
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
//            array( 'allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array( 'create', 'update' ),
//                'users' => array( '@' ),
//            ),
            array( 'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('create', 'update', 'admin', 'delete' ,'pricehistory','managestock','ExpirydateProductList','StockReport',
                                Helper::CONST_toggle,
                                Helper::CONST_updateProductStockAjax,
                                Helper::CONST_bulkupdateProductStockAjax,
                                Helper::CONST_viewProductPrices,'getPricesForAProduct',
'getinvoiceno'
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Productprice;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if ( isset( $_POST['Productprice'] ) )
        {
            $model->attributes = $_POST['Productprice'];
            if ( $model->save() )
                $this->redirect( array( 'view', 'id' => $model->id ) );
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
// $this->performAjaxValidation($model);

        if ( isset( $_POST['Productprice'] ) )
        {
            $model->attributes = $_POST['Productprice'];
            if ( $model->save() )
                $this->redirect( array( 'view', 'id' => $model->id ) );
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
// we only allow deletion via POST request
            $model = $this->loadModel( $id );
            $model->status = 0;
            $rtn = $model->save();

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
        $dataProvider = new CActiveDataProvider( 'Productprice' );
        $this->render( 'index', array(
            'dataProvider' => $dataProvider,
        ) );
    }
    public function actionToggleStatus($pk, $attribute)
    {
        if (Yii::app()->getRequest()->isPostRequest) {
                $model = $this->loadModel($pk);
                $model->$attribute = ($model->$attribute == 0) ? 1 : 0;
                $success = $model->save();
                if (Yii::app()->getRequest()->isAjaxRequest) {
                        echo $success ? 1 : 0;
                        exit(0);
                }
        } else {
                throw new CHttpException(Yii::t('zii', 'Invalid request'));
        }
    }    
    public function actionBulkupdateProductStockAjax()
    {
        $rtn = false;
        $trans = Yii::app()->db->beginTransaction();
        try 
        {
            $postedStocks = isset($_POST['Product'])?$_POST['Product']:array();
            foreach($postedStocks as $prdprcId => $obj)
            {
                $postedStock = $obj['Productprice']['stock'];
                $rtn = $this->updateStockFields($prdprcId, 'stock', $postedStock);
                if(!$rtn) break;
            }
        }catch (Exception $e) {
            $rtn = false;
            Yii::log("Error in updating stock. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
        }
        if($rtn)
        {
            $trans->commit();
            $data = array();
            $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_Record_Updated;
        }
        else
        {
            $trans->rollback();
            $data = array();
            $rtnCode = Helper::CONST_SaveError;
            $message = Helper::CONST_Error_Message;
        }
        $this->returnJsonResponse($rtnCode, $data, $message);
    }
    public function actionUpdateProductStockAjax()
    {
        $rtn = false;
        $trans = Yii::app()->db->beginTransaction();
        try 
        {
            $id = $_POST['pk'];
            $attrname = $_POST['name'];
            $attrvalue = $_POST['value'];

            if ( $attrname === 'stock'
                    || $attrname === 'rol'
                    || $attrname === 'moq'
            )
            {
                $rtn = $this->updateStockFields($id, $attrname, $attrvalue);                
            }
        }catch (Exception $e) {
            $rtn = false;
            Yii::log("Error in updating stock. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
        }
        if($rtn)
        {
            $trans->commit();
            $data = array();
            $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_Record_Updated;
        }
        else
        {
            $trans->rollback();
            $data = array();
            $rtnCode = Helper::CONST_SaveError;
            $message = Helper::CONST_Error_Message;
        }
        $this->returnJsonResponse($rtnCode, $data, $message);
    }
    public function updateStockFields($id, $attrname, $attrvalue)
    {
        $productprice = Productprice::model()->findByPk($id);
        $rtn = !empty($productprice);
        if($rtn)
        {
            $oldstock = $productprice->stock;
            $productprice->$attrname = $attrvalue;
            if($attrname === 'stock')
            {
                $productprice->stockvalue = $productprice->unit_cp * $attrvalue;
            }
            $rtn = $productprice->save();
            if($rtn)
            {
                if($attrname === 'stock')
                {
                    $rtn = $this->updateStockchangeHistory($productprice, $oldstock);
                }
            }
        }
        return $rtn;
    }
    public function updateStockchangeHistory($productprice, $oldstock)
    {
        $date = date($this->datetimemysqlformatYMDHIS);
        $prdid = $productprice->product_id;
        $prdprcid = $productprice->id;
        $newstock = $productprice->stock;
        $history = new Productstockhistory;
        $history->product_id = $prdid;
        $history->productprice_id = $prdprcid;
        $history->updationdate = $date;
        $history->beforeupdation = $oldstock;
        $history->afterupdation = $newstock;
        $history->updatedqnty = $newstock - $oldstock;
        return $history->save();
    }
    public function actionViewProductPrices($id)
    {
        $model = new Productprice( 'search' );
        $model->unsetAttributes();  // clear any default values
        if ( isset( $_GET['Productprice'] ) )
            $model->attributes = $_GET['Productprice'];
        $model->product_id = $id;
        $this->render( 'admin', array(
            'model' => $model,
        ) );
    }
    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Productprice( 'search' );
        $model->unsetAttributes();  // clear any default values
        if ( isset( $_GET['Productprice'] ) )
            $model->attributes = $_GET['Productprice'];

        $this->render( 'admin', array(
            'model' => $model,
        ) );	
    }
/********Show the each product purcahse details*************/
    public function actionPricehistory()
{
        $model = new Productprice;
        $model->unsetAttributes();  // clear any default values
        if ( isset( $_GET['Productprice'] ) )
            $model->attributes = $_GET['Productprice'];
        $id=$_GET['id'];
       
        $this->render('pricehistory', array(
            'model' => $model,'id'=>$id,
        ) );
       
   
}
/********Show the each product purcahse details*************/
    public function actionManagestock()
{
        $model = new Productprice('search');
        $model->unsetAttributes();  // clear any default values
        if ( isset( $_GET['Productprice'] ) )
            $model->attributes = $_GET['Productprice'];
   
       
        $this->render('managestock', array(
            'model' => $model,
        ) );
       
   
}
/********Duplicate checking for invoice number*************/
 public function actiongetinvoiceno()
   {
        $postedData = $this->getPostedData();
        $invoiceno = strtolower(trim($postedData['InvoiceNO']));
        $productprice_id = $postedData['Id'];
                  if(!empty($productprice_id))
       {
                          $condition = 'id=' .$productprice_id;                                    
                                            $criteria = new CDbCriteria;
                                            $criteria->condition = $condition;																				
                                            $Prdprice = Productprice::model()->findAll( $criteria );
                                            $invno_update=strtolower(trim($Prdprice[0]->invno)) ;
               $sql = "SELECT invno from productprices where LCASE(invno)='$invoiceno' and LCASE(invno)!='$invno_update'";
       }
       else{
                   $sql = "SELECT invno from productprices where LCASE(invno)='$invoiceno'";
       }
 $command = Yii::app()->db->createCommand( $sql );
     $result = $command->queryAll();
     if(count($result)>0)
              {
            $message = 'true';
        } else {
            $message = 'false';
        }
        echo $message;         
  }
//***********LOAD THE PRODUCT PRICE RECORDS USING AJAX**********
    public function actionGetPricesForAProduct()
    {
   $postedData = $this->getPostedData();
   $id = $postedData['Productprice_id'];       
   $rowsql = "select invno from productprices where id=$id";
   $invno = Yii::app()->db->createCommand( $rowsql )->queryScalar();
         $condition = 'invno='.'"'.$invno.'"';
         $criteria = new CDbCriteria;
         $criteria->condition = $condition; 
         $record = Productprice::model()->findAll( $criteria ); 
         $json = new CArJSON;			   

            $relations = array('supplier');
            // array('product') or array(array('product'=>array('taxrate')))            
            $attributes = array(
                'root' => array(),//null,//array of attribute names
                'supplier' => array('id','lookupDisplay'),//null,//array of attribute names
            );
            $isarray = true;			
              $product = $json->toJSON($record, $relations, $attributes, $isarray);
			 // return true;
            if(empty($product))
            {
			return false;
            }
			else{
			$RetCode ='success';
			return $this->returnJsonResponse($RetCode , $product , 'Success');			
			}

    }
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel( $id )
    {
        $model = Productprice::model()->findByPk( $id );
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
        if ( isset( $_POST['ajax'] ) && $_POST['ajax'] === 'productprice-form' )
        {
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }
    }
    /***********EXPIRY PRODUCT LIST****************/
public function actionExpirydateProductList()
        {  
            $model = new Productprice();
            if ( isset( $_GET['Productprice'] ) )
                $model->attributes = $_GET['Productprice'];
              $this->render('Expirydateproductlist', array(
                 'model' => $model,
               ));
        }
      public function actionStockReport()
        {           
            $model = new Productprice('stockreport'); 
            $model->unsetAttributes();
            if ( isset( $_GET['Productprice'] ) )
             $model->attributes = $_GET['Productprice'];
                           $this->render('stockreport', array(
                 'model' => $model,
               ));
                   
        }

}
