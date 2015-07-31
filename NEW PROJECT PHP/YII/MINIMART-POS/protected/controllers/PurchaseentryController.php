<?php

class PurchaseentryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        public $prdcolumns = array('id','product_id','code','sku','disc','tax',
                                'unit_cp','unit_sp','spminusdisc','stock',
                                'name', 'imagepath',
                            );
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
				                'actions' => array( 'admin', 'delete',
                            'create', 'update','createe',
                            Helper::CONST_toggle,
                            Helper::CONST_getPricesForAProduct,
                            Helper::CONST_multipriceproductsave,
                            Helper::CONST_bulkAddProductsAjax,
                            Helper::CONST_viewProductPrices,'checktrans',
                        ),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$model=new Product;
 $subproductprice = new Subproductprice;
		// Uncomment the following line if AJAX validation is needed
      if ( isset( $_POST['Product'] ) )
        {
            $rtn = $this->saveOrUpdate($model);
            if($rtn)
            {
                $this->redirect( Yii::app()->createUrl('subproductprice/adminproduct') );
            }
        }
        $this->render( 'create', array(
            'model' => $model,
            'subproductprice' => $subproductprice,
        ) );
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        $productprice_id=$id;
        $rowsql = "select product_id from subproductprices where id=$id";
        $productId = Yii::app()->db->createCommand( $rowsql )->queryScalar();
        $rowsql = "select category_id from masterproductcategories where productprice_id=$id";
        $categoryid = Yii::app()->db->createCommand( $rowsql )->queryScalar();


 
        $model = $this->getObject($productId);
//        $this->pageTitle = 'Update ' . get_class( Product::model() );
        $subproductprice = new Subproductprice;
// Uncomment the following line if AJAX validation is needed

        if ( isset( $_POST['Product'] ) )
        {            
            $rtn=$this->saveOrUpdate($model);
            if($rtn)
            {
                $this->redirect( Yii::app()->createUrl('subproductprice/adminproduct') );
            }
        }
       $this->render( 'update', array(
            'model' => $model,
            'subproductprice' => $subproductprice,'categoryid'=>$categoryid,
        ) );
	}
           /****GET OBJECT FOR PRODUCT ***************/
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
/******************************GET PRICES FOR A PRODUCT TO SHOW THE SUBPRODUCTPRICE DATA IN FT ***************/
     public function actionGetPricesForAProduct()
    {
        $postedData = $this->getPostedData();
        $product_id = $postedData['product_id'];
        $criteria=new CDbCriteria;
        $criteria->addCondition('status = 1');
        $data = Product::model()->findByPk($product_id, $criteria);
        if(!empty($data))
        {
            $json = new CArJSON;
            $relations = array(array('subproductprices'=>array('supplier')));        
            $attributes = array(
                'root' => array('id','name'),//null,//array of attribute names
                'subproductprices'=> array(),
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
        $this->returnJsonResponse($rtnCode, $data, $message);
    }
        /****SAVING PART FOR MASTER PRODUCT WHILE CREATING AND UPDATING ***************/
     /****SAVING PART FOR MASTER PRODUCT WHILE CREATING AND UPDATING ***************/
    public function actionMultipriceproductsave()
    {
        $postedData = $this->getPostedData();        
        $postedprices = $postedData['productprices'];
        $productfields = $postedData['Product'];
        $model = Product::model()->findByPk($productfields['id']);
        $rtn = !empty($model);
        if($rtn)
        {
            $productprices = $model->subproductprices;
            $extcatid = $model->category_id;
            $extimgpath = $model->imagepath;
             $extimgpath = $productfields['imagepath'];
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
        $removedprices = array();
        $existingprices = array();
         $extimgpath = $productfields['imagepath'];        
        $rtn = $this->saveMultipriceProduct($model, $extcatid, $extimgpath, $postedprices, $removedprices, $existingprices);
        if($rtn)
        {
            $data = Yii::app()->createUrl('purchaseentry/admin');
            $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_Record_Updated;
        }
        else
        {
            $data = $this->msg;
            $rtnCode = Helper::CONST_SaveError;
            $message = Helper::CONST_Error_Message;
        }
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
         private function saveOrUpdate($model)
    {
        $extcatid = $model->category_id;
        $extimgpath = $model->imagepath;
        $model->attributes = $_POST['Product'];
        $image=$model->imagepath;
                            $uploadedFile=CUploadedFile::getInstance($model,'imagepath'); 
                    if(!empty($uploadedFile))  // check if uploaded file is set or not
                    {
                        $fileName = $uploadedFile->name;
                        $model->imagepath = $fileName;
                        $chk=$model->imagepath ;
                         $model->person_id = 1;
                        $uploadedFile->saveAs($this->imageRealPath . $fileName);
                    }
                    $rtn=true;
        return $rtn;
    }
       public function updateProductInDB($model, $extcatid, $extimgpath, 
            $dealPrices = false, $newprices = array(), 
            $removedprices=array(), $existingprices = array()
    )
    {
           $imagepath=null;     
            $isnew = empty($model->id);
            if((!$isnew)&&($extimgpath == '')){
        $rowsqlCategory = "select imagepath from products where id=$model->id";
           $imagepath = Yii::app()->db->createCommand( $rowsqlCategory )->queryScalar();}       
        $rtn = false;
        $trans = Yii::app()->db->beginTransaction();
        try {
            if($isnew)
            {
                if($this->getEnableautoprdcode())
                {
                    $productcode = $this->generateCode(1, $model->name);
                }else{
                    $productcode = $model->code;
                }
            }else{
                $productcode = $model->code;                
            }
            $model->code = $productcode;            
            $rtn = $model->save(false,$model);
            if ( $rtn )
            {
                //$rtn = $this->saveOrUpdatePrdCat($model, $extcatid);
                if($rtn){
                    $uploadedFile=CUploadedFile::getInstance($model,'imagepath'); 
                    if(!empty($uploadedFile))  // check if uploaded file is set or not
                    {
                        $fileName = $uploadedFile->name;
                        $model->imagepath = $fileName;
                        $chk=$model->imagepath ;
                         $model->person_id = 1;
                        $rtn = $model->save();
                        $uploadedFile->saveAs($this->imageRealPath . $fileName);
                    }
                    else
                    {
                        if(!$isnew)
                        {
                            $model->person_id = 1;
                            $model->imagepath = $extimgpath;
                            $chk=$model->imagepath ;
                            //$this->performAjaxValidation($model);
                            if(count($imagepath)>0){
                            $model->imagepath =$imagepath;
                            }
                            $rtn = $model->save();
                        }
                    }
                    if($rtn){
                        // if($dealPrices)
                        // {
                            if($rtn)
                            {
		             $prdPriceForm1=array();
			     $prdPriceId=array();
	                     $criteria=new CDbCriteria;
								    $condition = ' product_id = '. '"'.$model->id.'"';
									$criteria->condition = $condition;
									$productprice = Subproductprice::model()->findAll($criteria);
									foreach ($productprice as $prdpriceid)
										{
										$prdPriceId []=$prdpriceid['id'];
										}	
                                foreach ($newprices as $newprc)
                                {				
								          if($newprc['id']>0){								  
				                          $prdPriceForm1 []=$newprc['id'];										 
                                          $condition = 'id=' .$newprc['id'];
                                           $criteria = new CDbCriteria;
                                           $criteria->condition = $condition;
                                           $productPrice = Subproductprice::model()->findAll( $criteria );
                                           $condition_prdSku='sku=' .'"'.$productPrice[0]->sku.'"';
                                           $condition_poslogSku='barcode=' .'"'.$productPrice[0]->sku.'"';
                                           $this->fillPriceFromPostToModel($productPrice[0], $newprc, true);                                          
				           $productPrice[0]->product_id = $model->id;
                                           $rtn =$productPrice[0]->save(false,null);										  
                                           $condition_prdcat = 'productprice_id=' .$newprc['id'];
                                           $command = Yii::app()->db->createCommand();
				           $command->update('masterproductcategories', array(
					'category_id'=>$newprc['category_id'],'product_id'=>$newprc['product_id']
											), $condition_prdcat, array());
						 $command->update('productprices', array(
                                       'code'=>$newprc['code'],'sku'=>$newprc['sku']
                                                                                       ), $condition_prdSku, array());
                                                 $command->update('poslogreport', array(
                                       'barcode'=>$newprc['sku']), $condition_poslogSku, array());
					
                                    }else{									
									 $prdprc = new Subproductprice;
									 $prdprc->product_id = $model->id;
                                     $this->fillPriceFromPostToModel($prdprc, $newprc, true);
                                   $rtn = $prdprc->save(false,null);
	                            $rtn = $this->saveOrUpdatePrdprcCat($prdprc, $extcatid, $model->category_id);
                                    }
									
                                    // $prdprc = new Subproductprice;
                                    // $prdprc->product_id = $model->id;
                                    // $this->fillPriceFromPostToModel($prdprc, $newprc, true);
                                    // $rtn = $prdprc->save(false,null);
                                    // if(!$rtn)
                                    // {
                                        // $this->msg = $prdprc->getErrors();
                                        // break;
                                    // }
                                    // $rtn = $this->saveOrUpdatePrdprcCat($prdprc, $extcatid, $model->category_id);
                                    if(!$rtn) break;
                                }  	//*************DELETION PART************************
								//echo json_encode($prdPriceId);
								//echo json_encode(array(count($prdPriceId),count($prdPriceForm)));exit;
								//if(count($prdPriceId)!== count($prdPriceForm1)){
								if(5!== 5){
$diff_prddb_prdfrm = array_diff($prdPriceId, $prdPriceForm1);
$j=0;
foreach ($prdPriceId as $deletePrdid){
 $isnewss = !empty($diff_prddb_prdfrm[$j]);
 if($isnewss){
    $command = Yii::app()->db->createCommand();
$command->delete('subproductprices', 'id=:id', array(':id'=>$diff_prddb_prdfrm[$j]));
$condition_prdcat = 'productprice_id=' .$diff_prddb_prdfrm[$j];
$command->delete('masterproductcategories', $condition_prdcat, array());
									   //$command->update('productcategories', $condition_prdcat, array());
}
$j++;
} 
//echo $k;exit;
}
								$trans->commit(); 
                            }
                        // }
//                        if($rtn){
//                            try{
//                                $this->setProductsLookupInState();//refresh
//                            }catch (Exception $e) {
//
//                            }
//                        }                        
                    }
                }else{
                    Yii::log("Error occurred while saving/activating product. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
                }
            } else
            {
                $model->code = null;
                $this->msg = $model->getErrors();
            }
        }catch (Exception $e) {
            $rtn = false;
            Yii::log("Error occurred while saving/activating product. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
        }  
        return $rtn;
    }
     //CHECKING TRANS. WHILE CHANGING CATEGORY
        public function actionChecktrans()
    {
                    $postedData = $this->getPostedData();
        $product_id = $postedData['productId'];
//       $values=array();
         $condition = 'product_id=' .$product_id;                                    
                                            $criteria = new CDbCriteria;
                                            $criteria->condition = $condition;                                                                                
                                            $Prdprice = Productcategory::model()->findAll( $criteria );     
                                            $mastercate = Masterproductcategory::model()->findAll( $criteria );  
                                       if(count($Prdprice)>0) {                                           
                                           $categoryFlag=(object)["flag"=>false,"catId"=>$mastercate[0]->category_id];
//                                           $values[]=$categoryFlag;     
                                              }                     
                                     
                                        else
                                         $categoryFlag=(object)["flag"=>false];
                                         echo json_encode($categoryFlag);
                                         
                                       }
    /**** SET DEFAULT VALUES *************/
        private function setDefaults(&$model)
    {
        $model->enableprdcode = $this->getEnableprdcode();
        $model->enableprdauxname = $this->getEnableprdauxname();
        $model->category_id = Category::model()->getCategoryId( Helper::CONST_General , true );
//        $model->taxrate_id = Taxrate::model()->getTaxrateId( Helper::CONST_No_Tax , true );
         $model->taxrate_id = null;
        $model->supplier_id = null;
        $model->person_id = Yii::app()->user->person->id;
        $model->sptype = 1;
    }
	/********************* ARRAGING VALUES COPY FROM PRODUCT *************/
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
        $prdprc->supplier_id = $newprc['supplier_id'];
        $prdprc->rol = (empty($newprc['rol'])?0:$newprc['rol']);
        $prdprc->moq = (empty($newprc['moq'])?0:$newprc['moq']);
        $prdprc->unit_cp = $newprc['unit_cp'];
        $prdprc->unit_sp = $newprc['unit_sp'];
        $prdprc->unit_sp_per = (empty($newprc['unit_sp_per'])?0:$newprc['unit_sp_per']);
    }
    /************************SAVING PART FOR CATEGORY *******************************/
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
            $result = Masterproductcategory::model()->findAll( $criteria );   
        }
        if(count($result) > 0)
        {
            $prdcat = Masterproductcategory::model()->findByPk( $result[0]->id );
        }
        else
        {
            $prdcat = new Masterproductcategory;
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
    /** GET SUB PRODUCT LIST TO VIEW IN DATA TABLE ********************/
        public function actionViewProductPrices($id)
    {
        $model = new Subproductprice( 'search' );
        $model->unsetAttributes();  // clear any default values
        if ( isset( $_GET['Subproductprice'] ) )
            $model->attributes = $_GET['Subproductprice'];
        $model->product_id = $id;
        $this->render( 'admin', array(
            'model' => $model,
        ) );
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
		$dataProvider=new CActiveDataProvider('Product');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Product('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Product']))
			$model->attributes=$_GET['Product'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Product the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Product $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}