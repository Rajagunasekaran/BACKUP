<?php

class SiteController extends Controller
{

    public $layout = '//layouts/column2';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }
    public function actionMobile($id)
    {
        $h = $id;
        echo 'hi';
    }
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        if ( !Yii::app()->user->isGuest )
        {
            $this->subTitle = 'Dashboard';
            
            $rendered = false;
            if($this->isCRTypeAPP())
            {
                $this->renderCRTypeDashboard();
                $rendered = true;
            }
            if($this->isPCTypeAPP())
            {
                $this->renderPCTypeDashboard();
                $rendered = true;
            }
            if($this->isPOSTypeAPP())
            {
                $this->renderPOSTypeDashboard();
                $rendered = true;
            }
            if(!$rendered)
            {
                $this->render( 'index');
            }
        }
        else
        {
            $this->actionLogin();
        }
    }
    public function renderCRTypeDashboard()
    {
        $model = new Order ( 'search' );
        $model->unsetAttributes();  // clear any default values
        $model->splsearch = Helper::CONST_Tomorrow;
        $model->hdnactionname = Helper::CONST_indexactionid;

        $timeslotmodel = new Persontimeslot;
        $timeslotmodel->unsetAttributes();
        $timeslotmodel->slotdate = $model->splsearch;

        if ( isset( $_GET['Order'] ) )
        {
            $model->attributes = $_GET['Order'];
            $timeslotmodel->slotdate = $model->splsearch;
        }
        $options = $this->prepareOrderGridOptions($model->hdnactionname, 
                Helper::CONST_grid_Height_200);
        $this->render( $this->getView('index','index'),
                        array(
                            'model' => $model,
                            'origin' => $model->hdnactionname,
                            'options'=> $options,
                            'fromdb' => true,
                            'timeslotmodel' => $timeslotmodel,
                            )
                    );
    }
    public function renderPCTypeDashboard()
    {
        $ordertask =new Ordertask('search');
        $ordertask->unsetAttributes();  // clear any default values
        
        $milestone =new Milestone('search');
        $milestone->unsetAttributes();  // clear any default values
        
        $orderlistLookup = Yii::app()->controller->getOrdersLookup();
        if(!empty($orderlistLookup))
        {
            $tmp = array_keys($orderlistLookup);
            $ordertask->order_id = $tmp[0];
            $milestone->order_id = $tmp[0];
        }
        if(isset($_GET['Ordertask']))
            $ordertask->attributes=$_GET['Ordertask'];
        
        if(isset($_GET['Milestone']))
            $milestone->attributes=$_GET['Milestone'];
        
        $payinmodel =new Payment('search');
        $payinmodel->unsetAttributes();  // clear any default values
        if(isset($_GET['Payment']))
            $payinmodel->attributes=$_GET['Payment'];
        
        $totalAR = 0;
        $totalAP = 0;
        $totalCash = 0;
        $accountchart = $this->getAccountChart($totalAR, $totalAP, $totalCash);
        $mschart = $this->getMSTaskChart($milestone->order_id);
        $this->render( $this->getView('index','index'),
                        array(
                            'ordertask' => $ordertask,
                            'milestone'=>$milestone,
                            'orderlistLookup' => $orderlistLookup,
                            'accountchart' => $accountchart,
                            'mschart' => $mschart,
                            'payinmodel'=>$payinmodel,
                            'totalAR' => $totalAR,
                            'totalAP' => $totalAP,
                            'totalCash' => $totalCash,
                            )
                    );
    }
    public function renderPOSTypeDashboard()
    {       
        if($this->isSales())
        {
            $this->redirect( Yii::app()->createUrl('order/' . Helper::CONST_posclient) );
        }else
        {
            $customerduemodel = new Person;
            $customerduemodel->unsetAttributes();
            $productpricemodel = new Subproductprice;
            $productpricemodel->unsetAttributes();
            $orderproductmodel = new Orderproduct;
            $orderproductmodel->unsetAttributes();
            $this->render( $this->getView('index','index'),
                        array(
                            'customerduemodel' => $customerduemodel, 
                            'productpricemodel' => $productpricemodel,
                            'orderproductmodel' => $orderproductmodel,
                            )
                    );
        }        
    }
    public function getAccountChart(&$totalAR = 0, &$totalAP = 0, &$totalCash = 0)
    {
        $criteria=new CDbCriteria;
        $criteria->with = array(
            'party'
            ,'accountorders'=>array(
                                    'with'=>array('order','ordertask' => array('with'=>array('task')))
                                )
            );
        $criteria->order = 'order.name asc';
        $criteria->addCondition('t.amount > 0 AND t.paid < t.amount');
        $accounts = Account::model()->findAll($criteria);
        $receivablesData = array();
        $payablesData = array();
        $xcategories = array();
        $totalAR = 0;
        $totalAP = 0;
        $totalCash = 0;
        $tmpPaidAR = 0;
        $tmpPaidAP=0;
        foreach($accounts as $account)
        {
            $mydata = '';
            $prjname = $account->accountorders[0]->order->name;
            if(!in_array( strtolower($prjname), array_map('strtolower',$xcategories) ))
            {
                $xcategories[] = $prjname;
            }
            $amount = (float)$account->amount;
            $paid = (float)$account->paid;
            $balance = (float)($amount - $paid);
            
            $mydata .= "<br/>Inv.No: ".$prjname;
            $mydata .= "<br/>Inv.No: ".$account->acnt_no;
            $mydata .= "<br/>Amount: ".$amount;
            $mydata .= "<br/>Paid: ".$paid;
            $mydata .= "<br/>Balance: " . $balance;
            if(strtolower($account->accounttype) === strtolower(Helper::CONST_Receivables))
            {
                $tmprow = array('y' => $amount, 'mydata' => $mydata);
                $receivablesData[] = $tmprow;
                $totalAR += $balance;
                $tmpPaidAR += $paid;
            }
            if(strtolower($account->accounttype) === strtolower(Helper::CONST_Payables))
            {
                $tmprow = array('y' => -$amount, 'mydata' => $mydata);
                $payablesData[] = $tmprow;
                $totalAP += $balance;
                $tmpPaidAP += $paid;
            }
        }
        $totalCash = $tmpPaidAR - $tmpPaidAP;
        
        $chart = $this->widget('booster.widgets.TbHighCharts', array(
                                         'options'=>array(
                                            'credits' => array('enabled' => false),
                                            'exporting' => array('enabled' => false),
                                            'legend' => array('enabled' => true),
                                            'chart' => array('type'=>'bar'),
                                            'title' => array('text' => 'Receivables & Payables'),
                                            'xAxis' => array(
                                               'categories' => $xcategories,
                                            ),
                                            'yAxis' => array(
                                               'title' => array('text' => '')
                                            ),
                                            'tooltip' => array('formatter' => "js:function() {
                                                                       return 'Details: <b>'+ this.point.mydata +'</b>';
                                                             }"
                                                         ),
                                            'series' => array(
                                               array('name' => 'Receivables', 'data' => $receivablesData
                                                   ),
                                               array('name' => 'Payables', 'data' => $payablesData
                                                   )
                                            ),                                           
                                         )
                                      ),true);
        return $chart;
    }
    public function getMSTaskChart($orderId)
    {
        $chartData = array();
        $chartUrl = Yii::app()->createUrl('order/' . Helper::CONST_ordermstasks."/$orderId");
        $chart = $this->widget(
                'ext.Hzl.google.HzlVisualizationChart',
                array(
                    'visualization' => 'Timeline',
                    'firstRow' => true,
                    'packages' => 'timeline',
                    'data' => $chartData,
                    'url' => $chartUrl,
                    'options' => array(
                                    'title' => 'Milestones & Tasks',
                                    'timeline' => array('colorByRowLabel' => true),
                                    'backgroundColor' => '#ffd',
                                    'avoidOverlappingGridLines' => true
                                )
                    )
                ,true);
        return $chart;
    }
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ( $error = Yii::app()->errorHandler->error )
        {
            if ( Yii::app()->request->isAjaxRequest )
                echo $error['message'];
            else
                $this->render( 'error', $error );
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if ( isset( $_POST['ContactForm'] ) )
        {
            $model->attributes = $_POST['ContactForm'];
            if ( $model->validate() )
            {
                $name = '=?UTF-8?B?' . base64_encode( $model->name ) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode( $model->subject ) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail( Helper::CONST_adminEmail, $subject, $model->body, $headers );
                Yii::app()->user->setFlash( 'contact', 'Thank you for contacting us. We will respond to you as soon as possible.' );
                $this->refresh();
            }
        }
        $this->render( 'contact', array( 'model' => $model ) );
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm;

        // if it is ajax validation request
        if ( isset( $_POST['ajax'] ) && $_POST['ajax'] === 'login-form' )
        {
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }

        // collect user input data
        if ( isset( $_POST['LoginForm'] ) )
        {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ( $model->validate() && $model->login() )
            {
                $model->setAllLookupsInState();
                $loggedinurl = Yii::app()->user->returnUrl;
                //$loggedinurl = Yii::app()->createUrl('category/admin');
                $this->redirect( $loggedinurl );
            }
        }
        // display the login form
        if(!empty($this->appSecurityStatus))
        {
            $model->addError('password', $this->appSecurityStatus->message);
            //$this->appSecurityStatus = null;
        }
        $this->render( 'login', array( 'model' => $model ) );
    }
    public function doLogout()
    {
        $loginid = Yii::app()->user->login->id;
        $roleid = Yii::app()->user->role->id;
//        $count = Loginhistory::model()->update(
//                        Loginhistory::model()->tableName(), 
//                        array('logout_time' => date($this->datetimemysqlformatYMDHIS))
//                        ,'login_id = :loginid AND role_id=:roleid AND logout_time IS NULL'
//                        ,array(':loginid' => $loginid, ':roleid' => $roleid, )
//                );
        $criteria=new CDbCriteria;
        $criteria->addCondition('login_id = :loginid AND role_id=:roleid AND logout_time IS NULL');
        $criteria->params = array(':loginid' => $loginid, ':roleid' => $roleid, );
        $histories = Loginhistory::model()->findAll($criteria);
        foreach ($histories as $history)
        {
            $history->logout_time = date($this->datetimemysqlformatYMDHIS);
            $history->save();
        }
        Yii::app()->user->logout();
        if (!Yii::app()->request->isAjaxRequest) 
        {
            $this->redirect( Yii::app()->homeUrl );
        }
        else
        {
            Yii::app()->end();
        }
    }
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        $this->doLogout();
    }
}