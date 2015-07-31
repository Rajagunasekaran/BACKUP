<?php

class ProductController extends Controller
{
    public $msg = '';
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
        public $prdcolumns = array('id','product_id','code','sku','disc','tax',
                                'unit_cp','unit_sp','spminusdisc','stock',
                                'name', 'imagepath',
                            );
    public function actions()
    {
        return array(
                Helper::CONST_toggle => array(
                        'class'=>'booster.actions.TbToggleAction',
                        'modelName' => 'Product',
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
            array( 'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array( 'admin', 'delete',
                            'create', 'update','createe',
                            Helper::CONST_toggle,
                            Helper::CONST_getPricesForAProduct,
                            Helper::CONST_multipriceproductsave,
                            Helper::CONST_bulkAddProductsAjax,
                            Helper::CONST_getProductlist,
							 Helper::CONST_getAllProducts,
							 Helper::CONST_getSubProductlist,'getCategoryProducts' ,'CheckProductname'
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
    private function setDefaults(&$model)
    {
        $model->enableprdcode = $this->getEnableprdcode();
        $model->enableprdauxname = $this->getEnableprdauxname();
        $model->category_id = Category::model()->getCategoryId( Helper::CONST_General , true );
        $model->taxrate_id = Taxrate::model()->getTaxrateId( Helper::CONST_No_Tax , true );
        $model->supplier_id = null;
        $model->person_id = Yii::app()->user->person->id;
        $model->sptype = 1;
    }
    private function getObject($id)
    {
        if(empty($id)) 
        {
            $model = new Product;
            $this->setDefaults($model);
        }
        else
        {
            $model = $this->loadModel( $id );
            if(empty($model->categories[0]->id))
            {
                $model->category_id = Category::model()->getCategoryId( Helper::CONST_General , true );
            }
            else
            {
                $model->category_id = $model->categories[0]->id;
            }
        }
        return $model;
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = $this->getObject(null);
       // $this->pageTitle = 'Create ' . get_class( Product::model() );
        $productprice = new Productprice;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if ( isset( $_POST['Product'] ) )
        {
            $rtn = true;
            if($rtn)
            {
                $this->redirect( Yii::app()->createUrl('productprice/admin') );
            }
        }

        $this->render( 'create', array(
            'model' => $model,
            'productprice' => $productprice,
        ) );
    }
        public function actionCreatee()
    {
        $model = $this->getObject(null);
        $this->pageTitle = 'Create ' . get_class( Product::model() );
        $productprice = new Productprice;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if ( isset( $_POST['Product'] ) )
        {
            $rtn = $this->saveOrUpdate($model);
            if($rtn)
            {
                $this->redirect( Yii::app()->createUrl('product/admin') );
            }
        }

        $this->render( 'createe', array(
            'model' => $model,
            'productprice' => $productprice,
        ) );
    }
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate( $id )
    {
        $productprice_id=$id;
        $rowsql = "select product_id from productprices where id=$id";
        $productId = Yii::app()->db->createCommand( $rowsql )->queryScalar();
        $rowsqlCategory = "select category_id from productcategories where productprice_id=$id";
        $categoryId = Yii::app()->db->createCommand( $rowsqlCategory )->queryScalar();
        $model = $this->getObject($productId);       
        $model->category_id =$categoryId;
     //   $this->pageTitle = 'Update ' . get_class( Product::model() );
        $productprice = new Productprice;
        $productprice ->id=$id;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if ( isset( $_POST['Product'] ) )
        {            
            //$rtn = $this->saveOrUpdate($model);
			$rtn=true;
            if($rtn)
            {
                $this->redirect( Yii::app()->createUrl('productprice/admin') );
            }
        }
        $rowsql = "select taxname from taxrates where id=$model->taxrate_id";
        $taxrate = Yii::app()->db->createCommand( $rowsql )->queryScalar();
        $model->taxrate_id=$taxrate;
        $this->render( 'update', array(
            'model' => $model,
            'productprice' => $productprice,'taxrate'=>$taxrate,
        ) );
    }
    private function saveOrUpdate($model)
    {
        $extcatid = $model->category_id;
        $extimgpath = $model->imagepath;
        $model->attributes = $_POST['Product'];
        $rtn = $this->updateProductInDB($model, $extcatid, $extimgpath);
        return $rtn;
    }
  public function updateProductInDB($model, $extcatid, $extimgpath, 
            $dealPrices = false, $newprices = array(), 
            $removedprices=array(), $existingprices = array()
    )
    {
      
        $isnew = empty($model->id);
        $rtn = false;
        $trans = Yii::app()->db->beginTransaction();
        try {
            $rtn = true;
            if ( $rtn )
            {

$prdPriceForm=array();
$prdPriceId=array();
        $criteria=new CDbCriteria;
       $condition = ' invno = '. '"'.$newprices[0]['invno'].'"';
        $criteria->condition = $condition;
        $productprice = Productprice::model()->findAll($criteria);
		foreach ($productprice as $prdpriceid)
                                {
        $prdPriceId []=$prdpriceid['id'];
                                }		
                                foreach ($newprices as $newprc)
                                {
                                    $prdprc = new Productprice;
                                    $prdprc->product_id = $model->id;                                   
                                    if($newprc['id']>0){
                                        $barcode  = $newprc['sku'];
                                                    $p_stock = $newprc['stock'];
                                                    $invoice = $newprc['invno'];
                                                    $beforestockcount = "select `stock` from `productprices` where `sku`='$barcode' and `invno`='$invoice'";
                                                    $beforestockresult = Yii::app()->db->createCommand( $beforestockcount )->queryScalar();     
                                                    $current_stock=$p_stock-$beforestockresult;
                                                    $stockupdate = "Update `subproductprices` set `stock`=`stock`+'$current_stock',`initial_stock`=`initial_stock`+'$current_stock' where `sku`='$barcode'";
                                                    Yii::app()->db->createCommand( $stockupdate )->execute();
                                                    $purchaselog= "select `sno` from `poslogreport` where `barcode`='$barcode' and `log_status`=0";
                                                    $purchaserecordid = Yii::app()->db->createCommand( $purchaselog )->queryScalar();
                                                    
                                                    
                                                    
                                                   if($current_stock!=0)
                                                   {
                                                    $previousstock= "select `stock` from `subproductprices` where `sku`='$barcode'";
                                                    $stockquantity = Yii::app()->db->createCommand( $previousstock )->queryScalar();
                                                    if($purchaserecordid=="")
                                                    {
                                                        $insertrowsql = "insert into `poslogreport`(`date`,`barcode`,`today_purchase`,`previous_stock`,`current_stock`) values(CURDATE(),'$barcode','$p_stock','$stockquantity','$stockquantity')";
                                                        Yii::app()->db->createCommand( $insertrowsql )->execute();  
                     
                                                    }
                                                    else
                                                    {   
                                                        $rowsqlupdate1 = "Update `poslogreport` set today_purchase=`today_purchase`+'$current_stock' where `barcode`='$barcode' and `log_status`=0";
                                                        Yii::app()->db->createCommand( $rowsqlupdate1)->execute(); 
                                                    }
                                                   }
				          $updateproductpricestock = "select `stock` from `subproductprices` where `sku`='$barcode'"; 
                                          $pre_stock = Yii::app()->db->createCommand( $updateproductpricestock )->queryScalar();
                                          $prdPriceForm []=$newprc['id'];
                                          $condition = 'id=' .$newprc['id'];                                         
                                           $criteria = new CDbCriteria;
                                           $criteria->condition = $condition;
                                           $productPrice = Productprice::model()->findAll( $criteria );                                                                                    
                                           $this->fillPriceFromPostToModel($productPrice[0], $newprc, true);
                                            $productPrice[0]->stockinhand = $pre_stock; 
                                           $productPrice[0]->id = $newprc['id'];
                                           $rtn =$productPrice[0]->save();
                                           $condition_prdcat = 'productprice_id=' .$newprc['id'];
                                           $command = Yii::app()->db->createCommand();
				           $command->update('productcategories', array(
					'category_id'=>$newprc['category_id'],'product_id'=>$newprc['product_id']
											), $condition_prdcat, array());
											
                                    }else
                                        {
                                            $this->fillPriceFromPostToModel($prdprc, $newprc, true);
                                            $barcode  = $newprc['sku'];
                                            $p_stock = $newprc['stock'];
                                            
                                            $updateproductpricestock = "select `stock` from `subproductprices` where `sku`='$barcode'"; 
                                            $pre_stock = Yii::app()->db->createCommand( $updateproductpricestock )->queryScalar(); 
                                            $prdprc->stockinhand = $pre_stock+$prdprc->stock; 
                                            $rtn = $prdprc->save();
                                            
                                            $rtn = $this->saveOrUpdatePrdprcCat($prdprc, $extcatid, $newprc['category_id']); 
                                            $inv_no = $pre_stock;// $prdprc->invno; 
                                            
                                            $previousstock= "select `stock` from `subproductprices` where `sku`='$barcode'";
                                            $stockquantity = Yii::app()->db->createCommand( $previousstock )->queryScalar();
                                            
                                            $rowsqlupdate = "Update `subproductprices` set `stock`=`stock`+'$p_stock',`initial_stock`=`initial_stock`+'$p_stock' where `sku`='$barcode'";
                                            Yii::app()->db->createCommand( $rowsqlupdate )->execute();
                                            
                                            $purchaselog= "select `sno` from `poslogreport` where `barcode`='$barcode' and `log_status`=0";
                                            $purchaserecordid = Yii::app()->db->createCommand( $purchaselog )->queryScalar();
                                                                                       
                                            if($purchaserecordid=="")
                                             {
                                               $insertrowsql = "insert into `poslogreport`(`date`,`barcode`,`today_purchase`,`previous_stock`,`current_stock`) values(CURDATE(),'$barcode','$p_stock','$stockquantity','$stockquantity')";
                                               Yii::app()->db->createCommand( $insertrowsql )->execute();                     
                                             }
                                            else
                                             {   
                                               $rowsqlupdate1 = "Update `poslogreport` set today_purchase=`today_purchase`+'$p_stock' where `barcode`='$barcode' and `log_status`=0";
                                               Yii::app()->db->createCommand( $rowsqlupdate1)->execute(); 
                                             }
                                    }
                                    $condition = 'product_id=' .$newprc['product_id'];
                                    $condition .= ' AND sku = ' . '"'.$newprc['sku'].'"';
                                            $criteria = new CDbCriteria;
                                            $criteria->condition = $condition;																				
                                            $subprdprc = Subproductprice::model()->findAll( $criteria );
                                            $subprdprc[0]->unit_cp =$newprc['unit_cp'];
                                             $subprdprc[0]->invno =$newprc['invno'];
                                               $subprdprc[0]->supplier_id =$newprc['supplier_id'];
                                            $subprdprc[0]->invdate = date('Y-m-d', strtotime(str_replace('/', '-', $newprc['invdate'])));
 
                                            $rtn =$subprdprc[0]->save();
                                       if(!$rtn)
                                    {
                                        $this->msg = $prdprc->getErrors();
                                        break;
                                    }
                                   
                                    if(!$rtn) break;
                                }
if(count($prdPriceId)!==count($prdPriceForm)){
$diff_prddb_prdfrm = array_diff($prdPriceId, $prdPriceForm);
$j=0;
foreach ($prdPriceId as $deletePrdid){
 $isnewss = !empty($diff_prddb_prdfrm[$j]);
 if($isnewss){
    $command = Yii::app()->db->createCommand();
$command->delete('productprices', 'id=:id', array(':id'=>$diff_prddb_prdfrm[$j]));
$condition_prdcat = 'productprice_id=' .$diff_prddb_prdfrm[$j];
$command->delete('productcategories', $condition_prdcat, array());
									   //$command->update('productcategories', $condition_prdcat, array());
}
$j++;
}
}
                        }
                        if($rtn){
                            try{
                                $this->setProductsLookupInState();//refresh
                            }catch (Exception $e) {
                            }
                        }                        
            else
            {
                $model->code = null;
                $this->msg = $model->getErrors();
            }
        }catch (Exception $e) {
            $rtn = false;
            Yii::log("Error occurred while saving/activating product. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
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
    public function fillPriceFromPostToModel(&$prdprc, $newprc, $isnew)
    {
        if($isnew)
        {
            if($this->getEnableautoprdcode())
            {
                $productcode = $this->generateCode(1, $prdprc->product->name);
            }else{
                $productcode = $newprc['code'];
            }
        }else{
            $productcode = $prdprc->code;
        }
        $prdprc->dontsyncwithstock = (empty($newprc['dontsyncwithstock'])?2:$newprc['dontsyncwithstock']);//$newprc['dontsyncwithstock'];
        $prdprc->code = $productcode;
        //$prdprc->code = $newprc['code'];
        $prdprc->sku = $newprc['sku'];
         $prdprc->product_id = $newprc['product_id'];
        if($newprc['expdate']!=''){
           $prdprc->expdate = date('Y-m-d', strtotime(str_replace('/', '-', $newprc['expdate'])));         
        }
        else{
           $prdprc->expdate =null;
        }
         $prdprc->invno = $newprc['invno'];
         $chk=$newprc['invdate'];
        $prdprc->invdate = date('Y-m-d', strtotime(str_replace('/', '-', $newprc['invdate'])));
        $prdprc->supplier_id = $newprc['supplier_id'];
        $prdprc->stock = $newprc['stock'];
        $prdprc->rol = (empty($newprc['rol'])?0:$newprc['rol']);
        $prdprc->moq = (empty($newprc['moq'])?0:$newprc['moq']);
        $prdprc->unit_cp = $newprc['unit_cp'];
        $prdprc->unit_sp = $newprc['unit_sp'];
        $prdprc->unit_sp_per = (empty($newprc['unit_sp_per'])?0:$newprc['unit_sp_per']);
    }
    public function saveOrUpdatePrdCat($model, $extcatid = null)
    {
        $product_id = $model->id;
        $category_id = $extcatid;
        
        $condition = 'product_id=' . $product_id;
        $condition .= ' AND category_id = ' . $category_id;
        
        $criteria = new CDbCriteria;
        $criteria->select = array( 'id' );
        $criteria->condition = $condition;
        $result = Productcategory::model()->findAll( $criteria );        
        if(count($result) > 0)
        {
            $prdcat = Productcategory::model()->findByPk( $result[0]->id );
        }
        else
        {
            $prdcat = new Productcategory;
        }
        $prdcat->product_id = $product_id;
        $prdcat->category_id = $model->category_id;
        return $prdcat->save();
    }
    public function saveOrUpdatePrdprcCat($model, $extcatid = null, $newcatid)
    {
        $product_id = $model->product_id;
        $productprice_id = $model->id;
        $result = array();
        if(!empty($extcatid))
        {
            $condition = 'product_id=' . $product_id;
            $condition .= ' AND productprice_id = ' . $productprice_id;
            $condition .= ' AND category_id = ' . $extcatid;

            $criteria = new CDbCriteria;
            $criteria->select = array( 'id' );
            $criteria->condition = $condition;
            $result = Productcategory::model()->findAll( $criteria );   
        }
        if(count($result) > 0)
        {
            $prdcat = Productcategory::model()->findByPk( $result[0]->id );
        }
        else
        {
            $prdcat = new Productcategory;
        }
        $prdcat->product_id = $product_id;
        $prdcat->productprice_id = $productprice_id;
        $prdcat->category_id = $newcatid;
        $rtn = $prdcat->save();
        if(!$rtn)
        {
            $this->msg = $prdcat->getErrors();
        }
        return $rtn;
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
        $dataProvider = new CActiveDataProvider( 'Product' );
        $this->render( 'index', array(
            'dataProvider' => $dataProvider,
        ) );
    }
    
    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Product( 'search' );
        $model->unsetAttributes();  // clear any default values
        $this->pageTitle = get_class( Product::model() );  
        $productprice = new Productprice();
        if ( isset( $_GET['Product'] ) )
            $model->attributes = $_GET['Product'];
        $this->render( 'admin', array(
            'model' => $model,'productprice'=>$productprice
        ) );
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel( $id )
    {
        $model = Product::model()->findByPk( $id );
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
        if ( isset( $_POST['ajax'] ) && $_POST['ajax'] === 'product-form' )
        {
            echo CActiveForm::validate( $model );
            
            Yii::app()->end();
        }
    }
    public function actionBulkAddProductsAjax()
    {
        if(empty($_POST['Product']))
        {
            $model = new Productprice( 'search' );
            $model->unsetAttributes();  // clear any default values
            if ( isset( $_GET['Product'] ) )
                $model->attributes = $_GET['Product'];

            $this->render( Helper::CONST_bulkAddProductsAjax, array(
                'model' => $model,
            ) );
            return;
        }
        $rtn = false;
        $failcount = 0;
        try 
        {
            $postedObjs = isset($_POST['Product'])?$_POST['Product']:array();
            foreach($postedObjs as $prdprcId => $obj)
            {
                $extcatid = -1;
                $extimgpath = null;                
                $model = $this->getObject(null);
                $model->category_id = $obj['category_id'];
                $model->name = $obj['product_id'];
                $removedprices = array();
                $existingprices = array();
                $newprices = array($obj['Productprice']);
                $rtn = $this->saveMultipriceProduct($model, $extcatid, $extimgpath, $newprices, $removedprices, $existingprices);
                if(!$rtn) $failcount++;
            }
        }catch (Exception $e) {
            $rtn = false;
            $failcount++;
            Yii::log("Error in updating stock. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
        }
        if($failcount == 0)
        {
            $data = Yii::app()->createUrl('productprice/admin');
            $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_Record_Updated;
        }
        else
        {
            $data = array();
            $rtnCode = Helper::CONST_SaveError;
            $message = Helper::CONST_Error_SomeOfRecordsFailed . "[$failcount]";
        }
        $this->returnJsonResponse($rtnCode, $data, $message);
    }
    public function actionMultipriceproductsave()
    {
        $postedData = $this->getPostedData();        
        $postedprices = $postedData['productprices'];
        $productfields = $postedData['Product'];
        $model = Product::model()->findByPk($productfields['id']);
        $criteria=new CDbCriteria;
       $condition = ' invno = '. '"'.$postedprices[0]['invno'].'"';
        $criteria->condition = $condition;
        $productprice = Productprice::model()->findAll($criteria);
//        $productprice = Productprice::model()->findByPk($productfields['id']);
        $rtn = !empty($model) && !empty($productprice);
        if($rtn)
        {
            $productprices = $model->productprices;
            $extcatid = $model->category_id;
            $extimgpath = $model->imagepath;
        }
        else
        {
            $model = new Product;
            $this->setDefaults($model);
            $extcatid = $model->category_id;
            $extimgpath = $model->imagepath;
            $productprices = array();
        }
        $model->attributes = $productfields;//
        $model->id=$productfields['id'];
        $removedprices = array();
        $existingprices = array();
        //$existingprices_catids = array();
//        foreach($productprices as $prdprc)
//        {
//            $foundinpost = false;
//            foreach($postedprices as $postprc)
//            {
//                $chhh=$prdprc->id;$kkk=$postprc['id'];
//                $foundinpost = ($prdprc->id == $postprc['id']);
//                if($foundinpost) break;
//            }
//            if(!$foundinpost)
//            {
//                $removedprices[] = $prdprc;
//            }
//            else
//            {                
//                $this->fillPriceFromPostToModel($prdprc, $postprc, false);
//                $existingprices[] = $prdprc;
//            }
//        }
//        $newprices = array();
//        foreach($postedprices as $postprc)
//        {
//            if(!($postprc['id'] > 0))
//            {
//                $newprices[] = $postprc;
//            }
//        }

        $rtn = $this->saveMultipriceProduct($model, $extcatid, $extimgpath, $postedprices, $removedprices, $existingprices);
      //return $rtn;
	 // $rtn=true;
	  
	   if($rtn)
        {
            $data = Yii::app()->createUrl('productprice/admin');
            $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_Record_Updated;
        }
        else
        {
            $data = $this->msg;
            $rtnCode = Helper::CONST_SaveError;
            $message = Helper::CONST_Error_Message;
        }
		//echo json_encode($data);
        $this->returnJsonResponse($rtnCode, $data, $message);
    }
    public function saveMultipriceProduct($model, $extcatid, $extimgpath,
            $newprices, $removedprices, $existingprices)
    {
        $dealPrices = true;
        $rtn = $this->updateProductInDB($model, $extcatid, $extimgpath, 
            $dealPrices, $newprices, $removedprices, $existingprices);
        return $rtn;
    }
    public function actionGetPricesForAProduct()
    {
   $postedData = $this->getPostedData();
   $id = $postedData['Productprice_id'];       
   $rowsql = "select invno from productprices where id=$id";
   $invno = Yii::app()->db->createCommand( $rowsql )->queryScalar();
   $rowsql ='select pp.code,pp.sku,pp.invno,pp.invdate from products p JOIN productprices pp on pp.product_id=p.id  where  pp.invno="inv001"';
   $result = Yii::app()->db->createCommand( $rowsql )->queryAll();
   $data=$result;  
   $record =  Product::model()
                        ->with(array(
                                'productprices' => array('condition'=>'productprices.invno='.'"'.$invno.'"'),                            
                                )
                        )->together()->findAll();
						  // return $record;
	 $condition = 'invno='.'"'.$invno.'"'.' AND product_id= '.$postedData['Product_id'];
         $criteria = new CDbCriteria;
         $criteria->condition = $condition;   
         $record = Productprice::model()->findAll( $criteria ); 
         $json = new CArJSON;					   
         $relations = array();
            $attributes = array(              			
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
			return $this->returnJsonResponse($RetCode , $record , 'Success');			
			}
			//***********************************
//         $criteria->with =array();
        $postedData = $this->getPostedData();
        $product_id = $postedData['product_id'];
        $criteria=new CDbCriteria;
        $criteria->addCondition('status = 1');
        $data = Product::model()->findByPk($product_id, $criteria);        
        if(!empty($data))
        {
            $json = new CArJSON;
            $relations = array(array('productprices'=>array('supplier')));
            // array('product') or array(array('product'=>array('taxrate')))            
            $attributes = array(
                'root' => array('id','name'),//null,//array of attribute names
                'productprices'=> array(),
                'supplier' => array('id','lookupDisplay'),//null,//array of attribute names
            );
            $isarray = true;
            $data = $json->toJSON($data, $relations, $attributes, $isarray);
            $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_PRDPRICES_LIST;
        }
        else
        {
            $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_NotFound_Message;
        }
             $rtnCode = Helper::CONST_Error_None;
             $message = Helper::CONST_NotFound_Message;
         $this->returnJsonResponse($rtnCode, $data, $message);
    }
    public function actionGetProductlist(){
        $postedData = $this->getPostedData();
            $condition = 'category_id='.$postedData['categoryId'];
            $criteria = new CDbCriteria;
            $criteria->select = array( 'product_id' );
            $criteria->condition = $condition;        
            $result = Masterproductcategory::model()->findAll( $criteria );    
        $chk1 =$result[0];
        $chk =$result[0]->product_id ;
        if(count($result) > 0)
        {
            $data = Product::model()->findByPk( $result[0]->product_id );
        }  
        $json = new CArJSON;            
      $relations = array();
            $attributes = array(
                'root' => array()				
            );
            $isarray = true;
              $data = $json->toJSON($data, $relations, $attributes, $isarray);
                $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_NotFound_Message;
   $this->returnJsonResponse($rtnCode, $data, $message);
   
    }	
	public function actionGetSubProductlist(){
        $postedData = $this->getPostedData();
         $productdata = Product::model()->findByPk( $postedData['productId'] );
            if(count($productdata) > 0)
        {
            $criteria = new CDbCriteria;
            $condition = 'product_id='.$postedData['productId'];
            $criteria->condition = $condition;
	    $productprice = Subproductprice::model()->findAll($criteria);
        }  
        $json = new CArJSON;            
        $relations = array();
            $attributes = array(
                'root' => array()                
            );
            $isarray = true;
              $product = $json->toJSON($productdata, $relations, $attributes, $isarray);
			     $relations = array();
            $attributes = array(
                'root' => array()				
            );
              $isarray = true;
              $productprice = $json->toJSON($productprice, $relations, $attributes, $isarray);
                $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_NotFound_Message;
            $criteria = new CDbCriteria;
            $criteria->select = array('id','taxname');
	    $taxrates = Taxrate::model()->findAll($criteria);
            $json = new CArJSON;            
        $relations = array();
            $attributes = array(
                'root' => array()                
            );
            $isarray = true;
              $taxrates = $json->toJSON($taxrates, $relations, $attributes, $isarray);
    $data = array(
               //Helper::CONST_prdskuToIdMap => $prdskuToIdMap,
               Helper::CONST_allproducts_short => $product,
               Helper::CONST_sec_cat_products => $productprice,'tax'=>$taxrates);
       	   $this->returnJsonResponse($rtnCode, $data, $message);
   
    }
    public function actionGetOrderProductsForABill()
    {
        $postedData = $this->getPostedData();
        $qoi_id = $postedData['billnumber'];
        $criteria=new CDbCriteria;
        $criteria->with = array('statusmaster');
        $criteria->compare('LCASE(qoi_id)',strtolower($qoi_id));
        $stsary = array(
            strtolower(Helper::CONST_REFUNDOLD),
            strtolower(Helper::CONST_REFUNDNEW),
            strtolower(Helper::CONST_CANCELOLD),
            strtolower(Helper::CONST_CANCELNEW)
                    );
        $criteria->addNotInCondition('LCASE(statusmaster.name)', $stsary);
        $data = Order::model()->findAll($criteria);
        if(!empty($data))
        {
            $json = new CArJSON;
            // Define which relations do you want to load
            //$relations = array('product');            
            $relations = array(array('orderproducts'=>array('productprice')));
            // array('product') or array(array('product'=>array('taxrate')))
            // Define which attributes, foreach relations do you want to load
            // root denote attributes for the main model  
            $attributes = array(
                'root' => array('id','disc','roundoff'),//null,//array of attribute names
                'orderproducts'=> array(),
                'productprice' => $this->prdcolumns,
                //'taxrate' => array(),
            );
            $isarray = true;
            $data = $json->toJSON($data, $relations, $attributes, $isarray);
            $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_ORDERPRD_LIST;
        }
        else
        {
            $rtnCode = Helper::CONST_Error_None; 
            $message = Helper::CONST_NotFound_Message;
        }
        //$edata = $this->getJsonOfData($rtnCode, $data, $message);
        //$this->writeToCookie(Helper::CONST_orderproducts, $edata);
        $this->returnJsonResponse($rtnCode, $data, $message);
    }
	
  //GET PRODUCT NAME FOR PARTICULAR CATEGORY  
  public function actiongetCategoryProducts()
   {
     $postedData = $this->getPostedData();
     $productcategoryval = $postedData['productcategory']; 
     $sql = "SELECT distinct p.name,p.id FROM products p,masterproductcategories mpc  WHERE mpc.product_id=p.id and category_id=". $productcategoryval ;
       $command = Yii::app()->db->createCommand($sql);
       $result = $command->queryAll(); 
       $arr = array('prodname' => $result);
       echo json_encode($arr);        
   }
   //CHECK UNIQUE PRODUCT NAME
public function actionCheckProductname()
{
      $postedData = $this->getPostedData();
       $product_name = strtolower(trim($postedData['prd_name'])); 
       $product_id = trim($postedData['prd_id']);
        if(!empty($product_id))
       {
               $sql = "SELECT name from products where LCASE(name)='$product_name' and id!='$product_id'";

       }
       else{
                   $sql = "SELECT name from products where LCASE(name)='$product_name'";
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
 
}