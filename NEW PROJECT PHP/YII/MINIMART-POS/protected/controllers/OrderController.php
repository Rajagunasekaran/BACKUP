<?php

class OrderController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
//    public $prdcolumns = array('id','code','sku','name', 'display',
//                                'tax','unit_cp','unit_sp','spminusdisc','disc','stock','imagepath',
////                    'enableprdcode','enableprdauxname','desc','manufacturer','color','size',
////                    'taxrate_id','auxname','person_id','dontsyncwithstock',
////                    'id','created_at','updated_at','stockvalue','rol','moq','remarks',
//                            );
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
                'actions' => array( 'create', 'update', 
                    Helper::CONST_updateProduct, 
                    Helper::CONST_updateProductAjax,
                    Helper::CONST_ordermstasks,
                    Helper::CONST_posclient,
                    Helper::CONST_openedbills,
                    Helper::CONST_possettings,
                    Helper::CONST_getOrderProductsForABill,
                    Helper::CONST_getAllProducts,
                    Helper::CONST_posSaveBill,
                    Helper::CONST_updateRegisterbalanceUrl,Helper::CONST_getSubproductLatestprice,
                    'getbillnumber',
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
public function actionGetbillnumber()
    {
        $criteria = new CDbCriteria;
        $criteria->select = array( 'qoi_id' );
        $arr=[];
        $result = Order::model()->findAll($criteria);
                foreach($result as $row)
        {
           $arr[] = $row->qoi_id;      
        }
        
       echo json_encode($arr);
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
        $model = new Order;
        $model->type = Helper::CONST_Order;
        $model->qoi_id = null;
        $model->amount = null;
        $model->customer = $this->getFirstOrNewPerson(Helper::CONST_Customer);
        $this->setOrderConfigs($model);
        
        $model->isopedit = false;
        $opmodel = new Orderproduct;
        $opmodel->unsetAttributes();  // clear any default values
        $opmodel->order_id = (empty($model->id)?0:$model->id);
        
        $model->ismsedit = false;
        $model->isotedit = false;
        $milestonemodel = new Milestone;
        $milestonemodel->unsetAttributes();  // clear any default values
        $milestonemodel->order_id = (empty($model->id)?0:$model->id);
        $otmodel = new Ordertask;
        $otmodel->unsetAttributes();  // clear any default values
        $otmodel->order_id = (empty($model->id)?0:$model->id);
        
        
        
        $alltasks = $this->getAllTasks();
        $allcontractors = Yii::app()->controller->getPeopleLookup(Helper::CONST_Contractor);
        
        $this->subTitle = ucwords( $this->action->id ) . ' ' . $this->getMenuLabels( ucwords( $this->controllerID ) );
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if ( !empty( $_POST['Order'] ) && !empty($_POST['Person']))
        {
            $rtn = $this->saveOrUpdateTheModel($model);
            if($rtn)
            {
                $this->redirect( array( 'admin' ) );
            }
        }

        $this->render( 'create', array(
            'model' => $model, 
            'opmodel' => $opmodel,
            'allproducts'=>Yii::app()->user->products,
            'milestonemodel'=>$milestonemodel,
            'otmodel' => $otmodel,
            'alltasks' => $alltasks,
            'allcontractors' => $allcontractors,
        ) );
    }
  public function actionGetstockcnt()
    {    
    $postedData = $this->getPostedData();
    $model=Subproductprice::model();   
        $rowsql = "select stock,unit_cp,unit_sp from subproductprices where sku='".$postedData['sku']."'"; 
       $stockPrice = Yii::app()->db->createCommand( $rowsql )->queryAll();
    echo json_encode($stockPrice);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate( $id )
    {
        $model = $this->loadModel( $id );
                
        $model->isopedit = false;
        $opmodel = new Orderproduct;
        $opmodel->unsetAttributes();  // clear any default values
        $opmodel->order_id = (empty($model->id)?0:$model->id);
        
        $model->ismsedit = false;
        $model->isotedit = false;
        $milestonemodel = new Milestone;
        $milestonemodel->unsetAttributes();  // clear any default values
        $milestonemodel->order_id = (empty($model->id)?0:$model->id);
        $otmodel = new Ordertask;
        $otmodel->unsetAttributes();  // clear any default values
        $otmodel->order_id = (empty($model->id)?0:$model->id);
        
        $alltasks = $this->getAllTasks();
        $allcontractors = Yii::app()->controller->getPeopleLookup(Helper::CONST_Contractor);
        
        $this->subTitle = ucwords( $this->action->id ) . ' ' . $this->getMenuLabels( ucwords( $this->controllerID ) );
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if ( !empty( $_POST['Order'] ) && !empty($_POST['Person']))
        {
            $rtn = $this->saveOrUpdateTheModel($model);
            if($rtn)
            {
                $this->redirect( array( 'admin' ) );
            }
        }

        $this->render( 'update', array(
            'model' => $model, 
            'opmodel' => $opmodel,
            'allproducts'=>Yii::app()->user->products,
            'milestonemodel'=>$milestonemodel,
            'otmodel' => $otmodel,
            'alltasks' => $alltasks,
            'allcontractors' => $allcontractors,
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
        $dataProvider = new CActiveDataProvider( 'Order' );
        $this->subTitle = ucwords( $this->action->id ) . ' ' . $this->getMenuLabels( ucwords( $this->controllerID ) );
        $this->render( 'index', array(
            'dataProvider' => $dataProvider,
        ) );
    }
    public function actionOrdermstasks($id)
    {
        $data = $this->getMSTaskChartData($id);
        $this->returnJsonResponseII($data);
    }
    public function actionPosclient()
    {
        $model = new Order;
        $model->type = Helper::CONST_Order;
        $model->qoi_id = null;
        $model->amount = null;
        $model->customer = $this->getFirstOrNewPerson(Helper::CONST_Customer);
        //$model->addnlinfo5 = Helper::CONST_Cash;
        $this->setOrderConfigs($model);
//        $this->render(Helper::CONST_posclient,array('model' => $model,'orderid' => $this->getOrderId()));   
        $this->render(Helper::CONST_posclient,array('model' => $model,'orderid' => $this->getOrderId(),'barcodeid'=> $this->getBarcodeId()));
    }
    public function actionUpdateRegisterbalanceUrl()
    {
        $balance = (!isset($_POST['balance'])?null:$_POST['balance']);
        $type = (!isset($_POST['type'])?null:$_POST['type']);
        if($type == '1')
        {
            $this->updateRegisterOpeningBalance($balance);
            Yii::app()->end();
        }
        if($type == '2')//closing balance
        {
            $this->updateRegisterClosingBalance($balance);
            $personid = Yii::app()->user->person->id;
            $loginid = Yii::app()->user->login->id;
            $roleid = Yii::app()->user->role->id;
            $rsltObject = new stdClass();
            $this->paymentTypewiseSummary($rsltObject, $personid, $loginid, $roleid);
            $RetCode = Helper::CONST_Error_None;
            $message = Helper::CONST_registercollectionsummary;
            $data = array($rsltObject);
            $this->returnJsonResponse($RetCode, $data, $message);
        }
    }
   public function actionPosSaveBill()
    {
        $postedData = $this->getPostedData();
        $order = new Order;
        $payment = new Payment;
        $rtn = false;
        $trans = Yii::app()->db->beginTransaction();
        try{
            $currentmode = (empty($postedData['currentmode'])?0:$postedData['currentmode']);
            $oldorderid = (empty($postedData['oldorderid'])?0:$postedData['oldorderid']);
            
            $closedstsid = $this->getStatusIdFromName(Helper::CONST_CLOSED);
            $ordersts = $closedstsid;
            $noerror = true;
            $oldorder = null;
            if($currentmode != 0 && $oldorderid == 0)
            {
                $noerror = false;
            }
            else if($currentmode == 1 || $currentmode == 3)
            {
                $oldorder = Order::model()->findByPk($oldorderid);
                if(empty($oldorder))
                {
                    $noerror=false;
                }
                else
                {
                    if($currentmode == 1)
                    {
                        $refundoldstsid = $this->getStatusIdFromName(Helper::CONST_REFUNDOLD);
                        $oldorder->status = $refundoldstsid;

                        $refundnewstsid = $this->getStatusIdFromName(Helper::CONST_REFUNDNEW);
                        $ordersts = $refundnewstsid;
                    }else
                    {
                        $canceloldstsid = $this->getStatusIdFromName(Helper::CONST_CANCELOLD);
                        $oldorder->status = $canceloldstsid;

                        $cancelnewstsid = $this->getStatusIdFromName(Helper::CONST_CANCELNEW);
                        $ordersts = $cancelnewstsid;
                    }
                }
            }
            else if($currentmode == 2)
            {
                $oldorder = Order::model()->findByPk($oldorderid);
                if(empty($oldorder))
                {
                    $noerror=false;
                }
                else
                {
                    $refundoldstsid = $this->getStatusIdFromName(Helper::CONST_EXCHANGEOLD);
                    $oldorder->status = $refundoldstsid;

                    $refundnewstsid = $this->getStatusIdFromName(Helper::CONST_EXCHANGENEW);
                    $ordersts = $refundnewstsid;  
                }
            }
            if(!$noerror)
            {
                $RetCode = Helper::CONST_Error;
                $message = Helper::CONST_OldBillNotFound_Message;
                $data = array();
                $this->returnJsonResponse($RetCode, $data, $message);
            }
            $order->status = $ordersts;
            $order->addnlinfo = $oldorderid;
            $customer_id = $postedData['customer_id'];
            $payment_modecheck = (empty($postedData['payment_modecheck'])?-1:$postedData['payment_modecheck']);
            if($payment_modecheck == '-1')
            {
                $payment_mode = $postedData['payment_mode'];
            }
            else
            {
                $payment_mode = Helper::CONST_OnAccount;
            }            
            $exchange = $postedData['exchange'];
            $roundoff = (empty($postedData['roundoff'])?0:$postedData['roundoff']);            
            $lineItems = $postedData['lineItems'];
            
            $order->type = Helper::CONST_Order;
            $order->customer_id = $customer_id;
            $order->created_id = Yii::app()->user->person->id;
            $order->modified_id = Yii::app()->user->person->id;
            $order->createdemp_id = Yii::app()->user->person->id;
            $order->modifiedemp_id = Yii::app()->user->person->id;                        
            $isconvert = $this->IsConversion($order);
            $extId = ($this->getEnableautoordrid()?($isconvert?null:$order->qoi_id):($isconvert?$order->new_id:$order->qoi_id));
            $isautogenerated = false;
            $curtype = $order->type;
            $isnew = empty($order->id);
            $gnrtdId = $this->getOrderAutoId($curtype, $isnew, $extId, $isautogenerated, $isconvert);
            if($isautogenerated)
            {
                $order->qoi_id = $gnrtdId;                
            }
            $order->name = $order->qoi_id;            
            $totalBilltax = 0;
            $totalBillcost = 0;
            $totalBillamount = 0;
            $orderproducts = array();
            $temporders = array();
            foreach($lineItems as $lineitem)
            {
                $orderproduct = new Orderproduct;
                $temppurchasedetails=new Poslogreport;
                $qnty = $lineitem['quantity'];            
                $temppurchasedetails->sold_out = $qnty;
                $temporders[] = $temppurchasedetails;
                $prdprice = $lineitem['unit_sp'];
                $lineitemdisc = $lineitem['disc'];
                $prdid = $lineitem['productprice'][0]['product_id'];
                $prdprcid = $lineitem['productprice'][0]['id'];
                $prdcost = $lineitem['productprice'][0]['unit_cp'];
                $prdtax = $lineitem['productprice'][0]['tax'];
                $skucode = $lineitem['productprice'][0]['sku'];
                $temppurchasedetails->barcode = $skucode;
                
                $lineitemcost =  $qnty * $prdcost;                                
                $lineitemamount = $qnty * $prdprice;
                $lineitemtax = $qnty * $prdtax;
                $lineitemamount += $lineitemtax - $lineitemdisc;
                
                $orderproduct->product_id = $prdid;
                $orderproduct->productprice_id = $prdprcid;
                $orderproduct->cost = $lineitemcost;
                $orderproduct->tax = $lineitemtax;
                
                $orderproduct->quantity = $qnty;
                $orderproduct->unit_sp = $prdprice;                
                $orderproduct->amount = $lineitemamount;
                $orderproduct->disc = $lineitemdisc;
                if($lineitemamount > 0)
                {
                    $orderproduct->discper = round(($lineitemdisc/$lineitemamount * 100),2);
                }
                else
                {
                   $orderproduct->discper = 0; 
                }
                
                $orderproducts[] = $orderproduct;
                
                $totalBilltax += $lineitemtax;
                $totalBillcost += $lineitemcost;
                $totalBillamount += $lineitemamount;
            }
            $billdiscount = $postedData['billdiscount'];
            if($currentmode == '1' || $currentmode == '3')
            {
                $billdiscount = $billdiscount * -1;
            }
            if($currentmode == '1' || $currentmode == '2' || $currentmode == '3')
            {
                $roundoff = $roundoff * -1;
            }
            $totalBillamount  = $totalBillamount - $billdiscount + $roundoff;
            if($currentmode == 2 && $totalBillamount <= 0)
            {
                $order->exchange = -$totalBillamount;//should add the amount in the name 'getback old bill discount'
                $totalBillamount = 0;
            }
            else if($currentmode != 1 && $currentmode != 2 
                    && $currentmode != 3 && $totalBillamount <= 0)
            {
                $RetCode = Helper::CONST_Error;
                $message = Helper::CONST_InvalidBillAmount_Message;
                $data = array();
                $this->returnJsonResponse($RetCode, $data, $message);
            }            
            $order->disc = $billdiscount;
            $order->roundoff = $roundoff;            
            $order->tax = $totalBilltax;
            $order->cost = $totalBillcost;
            $order->amount = $totalBillamount;
            if(strtolower($payment_mode) === strtolower(Helper::CONST_OnAccount))
            {
                $order->paid = 0;
            }
            else
            {
               $order->paid =  $order->amount;
            }
            
            $tenderedamount = $postedData['tenderedamount'];
            $balancereturned = $postedData['balancereturned'];
            $paymentdetails = $postedData['paymentdetails'];
            switch($currentmode)
            {
                case 1:
                    $paymentdetails = $paymentdetails . ':Refund:';
                    break;
                case 2:
                    $paymentdetails = $paymentdetails . ':Exchange:';
                    break;
                case 3:
                    $paymentdetails = $paymentdetails . ':Cancel:';
                    break;
                default:
                    break;
            }
            $payment->person_id = Yii::app()->user->person->id;
            $payment->amount = $totalBillamount;
            $payment->party_id = $customer_id;
            $payment->type = $payment_mode;
            $payment->tendered = $tenderedamount;
            $payment->balreturned = $balancereturned;
            $payment->details = $paymentdetails;
            $payment->direction = Helper::CONST_Inwards;
            
            $rtn = true;
            if(!empty($oldorder))
            {
                $rtn = $oldorder->save();
            }
            if($rtn)
            {
                $this->setOrderConfigs($order);
                $rtn = $order->save();
                if($rtn)
                {
                    $rtn = $this->updateOrderAutoId($order->qoi_id);
                    if($rtn)
                    {
                        foreach($orderproducts as $orderproduct)
                        {
                            $orderproduct->order_id = $order->id;
                            $orderproduct->order_type = $order->type;     
                            $rtn = $orderproduct->save();
                            if(!$rtn) break;
                        }
                        if($rtn)
                        {
                            $payment->order_id = $order->id;
                            $rtn = $payment->save();
                        }
                    }
                
                    $poslogs = new Poslogreport;
                        foreach($temporders as $temppurchasedetails)
                        {   
                             $quantities = $temppurchasedetails->sold_out;                            
                             $barcode = $temppurchasedetails->barcode;
                             
                             $rowsql = "select id from subproductprices where sku='$barcode'";
                             $result = Yii::app()->db->createCommand( $rowsql )->queryScalar();                  
                             $product = Subproductprice::model()->findByPk($result);
                             
                             $stockupdate = "update `subproductprices` set `initial_stock`=`initial_stock`-'$quantities' where `id`='$result'";
                             Yii::app()->db->createCommand($stockupdate)->execute(); 
                             
                             $rowsqlquery = "select `sno` from `poslogreport` where `barcode`='$barcode' and `log_status`=0";
                             $resultset = Yii::app()->db->createCommand( $rowsqlquery )->queryScalar();
                             
                             $rowsqlquery1 = "select `stock` from `subproductprices` where `sku`='$barcode'";
                             $stockresult = Yii::app()->db->createCommand( $rowsqlquery1)->queryScalar();
                             
                             if($resultset=="")
                             {
                              $insertrowsql = "insert into `poslogreport`(`date`,`barcode`,`previous_stock`,`current_stock`) values(CURDATE(),'$barcode','$stockresult','$stockresult')";
                              $result = Yii::app()->db->createCommand( $insertrowsql )->execute(); 
                             }
                
                             $rowsqlupdate = "select sno from poslogreport where barcode='$barcode' and `log_status`=0";
                             $resultupdate = Yii::app()->db->createCommand( $rowsqlupdate )->queryScalar();                  
                             $productupdate = Poslogreport::model()->findByPk($resultupdate);
                             
                             $rtn = !empty($productupdate);
                             if($rtn)
                              {
                                 if($quantities>0)
                                 {
                                 $productupdate->current_stock -= $quantities;
                                 $rtn = $productupdate->save();
                                 }
                                 else 
                                 {
                                  $cancelstockupdate = "update `poslogreport` set `rtn_product_quantity`=-$quantities where `sno`='$resultupdate'";
                                  Yii::app()->db->createCommand($cancelstockupdate)->execute();
                                 }
                               }
                        }                                        
                }
            }
        }catch(Exception $e){
            $rtn = false;
        }
        if($rtn)
        {     
//            $curr_date=Yii::app()->Date->now();
            $trans->commit();
            $RetCode = Helper::CONST_Error_None;
            $message = 'Saved Bill No.:.' .$order->qoi_id;
            $data = array(); 
           $this->printSavedbill($postedData,$order->qoi_id);
        }else
        {
            $trans->rollback();
            $RetCode = Helper::CONST_Error;
            $message = $cancelstockupdate;
            $data = array();
        }
        $this->returnJsonResponse($RetCode, $data, $message);        
    }
    private function printSavedbill($postedData,$BillNo) {
       $dataArray =array(array("Sno","Product","Qty","Price","Total"));
       $lineItems=$postedData['lineItems'];
       $Total=0;
       $T_Tax=0;
       foreach($lineItems  as $key => $product){
         $SNO=$key+1;
         $Product=$product['productprice'][0]['name'];
         $Product = substr($Product, 0, strpos($Product, '@'));
         $Tax=$product['productprice'][0]['tax'];
         $Qty=$product['quantity'];
         $Price=$product['unit_sp'];
         $Amt= Yii::app()->numberFormatter->formatCurrency($product['amount'],'USD'); 
         //if negative amount changed by PUNI ON 26/11/2014 START
           if($product['amount']<0)
          {
             $Amt="-".$Amt; 
             $Amt=str_replace(array( '(', ')' ), '', $Amt);
          } 
          //if negative amount changed by PUNI ON 26/11/2014 END
         $dataArray[]=array($SNO,$Product,$Qty,$Price,$Amt);
         $Total +=$product['amount'];
         $T_Tax +=$product['productprice'][0]['tax'];
        }
        $sub_total=$Total-$postedData['billdiscount'];
        $sub_total1=$sub_total;
        $Total1=$Total;
        $roundoff1=$postedData['roundoff'];
        $Total  = Yii::app()->numberFormatter->formatCurrency($Total,'USD');
        $Discount  = Yii::app()->numberFormatter->formatCurrency($postedData['billdiscount'],'USD');
        $sub_total= Yii::app()->numberFormatter->formatCurrency($sub_total,'USD');
                  //if negative amount changed by PUNI ON 26/11/2014 START
           if($sub_total1<0)
          {
             $sub_total="-".$sub_total; 
             $sub_total=str_replace(array( '(', ')' ), '', $sub_total);
          }
           if($Total1<0)
          {
             $Total="-".$Total; 
             $Total=str_replace(array( '(', ')' ), '', $Total);
          } 
                   //if negative amount changed by PUNI ON 26/11/2014 END
//          echo "round:".$postedData['roundoff'];exit;
        $T_Tax= Yii::app()->numberFormatter->formatCurrency($T_Tax,'USD');
        $roundOFF= Yii::app()->numberFormatter->formatCurrency($postedData['roundoff'],'USD');
        $tenderedamount= Yii::app()->numberFormatter->formatCurrency($postedData['tenderedamount'],'USD');
        $balancereturned= Yii::app()->numberFormatter->formatCurrency($postedData['balancereturned'],'USD');
        //  $balancereturned= Yii::app()->numberFormatter->format("#,##0.00",$postedData['balancereturned'],null);
           //if negative amount changed by PUNI ON 26/11/2014 START
        if($roundoff1<0)
          {
             $roundOFF="-".$roundOFF; 
             $roundOFF=str_replace(array( '(', ')' ), '', $roundOFF);
          }
             //if negative amount changed by PUNI ON 26/11/2014 END
        $dataArray[]=array('','','','SubTotal',$sub_total);       
        $dataArray[]=array('','','','Discount',$Discount);
        $dataArray[]=array('','','','Total',$Total);
        $dataArray[]=array('','','','RoundOff',$roundOFF);
        $dataArray[]=array('','','','','');
       
        $dataArray[]=array('','','','Tendered',$tenderedamount);
        $dataArray[]=array('','','','Balance',$balancereturned);
        
        $html ='<tr><td colspan="3"></td><td colspan="2">Total</td><td colspan="3">'.$Total.'</td>'.
                '<tr><td colspan="3"></td><td colspan="2">Discount</td><td colspan="3">'.$postedData['billdiscount'].'</td>'.
                '<tr><td colspan="3"></td><td colspan="2">Sub-Total</td><td colspan="3">'.$sub_total.'</td>'.
                '<tr><td colspan="3"></td><td colspan="2">Tax</td><td colspan="3">'.$T_Tax.'</td>'.
                '<tr><td colspan="3"></td><td colspan="2">Round-Off</td><td colspan="3">'.$sub_total.'</td>'.
                '<tr><td colspan="3"></td><td colspan="2">Tendered</td><td colspan="3">'.$postedData['tenderedamount'].'</td>'.
                '<tr><td colspan="3"></td><td colspan="2">Balance</td><td colspan="3">'.$postedData['balancereturned'].'</td>'.               
                '</tbody></table>';
        
        //$this->writeToPdf( $html, $mode = 'bn', $paper = 'A4', $dest = 'F', $name = 'POSlastBill.pdf');
        //$html ='<h1>dsaad</h1>';
        $header='Receipt No:   '.$BillNo;
        $this->directPrint($header,$dataArray);
    }
    
    /* 
     * SELECT SUM(amount+getbackdiscount(getback old bill discount)) FROM orders
SELECT SUM(amount) FROM payments
     * These should be matched 
     */
     public function actionGetAllProducts()
    {
        $json = new CArJSON;
        
        $criteria=new CDbCriteria;
        $criteria->order='id asc';
        $criteria->addCondition('parent_id = 0 and status=1');
        $catwithproducts = Category::model()->findAll($criteria);
                
        $prdcondition = array('condition'=>'t.status = 1 AND product.status = 1');
        $products = Subproductprice::model()->with('product')
                                ->findAll($prdcondition);
        $prdcondition_non_mngd = array('condition'=>'t.status = 1 
            AND product.status = 1 AND t.dontsyncwithstock = 1');
        $non_mngd_products = Productprice::model()->with('product')
                                ->findAll($prdcondition_non_mngd);
        if(!empty($catwithproducts)
            && !empty($products)
        )
        {
            //$relations = array(array('categories'=>array(array('products'=>array('taxrate')))));
            $relations = array(array('categories'=>array('subproductprices')));
            $attributes = array(
                'root' => array(),//null,//array of attribute names
                'categories' => array(),
                'subproductprices' => $this->prdcolumns,
            );
            $isarray = true;
            $iskeybasedarray = true;
            $sec_cat_products = $json->toJSON($catwithproducts, 
                    $relations, $attributes, $isarray, $iskeybasedarray);

            $relations = array();
            $attributes = array(
                'root' => $this->prdcolumns,                
            );
            $isarray = true;
            $iskeybasedarray = true;
            $non_mngd_products = $json->toJSON($non_mngd_products, 
                    $relations, $attributes, $isarray, $iskeybasedarray);
            
            $relations = array();
            $attributes = array(
                'root' => array('value','label'),
            );
            $isarray = true;
            $iskeybasedarray = false;
            $allproducts_short = $json->toJSON($products, 
                    $relations, $attributes, $isarray, $iskeybasedarray);

            $customercondition = array();
            $customers = $this->getAllPeopleNoRestriction(Helper::CONST_Customer);            
            $allcustomers = CHtml::listData($customers, 'id', 'name');
            
            $dfltcustomerid = $this->getPersonByName(Helper::CONST_Walk_in_Customer);
            $data = array(
                //Helper::CONST_prdskuToIdMap => $prdskuToIdMap,
                Helper::CONST_allproducts_short => $allproducts_short,
                Helper::CONST_non_mngd_products => $non_mngd_products,
                Helper::CONST_sec_cat_products => $sec_cat_products,
                Helper::CONST_allcustomers => $allcustomers,
                Helper::CONST_default_customer_id => $dfltcustomerid
            );
            $rtnCode = Helper::CONST_Error_None;
            $message = Helper::CONST_POS_Masters;
        }
        else
        {
            $data = array(
                        Helper::CONST_allproducts_short => array(),
                        Helper::CONST_non_mngd_products => array(),
                        Helper::CONST_sec_cat_products => array(),
                        Helper::CONST_allcustomers => array(),
                        Helper::CONST_default_customer_id => -1
                    );
            $rtnCode = Helper::CONST_Error_None; 
            $message = Helper::CONST_NotFound_Message;
        }
//        $edata = $this->getJsonOfData($rtnCode, $data, $message);
//        $this->writeToCookie(Helper::CONST_sec_cat_products, $edata);        
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
    public function actionOpenedbills()
    {
        $this->render(Helper::CONST_openedbills,array());
    }
    public function actionPossettings()
    {
        $this->render(Helper::CONST_possettings,array());
    }
    public function actionUpdateProductAjax()
    {
        //post params name,value,pk,scenario       
//        $es = new TbEditableSaver('Orderproduct');
//        $es->update();
        
        $id = $_POST['pk'];
        $attrname = $_POST['name'];
        $attrvalue = $_POST['value'];
        $model = Orderproduct::model()->findByPk( $id );
        $oldproductId = $model->product_id;
        $model->$attrname = $attrvalue;
        $this->saveOrUpdateII($model, $oldproductId);
    }
    public function actionUpdateProduct($id)
    {
        $rtndata = array();
        $parentModel = Order::model()->findByPk($id);
        if(empty($parentModel))
        {
            $RetCode = 1;
            $data = 0;
            $message = 'Save the Master details first';
        }
        else
        {
            if ( isset( $_POST['Orderproduct'] ) )
            {
                $model = new Orderproduct;
                $oldproductId = $model->product_id;
                $model->attributes = $_POST['Orderproduct'];
                $orderModel = Order::model()->findByPk($id);
                $model->order_id = $id;
                $model->order_type = $parentModel->type;
                $this->saveOrUpdateII($model, $oldproductId);
            }
            else
            {
                $RetCode = 1;
                $data = array();
                $message = 'No data to save/update';
            }
        }
        $this->returnJsonResponse($RetCode, $data, $message);
    }
    public function getExistingSubModelId($id, $product_id)
    {
        $condition = 'order_id=' . $id;
        $condition .= ' AND product_id = ' . $product_id;

        $criteria = new CDbCriteria;
        $criteria->select = array( 'id' );
        $criteria->condition = $condition;
        $result = Orderproduct::model()->findAll( $criteria );
        return ((count($result) === 0)? -1:$result[0]['id']);
    }
    public function saveOrUpdateII($model, $oldProductId = null)
    {
        if($model->validate())
        {
            $isNew = $model->id > 0;
            $status = false;
            $exists = false;
            $trans = Yii::app()->db->beginTransaction();
            try 
            {
                
                $extId = $this->getExistingSubModelId($model->order_id, $model->product_id);
                $exists = $extId > 0;                        
                if(!$exists || $oldProductId === $model->product_id)
                {
                    $model->amount = $model->quantity * $model->unit_sp;
                    //$model->tax = $model->amount * $model->taxper / 100;
                    $status = $model->save(false);

                    if($status)
                    {
                        $amount = 0;
                        $status = $this->updateOrder($model->order_id, $amount);
                    }
                }                        
            }
            catch (Exception $e)
            {
                Yii::log("Error occurred while saving. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
            }
            if($status)
            {
                $trans->commit();
                $RetCode = 0;
                $data = $amount;
                $message = ($isNew)? 'product added' : 'product updated';
            }
            else                        
            {                        
                $trans->rollback();
                if($exists)
                {
                    $RetCode = 1;
                    $data = 0;
                    $message = 'Already selected';
                }
                else
                {
                    $RetCode = 1;
                    $data = 0;
                    $message = ($isNew)? 'product add failed' : 'product update failed';
                }
            }
        }
        else
        {
            $RetCode = 1;
            $data = array();
            $message = 'invalid product details';
        }
        $this->returnJsonResponse($RetCode, $data, $message);
    }
    private function setOrderConfigs($model)
    {
        $model->enableordername = Yii::app()->controller->getEnableordername();
        $model->enableordrprd = Yii::app()->controller->getEnableordrprd();
        $model->enableordrtasks = Yii::app()->controller->getEnableordrtasks();
        $model->enableordrtaskpeople = Yii::app()->controller->getEnableordrtaskpeople();
        $model->enableordrpayments = Yii::app()->controller->getEnableordrpayments();
        $model->enableordermilestones = Yii::app()->controller->getEnableordermilestones();
        $model->ordercostamountfrom = Yii::app()->controller->getOrdercostamountfrom();
        $model->ordertaskcostamountfrom = Yii::app()->controller->getOrdertaskcostamountfrom();
        $model->enablediscount = Yii::app()->controller->getEnablediscount();
        $model->orderdiscfor = Yii::app()->controller->getOrderdiscfor();
    }
    public function saveOrUpdateTheModel($model)
    {
        $rtn = false;
        $trans = Yii::app()->db->beginTransaction();
        try 
        {
            $model->attributes = $_POST['Order'];
            $customer = Person::model()->findByPk($_POST['Person']['id']);
            if(!empty($customer))
            {
                $model->customer = $customer;
            }
            $rtn1 = $model->customer->validate();
            $rtn2 = $model->validate();
            $rtn = $rtn1 && $rtn2;
            if ( $rtn )
            {
                $rtn = $model->save(false);
                if($rtn)
                {
                    $rtn = $this->updateOrderPeopleFor($model, Yii::app()->user->person->id, Helper::CONST_Created);
                    if($rtn)
                    {
                        $rtn = $this->updateOrderPeopleFor($model, Yii::app()->user->person->id, Helper::CONST_Modified);
                        if($rtn)
                        {
                            $rtn = $this->updateOrderPeopleFor($model, $model->customer->id, Helper::CONST_Customer);                        
                        }
                    }
                }
            }
        }
        catch(Exception $e)
        {
            Yii::log("Error occurred while saving. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
            $rtn = false;
        }
        if($rtn)
        {
            $trans->commit();
        }
        else
        {
            $trans->rollback();            
        }
        return $rtn;
    }
    public function updateOrderPeopleFor($model, $person_id, $type)
    {
        $rtn = false;
        $order_id = $model->id;
        $condition = 'order_id=' . $order_id;
        $condition .= ' AND LCASE(type) = "' . strtolower($type) . '"';
        $criteria = new CDbCriteria;
        $criteria->condition = $condition;
        $result = Orderperson::model()->findAll( $criteria );
        if(count($result)>0)
        {
            if(strtolower($type) === strtolower(Helper::CONST_Created)) return true;
            $record = $result[0];
        }
        else
        {
            $record = new Orderperson;
        }
        if(empty($person_id) && !empty($record->id))
        {
            $rtn = $record->delete();
        }
        else
        {
            $record->order_id = $order_id;
            $record->person_id = $person_id;
            $record->type = $type;
            $rtn = $record->save();            
        }
        return $rtn;
    }
    public function getMSTaskChartData($id)
    {
        $criteria=new CDbCriteria;        
        $criteria->order='details asc';
        $criteria->compare('LCASE(order_id)',strtolower($id),true);
        
        $milestones = Milestone::model()->findAll($criteria);
        $chartData = array();
//        $chartRow = array('Ms/Task','Details','Start','End');
//        $chartData[] = $chartRow;
        $chartRow = array();
        $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
        foreach($milestones as $milestone)
        {
            $start_at = Yii::app()->controller->getMysqlFormattedDatetime($milestone->start_at, $dateformat, false);
            //$end_at = Yii::app()->controller->getMysqlFormattedDatetime($milestone->end_at, $dateformat, false);            
            $chartRow[] = $milestone->details;
            $info = $start_at;
            $chartRow[] = $info;//this info field.
            $chartRow[] = $start_at;
            $chartRow[] = $start_at;
            $chartData[] = $chartRow;
            $chartRow = array();
        }
        
        $criteria=new CDbCriteria;
        $criteria->with = array('task');
        $criteria->order='task.name asc';
        $criteria->compare('LCASE(t.order_id)',strtolower($id),true);
        $ordertasks = Ordertask::model()->findAll($criteria);
        foreach($ordertasks as $ordertask)
        {
            $completed = $ordertask->completed;
            $start_at = Yii::app()->controller->getMysqlFormattedDatetime($ordertask->start_at, $dateformat, false);
            $end_at = Yii::app()->controller->getMysqlFormattedDatetime($ordertask->end_at, $dateformat, false);
            if($start_at === $end_at)
            {
                $datetime = new DateTime($ordertask->start_at);
                $datetime->modify('+24 hour');
                $end_at = $datetime->format($dateformat);
            }
            $info = ' [ ' . $completed . '% ] '. $start_at . ' - ' . $end_at;
            $chartRow[] = $ordertask->task->name;
            $chartRow[] = $info;//this info field.
            $chartRow[] = $start_at;
            $chartRow[] = $end_at;
            $chartData[] = $chartRow;
            $chartRow = array();
        }
//        $datetime = new DateTime('today');       
//        $datestr = $datetime->format($this->datetimemysqlformatDMY);
//        $low = $datestr;
//        $datetime->modify('+2 day');
//        $datestr = $datetime->format($this->datetimemysqlformatDMY);
//        $high = $datestr;
//        ["testms1", 
//            0, 
//            Object { date="2014-08-21 00:00:00", timezone_type=3,
//            timezone="Singapore"}, Object { date="2014-08-21 00:00:00", timezone_type=3,
//            timezone="Singapore"}                
//        ]
//        $chartData = array();
//        $chartRow = array();
//        $chartRow[] = 'MS-1';
//        $chartRow[] = $low;
//        $chartRow[] = $low;
//        $chartData[] = $chartRow;
//        $chartRow = array();
//        $chartRow[] = 'MS-2';
//        $chartRow[] = $low;
//        $chartRow[] = $high;
//        $chartData[] = $chartRow;
        return $chartData;
    }
    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Order( 'search' );
        $model->unsetAttributes();  // clear any default values
        $this->subTitle = ucwords( $this->action->id ) . ' ' . $this->getMenuLabels( ucwords( $this->controllerID ) );
        if ( isset( $_GET['Order'] ) )
            $model->attributes = $_GET['Order'];
           if(!empty( $_GET['actionid'] ) && $_GET['actionid'] == Helper::CONST_PDF)
            {
                $html = $this->renderPartial( 'admin', array(
                            'model' => $model,
                        ),true );
                
                $this->writeToPdf( $html );
            }
            else
            {
        $this->render( 'admin', array(
            'model' => $model,
        ) );
            }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel( $id )
    {
        $model = Order::model()->findByPk( $id );
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
        if ( isset( $_POST['ajax'] ) && $_POST['ajax'] === 'order-form' )
        {
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }
    }
    public function IsConversion($model)
    {
        $rtn = false;        
        $toorderstatusid = Yii::app()->controller->getStatusIdFromName(Helper::CONST_TOORDER,1);
        $toinvoicestatusid = Yii::app()->controller->getStatusIdFromName(Helper::CONST_TOINVOICE,1);        
        $rtn = ($model->type === Helper::CONST_Quote 
                    && strtolower($model->status) === strtolower($toorderstatusid)
                )
                || ($model->type === Helper::CONST_Order
                        && strtolower($model->status) === strtolower($toinvoicestatusid)
                );
        return $rtn;
    }
}