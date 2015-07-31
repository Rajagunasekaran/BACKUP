<?php
//require_once('./html2fpdf_sample/fpdf.php');
//require_once('./html2fpdf_sample/fpdf.php');
class ReportsController extends Controller
{
        public function accessRules()
        {
            return array (
                array ( 'allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions' => array ( 'index',
                    Helper::CONST_registerwisecollections,
                    Helper::CONST_customerdatewisepayments,
                    Helper::CONST_dailysales,
                    Helper::CONST_periodWiseSales,
                    Helper::CONST_stockInventory,
                    Helper::CONST_StockReport,
                    Helper::CONST_dailyItemSales,
                    Helper::CONST_exchange,
                    Helper::CONST_registerBalance,
                    Helper::CONST_registerBalanceII,
                    Helper::CONST_refund,
                    Helper::CONST_cancel,
                        ),
                    'users' => array ( 'admin' ),
                ),
                array ( 'deny', // deny all users
                    'users' => array ( '*' ),
                ),
            );
        }
public function actionIndex()
{
$this->render('index');
}
        public function actionRegisterwisecollections()
{
            $model = new Register( 'search' );
            $model->unsetAttributes();  // clear any default values
            if ( isset( $_GET['Register'] ) )
                $model->attributes = $_GET['Register'];
            if(!empty( $_GET['actionid'] ) && $_GET['actionid'] == Helper::CONST_PDF)
            {
                $html = $this->renderPartial( 'registerwisecollections', array(
                            'model' => $model,
                        ),true );
                $this->writeToPdf( $html );
            }
            else
            {
                $this->render( 'registerwisecollections', array(
                    'model' => $model,
                ) );
            }
}
        public function actionCustomerdatewisepayments()
{
            $model = new Payment( 'search' );
            $model->unsetAttributes();  // clear any default values
            if ( isset( $_GET['Payment'] ) )
                $model->attributes = $_GET['Payment'];

            $this->render( 'customerdatewisepayments', array(
                'model' => $model,
            ) );
}
        public function actionDailysales()
{
            $model = new Order( 'search' );
            $model->unsetAttributes();  // clear any default values
            if ( isset( $_GET['Order'] ) )
                $model->attributes = $_GET['Order'];
            
            if(!empty( $_GET['actionid'] ) && $_GET['actionid'] == Helper::CONST_PDF)
            {
                $html = $this->renderPartial( Helper::CONST_dailysales, array(
                            'model' => $model,
                        ),true );
                $this->writeToPdf( $html );
            }
            else
            {
                $this->render( Helper::CONST_dailysales, array(
                    'model' => $model,
                ) );
            }
}
        public function actionPeriodWiseSales()
{
            $model = new Orderproduct( 'search' );
            $model->unsetAttributes();  // clear any default values
            $model->groupby = Helper::CONST_Product;
            if ( isset( $_GET['Orderproduct'] ) )
            {
                $model->attributes = $_GET['Orderproduct'];
            }
            if(!empty( $_GET['actionid'] ) && $_GET['actionid'] == Helper::CONST_PDF)
            {
                $html = $this->renderPartial( Helper::CONST_periodWiseSales, array(
                            'model' => $model,
                        ),true );
                $this->writeToPdf( $html );
            }
            else
            {
                $this->render( Helper::CONST_periodWiseSales, array(
                    'model' => $model,
                ) );
            }
}
        public function actionStockInventory()
        {
            $model = new Subproductprice( 'stockinventory' );
            $model->unsetAttributes();
            if ( isset( $_GET['Subproductprice'] ) )
                $model->attributes = $_GET['Subproductprice'];
            if(!empty( $_GET['actionid'] ) && $_GET['actionid'] == Helper::CONST_PDF)
            {
                $html = $this->renderPartial( Helper::CONST_stockInventory, array(
                            'model' => $model,
                        ),true );
                $this->writeToPdf( $html );
            }
            else
            {
                $this->render( Helper::CONST_stockInventory, array(
                    'model' => $model,
                ) );
            }
        }

        public function actionDailyItemSales()
        {
            $model = new Orderproduct( 'dailyitemsales' );
            $model->unsetAttributes();  // clear any default values
            //$model->groupby = Helper::CONST_Product;
            if ( isset( $_GET['Orderproduct'] ) )
                $model->attributes = $_GET['Orderproduct'];
            
            if(!empty( $_GET['actionid'] ) && $_GET['actionid'] == Helper::CONST_PDF)
            {
                $html = $this->renderPartial( Helper::CONST_dailyItemSales, array(
                            'model' => $model,
                        ),true );
                $this->writeToPdf( $html );
            }
            else
            {
                $this->render( Helper::CONST_dailyItemSales, array(
                    'model' => $model,
                ) );
            }
        }
        public function actionExchange()
{
            $model = new Order( 'exchange' );
            $model->unsetAttributes();  // clear any default values
            if ( isset( $_GET['Order'] ) )
                $model->attributes = $_GET['Order'];
            if(!empty( $_GET['actionid'] ) && $_GET['actionid'] == Helper::CONST_PDF)
            {
                $html = $this->renderPartial( Helper::CONST_exchange, array(
                            'model' => $model,
                        ),true );
                $this->writeToPdf( $html );
            }
            else
            {
                $this->render( Helper::CONST_exchange, array(
                    'model' => $model,
                ) );
            }
}
        public function actionRegisterBalance()
        {
            $model = new Person( 'search' );
            $model->unsetAttributes();  // clear any default values
            $registerBalance = null;
            if ( isset( $_REQUEST['Person'] ) )
            {
                $model->attributes = $_REQUEST['Person'];
                if($model->id > 0)
                {
                    $registerBalance = $this->getRegisterBalanceReport($model); 
                }
            }
            if(!empty( $_REQUEST['actionid'] ) && $_REQUEST['actionid'] == Helper::CONST_PDF)
            {
                $html = $this->renderPartial( Helper::CONST_registerBalance, array(
                            'model' => $model,
                            'registerBalance' => $registerBalance,
                            'method' => 'first',
                        ),true );
                $this->writeToPdf( $html );
            }
            else
            {
                $this->render( Helper::CONST_registerBalance, array(
                    'model' => $model,
                    'registerBalance' => $registerBalance,
                    'method' => 'first',
                ) );
            }            
        }
      public function actionRegisterBalanceII()
        {                     
            $model = new Person( 'search' );
            $model->unsetAttributes();  // clear any default values
            $registerBalance = null;
            if ( isset( $_REQUEST['Person'] ) )
            {
                $model->attributes = $_REQUEST['Person'];
            }
            else
            {
                $model = null;
            }
            $registerBalance = $this->getRegisterBalanceReport($model);
            if(!empty( $_REQUEST['actionid'] ) && $_REQUEST['actionid'] == Helper::CONST_PDF)
            {
                $html = $this->renderPartial( Helper::CONST_registerBalance, array(
                            'model' => $model,
                            'registerBalance' => $registerBalance,
                            'method' => 'second',
                        ),true );
                $rowsql = "UPDATE `subproductprices` SET `stock` = `initial_stock`";
                $result = Yii::app()->db->createCommand( $rowsql )->execute();
               
                $rowsql1 = "UPDATE `poslogreport` SET `current_aval_stock`=`current_stock`+`today_purchase`+`rtn_product_quantity`+`stock_adjustment` where `log_status`=0";
                $result1 = Yii::app()->db->createCommand( $rowsql1)->execute(); 
                
                $rowsql1 = "UPDATE `poslogreport` SET `sold_out` = `previous_stock`-`current_stock`,`log_status`=1";
                $result1 = Yii::app()->db->createCommand( $rowsql1)->execute();
                
                $header="Register Balance Report";
                $dataArray=array(array('Open Balance',$registerBalance->op_balance));  
                foreach($registerBalance->cashsummary as $key => $values)
                $dataArray[]=array($values[0],$values[1]);
                $dataArray[]=array('Expected Cash In Hand',$registerBalance->expectedCB);
                $dataArray[]=array('Actual Cash In Hand',$registerBalance->cl_balance);
                $XaxisArray=array(0,180);
                $this->directPrint($header,$dataArray,$XaxisArray);
               // $this->writeToPdf( $html );
                 $this->redirect('/pos/order/posclient');
            }
            else
            {
                $this->render( Helper::CONST_registerBalance, array(
                    'model' => $model,
                    'registerBalance' => $registerBalance,
                    'method' => 'second',
                ) );
            }
        }
        public function actionRefund()
        {
           $model = new Order( 'refund' );
            $model->unsetAttributes();  // clear any default values
            if ( isset( $_GET['Order'] ) )
                $model->attributes = $_GET['Order'];
            if(!empty( $_GET['actionid'] ) && $_GET['actionid'] == Helper::CONST_PDF)
            {
                $html = $this->renderPartial( Helper::CONST_refund, array(
                            'model' => $model,
                        ),true );
                $this->writeToPdf( $html );
            }
            else
            {
                $this->render( Helper::CONST_refund, array(
                    'model' => $model,
                ) );
            }
        }
        public function actionCancel()
        {
           $model = new Order( 'cancel' );
            $model->unsetAttributes();  // clear any default values
            if ( isset( $_GET['Order'] ) )
                $model->attributes = $_GET['Order'];
            if(!empty( $_GET['actionid'] ) && $_GET['actionid'] == Helper::CONST_PDF)
            {
                $html = $this->renderPartial( Helper::CONST_cancel, array(
                            'model' => $model,
                        ),true );
                
                $this->writeToPdf( $html );
            }
            else
            {
                $this->render( Helper::CONST_cancel, array(
                    'model' => $model,
                ) );
            }
        }
        
// Uncomment the following methods and override them if needed
/*
public function filters()
{
// return the filter configuration for this controller, e.g.:
return array(
'inlineFilterName',
array(
'class'=>'path.to.FilterClass',
'propertyName'=>'propertyValue',
),
);
}

public function actions()
{
// return external action classes, e.g.:
return array(
'action1'=>'path.to.ActionClass',
'action2'=>array(
'class'=>'path.to.AnotherActionClass',
'propertyName'=>'propertyValue',
),
);
}
*/
}