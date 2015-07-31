<?php

namespace Controller;

Class Menu extends \applib\Controller
{
        private $log;
        public function __construct($routes){
           parent::__construct();
           foreach ($routes as $i => $route) {
               if($route->getName()){
                    $this->router()->map($route);
               }
            }
            $this->log = $this->getLog();
        }
        public function notFound($callable = NULL){
            $this->render("error", array(), 404);
        }
        private function getTitle($domain){
            $title = "Management";
            switch ($domain){
                case Menu::domain_people:
                    $title = "People Management";
                    break;
                case Menu::domain_jobs:
                case Menu::domain_orders:
                    $title = "Job Management";
                    break;
                default:
                    break;
            }
            return $title;
        }
        public function getMethod($param1, $param2 = -1, $param3 = -1, $param4 = 'full'){
            try{
//              //  $this->testLogins();
                if($param1 === Menu::domain_mstasksforchart){
                    ////why? don't know returning empty caused something weired for chart so open!!!
                    $whowantsid = 1;
                    $whowantstype = Menu::ppl_type_admin;
                }else{
                    $person = $this->authenticate();
                    if($person === false){
                        return;
                    }
                    $whowantsid = $person['id'];
                    $whowantstype = $person['type'];
                }
                $title = $this->getTitle($param1);
                $wanted2ndtype = '';
                $issummary = false;
                if(!is_numeric($param2)){
                    if(strtoupper($param2) === 'SHORT' 
                            || strtoupper($param2) === 'FULL')
                    {
                        $param4 = $param2;
                        $param3 = -1;
                        $param2 = '';
                        $wantedid = (int)$param3;
                        $wantedstatus = '';
                    }else{
                        $tmptype = $param2;
                        if($tmptype !== Menu::domain_all
                                && $tmptype !== Menu::domain_employees
                                && $tmptype !== Menu::domain_customers
                                && $tmptype !== Menu::domain_peopleslots
                                && $tmptype !== Menu::domain_contractors
                                && $tmptype !== Menu::domain_suppliers
                                && $tmptype !== Menu::domain_jobs
                                && $tmptype !== Menu::domain_orders
                                && $tmptype !== Menu::domain_quotes
                                && $tmptype !== Menu::domain_invoices
                                && $tmptype !== Menu::domain_voids
                                && strtolower($tmptype) !== Menu::payment_inwards
                                && strtolower($tmptype) !== Menu::payment_outwards
                                && strtolower($tmptype) !== Menu::ordertask_tasksummary
                                && strtolower($tmptype) !== 'noproducts'
                        ){
                            $wantedstatus = $param2;
                            $param2 = '';
                            $wantedid = $param3;
                        }else{
                            if(!is_numeric($param3)){//get by statuses or customs
                                if(strtoupper($param3) === 'SHORT' || strtoupper($param3) === 'FULL'){                        
                                    $param4 = $param3;
                                    $param3 = -1;
                                    $wantedid = (int)$param3;
                                    $wantedstatus = '';
                                }else{
                                    if($param3 === Menu::domain_quotes 
                                            || $param3 === Menu::domain_orders
                                            || $param3 === Menu::domain_invoices
                                            || $param3 === Menu::domain_customers
                                            || $param3 === Menu::domain_employees
                                    ){
                                        $wanted2ndtype = $param3;
                                        $wantedstatus = '';
                                    }else{                                        
                                        if(strtoupper($param3) === 'SUMMARY'){
                                            $wantedstatus = '';
                                            $issummary = true;
                                        }else{
                                            $wantedstatus = $param3;
                                        }
                                    }
                                    if(is_numeric($param4) && ((int)$param4) >0 ){
                                        $wantedid = (int)$param4;
                                        $param4 = 'full';
                                    }else{
                                        $wantedid = -1;                                        
                                        if(strtoupper($param4) === 'SUMMARY'){
                                            $issummary = true;
                                            $param4 = 'full';
                                        }
                                    }
                                }
                            }else{
                                if($param1 === Menu::domain_ordertasks 
                                        && strtolower($param2) === Menu::ordertask_tasksummary)
                                {
                                    $wantedid = -1;
                                }else{
                                    $wantedid = (int)$param3;
                                }
                                $wantedstatus = '';
                            }
                        }
                    }
                }else{
                    if($param3 === -1){
                       $wantedstatus = ''; 
                    }else{
                        $wantedstatus = $param3;
                    }
                    $wantedid = $param2;
                    $param2 = '';                    
                }
                if(($param1 === Menu::domain_jobs || $param1 === Menu::domain_orders)
                        && $issummary
                        && ($wanted2ndtype === Menu::domain_customers
                            || $wanted2ndtype === Menu::domain_employees)
                ){//orders/quotes/customers/summary group by people
                    $param1 = Menu::domain_people;
                    $t = $param2;
                    $param2 = $wanted2ndtype;
                    $wanted2ndtype = $t;
                }
                
                switch ($param1){
                    case Menu::domain_people:
                        $wantedtype = $this->getPeopleType($param2);
                        if(is_null($wantedtype) && $param2 !== Menu::domain_peopleslots)
                        {
                            $data = array();
                        }else{
                            if($param2 === Menu::domain_peopleslots){
                                $wantedtype = $param2;
                            }
                            $data = $this->getPeople($wantedtype, $wantedid, $wantedstatus, $whowantsid, $whowantstype, $wanted2ndtype, $issummary);
                        }
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                        echo $data;
                        break;                    
                    case Menu::domain_products:
                        $data = array();
                        $wantedtype = $param2;//category if given
                        $data = $this->getProducts($wantedid, $wantedtype, $whowantsid, $whowantstype);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));                        
                        $jsonerr = $this->getJsonerror();
                        echo $data;
                        break;
                    case Menu::domain_purchases:
                        $data = array();
                        $wantedtype = $param2;//category if given
                        $data = $this->getPurchases($wantedid, $wantedtype, $whowantsid, $whowantstype);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                        $jsonerr = $this->getJsonerror();
                        echo $data;
                        break;
                    case Menu::domain_orders:
                    case Menu::domain_jobs:
                        switch($param2){
                            case Menu::domain_all:
                                $wantedtype = '';
                                break;
                            case Menu::domain_quotes:
                                $wantedtype = Menu::ord_type_quote;
                                break;
                            case Menu::domain_orders:
                            case '':
                                $wantedtype = Menu::ord_type_order;
                                break;
                            case Menu::domain_invoices:
                                $wantedtype = Menu::ord_type_invoice;
                                break;
                        }
                        if(!isset($wantedtype))
                        {
                            $data = array();
                        }else{
                            $wanteddate = null;
                            $data = $this->getOrders($param2, $wantedtype, $wanted2ndtype, $wantedid
                                    , $wantedstatus, $wanteddate, $whowantsid, $whowantstype, $issummary);
                        }
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                        echo $data;
                        break;
                    case Menu::domain_orderentrylists:
                        $data = array();
                        $this->getListsForOrderCrud($whowantsid, $whowantstype, $data, $param2);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                        echo $data;
                        break;
                    case Menu::domain_ordertaskentrylists:
                        $data = array();
                        $this->getListsForOrderTaskCrud($data);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);                        
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                        echo $data;
                        break;
                    case Menu::domain_orderslkuplist:
                        $data = array();
                        $this->getOrderslkuplist($data);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                        echo $data;
                        break;
                    case Menu::domain_accountentrylists:
                        $data = array();
                        $this->getListsForAccountCrud($data);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);                        
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                        echo $data;
                        break;
                    case Menu::domain_paymententrylists:
                        $data = array();
                        $this->getListsForPaymentCrud($data);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);                        
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                        echo $data;
                        break;
                    case Menu::domain_productentrylists:
                        $data = array();
                        $this->getListsForProductCrud($data);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);                        
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                        echo $data;
                        break;
                    case Menu::domain_purchaseentrylists:
                        $data = array();
                        $this->getListsForPurchaseCrud($data, $param2);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);                        
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                        echo $data;
                        break;
                    case Menu::domain_ordertasks:
                        if($param3 > 0)
                        {
                            $forwhatOrder = $param3;
                            $isonlysummary = strtolower($param2) === Menu::ordertask_tasksummary;                            
                        }
                        else
                        {
                            $forwhatOrder = -1;
                        }
                        
                        $data = $this->getOrderTasks($wantedid, $wantedstatus, $whowantsid, $whowantstype, $forwhatOrder, $isonlysummary);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                        echo $data;
                        break;
                    case Menu::domain_milestones:
                    	$chartData = array();
                    	$isForChart = false;
                        $data = $this->getMilestones($wantedid, $wantedstatus, $whowantsid, $whowantstype, $isForChart, $chartData);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                        echo $data;
                        break;
                    case Menu::domain_mstasksforchart:
                        $chartData = array();
                    	$isForChart = true;
                        $data = $this->getMilestones($wantedid, $wantedstatus, $whowantsid, $whowantstype, $isForChart, $chartData);
                        $rtnCode = Menu::app_OK;
                        $message = count($chartData);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $chartData, 'message' => $message));
                        //$data = json_encode($data);
                        echo $data;
                        break;
                    case Menu::domain_accounts:
                        $data = $this->getAccounts($wantedid, $wantedstatus, $whowantsid, $whowantstype);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                        $jsonerr = $this->getJsonerror();
                        echo $data;
                        break;
                    case Menu::domain_payments:
                        $wantedtype = $param2;
                        $data = $this->getPayments($wantedid, $wantedstatus, $wantedtype, $whowantsid, $whowantstype);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                        echo $data;
                        break;
                    case Menu::domain_paymentsforchart:
                        $wantedtype = $param2;
                        $data = $this->getPaymentsForChart($wantedid);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                        echo $data;
                        break;
                    case Menu::domain_accountsforchart:
                        $wantedtype = $param2;
                        $data = $this->getAccountsForChart($wantedid);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                        echo $data;
                        break;
                    case Menu::domain_configs:
                        $data = array();
                        $this->getConfigs($data);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);                        
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                        echo $data;
                        break;
                    case Menu::domain_geolocations:
                        $data = $this->getGeolocations(Menu::ppl_type_employee, -1);
                        $rtnCode = Menu::app_OK;
                        $message = count($data);
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                        echo $data;
                        break;
                    default:
                        $data = array();
                        $rtnCode = Menu::app_Unavailable;
                        $message = "Unavailable";
                        $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                        echo $data;
                        break;
                }
            }catch (\ActiveRecord\RecordNotFound $ex) {
                $data = array();
                $rtnCode = Menu::app_Unavailable;
                $message = "Requested resource unavailable.";
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                echo $data;
            }
            catch (\ActiveRecord\RelationshipException $ex) {
                $data = array();
                $rtnCode = Menu::app_UnableToProcess;
                $message = "Unable able to process your request.";
                $this->log->debug($ex->getMessage());
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                echo $data;
            }
            catch (\ActiveRecord\DatabaseException $ex) {
                $data = array();
                $rtnCode = Menu::app_UnableToProcess;
                $message = "Unable able to process your request.";
                $this->log->debug($ex->getMessage());
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                echo $data;
            }
            catch (\Slim\Exception $ex) {
                $data = array();
                $rtnCode = Menu::InternalServerError;
                $message = "Internal server error";
                $this->log->debug($ex->getMessage());
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                echo $data;
            }            
            catch (\Exception $ex) {                
                $data = array();
                $rtnCode = Menu::InternalServerError;
                $message = "Internal server error";
                $this->log->debug($ex->getMessage());
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                echo $data;
            }
        }
        private function getJsonerror(){
            $tt = json_last_error();
            $err = '';
            switch ($tt) {
                case JSON_ERROR_NONE:
                    $err = '';
                break;
                case JSON_ERROR_DEPTH:
                    $err = ' - Maximum stack depth exceeded';
                break;
                case JSON_ERROR_STATE_MISMATCH:
                    $err = ' - Underflow or the modes mismatch';
                break;
                case JSON_ERROR_CTRL_CHAR:
                    $err = ' - Unexpected control character found';
                break;
                case JSON_ERROR_SYNTAX:
                    $err = ' - Syntax error, malformed JSON';
                break;
                case JSON_ERROR_UTF8:
                    $err = ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
                default:
                    $err = ' - Unknown error';
                break;
            }
            return $err;
        }
        public function postMethod($domain, $domaintype = -1, $param = -1, $id = -1){
            try{
                $ismbllogin = ($domain === 'mobile' && $domaintype === 'login');
                $islogin = $domain === 'login' || $ismbllogin;
                $ismblgnrgstr = ($domain === 'mobile' && ($domaintype === 'login' || $domaintype === 'register'));
                $authnotreqd =  $domain === 'login' 
                                || $domain === 'register' 
                                || $ismblgnrgstr;
                if(!$authnotreqd){
                    $person = $this->authenticate();
                    if($person === false){
                        return;
                    }
                }
                else
                {//missing check for config[which is included in auth.] 
                //so check for the case of auth not required
                //and for mobile auth not required too
                   //if(!$ismblgnrgstr){
                        $configOk = $this->setConfigsFromDB();
                        if(!$configOk)
                        {
                            $data = array();
                            $rtnCode = Menu::InternalServerError;
                            $message = "Invalid Config.";
                            $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                            echo $data;
                            return;
                        }
                    //
                }                
                //getting params method 1
//                $reqData = array();
//                $reqData = $_REQUEST;
//                // Handling PUT request params
//                if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
//                    $app = \Slim\Slim::getInstance();
//                    parse_str($app->request()->getBody(), $reqData);
//                }
                //getting params method 2
                $reqData = $this->request()->getBody();
                $postedData = json_decode($reqData);
                if($domain === Menu::domain_orders && $domaintype === Menu::invoicepdf){
//                    $wantedid = (int)$param;
                    $config = array('moperinvoice' => $this->moperinvoice
                                    , 'enableordrlis' => $this->enableordrlis
                                    , 'enableordrtasks' => $this->enableordrtasks);                    
                    $this->testFpdf($config, $postedData);
                    return;
                }
                if($islogin){
                    $rtnarray = array();
                    $this->checkLogin($postedData, $rtnarray, $ismbllogin);
                    $rtnCode = $rtnarray['RetCode'];
                    $data = $rtnarray['data'];
                    $message = $rtnarray['message'];
                    $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                    echo $data;
                }else{
                    if($domain === 'mobile' && $domaintype !== 'register'){
                        //for requests coming from mobile
                        $this->processForMobileClient($person, $domaintype, $postedData);
                    }else{
                        $rtnarray = array();
                        if($domain === 'register' ||
                                ($domain === 'mobile' && $domaintype === 'register')){
                            $domain = Menu::domain_people;
                            $domaintype = '';
                            $rtnmsg = $this->addData($domain, $postedData);
                        }else if(!isset($domaintype)
                                || (is_numeric($domaintype) && (int)$domaintype === -1)
                        ){
                            $domaintype = '';
                            $rtnmsg = $this->addData($domain, $postedData);
                        }else if((!isset($param)
                                || (is_numeric($param) && (int)$param === -1))
                                && !is_numeric ($domaintype)
                                && $domaintype !== Menu::updateordertask
                                && $domaintype !== Menu::payment
                                && $domaintype !== Menu::quottoorder
                                && $domaintype !== Menu::ordrtoinvoice
                                && $domaintype !== Menu::schedule
                                && $domaintype !== Menu::search
                                && $domaintype !== Menu::domain_peopleslots
                                && $domaintype !== Menu::domain_orderdeliverynotes
                        ){
                            $rtnmsg = $this->addData($domain, $postedData);
                        }else{
                            if(isset($domaintype) && (int)$domaintype > 0){
                                $rtnmsg = $this->updateData($domain, (int)$domaintype, $postedData);
                            }else if(isset($param) && (int)$param > 0){
                                $rtnmsg = $this->updateData($domain, (int)$param, $postedData);
                            }else{
                                if(isset($domaintype)
                                    && ($domaintype === Menu::updateordertask
                                    || $domaintype === Menu::payment
                                    || $domaintype === Menu::quottoorder
                                    || $domaintype === Menu::ordrtoinvoice
                                    || $domaintype === Menu::schedule
                                    || $domaintype === Menu::search
                                    || $domaintype === Menu::domain_peopleslots
                                    || $domaintype === Menu::domain_orderdeliverynotes)
                                ){
                                    $whattodo = $domaintype;
                                    $this->dotheRqrdOperations($person, $domain, $whattodo, $postedData);
                                    return;
                                }
                            }
                        }
                        //for adddate or updatedata methods.
                        $retcode = Menu::app_OK;
                        if(strtolower($rtnmsg) !== 'ok'
                                && strtolower($rtnmsg) !== 'updated'){
                            $retcode = Menu::app_SaveError;
                            $rtnmsg = "Error in save/update";
                        }
                        $data = json_encode(array('message' => $rtnmsg,'RetCode'=>$retcode));
                        echo $data;
                    }
                }
            }
            catch (\ActiveRecord\RelationshipException $ex) {
                $data = array();
                $rtnCode = Menu::app_UnableToProcess;
                $message = "Unable able to process your request.";
                $this->log->debug($ex->getMessage());
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                echo $data;
            }
            catch (\ActiveRecord\DatabaseException $ex) {
                $data = array();
                $rtnCode = Menu::app_UnableToProcess;
                $message = "Unable able to process your request.";
                $this->log->debug($ex->getMessage());
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                echo $data;
            }
            catch (\Slim\Exception $ex) {
                $data = array();
                $rtnCode = Menu::InternalServerError;
                $message = "Internal server error";
                $this->log->debug($ex->getMessage());
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                echo $data;
            }
            catch (\Exception $ex) {
                $data = array();
                $rtnCode = Menu::InternalServerError;
                $message = "Internal server error";
                $this->log->debug($ex->getMessage());
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                echo $data;
            }
        }
        private function processForMobileClient($person, $domaintype, $postedData){
            $person_id = $person["id"];
            switch($domaintype){
                case Menu::domain_geolocations:
                    $this->addGeolocations($person_id, $postedData);
                    $data = array();
                    $rtnCode = Menu::app_OK;
                    $message = "Geolocation added";
                    $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                    echo $data;
                    break;
                case Menu::domain_jobs:
                case Menu::domain_orders:
                    $wanteddate = $postedData->slotdate;
                    $wantedstatus = 'exceptopenrejected';// undelivered -> array('ASSIGNED','ACCEPTED','PICKEDUP');
                    $data = $this->getOrders(Menu::domain_orders, Menu::ord_type_order, Menu::domain_employees, $person_id
                                    , $wantedstatus, $wanteddate, $person_id, Menu::ppl_type_employee, false, array(), true);
                    $rtnCode = Menu::app_OK;
                    $message = "Jobs List";
                    $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                    echo $data;
                    break;
                case Menu::domain_updatejobstatus:
                    $this->updateJobStatus($person_id, $postedData);
                    $data = array();
                    $rtnCode = Menu::app_OK;
                    $message = "Job Status Updated.";
                    $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                    echo $data;
                    break;
                case Menu::domain_updatedevicetoken:
                    $this->updateDevicetoken($person_id, $postedData);
                    $data = array();
                    $rtnCode = Menu::app_OK;
                    $message = "Device Token Updated.";
                    $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                    echo $data;
                    break;
                    break;
                default:
                    $data = array();
                    $rtnCode = Menu::NotImplemented;
                    $message = "Not Implemented";
                    $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                    echo $data;
                    break;
            }
        }
        private function addGeolocations($person_id, $postedData){
            if(!is_array($postedData)){
               $postedData = array($postedData); 
            }
            foreach ($postedData as &$data) {
                try{
                    if($data->locname === null) $data->locname = 'Not Given';
                     $attributes = array(
                                     "person_id" => $person_id,
                                     "lng" => $data->lng,
                                     "lat" => $data->lat,
                                     "locname" => $data->locname,
                                     "captured_at" => $data->captured_at
                                     );
                     \Geolocation::create($attributes);
                }
                catch (\Slim\Exception $ex) {                    
                }
                catch (\Exception $ex) {
                }
            }
        }
        private function updateJobStatus($personId, $postedData){
            if(!is_array($postedData)){
                $postedData = array($postedData);
            }
            $rjcnt = 0;
            $rjctdJobs = array();
            foreach ($postedData as &$data) {
                try{
                    $job_id = -1;
                    if(isset($data->job_id)) $job_id = $data->job_id;
                    try{
                        $jobdata = \Order::find($job_id);
                    }catch (\ActiveRecord\RecordNotFound $ex) {
                        $jobdata = null;
                    }
                    if(is_null($jobdata)){
                        continue;
                    }
                    $prvsts = $jobdata->status;
                    $pdate = $postedData->pickedup_at;
                    if(strtoupper($postedData->status) === Menu::sts_pickedup && !$pdate){
                        $pdate = date('Y-m-d H:i:s');
                    }
                    $ddate = $postedData->delivered_at;
                    if(strtoupper($postedData->status) === Menu::sts_delivered && !$ddate){
                        $ddate = date('Y-m-d H:i:s');
                    }
                    $attributes = array(
                                    "status" => strtoupper($data->status),
                                    "started_at" => $pdate,
                                    "closed_at" => $ddate
                                    );
                    $jobdata->update_attributes($attributes);
                    if(strtolower($jobdata->status) !== strtolower($prvsts)){
                        $this->updatestatushistory(1, $jobdata->id, $jobdata->status, $jobdata->updated_at);//1 -order 2- ordertask etc.,
                    }
                    if(strtoupper($data->status) === Menu::sts_rejected){
                        $rjcnt++;
                        $existemprow = \Orderperson::find('all', array('conditions' => array('type = \'employee\' AND job_id=? AND person_id=?', $job_id, $personId)));
                        if(count($existemprow) === 1){
                            $existemprow[0]->delete();
                        }
                        $rjctdJobs[$rjcnt] = $data;
                    }
                    $this->checkAndSaveSlots($personId, $jobdata->addnlinfo1, $jobdata->status, $jobdata->addnlinfo1);
                    if($data->consignmentnotes){
                        $consignattrs = array(
                        "notes" => $data->consignmentnotes,
                        "job_id" => $job_id,
                        "person_id" => $personId);
                        \Consignmentnote::create($consignattrs);
                    }
                } catch (\Slim\Exception $ex) {                    
                }
                catch (\Exception $ex) {
                }
            }
            if($rjcnt > 0){
                $message = '';
                $message = "Dear Sir, ". "<br><br>";
                $message .= "Job Rejections happened." . "<br><br><br>" . "The details follow:" . "<br><br>";
                $message .= "Rejected by the Employee " . $personId . "<br><br>";
                $message .= "Rejected Jobs Count : " . $rjcnt . "<br><br><br>";
                $jids = '';
                foreach ($rjctdJobs as &$rdata) {
                    $job_id = $rdata->job_id;
                    $jids .=  $job_id . ', ' ;
                    $jobdata = \Order::find($job_id);
                    $custName = 'N/A';
                    $custMobile = 'N/A';
                    $rjct_time = 'N/A';
                    $jobpersndata = \Orderperson::find('all', array('conditions' => array('type = ? AND job_id=?', Menu::ppl_type_customer, $job_id)));
                    if(count($jobpersndata) === 1){
                        foreach($jobdata->people as &$prsndata){
                            if($prsndata->id === $jobpersndata[0]->person_id){
                                $custName = $prsndata->name . ", Contact: " . $prsndata->firstname . ' ' . $prsndata->lastname;
                                $custMobile = $prsndata->mobile;
                                $rjct_time = $jobdata->updated_at->format('m/d/Y H:i:s a') . '[Zone : ' . $jobdata->updated_at->getTimeZone()->getName() . ']';
                            }
                        }
                    }
                    $message .= "Job Sender Name :" . $custName . "<br><br>";
                    $message .= "Job Sender Mobile :" . $custMobile . "<br><br>";                    
                    $message .= "Job Rejection Time :" . $rjct_time . "<br><br>";
                }
                $message .= "Thanks." . "<br><br>";
                $message .= "Portal Admin.". "<br><br>";
                $subject = $this->job_rejectmail_sub . '  Emp.ID : '  . $personId . ', JobID[s]: '  . $jids;
                $this->pushToMailQueue($subject, $message);
            }
        }
        private function updateDevicetoken($personId, $postedData){
            if(!is_array($postedData)){
                $postedData = array($postedData);
            }
            foreach ($postedData as &$data) {
                try{
                    $devtoken = null;
                    if(isset($data->deviceToken)) $devtoken = $data->deviceToken;
                    try{
                        $person = \Person::find($personId);
                    }catch (\ActiveRecord\RecordNotFound $ex) {
                        $person = null;
                    }
                    if(is_null($person)){
                        continue;
                    }
                    $attributes = array(
                                    "devicetoken" => $devtoken
                                    );
                    $person->update_attributes($attributes);                    
                } catch (\Slim\Exception $ex) {
                }
                catch (\Exception $ex) {
                }
            }
        }
        public function deleteMethod($domain, $domaintype = -1, $id = -1){
            try{
                $rtnmsg = $this->deleteData($domain, $domaintype, $id);
                $data = array();
                $isOk = strpos($rtnmsg, Menu::OK .'') === 0;
                if($isOk){
                    $rtnCode = Menu::app_OK;
                    $message = substr($rtnmsg, strlen(Menu::OK .''));
                    if(empty($message)) $message = "Deleted";
                }else{
                    $rtnCode = Menu::app_SaveError;
                    $message = $rtnmsg;
                }
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                echo $data;
            }catch (\ActiveRecord\RecordNotFound $ex) {
                $data = array();
                $rtnCode = Menu::app_Unavailable;
                $message = "Requested resource unavailable.";
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                echo $data;
            }
            catch (\ActiveRecord\RelationshipException $ex) {
                $data = array();
                $rtnCode = Menu::app_UnableToProcess;
                $message = "Unable able to process your request.";
                $this->log->debug($ex->getMessage());
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                echo $data;
            }
            catch (\ActiveRecord\DatabaseException $ex) {
                $data = array();
                $rtnCode = Menu::app_UnableToProcess;
                $message = "Unable able to process your request.";
                $this->log->debug($ex->getMessage());
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                echo $data;
            }
            catch (\Slim\Exception $ex) {
                $data = array();
                $rtnCode = Menu::InternalServerError;
                $message = "Internal server error";
                $this->log->debug($ex->getMessage());
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                echo $data;
            }
            catch (\Exception $ex) {
                $data = array();
                $rtnCode = Menu::InternalServerError;
                $message = "Internal server error";
                $this->log->debug($ex->getMessage());
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                echo $data;                
            }
        }
        private function getDateFromNouns($nounstr){
            $datetime = new \DateTime('today');
            switch(strtoupper($nounstr)){
                case strtoupper('TODAY'):
                    break;
                case strtoupper('TOMORROW'):
                    $datetime->modify('+1 day');
                    break;
                case strtoupper('DayAfterTomorrow'):
                    $datetime->modify('+1 day');
                    break;
            }
            $datestr = $datetime->format('Y-m-d');
            return $datestr;
        }
        private function dotheRqrdOperations($person, $domain, $whattodo, $postedData){
            switch ($domain){
                case Menu::domain_people:
                    switch($whattodo){
                        case Menu::domain_peopleslots:
                            $stdemptypes = explode(',', Menu::std_ppl_types);
                            $isemployee = in_array(strtolower($person['type']), array_map('strtolower', $stdemptypes));
                            if($isemployee){
                                $slotdate = $this->getDateFromNouns($postedData->slotdate);
                                $slotsdata = $this->searchPeopleSlots($person, $slotdate);
                            }                            
                            $jobsdata = $this->searchOrdersRefined($person, $postedData);
                            $employeesdata = array();
                            $allempresult = \Person::find('all', array('conditions' => array('type=?', 'employee'), 'order' => 'name asc'));
                            foreach ($allempresult as $allemprec) {
                                 $allemprecary = $allemprec->to_array(array('select' => array('id','name')));
                                 $employeesdata[] = $allemprecary;
                            }
                            $rtnCode = Menu::app_OK;
                            $message = count($jobsdata);
                            $data = json_encode(array('RetCode' => $rtnCode, 'jobsdata' => $jobsdata
                                            , 'slotsdata' => $slotsdata, 'employeesdata' => $employeesdata
                                            , 'message' => $message));
                            echo $data;
                            break;
                        default:
                        break;
                    }
                    break;
                case Menu::domain_jobs:
                case Menu::domain_orders:
                    switch($whattodo){
                        case Menu::quottoorder:
                            break;
                        case Menu::ordrtoinvoice:
                            break;
                        case Menu::updateordertask:
                            break;
                        case Menu::updateorderstatus:
                            break;
                        case Menu::schedule:
                            $this->scheduleOrders(-1, $postedData);//new schedule
                            $data = array();
                            $rtnCode = Menu::app_OK;
                            $message = "Assignment Done.";
                            $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));
                            echo $data;
                            break;
                        case Menu::search:
                            $data = $this->searchOrdersRefined($person, $postedData);
                            $rtnCode = Menu::app_OK;
                            $message = "Searh Result.";
                            $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));                            
                            echo $data;
                            break;
                        case Menu::domain_orderdeliverynotes:
                            $rtnCode = $this->addDeliveryNotes($postedData);
                            $message = "Deliverynote saved.";
                            if($rtnCode !== Menu::app_OK){
                                $message = "Deliverynote save failed.";
                            }
                            $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message, 'title' => $title));                            
                            echo $data;
                            break;
                        default:
                        break;
                    }
            }
        }
        private function addDeliveryNotes($postedData){
            $orderid = $postedData->id;
            $order = \Order::find($orderid);
            if(is_null($order) || count($order) <= 0){
                return;
            }
            foreach($postedData->orderproducts as $orderprd){
                $productid = $orderprd->product_id;
                $orderproductid = $orderprd->id;
                $product = \Product::find($productid);
                $orderproduct = \Orderproduct::find($orderproductid);
                if(is_null($product) || count($product) <= 0                        
                        || is_null($orderproduct) || count($orderproduct) <= 0){
                    return;
                }
                $curntdlvry = $orderprd->tmpqnty;
                if(is_numeric($curntdlvry) && $curntdlvry > 0){
                    $ttldlvrd =  $orderprd->delivered + $curntdlvry;
                    $attributes = array("delivered" => $ttldlvrd);
                    $orderproduct->update_attributes($attributes);

                    $attributes = array("order_id" => $orderid
                                        ,"orderproduct_id" => $orderproductid
                                        ,"quantity" => $curntdlvry
                                        ,"delivered_at" => date('Y-m-d'));
                    \Orderproductdn::create($attributes);

                    if($this->enablestock){
                        $newstock = $product->stock - $curntdlvry;
                        $remarks = $product->remarks;                               
                        if($ttldlvrd > $orderprd->quantity){
                            $extradlvry = $ttldlvrd - $orderprd->quantity;
                            $orderqoiid = $order->qoi_id;
        //                    $newstock = $product->stock - $extradlvry;

                            $remarks = $remarks . "\n as of " . date('Y-m-d') . " totally $extradlvry  Extra for Order $orderqoiid";
                        }
                        $newstockval = round($newstock * $product->unit_cp, 2);
                        $attributes = array("stock" => $newstock
                                                ,"stockvalue" => $newstockval
                                                ,"remarks" => $remarks);
                        $product->update_attributes($attributes);
                    }
                }                
            }
            $this->updateOrderDeliveryStatus($order);
            $rtnCode = Menu::app_OK;
            return $rtnCode;
        }
        private function updateOrderDeliveryStatus($order){
            $fullydelivered = true;            
            foreach($order->orderproducts as $op){
                if($op->delivered < $op->quantity){
                    $fullydelivered = false;
                    break;
                }
            }
            $status = (($fullydelivered)?Menu::sts_delivered:Menu::sts_pending);
            $attributes = array("status" => $status
                                ,"delivered" => $fullydelivered);
            $order->update_attributes($attributes);
        }
        private function scheduleOrders($id, $postedData){
            foreach($postedData->jobs as $postedjob){
                $orderId = $postedjob->job->id;
                $empId = $postedjob->person->id;
                $createdId = $postedjob->created->id;
                if($orderId === -1 || $empId === -1 || $createdId === -1){
                    continue;
                }
                $existentryrow = \Orderperson::find('all', array('conditions' => array('type = ? AND order_id=?', Menu::ppl_type_created, $orderId)));
                if(count($existentryrow) === 1){
                    $existentryrow[0]->delete();
                }
                $existemprow = \Orderperson::find('all', array('conditions' => array('type = ? AND order_id=?', Menu::ppl_type_employee, $orderId)));
                $prvassgndempid = -1;
                if(count($existemprow) === 1
                        && !is_null($existemprow[0])
                        && !is_null($existemprow[0]->person)
                        && !is_null($existemprow[0]->person->id)
                ){
                    $prvassgndempid = $existemprow[0]->person->id;
                }
                if(count($existemprow) === 1){
                    $existemprow[0]->delete();
                }
                $ordrpplattributes = array(
                        "type" => Menu::ppl_type_created,
                        "order_id" => $orderId,
                        "person_id" => $createdId);
                \Orderperson::create($ordrpplattributes);
                $ordrpplattributes = array(
                    "type" => Menu::ppl_type_employee,
                    "order_id" => $orderId,
                    "person_id" => $empId);
                \Orderperson::create($ordrpplattributes);
                $order = \Order::find('all', array('conditions' => array('id=?', $orderId)));
                if(count($order) === 1){
                    $attributes = array(
                                "status" => "ASSIGNED"
                                );
                    $order[0]->update_attributes($attributes);
                    try{
                        $prvassgndemp = \Person::find($prvassgndempid);
                    }catch (\ActiveRecord\RecordNotFound $ex) {
                        $prvassgndemp = null;
                    }
                    if(!is_null($prvassgndemp)){
                        //need to check for his alloted slot and free him in that.
                        $isremoveassign = true;
                        $this->addOrUpdateTimeslots($order[0], array($prvassgndemp), $orders[0]->addnlinfo1, $isremoveassign);                        
                    }
                    try{
                        $curassgndemp = \Person::find($empId);
                    }catch (\ActiveRecord\RecordNotFound $ex) {
                        $curassgndemp = null;
                    }
                    if(!is_null($curassgndemp)){
                        $this->addOrUpdateTimeslots($order[0], array($curassgndemp), $orders[0]->addnlinfo1);
                    }
                }
            }
        }
        private function searchOrdersRefined($person, $postedData){
            $isperm = false;
            $cno = $postedData->cno;
            $cc = $postedData->cc;
            $cname = $postedData->cname;
            $ename = $postedData->ename;
            $invno = $postedData->invno;
            $orderstatus = $postedData->status;
            $ordrinvstatus = $postedData->invstatus;
            $ct = $postedData->slotdate;
            $st = $postedData->strange;
            $end = $postedData->endrange;
            
            $iscno = (isset($cno) && trim($cno) !== '');
            $iscc = (isset($cc) && trim($cc) !== '');
            $iscname = (isset($cname) && trim($cname) !== '');
            $isename = (isset($ename) && trim($ename) !== '');
            $isinvno = (isset($invno) && trim($invno) !== '');
            $isorderstatus = (isset($orderstatus) && !empty($orderstatus) && strtoupper(trim($orderstatus)) !== 'ALL');
            $isordrinvstatus = (isset($ordrinvstatus) && !empty($ordrinvstatus) && strtoupper(trim($ordrinvstatus)) !== 'ALL');
            $isct = (isset($ct) && strtoupper(trim($ct)) !== 'ALL');
            $isst = (isset($st) && strtoupper(trim($st)) !== 'ALL');
            $isend = (isset($end) && strtoupper(trim($end)) !== 'ALL');
            
            //min conditions.
            $wantedtype = Menu::ord_type_order;
            $domaintype = Menu::domain_orders;
            $conditions = array('UPPER(' . $domaintype . '.type)=?', $wantedtype);
            $dummyorderid = 1;
            $tmpcondition = array('orders.id!=?',$dummyorderid);
            \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            if($isct){
                $ctdate = $this->getDateFromNouns($postedData->slotdate);
                $tmpcondition = array('DATE(orders.addnlinfo1) = ?', $ctdate);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            if($isst){
                $tmptime = new \DateTime($st);
                $st = $tmptime->format('Y-m-d');
//                $di = date_parse_from_format('Y/m/d H:i', $st);
//                $st = $di['year'] . '-' . $di['month'] . '-' . $di['day'];
                $tmpcondition = array('DATE(orders.addnlinfo1) >= ?', $st);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            if($isend){
                $tmptime = new \DateTime($end);
                $end = $tmptime->format('Y-m-d');
//                $di = date_parse_from_format('Y/m/d H:i', $end);
//                $end = $di['year'] . '' . $di['month'] . '-' . $di['day'];
                $tmpcondition = array('DATE(orders.addnlinfo1) <= ?', $end);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            //based on loggedin user permissions. [orderpeople table]
            $whowantsid = $person['id'];
            $whowantstype = $person['type'];
            $isOrderpeoplejoin = ($whowantstype !== Menu::ppl_type_admin && !$isperm);
            if($isOrderpeoplejoin){
//                $rltnconditions = array('orderpeople.person_id=? AND orderpeople.type IN (?)', $whowantsid, array($whowantstype, "created", "modified", "employee", "incharge"));
                $rltnconditions = array('orderpeople.person_id=? AND orderpeople.type IN (?)', $whowantsid, array($whowantstype));
                \ActiveRecord\Utils::add_condition($conditions, $rltnconditions);
            }            
            //search creteria posted.
            if($iscno){
                $tmpcondn = array('UPPER(orders.addnlinfo) LIKE ?', '%'.strtoupper($cno).'%');
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondn);
            }
            if($isordrinvstatus){
                $tmpcondn = array('UPPER(orders.invstatus)=?', strtoupper($ordrinvstatus));
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondn);
            }
            if($isorderstatus){
                $gvnstsstr = strtoupper($orderstatus);
                switch($gvnstsstr){
                    case 'GTPICKED'://> pickedup thatis pickedup and closed
                        $orderstatusary = array(Menu::sts_pickedup, Menu::sts_closed, Menu::sts_delivered);
                        break;
                    case 'UPTOASSIGNED':
                        $orderstatusary = array(Menu::sts_open, Menu::sts_assigned);                        
                        break;
                    default:
                        $orderstatusary =  array(strtoupper($orderstatus));
                        break;
                }
                $tmpcondn = array('UPPER(orders.status) IN (?)', $orderstatusary);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondn);
            }
            $isPeoplejoin = $iscc || $iscname || $isename;//if need to search on costcenter,customername [people table]
            
            if($isPeoplejoin){
                $bothcustandemp = ($iscc || $iscname) && $isename;
                if($iscc){
                    $tmpcondn = array('UPPER(people.cost_center) LIKE ?', '%'.strtoupper($cc).'%');
                    \ActiveRecord\Utils::add_condition($conditions, $tmpcondn);
                }
                if($iscname){
                    $tmpcondn = array('people.type = ? and UPPER(people.name) LIKE ?', Menu::ppl_type_customer, '%'.strtoupper($cname).'%');
                    \ActiveRecord\Utils::add_condition($conditions, $tmpcondn);
                }
                if($iscc || $iscname){
                    $tmpcondn = array('orderpeople.type IN (?)', array(Menu::ppl_type_customer));
                    \ActiveRecord\Utils::add_condition($conditions, $tmpcondn);
                }
                if($isename && !$bothcustandemp){//people will be customers only later check for employees
                    $tmpcondn = array('orderpeople.type IN (?)', array(Menu::ppl_type_employee));
                    \ActiveRecord\Utils::add_condition($conditions, $tmpcondn);
                    $tmpcondn = array('people.type = ? and UPPER(people.name) LIKE ?', Menu::ppl_type_employee, '%'.strtoupper($ename).'%');
                    \ActiveRecord\Utils::add_condition($conditions, $tmpcondn);
                }
            }
            
            $isAccountjoin = $isinvno;
            if($isAccountjoin){
                $tmpcondn = array('UPPER(accounts.acnt_no) LIKE ?', '%'.strtoupper($invno).'%');
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondn);
            }
            
            $joins = '';
            if($isOrderpeoplejoin){
                $joins .= ' JOIN orderpeople on orders.id = orderpeople.order_id';
            }
            if($isPeoplejoin){
                $joins .= ' JOIN orderpeople on orders.id = orderpeople.order_id 
                            JOIN people on orderpeople.person_id = people.id';                
            }
            if($isAccountjoin){
                $joins .= ' JOIN accountorders on orders.id = accountorders.order_id
                            JOIN accounts on accountorders.account_id = accounts.id';
            }
            $optionsAry = array('conditions' => $conditions
                                , 'order' => 'end_at desc');
            if(trim($joins) !== ''){
                $optionsAry['joins'] = array($joins);
            }
            $result = \Order::find('all', $optionsAry);
            $this->prepareOrdersResult($result, $domaintype, $wantedtype, false, $bothcustandemp, $ename);
            return $result;
        }
//            SELECT * FROM orders a JOIN accounts b ON a.id = b.`order_id` 
//WHERE a.`addnlinfo` = 'E123' AND b.`acnt_no`='inv123'
//
//SELECT * FROM orders a JOIN orderpeople b ON a.id = b.`order_id` JOIN people c ON b.`person_id` = c.`id`
//WHERE a.`addnlinfo` = 'E123' AND c.`cost_center`='chennai'
//
//SELECT * FROM orders a JOIN accounts d ON a.id = d.order_id JOIN orderpeople b ON a.id = b.`order_id` JOIN people c ON b.`person_id` = c.`id`
//WHERE c.`cost_center`='chennai' AND d.acnt_no = 'inv123'
//
//SELECT * FROM orders a JOIN accounts d ON a.id = d.order_id JOIN orderpeople b ON a.id = b.`order_id` JOIN people c ON b.`person_id` = c.`id`
//WHERE a.`addnlinfo` = 'E123' AND c.`cost_center`='chennai' AND d.acnt_no = 'inv123'
//                $sql = "SELECT * FROM orders JOIN orderpeople ON orders.`id` = orderpeople.`order_id` JOIN people ON orderpeople.`person_id` = people.`id`";
//                $sql .= "WHERE UPPER(orders.type) = ? AND UPPER(orderpeople.type) = ? AND UPPER(people.`cost_center`) = ?";
//                $values = array(strtoupper($wantedtype), strtoupper(Menu::ppl_type_customer), strtoupper($cc));
//                $result = \ORder::find_by_sql($sql, $values);
//                SELECT * FROM orders JOIN orderpeople ON orders.`id` = orderpeople.`order_id` JOIN people ON orderpeople.`person_id` = people.`id`
// WHERE orders.type = 'ORDER' AND orderpeople.type = 'customer' AND people.`cost_center` = 'chennai'
        private function addData($domain, $postedData){
            switch ($domain){
                    case Menu::domain_people:                        
                    case Menu::domain_jobs:
                    case Menu::domain_orders:
                    case Menu::domain_ordertasks:
                    case Menu::domain_milestones:
                    case Menu::domain_accounts:
                    case Menu::domain_payments:                       
                    case Menu::domain_products:                       
                    case Menu::domain_purchases:
                        return $this->updateData($domain, -1, $postedData);
                        break;
                    default:
                        break;
            }
        }
        private function updateData($domain, $id, $postedData){
            switch ($domain){
                    case Menu::domain_people:
                        return $this->addOrUpdatePeople($id, $postedData);
                        break;
                    case Menu::domain_jobs:
                    case Menu::domain_orders:
                        return $this->addOrUpdateOrders($id, $postedData);
                        break;
                    case Menu::domain_ordertasks:
                        $isFromOrder = false;
                        return $this->addOrUpdateOrdertasks($id, $postedData, $isFromOrder);
                        break;
                    case Menu::domain_milestones:
                        $isFromOrder = false;
                        return $this->addOrUpdateOrderMilestones($id, $postedData, $isFromOrder);
                    break;
                    case Menu::domain_accounts:
                        return $this->addOrUpdateAccounts($id, $postedData);
                        break;
                    case Menu::domain_payments:
                        return $this->addOrUpdatePayments($id, $postedData);
                        break;
                    case Menu::domain_products:
                        return $this->addOrUpdateProducts($id, $postedData);
                        break;
                    case Menu::domain_purchases:
                        return $this->addOrUpdatePurchases($id, $postedData);
                        break;
                    default:
                        return "Not Supported.";
                        break;
                }
        }
        private function deleteData($domain, $domaintype, $id = -1){
            switch ($domain){
                case Menu::domain_people:
                    return $this->deletePeople($domaintype, $id);
                    break;
                case Menu::domain_jobs:
                case Menu::domain_orders:
                    return $this->deleteOrders($domaintype, $id);
                    break;
                case Menu::domain_products:
                    return $this->deleteProduct($domaintype);
                    break;
                default:
                    break;
            }
        }
        private function checkAndAppendE(&$consignmentno){
            $needle = "E";
            $isthere = $needle === "" || strpos($consignmentno, $needle) === 0;
            if(!$isthere && !empty($consignmentno)){
                $consignmentno = "E" . $consignmentno;
            }
        }
        private function getAttrForOrdersFromPost($postedData, $data = null){
            $isnew = is_null($data);
            $type = $postedData->type;            
            if(!$isnew){//for updating data
                $closed_at = $data->closed_at;
                $odrcnvt_at = $data->ordcnvrtdate;
                $qotcnvt_at = $data->qutcnvrtdate;                
                if($postedData->isconvert){
                    if($type === Menu::ord_type_quote){
                        $type = Menu::ord_type_order;
                        $quote_qoi_id = $postedData->qoi_id;
                        $qotcnvt_at = $postedData->qutcnvrtdate;
                        $status = Menu::sts_open;
                    }else if($type === Menu::ord_type_order){
                        $status = Menu::sts_closed;
                        $closed_at = (!is_null($postedData->ordcnvrtdate)?$postedData->ordcnvrtdate:date('Y-m-d H:i:s'));
                        $invstatus = Menu::sts_invoiced;
                        $odrcnvt_at = $closed_at;
                        $attributes = array(
                                "status" => $status,
                                "invstatus" => $invstatus,
                                "ordcnvrtdate" => $odrcnvt_at,
                                "closed_at" => $closed_at,
                                );
                        return $attributes;
                    }
                }else{
                    $status = $data->status;
                    if(isset($postedData->status)
                                && $postedData->status !== $status
                    ){
                        $status = $postedData->status;                            
                    }
                }
            }else{
                $status = Menu::sts_open;
                if(isset($postedData->status)
                                && $postedData->status !== $status
                ){
                    $status = $postedData->status;                            
                }
            }
            $closed_at = null;
            if($status === Menu::sts_closed || $status === Menu::sts_delivered){
                $closed_at = is_null($postedData->ordcnvrtdate)?$postedData->ordcnvrtdate:date('Y-m-d H:i:s');
            }
            $invstatus = Menu::sts_uninvoiced;            
            if(is_null($postedData->qotcnvt_at) && $this->directorder){
                $qotcnvt_at = date('Y-m-d H:i:s');
            }
            $esdate = $postedData->start_at;
            if(is_null($esdate)){
                $esdate = date('Y-m-d H:i:s');//expected start date start_at
            }
            $eedate = $postedData->end_at;
            if(is_null($eedate)){
                $eedate = date('Y-m-d H:i:s');//expected end date end_at
            }
            $started_at = $postedData->started_at;
            if(!isset($started_at)){
                $started_at = $postedData->pickedup_at;
            }
            if(!isset($started_at)){
                if(!$postedData->markasstarted 
                        && $status !== Menu::sts_started 
                        && $status !== Menu::sts_pickedup){
                    $started_at = $esdate;
                }else{
                    $started_at = date('Y-m-d H:i:s');
                }
            }
            $quote_qoi_id = (isset($postedData->quote_qoi_id))?$postedData->quote_qoi_id:"-1";
            $order_qoi_id = (isset($postedData->order_qoi_id))?$postedData->order_qoi_id:"-1";
            $budget = (isset($postedData->budget))?$postedData->budget:0;
            $cost = 0;
            $amount = 0;
            $discper = 0;
            $disc = 0;
            $taxper = 0;
            $taxamount = 0;
            $paid = 0;
                        
            $enableordrlis = ((!is_null($data))? $data->enableordrlis:$postedData->enableordrlis);
            $enableordrtasks = ((!is_null($data))? $data->enableordrtasks:$postedData->enableordrtasks);
            $enableordrtaskpeople = ((!is_null($data))? $data->enableordrtaskpeople:$postedData->enableordrtaskpeople);
            $enableordrpayments = ((!is_null($data))? $data->enableordrpayments:$postedData->enableordrpayments);
            $enableordermilestones = ((!is_null($data))? $data->enableordermilestones:$postedData->enableordermilestones);
            $ordercostamountfrom = ((!is_null($data))? $data->ordercostamountfrom:$postedData->ordercostamountfrom);
            $ordertaskcostamountfrom = ((!is_null($data))? $data->ordertaskcostamountfrom:$postedData->ordertaskcostamountfrom);
            $enablediscount = ((!is_null($data))? $data->enablediscount:$postedData->enablediscount);
            $orderdiscfor = ((!is_null($data))? $data->orderdiscfor:$postedData->orderdiscfor);
            $enableordername = ((!is_null($data))? $data->enableordername:$postedData->enableordername);
            
            if($ordercostamountfrom === 0){
                $cost = (isset($postedData->cost) && is_numeric($postedData->cost))?$postedData->cost:0;
                $amount = (isset($postedData->amount) && is_numeric($postedData->amount))?$postedData->amount:0;
                $taxper = (isset($postedData->taxper) && is_numeric($postedData->taxper))?$postedData->taxper:0;
                $taxamount = $amount * $taxper / 100.0;
                if($enablediscount === 1 && ($orderdiscfor === 0 || $orderdiscfor === 3 || $orderdiscfor === 4)){//discount on total order amount [cash discount]                    
                    if($this->discentry === 1){//not possible for discount
                        $discper = 0;
                        $disc = 0;
                    }else{
                        $discper = (isset($postedData->discper) && is_numeric($postedData->discper))?$postedData->discper:0;
                        $disc = $amount * $discper / 100.0;
                        //if discount amount entered but percent is 0. calculate %.
                        $disctmp = (isset($postedData->disc) && is_numeric($postedData->disc))?$postedData->disc:0;
                        if($discper <= 0 && $disctmp > 0){
                            $discper = $disctmp / $amount * 100.0;
                        }
                    }
                }
            }
            if($enableordrpayments === 0){
                $paid = (isset($postedData->paid) && is_numeric($postedData->paid))?$postedData->paid:0;
            }
            $qoi_id = $this->getOrderId($postedData, $type, $isnew);
            $this->checkAndAppendE($postedData->addnlinfo);
            $attributes = array(
                        "type" => $type,
                        "qoi_id" => $qoi_id,
                        "quote_qoi_id" => $quote_qoi_id,
                        "order_qoi_id" => $order_qoi_id,
                        "name" => $postedData->name,
                        "desc" => $postedData->desc,
                        "addnlinfo" => $postedData->addnlinfo,
                        "addnlinfo1" => $postedData->addnlinfo1,
                        "start_at" => $esdate,
                        "end_at" => $eedate,
                        "budget" => $budget,
                        "cost" => $cost,
                        "amount" => $amount - $disc,
                        "disc" => $disc,
                        "taxper" => $taxper,
                        "tax" => $taxamount,
                        "paid" => $paid,
                        "remarks" => $postedData->remarks,
                        "status" => $status,
                        "invstatus" => $invstatus,
                        "started_at" => $started_at,
                        "closed_at" => $closed_at,
                        "qutcnvrtdate" => $qotcnvt_at,
                        "ordcnvrtdate" => $odrcnvt_at,
                        "enableordrlis"  => $enableordrlis,
                        "enableordrtasks"  => $enableordrtasks,
                        "enableordrtaskpeople"  => $enableordrtaskpeople,
                        "enableordrpayments"  => $enableordrpayments,
                        "enableordermilestones"  => $enableordermilestones,
                        "ordercostamountfrom"  => $ordercostamountfrom,
                        "ordertaskcostamountfrom"  => $ordertaskcostamountfrom,
                        "enablediscount"  => $enablediscount,
                        "orderdiscfor"  => $orderdiscfor,
                        "enableordername"=>$enableordername
                        );
            return $attributes;
        }
        private function updateLastId($type, $idvalue){
            $lastid = explode('/', $idvalue);
            $lastid = substr($lastid[2],3);
            if(!is_numeric($lastid) || (int)$lastid <= 0) return;//number is not in our format.
            $conditions = array('forwhat=? AND foryear=? AND formonth=?', $type, $this->curyear, $this->curmonth);
            $result = \Idmaster::find('all', array('conditions' => $conditions));
            $attributes = array(
                            "forwhat" => $type
                            ,"foryear" => $this->curyear
                            ,"formonth" => $this->curmonth
                            ,"lastid" => $lastid);
            if(count($result) > 0){
                foreach ($result as &$rec) {                    
                    $rec->update_attributes($attributes);
                    break;
                }
            }else{
                \Idmaster::create($attributes);
            }
        }
        private function getOrderId($postedData, $type, $isnew, $fldname = 'qoi_id'){
            $newid = "-1";
            if(!$this->isordridauto){
                if($postedData->isconvert){
                    $newid = $postedData->newid;
                }else{
                    $newid = $postedData->$fldname;
                }
                if(!isset($newid)){
                    $newid = "-1";
                }
                return $newid;
            }else{
                if($isnew || $postedData->isconvert){
                    $conditions = array('forwhat=? AND foryear=? AND formonth=?', $type, $this->curyear, $this->curmonth);
                    $select = 'lastid';
                    $result = \Idmaster::find('all', array('select' => $select
                                , 'conditions' => $conditions));
                    $newid = $this->curyear . '/' . $this->curmonth . '/';
                    switch($type){
                        case Menu::ord_type_quote:
                            $staticstr = $this->qotid_static_str;
                        break;
                        case Menu::ord_type_order:
                            $staticstr = $this->ordrid_static_str;
                        break;
                        case Menu::ord_type_invoice:
                            $staticstr = $this->invid_static_str;
                        break;
                    }
                    $newid .= $staticstr;
                    if(count($result) > 0){
                        foreach ($result as &$rec) {
                            $tmpid = $rec->lastid + 1;
                            $newid .= sprintf('%05d',$tmpid);
                            break;
                        }
                    }else{
                        $tmpid = 1;
                        $newid .= sprintf('%05d',$tmpid);
                    }
                }else{
                    $newid = $postedData->$fldname;
                }
            }
            return $newid;
        }
        private function addOrUpdateOrders($id, $postedData){
            $rtnmsg = 'Error';
            try{
                try{
                    $data = \Order::find($id);
                }catch (\ActiveRecord\RecordNotFound $ex) {
                    $data = null;
                }
                $attributes = $this->getAttrForOrdersFromPost($postedData, $data);
                if(is_null($data)){
                    $oldtype = $postedData->type;
                }else{
                    $oldtype = $data->type;
                }
                if($attributes['qoi_id'] === '-1' 
                        && (!$postedData->isconvert 
                                || ($oldtype === Menu::ord_type_quote))
                ){
                    //$rtnmsg = 'Unable to save/update';
                    return $rtnmsg;              
                }                
                if(is_null($data)){
                    $isnew = true;
                    $data = \Order::create($attributes);
                    $id = $data->id;
                    if(is_null($id) || $id <= 0){//
                        //$rtnmsg = \ActiveRecord\array_flatten($data->errors->errors);
                        //$rtnmsg = 'Error in save/update';
                        return $rtnmsg;
                    }
                    $toupdateidmasters = $this->isordridauto;
                    $isordertoinvoice = false;
                    $prvcust = -1;
                    $prvct = null;
                    $prvsts = null;
                    $prvamnt = 0;
                }else{
                    $isnew = false;
                    $prvcust = $data->ordrcustomers[0]->id;
                    $prvct = $data->addnlinfo1;
                    $prvsts = $data->status;
                    $prvamnt = $data->amount;
                    $data->update_attributes($attributes);
                    $toupdateidmasters = $this->isordridauto 
                            && $postedData->isconvert 
                            && $oldtype === Menu::ord_type_quote;
                    $isordertoinvoice =  
                            ($postedData->type === Menu::ord_type_order
                                && $postedData->isconvert)
                            ||
                            ($postedData->type === Menu::ord_type_invoice
                                && $oldtype === Menu::ord_type_order);//order to invoice
                }
                if($toupdateidmasters){
                    $this->updateLastId($data->type, $data->qoi_id);
                }
                if($isordertoinvoice){
                    $this->addAccountsFromOrder($data);
                }else{
                    $this->addOrUpdateOrderRelated($isnew, $data, $postedData, $prvct, $prvcust, $prvsts, $prvamnt);   
                }
                $rtnmsg = 'Updated';
            }catch (\Slim\Exception $ex) {
                $rtnmsg = 'Error in save/update';
            }
            catch (\Exception $ex) {
                $rtnmsg = 'Error in save/update';
            }
            return $rtnmsg;
        }
        private function addOrUpdateOrderRelated($isnew, $order, $postedData, $prvct = null, $prvcust = -1, $prvsts = null, $prvamnt = 0){
            if(strtolower($order->status) !== strtolower($prvsts)){
                $this->updatestatushistory(1, $order->id, $order->status, $order->updated_at);//1 -order 2- ordertask etc.,
            }
            $newcustomer = $this->addorupdateOrderPeople($order, $postedData, $prvct);
            if($postedData->type === Menu::ord_type_order || $postedData->isconvert){
                $this->addorupdateOrderAdresses($order, $postedData, $newcustomer, $prvcust);
            }
            //for order-products
            $rolproducts = array();
            $ismodifylis = $order->enableordrlis === 1
                            && ((isset($postedData->ismodifylis))?$postedData->ismodifylis:false);
            if($ismodifylis){//either product sales[items oriented] 
                $this->addorupdateOrderLineItems($order, $postedData, $rolproducts);                
            }else{
                if($order->ordercostamountfrom === 1){
                    $this->reupdateOrderAmountsFromProducts($order, $postedData);
                }
            }
            if(count($rolproducts)>0 && $this->mail_for_rols){
                $this->prepareMailForROLAlert($rolproducts);
            }
            //for order-tasks
            $ismodifytasks = $order->enableordrtasks === 1
                    && ((isset($postedData->ismodifytasks))?$postedData->ismodifytasks:false);
            if($ismodifytasks){// or service sales[task oriented]
                $this->addOrUpdateOrderTasksFromOrder($order, $postedData);                
            }
            if($order->ordercostamountfrom === 2){
                //updating order amounts from tasks
                $order = \Order::find($order->id);
                $this->reupdateOrderAmountsFromTasks($order, $postedData->amount);
            }
            //for order-payments
            $ismodifypymnts = $order->enableordrpayments === 1
                                    && ((isset($postedData->ismodifypymnts))?$postedData->ismodifypymnts:false);
            if($ismodifypymnts){
                $this->addorupdateOrderPayments($order, $postedData);
            }
            $ismodifyms = $order->enableordermilestones === 1
                                    && ((isset($postedData->ismodifyms))?$postedData->ismodifyms:false);
            if($ismodifyms){
                $this->addOrUpdateOrderMsFromOrder($order, $postedData);
            }
            $this->updateInvoiceFromOrders($order, $prvamnt);
            if($isnew && $this->mail_on_new_order){
                $order_time = $order->created_at->format('m/d/Y H:i:s a') . '[Zone : ' . $order->created_at->getTimeZone()->getName() . ']';
                $this->prepareMailForNewOrder($order->id, $order_time, $postedData);
            }
        }
        private function updateInvoiceFromOrders($order, $oldorderamount, $applysurcharge = false)
        {
            foreach($order->accounts as $account)
            {
                $oldscamount = $account->scamount;
                $oldacntamount = $account->amount;
                $neworderamount = $order->amount;
                $newamount = $oldacntamount - $oldorderamount + $neworderamount;
                $newamount = $newamount - $oldscamount;                
                $newscamount = 0;
                if($newamount < 100)
                {
                    $newscamount =  ($applysurcharge)?$this->invsurcharge:0;
                    $newamount = $newamount + $newscamount;
                }
                $attributes = array('amount' => $newamount
                                    ,'scamount' => $newscamount);
                $account->update_attributes($attributes);
            }
        }
        private function deleteOrders($domaintype, $id){
            $rtnmsg = Menu::OK;
            try{
                if(is_numeric($id) && (int)$id > 0){
                    $conditions = array('id=?', $id);
                }else{
                    $ppltype = $this->getPeopleType($domaintype);
                    if(!is_null($ppltype) && trim($ppltype) !== ''){
                        $conditions = array('type=?', $ppltype);
                    }else{
                        $conditions = array();
                    }
                }
                $tmpcondition = array('id!=?', 1);//seed order
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
                $result = \Order::find('all', array('conditions' => $conditions));
                $unables = 0;
                foreach($result as $data){
                    $accounts = count($data->accounts);
                    $payments = count($data->payments);
                    $isanytranshappened = ($accounts > 0
                                            || $payments > 0);
                    if(!$isanytranshappened){
                        foreach($data->orderproducts as $rec){
                            $rec->delete();
                        }
                        foreach($data->ordertasks as $rec){
                            foreach($rec->otprgrshistories as $prgrshistory){
                                $prgrshistory->delete();
                            }//ordertaskpeople
                            foreach($rec->ordertaskpeople as $otppl){
                                $otppl->delete();
                            }
                            $rec->delete();
                        }
                        $prsnaddrsids = array();
                        foreach($data->orderpeople as $rec){
                            foreach($rec->person->personaddresses as $peradd){
                                if($peradd->location !== null){
                                    if($rec->type === Menu::ppl_type_receiver){
                                        $peradd->location->delete();
                                    }else{
                                        $prsnaddrsids[] = $peradd->location->id;
                                    }
                                }
                                if($rec->type === Menu::ppl_type_receiver){
                                    $peradd->delete();
                                }
                            }
                            if($rec->type === Menu::ppl_type_receiver){
                                if($rec->person !== null){
                                    $rec->person->delete();
                                }
                            }
                            $rec->delete();
                        }
                        foreach($data->orderaddresses as $rec){                            
                            if($rec->location !== null)
                            {
                                $lcnid = $rec->location->id;
                                if(!in_array($lcnid, $prsnaddrsids)){
                                    $rec->location->delete();
                                }
                            }
                            $rec->delete();
                        }
                        foreach($data->accounts as $rec){
                            $rec->delete();
                        }
                        foreach($data->payments as $rec){
                            $rec->delete();
                        }
                        foreach($data->consignmentnotes as $rec){
                            $rec->delete();
                        }
                        $data->delete();
                    }else{
                        $unables++;
                    }
                }
                if($unables > 0){
                   $rtnmsg = Menu::OK . "Can not delete. Reason: Transactions exists."; 
                }
            }catch (\Slim\Exception $ex) {
                $rtnmsg = 'Error.';
            }
            catch (\Exception $ex) {
                $rtnmsg = "Error ";
            }
            return $rtnmsg;
        }
        private function addorupdateOrderPeople($order, $postedData, $prvct = null){
            $orderid = $order->id;
            $ordertype = $order->type;
            $crtpeople = $postedData->ordrcreatedby;
            $mdfypeople = $postedData->ordrmodifiedby;
            $customers = $postedData->ordrcustomers;
            $employees = $postedData->ordremployees;
            $this->addorupdateOrderPerson($orderid, $crtpeople, Menu::ppl_type_created);
            $this->addorupdateOrderPerson($orderid, $mdfypeople, Menu::ppl_type_modified);
            $newcustomer = $this->addorupdateOrderPerson($orderid, $customers, Menu::ppl_type_customer);
            
            $existemprow = \Orderperson::find('all', array('conditions' => array('type = ? AND order_id=?', Menu::ppl_type_employee, $orderid)));
            $prvassgndempid = -1;
            if(count($existemprow) === 1
                    && !is_null($existemprow[0])
                    && !is_null($existemprow[0]->person)
                    && !is_null($existemprow[0]->person->id)
            ){
                $prvassgndempid = $existemprow[0]->person->id;
            }
            $this->addorupdateOrderPerson($orderid, $employees, Menu::ppl_type_employee);
            $receivers = $postedData->ordrreceivers;
            foreach($receivers as &$person){
                if($person->id <= 0){
                    $person->id = -1;
                    $person->type = Menu::ppl_type_receiver;
                    $person->loginenabled = 0;
                }
            }
            $this->addorupdateOrderPerson($orderid, $receivers, Menu::ppl_type_receiver);   
            $this->log->debug('gsm00');
            try{
                $prvassgndemp = \Person::find($prvassgndempid);
            }catch (\ActiveRecord\RecordNotFound $ex) {
                $prvassgndemp = null;
            }
            if(!is_null($prvassgndemp)){
                //need to check for his alloted slot and free him in that.
                $isremoveassign = true;
                $this->addOrUpdateTimeslots($order, array($prvassgndemp), $prvct, $isremoveassign);                        
            }
            $this->addOrUpdateTimeslots($order, $employees, $order->addnlinfo1);//current assigned employee
            return $newcustomer;
        }
        private function addOrUpdateTimeslots($order, $employees, $prvct, $isremoveassign){
            foreach($employees as &$person){
                if(!is_null($person)){
                    $this->checkAndSaveSlots($person->id, $order->addnlinfo1, $order->status, $prvct, $isremoveassign);
                }
            }
        }
        private function checkAndSaveSlots($personId, $slotdate, $orderstatus, $prvct=null, $isremoveassign = false){
            if(strtoupper($orderstatus) !== Menu::sts_accepted
                            && strtoupper($orderstatus) !== Menu::sts_assigned
            ){
                $slotvalue = -1;
            }else{
                if($isremoveassign){
                    $slotvalue = -1;
                }else{
                    $slotvalue = 1;
                }
            }
            $tmpdate = $slotdate;
            if(!is_null($prvct)){
                $tmpdate = $prvct;
            }
            $this->addOrUpdatePersonTimeSlots($personId, $tmpdate, $slotvalue);
        }
        private function addOrUpdatePersonTimeSlots($personId, $slotdate, $slotvalue){
            $slot = $this->getSlotfromCT($slotdate);
            if($slot === null){
                return;
            }
            $slotdatestr = $slotdate->format('Y-m-d');
            $conditions = array('person_id=? AND DATE(slotdate)=?', $personId, $slotdatestr);
            $result = \Persontimeslot::find('all', array('conditions' => $conditions));
            $rec===null;
            if(count($result) > 0){
                $rec = $result[0];
                //$rec = \Persontimeslot::find($result[0]->id);
            }
            if($rec===null){
                $attributes = array('person_id' => $personId
                                    ,'slotdate' => $slotdate);
                $rec = \Persontimeslot::create($attributes);
            }
            $oldvalue = (is_null($rec->$slot))?0:$rec->$slot;
            $newvalue = $oldvalue + $slotvalue;
            if($newvalue <= 0) $newvalue = null;
            $attributes = array($slot => $newvalue);
            $rec->update_attributes($attributes);
        }
        private function getSlotfromCT($ct){
            $slot = null;
            if(is_null($ct)){
                return $slot;
            }
            $timeslots = array(
                'ts1','ts2','ts3','ts4'
                ,'ts5','ts6','ts7','ts8'
                ,'ts9','ts10','ts11','ts12'
                ,'ts13','ts14','ts15','ts16'
                ,'ts17','ts18','ts19','ts20'
                ,'ts21','ts22','ts23','ts24'
                );
               $hrs = (int)$ct->format('H');
               $slot = $timeslots[$hrs];
               return $slot;
        }
        private function addorupdateOrderPerson($orderid, $orderpeople, $ppltype){
            $newperson = false;
            $this->deleteOrderPersonByPpltype($orderid, $ppltype);
            foreach($orderpeople as $person){
                if($person->id <= 0){// $ppltype === Menu::ppl_type_receiver
                    $this->addOrUpdatePeople(-1, $person);
                    $newperson = true;
                }
                if(!is_null($person->id)){
                   $attributes = array(
                           "order_id" => $orderid,
                           "person_id" => $person->id,
                           "type" => $ppltype
                           );
                   $data = \Orderperson::create($attributes);                   
                }
            }
            return $newperson;
        }
        private function deleteOrderPersonByPpltype($orderid, $ppltype){
            $conditions = array('order_id=? AND type=?', $orderid, $ppltype);
            $result = \Orderperson::find('all', array('conditions' => $conditions));
            foreach($result as $data){
                $data->delete();
            }
        }
        private function getTaskAttributes($task){
            if(!empty($task->desc)){
                $desc = $task->desc;
            }else{
                $desc = $task->name;
            }
            if(isset($task->category)){
                $catid = $task->category->id;
            }else{
                $catid = 1;
            }
            $attributes = array(
                           "category_id" => $catid,
                           "name" => $task->name,
                           "desc" => $desc
                           );
            return $attributes;
        }
        private function addOrUpdateTasks($id, $task){
            try{
                $data = \Task::find($id);
            }catch (\ActiveRecord\RecordNotFound $ex) 
            {
                $data = null;
            }
            $attributes = $this->getTaskAttributes($task);
            if(is_null($data)){
                $data = \Task::create($attributes);
                if(!is_null($data)){
                    $id = $data->id;
                }
            }else{
               $data->update_attributes($attributes);
            }
            return $id;
        }
        private function getOTAttributes($ordertask){
            $esdate = $ordertask->start_at;
            if(is_null($esdate)){
                $esdate = date('Y-m-d H:i:s');//expected start date start_at
            }
            $eedate = $ordertask->end_at;
            if(is_null($eedate)){
                $eedate = date('Y-m-d H:i:s');//expected end date end_at
            }

            $cost = ((isset($ordertask->cost) && is_numeric($ordertask->cost))?$ordertask->cost:0);
            $amount = ((isset($ordertask->amount) && is_numeric($ordertask->amount))?$ordertask->amount:0);
            $taxper = (isset($ordertask->taxper) && is_numeric($ordertask->taxper))?$ordertask->taxper:0;
            $taxamount = $amount * $taxper / 100;
            $disc = 0;
            $completedper = ((isset($ordertask->completed) && is_numeric($ordertask->completed))?$ordertask->completed:0);
            $completed_at = $ordertask->completed_at;
            if(is_null($completed_at) && $completedper > 0){
                $completed_at = date('Y-m-d H:i:s');
            }
            if((int)$completedper === 100){
                $status = Menu::sts_closed;
            }else if((int)$completedper === 0){
                $status = Menu::sts_open;
            }else{
               $status = Menu::sts_pending; 
            }
            if($status === Menu::sts_closed){
               $closed_at = $ordertask->closed_at;
            }
            if($status === Menu::sts_open){
                $stdatdate = $ordertask->started_at;
                if(is_null($stdatdate)){
                    $stdatdate = date('Y-m-d H:i:s');//expected end date end_at
                }
            }
            
            $attributes = array(
                    "start_at" => $esdate,
                    "end_at" => $eedate,
                    "cost" => $cost,
                    "amount" => $amount,
                    "tax" => $taxamount,
                    "taxper" => $taxper,
                    "completed" => $completedper,
                    "completed_at" => $completed_at,
                    "completed_remarks" => $ordertask->completed_remarks,
                    "details" => $ordertask->details,
                    "status" => $status,
                    "started_at" => $stdatdate,
                    "closed_at" => $closed_at
                    );
            return $attributes;
        }
        private function addOrUpdateOrdertasks($id, $ordertask, $isFromOrder = true){
            if(!isset($ordertask->order))
            {
                return;
            }
            if(isset($ordertask->order->id))
            {
                $orderid = $ordertask->order->id;
            }else
            {
                $orderid = -1;
            }
            try{
                $order = \Order::find($orderid);
            }catch (\ActiveRecord\RecordNotFound $ex) 
            {
                $order = null;
            }
            if(is_null($order))
            {
                return;
            }
            if(!isset($ordertask->task))
            {
                return;
            }
            if(isset($ordertask->task->id))
            {
                $taskid = $ordertask->task->id;
            }
            else
            {
                $taskid = -1;
            }
            $taskid = $this->addOrUpdateTasks($taskid, $ordertask->task);
            if($taskid === -1){
                return;
            }
            try{
                try{
                    $data = \Ordertask::find($id);
                }catch (\ActiveRecord\RecordNotFound $ex) 
                {
                    $data = null;
                }
                $attributes = $this->getOTAttributes($ordertask);
                $attributes["order_id"] = $order->id;
                $attributes["order_type"] = $order->type;
                $attributes["task_id"] = $taskid;
                if(is_null($data)){
                    $data = \Ordertask::create($attributes);
                    if(is_null($data)){
                        return;
                    }else{
                        $id = $data->id;
                        $extcompleted = 0;
                        $completedper = $data->completed;
                    }
                }else{
                    $extcompleted = $data->completed;
                    $data->update_attributes($attributes);
                    $completedper = $data->completed;
                }
                //do the additionals.
                if(!$isFromOrder && $order->ordercostamountfrom === 2){//in case coming from order this work will be done in order update
                    //updating order amounts from tasks
                    $this->reupdateOrderAmountsFromTasks($order, $order->amount);
                }
                if(($completedper * 1.0) !== ($extcompleted * 1.0)){
                  $this->createOtprgrshistory($data, $ordertask);
                }
                if(count($ordertask->ordertaskexternals) > 0){
                    $tmpobj = new \stdClass();
                    $tmpobj->order_id = $order->id;
                    $tmpobj->order_type = $order->type;
                    $tmpobj->ordertask_id = $id;
                    $tmpobj->person = new \stdClass();
                    $tmpobj->person->id = $ordertask->ordertaskexternals[0]->id;
                    $tmpobj->type = $ordertask->ordertaskexternals[0]->type;
                    $ordertaskpeople = array($tmpobj);
                    $otppltype = array('external');
                    $this->addOrUpdateOrdertaskPeople($order, $data, $ordertaskpeople, $otppltype);
                }
                if($order->enableordrtaskpeople === 1){
                    $ordertaskpeople = $ordertask->ordertaskemppeople;
                    $otppltype = array('employee','incharge');
                    $this->addOrUpdateOrdertaskPeople($order, $data, $ordertaskpeople, $otppltype);
                }
                $rtnmsg = "OK";
            }catch (\Slim\Exception $ex) {
                $rtnmsg = 'Error';
            }
            catch (\Exception $ex) {
                $rtnmsg = "Error";
            }
            return $rtnmsg;            
        }
        private function createOtprgrshistory($ordertask, $postedData){
            $attributes = array(
                    "order_id" => $ordertask->order_id,
                    "order_type" => $ordertask->order_type,
                    "ordertask_id" => $ordertask->id,                    
                    "completed" => $postedData->completed,
                    "completed_at" => $postedData->completed_at,
                    "remarks" => $postedData->completed_remarks
                    );
            $data = \Otprgrshistory::create($attributes);
        }
        private function addOrUpdateOrderMsFromOrder($order, $postedData){
            $extorderms = $order->ordermilestones;
            $postedorderms = $postedData->ordermilestones;
            //check for deleted milestones.
            $todelete = array();
            foreach($extorderms as $eoms){
                $found = false;
                foreach($postedorderms as $poms){
                    $found = ($eoms->id === $poms->id);
                    if($found)
                    {
                        break;
                    }
                }
                if(!$found){
                    $todelete[] = $eoms;
                }
            }
            foreach($todelete as $doms){
                $doms->delete();
            }
            foreach($postedorderms as $ordermilestone){
                $ordermilestone->order = $order;
                $isFromOrder = true;
                if(!isset($ordermilestone->id))
                {
                    $ordermilestone->id = -1;
                }
                $this->addOrUpdateOrderMilestones($ordermilestone->id, $ordermilestone, $isFromOrder);
            }
        }
        private function addOrUpdateOrderTasksFromOrder($order, $postedData){
            $extngordertasks = $order->ordrtasks;
            $postedordertasks = $postedData->ordrtasks;
            //check for deleted ordertasks.
            $todelete = array();
            foreach($extngordertasks as $eot){
                $found = false;
                foreach($postedordertasks as $pot){
                    $found = ($eot->id === $pot->id);
                    if($found)
                    {
                        break;
                    }
                }
                if(!$found){
                    $todelete[] = $eot;
                }
            }
            foreach($todelete as $dot){
                $dot->delete();
            }
            foreach($postedordertasks as $ordertask){
                $ordertask->order = $order;
                $isFromOrder = true;
                if(!isset($ordertask->id))
                {
                    $ordertask->id = -1;    
                }
                $this->addOrUpdateOrdertasks($ordertask->id, $ordertask, $isFromOrder);
            }
        }
//        private function createDflttask($order, $postedData){
//            $conditions = array('order_id=? AND order_type=? AND task_id=1', $order->id, $order->type);
//            $result = \Ordertask::find('all', array('conditions' => $conditions));
//            if(count($result) === 0){
//                $attributes = array(
//                            "order_id" => $order->id,
//                            "order_type" => $order->type,
//                            "task_id" => 1,//always there is one task general[id=1]                            
//                            "start_at" => $order->start_at,
//                            "end_at" => $order->end_at,
//                            );
//                $data = \Ordertask::create($attributes);
//                $crtpeople = $postedData->ordrcreatedby;
//                $mdfypeople = $postedData->ordrmodifiedby;                
//                $this->addorupdateOrdertaskPerson($order, $data, $crtpeople, Menu::ppl_type_created);
//                $this->addorupdateOrdertaskPerson($order, $data, $mdfypeople, Menu::ppl_type_modified);
//            }
//        }
//        private function addorupdateOrdertaskPerson($order, $ordertask, $taskpeople, $ppltype){
//            $this->deleteOrdertaskPersonByPpltype($order->id, $order->type, $ppltype);            
//            foreach($taskpeople as $person){
//                $attributes = array(
//                        "order_id" => $order->id,
//                        "order_type" => $order->type,
//                        "ordertask_id" => $ordertask->id,
//                        "person_id" => $person->id,
//                        "type" => $ppltype
//                        );
//                $data = \Ordertaskperson::create($attributes);
//            }
//        }
        private function deleteOrderTasksByOrder($orderid, $ordertype){
            $conditions = array('order_id=? AND order_type=?', $orderid, $ordertype);
            $result = \Ordertask::find('all', array('conditions' => $conditions));
            foreach($result as $data){
                $data->delete();
            }
            $ppltype = array();
            $ordertaskid = -1;
            $this->deleteOrdertaskPeople($orderid, $ordertype, $ordertaskid, $ppltype);
        }
        private function addOrUpdateOrdertaskPeople($order, $ordertask, $ordertaskpeople, $otppltype)
        {
            $this->deleteOrdertaskPeople($order->id, $order->type, $ordertask->id, $otppltype);
            $totalcost = 0;
            $totalamount = 0;
            $totaltaxamount = 0;
            foreach($ordertaskpeople as $otppl){
                $person = \Person::find($otppl->person->id);
                if(!$person){
                    continue;
                }
                
                $ppltype = $otppl->type;
                if($ppltype === 'contractor'){
                    $ppltype = 'external';
                }
                
                $efforts = ((isset($otppl->efforts) && is_numeric($otppl->efforts))?$otppl->efforts:0);
                $cost = ($person->mhcost * $efforts);
                $amount = ($person->mhrate * $efforts);
                $taxamount = $amount * $this->taskppltax / 100.0;
                $totalcost += $cost;
                $totalamount += $amount;
                $totaltaxamount += $taxamount;
                $ppllevel = ((isset($otppl->level) 
                                && is_numeric($otppl->level)
                                && $otppl->level > 0)?$otppl->level:0);
                
                $attributes = array(
                        "order_id" => $order->id,
                        "order_type" => $order->type,
                        "ordertask_id" => $ordertask->id,
                        "person_id" => $otppl->person->id,
                        "efforts" => $efforts,
                        "cost" => $cost,
                        "amount" => $amount,
                        "tax" => $taxamount,
                        "level" => $ppllevel,
                        "type" => $ppltype
                        );
                $data = \Ordertaskperson::create($attributes);
            }
            if($order->ordertaskcostamountfrom === 1 
                    && ($ppltype === Menu::ppl_type_employee 
                        || $ppltype === Menu::ppl_type_incharge)){
                $taxper = 0;
                $this->updateAmntTaxInOrderTask($ordertask, $totalcost, $totalamount, $totaltaxamount, $taxper);
            }
        }
        private function reupdateOrderAmountsFromTasks($order, $postedOrderAmount){
            $ototalcost = 0;
            $ototalamount = 0;
            $ototaltaxamount = 0;
            $ototaldisc = 0;
            foreach($order->ordrtasks as $ordertask){
                $ototalcost += $ordertask->cost;
                $ototalamount += $ordertask->amount;
                $ototaltaxamount += $ordertask->tax;
                //$ototaldisc += $ordertask->disc;
            }
            $taxper = $ototaltaxamount / $ototalamount * 100;
            if($order->enablediscount === 1 
                    && ($order->orderdiscfor === 0 
                            || $order->orderdiscfor === 4)){
                $totalamount = $ototalamount - $ototaldisc;
                if($this->discentry === 1){
                    $postedamount = (isset($postedOrderAmount) && is_numeric($postedOrderAmount))?$postedOrderAmount:0;
                    if($postedamount !== $totalamount){
                        $disc = $totalamount - $postedamount;
                        $discper = $disc / $totalamount * 100.0;
                    }
                }else if($this->discentry === 0){
                    $discper = (isset($order->discper) && is_numeric($order->discper))?$order->discper:0;
                    $disc = $totalamount * $discper / 100.0;
                    //if discount amount entered but percent is 0. calculate %.
                    $disctmp = (isset($order->disc) && is_numeric($order->disc))?$order->disc:0;
                    if($discper <= 0 && $disctmp > 0){
                        $discper = $disctmp / $totalamount * 100.0;
                    }
                }
            }
            $this->updateAmntTaxInOrder($order, $ototalcost, $ototalamount, $taxper, $ototaltaxamount, 0, 0);
        }
        private function deleteOrdertaskPeople($orderid, $ordertype, $ordertaskid, $otppltype){
            $str = 'order_id=? AND order_type=?';
            $tmpary = array($orderid, $ordertype);
            if($ordertaskid > 0){
                $str .= ' AND ' . 'ordertask_id=?';
            }
            if(count($otppltype) > 0){
               $str .= ' AND type IN (?)';
            }
            $conditions = array_merge(array($str), $tmpary);
            if($ordertaskid > 0){
                $conditions = array_merge($conditions, array($ordertaskid));
            }
            if(count($otppltype) > 0){
                $conditions = array_merge($conditions, array($otppltype));
            }
//            if(count($otppltype) === 0){
//                $conditions = array('order_id=? AND order_type=? AND ordertask_id=?', $orderid, $ordertype, $ordertaskid);                   
//            }else{
//                $conditions = array('order_id=? AND order_type=? AND ordertask_id=? AND type IN (?)', $orderid, $ordertype, $ordertaskid, $otppltype);
//            }
            $result = \Ordertaskperson::find('all', array('conditions' => $conditions));
            foreach($result as $data){
                $data->delete();
            }
        }
        private function deleteOrdertaskPersonByPpltype($orderid, $ordertype, $ppltype){
            $conditions = array('order_id=? AND order_type=? AND type=?', $orderid, $ordertype, $ppltype);
            $result = \Ordertaskperson::find('all', array('conditions' => $conditions));
            foreach($result as $data){
                $data->delete();
            }
        }
        private function addorupdateOrderAdresses($order, $postedData, $newcustomer = false, $prvcust = -1){
            $orderid = $order->id;
            $ordertype = $order->type;
            $custid = -1;
            $customers = $postedData->ordrcustomers;
            if(count($customers) > 0){
                $custid = $customers[0]->id;
            }
            $this->addorupdateOrdrAddrAndLocations($orderid, $custid, $postedData->shpngaddresses, Menu::address_type_shpngorto, $prvcust);
            $this->addorupdateOrdrAddrAndLocations($orderid, $custid, $postedData->blngaddresses, Menu::address_type_blngorfrom, $prvcust);
            if($newcustomer){
                $this->createPersonAddress($custid, $postedData->blngaddresses[0]->id, Menu::address_type_office);
            }
        }
        private function addorupdateOrdrAddrAndLocations($orderid, $custid, &$orderaddresses, $addrtype, $prvcust){
            $this->deleteOrderAddressesByType($orderid, $prvcust, $addrtype);
            if(!isset($orderaddresses)
                    || count($orderaddresses) === 0 
                    || !isset($orderaddresses[0])
                    || !isset($orderaddresses[0]->street)){
                return;
            }
            foreach($orderaddresses as &$location){
                $lcn = $this->addOrUpdateLocations($location);
                if(!is_null($lcn) && $lcn->id > 0){
                    $location->id = $lcn->id;
                    $locid = $lcn->id;
                    $attributes = array(
                            "person_id" => $custid,
                            "order_id" => $orderid,
                            "location_id" => $locid,
                            "type" => $addrtype
                            );
                    $data = \Orderaddress::create($attributes);
                }
            }
        }
        private function deleteOrderAddressesByType($orderid, $custid, $addrtype){
            $conditions = array('person_id=? AND order_id=? AND type=?', $custid, $orderid, $addrtype);
            $result = \Orderaddress::find('all', array('conditions' => $conditions));
            foreach($result as $data){
                $data->delete();
            }
        }
        private function addOrUpdateLocations($location){
            if(empty($location->country)){
                $location->country = 'Singapore';
            }
            if(is_null($location->id)) $location->id = -1;
            try{
                $data = \Location::find($location->id);
            }catch (\ActiveRecord\RecordNotFound $ex) {
                $data = null;
            }
            $attributes = array(
                        "street" => $location->street,
                        "locality" => $location->locality,
                        "city" => $location->city,
                        "state" => $location->state,
                        "country" => $location->country,
                        "pincode" => $location->pincode,
                        "remarks" => $location->remarks
                        );
            if(is_null($data)){
                $data = \Location::create($attributes);
            }else{
                $data->update_attributes($attributes);
            }
            return $data;
        }
        private function reupdateOrderCostAmountsFromOT($orderId, $toupdate = 1){
            try{
                if(!isset($orderId)) $orderId = -1;
                $data = \Order::find($orderId);
            }catch (\ActiveRecord\RecordNotFound $ex) {
                $data = null;
            }
            if(!is_null($data)){
                foreach($data->ordrtasks as $ot){
                    $ttlcost += $ot->cost;
                    $ttlamount += $ot->amount;
                }
                if($toupdate ===  1){
                    $attributes = array('cost' => $ttlcost);
                }else{
                    $attributes = array('amount' => $ttlamount);
                }
                $data->update_attributes($attributes);
            }
        }
        private function reupdateOrderAmountsFromProducts($order, $postedData){
            $ototalcost = 0;
            $ototalamount = 0;
            $ototaltaxamount = 0;
            $ototaldisc = 0;
            $ototaldiscper = 0;
            foreach($order->orderproducts as $ordprod){
                $ototalcost += $ordprod->cost;
                $ototalamount += $ordprod->amount;
                $ototaltaxamount += $ordprod->tax;
                $ototaldisc += $ordprod->disc;
                $ototaldiscper += $ordprod->discper;
            }
            $otaxper = $ototaltaxamount / $ototalamount * 100.0;//average tax % on this order
            //$ototaldiscper = $ototaldisc / $ototalamount * 100.0;//average tax % on this order / $amount * 100.0;//average disc % on this order            
            if($order->enablediscount === 1 && ($order->orderdiscfor === 0 || $order->orderdiscfor === 3)){
                $totalamount = $ototalamount + $ototaldisc;
                if($this->discentry === 1){
                    $postedamount = (isset($postedData->amount) && is_numeric($postedData->amount))?$postedData->amount:0;
                    if($postedamount !== $totalamount){
                        $ototaldisc = round(($totalamount - $postedamount),2);
                        $ototaldiscper = round($ototaldisc / $totalamount * 100.0,2);
                    }
                }else if($this->discentry === 0){
                    $ototaldiscper = (isset($order->discper) && is_numeric($order->discper))?$order->discper:0;
                    $ototaldisc = round($totalamount * $ototaldiscper / 100.0, 2);
                    //if discount amount entered but percent is 0. calculate %.
                    $disctmp = (isset($order->disc) && is_numeric($order->disc))?$order->disc:0;
                    if($ototaldiscper <= 0 && $disctmp > 0){
                        $ototaldiscper = round($disctmp / $totalamount * 100.0,2);
                    }
                }
            }
            $this->updateAmntTaxInOrder($order, $ototalcost, $ototalamount, $otaxper, $ototaltaxamount, $ototaldiscper, $ototaldisc);
        }
        private function addorupdateOrderLineItems($order, $postedData, &$rolproducts)
        {            
            $extorderprds = $order->orderproducts;
            $postedorderprds = $postedData->orderproducts;
            //check for deleted orderproducts.
            $todelete = array();
            foreach($extorderprds as $eop){
                $found = false;
                foreach($postedorderprds as $pop){
                    $found = ($eop->id === $pop->id);
                    if($found)
                    {
                        break;
                    }
                }
                if(!$found){
                    $todelete[] = $eop;
                }
            }
            foreach($todelete as $dop){
                $dopid = $dop->id;
                $prdid = $dop->product_id;
                if($this->enableordrdn){
                    $conditions = array('orderproduct_id=?', $dopid);
                    $dopdns = \Orderproductdn::find('all', array('conditions' => $conditions));
                    if(isset($dopdns) && is_array($dopdns)){
                       foreach($dopdns as $dopdn){
                           $dopdn->delete();                           
                       }
                    }
                }
                $dop->delete();                
                if($this->enablestock){
                    $prd = $dop->product;
                    //$prd = \Product::find($prdid);
                    if(!$prd){
                        continue;
                    }
                    $qnty = $dop->delivered;
                    $newstock= $prd->stock + $qnty;
                    $attributes = array(
                        "stock" => $newstock,
                        "stockvalue" => $newstock * $prd->unit_cp);
                    $prd->update_attributes($attributes);
                }
            }
            $ototalcost = 0;
            $ototalamount = 0;
            $ototaltaxamount = 0;
            $ototaldiscper = 0;
            $ototaldisc = 0;
            foreach($postedorderprds as $ordprod){
                $qnty = $ordprod->quantity;
                if(!$this->enableordrdn){
                    $ordprod->delivered = $ordprod->quantity;
                }else if(!isset($ordprod->delivered)){
                    $ordprod->delivered = 0;
                }
                
                $vldqnty = (is_numeric($qnty) && $qnty > 0);
                if(!$vldqnty){
                    continue;
                }
                $prd = \Product::find($ordprod->product_id);
                if(!$prd){
                    continue;
                }
                if($prd->rol >= ($prd->stock - $qnty)){
                    $rolproducts[] = $prd->name;
                }
                $ucost = $prd->unit_cp;
                $ugainper = $prd->gainpercent;//actual unit gain percentage
                $ugain = $ucost * $ugainper / 100;//actual unit gain amount
                $ugain = round($ugain, 2);
                $usp = $ucost + $ugain;//actual unit selling price
                $usp = round($usp, 2);
                
                $cost = $qnty * $ucost;//actual total cost
                $ttlamnttobe = $qnty * $usp;//actual total selling price                                
                $postedamount = (isset($ordprod->amount) && is_numeric($ordprod->amount))?$ordprod->amount:$ttlamnttobe;
                
                $discper = 0;
                $disc = 0;
                if($order->enablediscount === 1 && ($order->orderdiscfor === 0 || $order->orderdiscfor === 3)){
                    if($this->discentry === 1){
                        if($postedamount !== $ttlamnttobe){
                            $disc = $ttlamnttobe - $postedamount;
                            $discper = $disc / $ttlamnttobe * 100.0;
                        }
                    }else if($this->discentry === 0){
                        $discper = (isset($ordprod->discper) && is_numeric($ordprod->discper))?$ordprod->discper:0;
                        $disc = $ttlamnttobe * $discper / 100.0;
                        //if discount amount entered but percent is 0. calculate %.
                        $disctmp = (isset($ordprod->disc) && is_numeric($ordprod->disc))?$ordprod->disc:0;
                        if($discper <= 0 && $disctmp > 0){
                            $discper = $disctmp / $ttlamnttobe * 100.0;
                        }
                    }
                }
                $taxamount = $postedamount * $prd->taxper / 100 ;
                $attributes = array(
                        "order_id" => $order->id,
                        "order_type" => $order->type,
                        "product_id" => $ordprod->product_id,
                        "quantity" => $qnty,
                        "delivered" => ((!$this->enableordrdn)?$qnty:$ordprod->delivered),
                        "cost" => $cost,
                        "unit_sp" => $ordprod->unit_sp,
                        "amount" => $postedamount,
                        "tax" => $taxamount,
                        "discper" => $discper,
                        "disc" => $disc,
                        );
                $id = $ordprod->id;
                if(!isset($id)){
                    $id = -1;
                }
                try{
                    $data = \Orderproduct::find($id);
                }catch (\ActiveRecord\RecordNotFound $ex) {
                    $data = null;
                }
                if(is_null($data)){
                    $data = \Orderproduct::create($attributes);
                    if($this->enablestock && !$this->enableordrdn){
                        $newstock= $prd->stock - $qnty;
                    }
                }else{
                    $prvqnty = $data->quantity;
                    $data->update_attributes($attributes);
                    if($this->enablestock && !$this->enableordrdn){
                        $newstock= $prd->stock - $qnty;//minus current posted.
                        $newstock= $newstock + $prvqnty;//plus qnty prvsly deducted.
                    }
                }
                $ototalcost += $cost;
                $ototalamount += $postedamount;
                $ototaltaxamount += $taxamount;
                $ototaldiscper += $discper;
                $ototaldisc += $disc;
                if($this->enablestock && !$this->enableordrdn){
                    $attributes = array(
                        "stock" => $newstock,
                        "stockvalue" => $newstock * $prd->unit_cp);
                    $prd->update_attributes($attributes);
                }
            }
            if((!is_null($order) && $order->ordercostamountfrom === 1) 
                    || $postedData->ordercostamountfrom === 1){
                //updating order amounts with lineitems
                $otaxper = $ototaltaxamount / $ototalamount * 100.0;//average tax % on this order
                if($order->enablediscount === 1 
                        && ($order->orderdiscfor === 0 
                        || $order->orderdiscfor === 3)
                ){
                    if($this->discentry === 1){
                        $postedamount = (isset($postedData->amount) && is_numeric($postedData->amount))?$postedData->amount:0;
                        if($postedamount !== $ototalamount){
                            $ototaldisc = $ototalamount - $postedamount + $ototaldisc;                            
                        }
                        $ototaldiscper = round($ototaldisc / $ttlamnttobe * 100.0, 2);
                        $ototalamount = $postedamount;
                    }else if($this->discentry === 0){
                        $tmpdiscper = (isset($order->discper) && is_numeric($order->discper))?$order->discper:0;                        
                        $ototaldisc += round($ototalamount * $tmpdiscper / 100.0, 2);
                        $ototaldiscper = $ototaldisc / $ttlamnttobe * 100.0;
                        //if discount amount entered but percent is 0. calculate %.
                        $disctmp = (isset($order->disc) && is_numeric($order->disc))?$order->disc:0;
                        if($ototaldiscper <= 0 && $disctmp > 0){
                            $ototaldisc += $disctmp;
                            $ototaldiscper = $ototaldisc / $ttlamnttobe * 100.0;
                        }
                        $ototaldiscper = round($ototaldiscper, 2);
                        $ototalamount = $ttlamnttobe - $ototaldisc;
                    }
                }else{
                    $ototaldisc = 0;
                    $ototaldiscper = 0;
                }
                $this->updateAmntTaxInOrder($order, $ototalcost, $ototalamount, $otaxper, $ototaltaxamount, $ototaldiscper, $ototaldisc);
            }
            if($this->enableordrdn){
                $orderagain = \Order::find($order->id);
                $this->updateOrderDeliveryStatus($orderagain);
            }
        }
        private function deleteOrderlitemsByOrder($orderid, $ordertype){
            $conditions = array('order_id=? AND order_type=?', $orderid, $ordertype);
            $result = \Orderproduct::find('all', array('conditions' => $conditions));
            foreach($result as $data){
                $stck = $data->quantity;
                $prdid = $data->product_id;
                $data->delete();
                if($this->enablestock && !$this->enableordrdn){
                    $prd = \Product::find($prdid);
                    if($prd){
                        $newstock= $prd->stock + $stck;
                        $attributes = array(
                            "stock" => $newstock,
                            "stockvalue" => $newstock * $prd->unit_cp);
                        $prd->update_attributes($attributes);
                    }
                }
            }
        }
        private function updateAmntTaxInOrder($order, $cost, $amount, $taxper, $tax, $totaldiscper, $totaldisc){
            $attributes = array(
                        "cost" => $cost,
                        "amount" => $amount,
                        "taxper" => $taxper,
                        "tax" => $tax,
                        "discper" => $totaldiscper, 
                        "disc" => $totaldisc
                        );
            $order->update_attributes($attributes);
        }
        private function updateAmntTaxInOrderTask($ordertask, $cost, $amount, $tax, $taxper){
            $attributes = array(
                        "cost" => $cost,
                        "amount" => $amount,
                        "taxper" => $taxper,
                        "tax" => $tax,
                        );
            $ordertask->update_attributes($attributes);
        }
        private function createPaymentRec($ordpymnt, $person_id){
            $status = ((isset($ordpymnt->status))?$ordpymnt->status:Menu::sts_collected);                    
            $isclctd =  $status === Menu::sts_collected;

            $amount = $ordpymnt->amount;
            $type = ((isset($ordpymnt->type))?$ordpymnt->type:'CASH');
            $clctdate = $ordpymnt->collected_at;
            if(is_null($clctdate) && $isclctd){
                $clctdate = date('Y-m-d H:i:s');//expected start date start_at
            }
            $payment_at = $ordpymnt->payment_at;
            if(is_null($payment_at)){
                $payment_at = date('Y-m-d H:i:s');//expected start date start_at
            }
            $ordertaskid = -1;
            if(strtolower($ordpymnt->direction) === Menu::payment_outwards){
                $ordertaskid = $ordpymnt->ordertask_id;
            }
            $attributes = array(
                    "person_id" => $person_id,
                    "account_id" => $ordpymnt->account_id,
                    "party_id" => $ordpymnt->party_id,
                    "order_id" => $ordpymnt->order_id,
                    "ordertask_id" => $ordertaskid,
                    "type" => $type,
                    "amount" => $amount,
                    "status" => $status,
                    "payment_at" => $payment_at,
                    "collected_at" => $clctdate,
                    "direction" => $ordpymnt->direction,
                    );
            $data = \Payment::create($attributes);
        }
        private function addorupdateAccountPayments($account, $postedData){
            try{
                $this->deletePaymentsByAccount($account->id);
                //$this->deletePaymentsByOrder($account->order->id);
                $paid = 0;
                $this->updatePaidamntInAccount($account, $paid);
                if($account->accounttype === Menu::acc_type_receivables){
                    if(!$this->moperinvoice){
                        $this->updatePaidamntInOrder($account->orders[0], $paid);
                    }
                }
                $person_id = $postedData->person->id;
                
                foreach($postedData->payments as $ordpymnt){
                    $status = ((isset($ordpymnt->status))?$ordpymnt->status:Menu::sts_collected);                    
                    $isclctd =  $status === Menu::sts_collected;
                    $amount = $ordpymnt->amount;
                    $this->createPaymentRec($ordpymnt, $person_id);
                    if($isclctd){
                        $paid += $amount;//sum up only confirmed payments
                    }
                }
                $this->updatePaidamntInAccount($account, $paid);
                if($account->accounttype === Menu::acc_type_receivables){
                    if(!$this->moperinvoice){
                        $this->updatePaidamntInOrder($account->orders[0], $paid);
                    }
                }
            }catch (\Slim\Exception $ex) {
                
            }
            catch (\Exception $ex) {

            }
        }
        private function addorupdateOrderPayments($order, $postedData){
            try{                
                $this->deletePaymentsByOrder($order->id);
                $paid = 0;
                $this->updatePaidamntInorder($order, $paid);
                $person_id = $order->ordrmodifiedby[0]->id;
                foreach($postedData->payments as $ordpymnt){
                    $amount = $ordpymnt->amount;
                    $status = ((isset($ordpymnt->status))?$ordpymnt->status:Menu::sts_collected);
                    $isclctd =  $status === Menu::sts_collected;
                    $this->createPaymentRec($ordpymnt, $person_id);
                    if($isclctd){
                        $paid += $amount;//sum up only confirmed payments
                    }
                }
                $this->updatePaidamntInorder($order, $paid);
            }catch (\Slim\Exception $ex) {
                
            }
            catch (\Exception $ex) {

            }
        }
        private function deletePaymentsByAccount($accountid){
            $conditions = array('account_id=?', $accountid);
            $result = \Payment::find('all', array('conditions' => $conditions));
            foreach($result as $data){
                $data->delete();
            }
        }
        private function deletePaymentsByOrder($orderid){
            $conditions = array('order_id=?', $orderid);
            $result = \Payment::find('all', array('conditions' => $conditions));
            foreach($result as $data){
                $data->delete();
            }
        }
        private function updatePaidamntInAccount($account, $paid){
            $attributes = array(
                        "paid" => $paid,
                        );
            $account->update_attributes($attributes);
        }
        private function updatePaidamntInOrder($order, $paid){
            $attributes = array(
                        "paid" => $paid,
                        );
            $order->update_attributes($attributes);
        }
        private function prepareMailForMSAlert($milestoneary, $msresult){
            $subject = $this->ms_alert_mail_sub;
            $msgsalute = "Dear Sir, ". "<br><br>";
                        
            $msgmain .= "The following milestones are going to start soon." . "<br><br><br>";
            
//            $milestonesstr = \ActiveRecord\array_flatten($alertms);
//            if (is_array($milestones)){
//                $milestonesstr = implode("<br><br>", $milestonesstr);
//            }
//            $msgmain .= $milestonesstr;
            
            $msgfooter .= "Thanks." . "<br><br>";
            $msgfooter .= "Portal Admin.". "<br><br>";
//            $message = $msgsalute . $msgmain . $msgfooter;
//            $return = $this->pushToMailQueue($subject , $message);
//            if($return){
//                foreach ($milestoneary as $milestoneid => $milestone) {
//                    $this->updateMsmailsentcount($milestoneid);
//                }
//            }
            foreach ($msresult as &$milestone) {
                $order = $milestone->order->qoi_id . ', ' . $milestone->order->name;
                $msdetails = $milestone->details;
                $msstart = $milestone->start_at;
                $msremarks = $milestone->remarks;
                $msgmain .= "<br><br><b>" . $order . "</b><br><br>";
                $msgmain .= "Milestone :<br><br>" . $msdetails . "<br><br>";
                $msgmain .= "Start On :<br><br>" . $msstart->format('m/d/Y H:i:s a') . "<br><br>";
                $msgmain .= "Remarks :<br><br>" . $msdetails . "<br><br>";
                $message = $msgsalute . $msgmain . $msgfooter;
                $mailids = $milestone->mailids;
                $return = $this->pushToMailQueue($subject , $message, $mailids);
                if($return){
                    $this->updateMsmailsentcount($milestone->id);
                }
            }
        }
        private function updateMsmailsentcount($milestoneid){
            if(!isset($milestoneid)) $milestoneid = -1;
            try{
                $data = \Milestone::find($milestoneid);
            }catch (\ActiveRecord\RecordNotFound $ex) 
            {
                $data = null;
            }
            if(is_null($data))
            {
                return;
            }
            $mailcount = $data->mailcount + 1;
            $sent_at = date('Y-m-d H:i:s');
            //update sentmail count in milestones.
            $attributes = array(
                "mailcount" => $mailcount,
                "lastmailsent_at" => $sent_at
                );
            $data->update_attributes($attributes);
        }
        private function prepareMailForROLAlert($rolproducts){
            $products = \ActiveRecord\array_flatten($rolproducts);
            if (is_array($products)){
                $products = implode("<br><br>", $products);
            }
            $message = "Dear Sir, ". "<br><br>";
            $message .= "The stocks of the following products are in Re-order Level." . "<br><br><br>";
            $message .= "Products :<br><br>" . $products . "<br><br>";            
            $message .= "Thanks." . "<br><br>";
            $message .= "Portal Admin.". "<br><br>";
            $subject = $this->rol_alert_mail_sub;
            $return = $this->pushToMailQueue($subject , $message);
        }
        private function prepareMailForNewOrder($order_id, $order_time, $postedData){
            $custName = $postedData->ordrcustomers[0]->name . ", Contact: " . $postedData->ordrcustomers[0]->firstname . ' ' . $postedData->ordrcustomers[0]->lastname;;
            $custMobile = $postedData->ordrcustomers[0]->mobile;
            $custAddr = $postedData->blngaddresses[0]->street;
            $rcvrMobile = $postedData->receiver->mobile;
            $message = "Dear Sir, ". "<br><br>";
            $message .= "New Order is made." . "<br><br><br>" . "The details follow:" . "<br><br>";
            $message .= "Customer Name :" . $custName . "<br><br>";
            $message .= "Customer Mobile :" . $custMobile . "<br><br>";
            $message .= "Customer Address :" . $custAddr . "<br><br>";
            $message .= "Receiver Mobile :" . $rcvrMobile . "<br><br>";
            $message .= "Generated Time :" . $order_time . "<br><br>";
            $message .= "Thanks." . "<br><br>";
            $message .= "Portal Admin.". "<br><br>";
            $subject = $this->new_order_mail_sub . '  OrderID[s]: '  . $order_id;            
            $return = $this->pushToMailQueue($subject , $message);
        }
        private function pushToMailQueue($subject, $message, $mailids = null){
            $return = false;
            try{
                if(empty($subject) || empty($message)){
                    return;
                }
                if(!isset($mailids) || empty($mailids)){
                    $mailids = $this->admin_mail;
                }
                $attributes = array(
                                "mailids" => $mailids,
                                "subject" => $subject,
                                "mail_body" => $message
                                );
                $data = \Mailqueue::create($attributes);
                $isOk = \applib\EmailClass::SendMail($mailids, $this->send_mail_from, $subject, $message);
                $return = true;
            }
            catch (\Slim\Exception $ex) {
                $err = $ex;
            }
            catch (\Exception $ex) {
                $err = $ex;
            }
            return $return;
        }
        private function getAttrFormilestonesFromPost($milestone){
            $start_at = $milestone->start_at;
            if(is_null($start_at)){
                $start_at = date('Y-m-d H:i:s');//expected start date start_at
            }
            $end_at = $milestone->end_at;
            if(is_null($end_at)){
                $end_at = $start_at;
            }
            
            $completedper = ((isset($milestone->completed) && is_numeric($milestone->completed))?$milestone->completed:0);
            $completed_at = $milestone->completed_at;
            if(is_null($completed_at) && $completedper > 0){
                $completed_at = date('Y-m-d H:i:s');
            }
            if($completedper === 100.0){
                $status = Menu::sts_closed;
            }else if($completedper === 0.0){
                $status = Menu::sts_open;
            }else{
                $status = Menu::sts_pending; 
            }
            if($status === Menu::sts_closed){
               $closed_at = $milestone->closed_at;
            }
            $attributes = array(
                    "person_id" => $milestone->person->id,
                    "order_id" => $milestone->order->id,
                    "details" => $milestone->details,
                    "remarks" => $milestone->remarks,                    
                    "start_at" => $start_at,
                    "end_at" => $end_at,
                    "alertbefore" => $milestone->alertbefore,
                    "completed" => $completedper,
                    "completed_at" => $completed_at,
                    "completed_remarks" => $milestone->completed_remarks,
                    "mailids" => $milestone->mailids,
                    "started_at" => $milestone->started_at,
                    "closed_at" => $closed_at,
                    "status" => $status
                    );
            return $attributes;
        }
        private function addOrUpdateOrderMilestones($id, $ordermilestone, $isFromOrder = true){
            if(!isset($ordermilestone->order))
            {
                return;
            }
            if(isset($ordermilestone->order->id))
            {
                $orderid = $ordermilestone->order->id;
            }else
            {
                $orderid = -1;
            }
            try{
                $order = \Order::find($orderid);
            }catch (\ActiveRecord\RecordNotFound $ex) 
            {
                $order = null;
            }
            if(is_null($order))
            {
                return;
            }
            try{
                try{
                    $data = \Milestone::find($id);
                }catch (\ActiveRecord\RecordNotFound $ex) {
                    $data = null;
                }
                $attributes = $this->getAttrFormilestonesFromPost($ordermilestone);
                $attributes["order_id"] = $order->id;
                if(is_null($data)){
                    $data = \Milestone::create($attributes);
                }else{
                    $data->update_attributes($attributes);
                }
                $rtnmsg = "OK";
            }
            catch (\Slim\Exception $ex) {
                $rtnmsg = "Error";
            }
            catch (\Exception $ex) {
                $rtnmsg = "Error";
            }
            return $rtnmsg;
        }
        private function getAttrForpaymentsFromPost($ordpymnt){                        
            $status = ((isset($ordpymnt->status))?$ordpymnt->status:Menu::sts_collected);                    
            $isclctd =  $status === Menu::sts_collected;

            $amount = $ordpymnt->amount;
            $type = ((isset($ordpymnt->type))?$ordpymnt->type:'CASH');
            $clctdate = $ordpymnt->collected_at;
            if(is_null($clctdate) && $isclctd){
                $clctdate = date('Y-m-d H:i:s');//expected start date start_at
            }
            $payment_at = $ordpymnt->payment_at;
            if(is_null($payment_at)){
                $payment_at = date('Y-m-d H:i:s');//expected start date start_at
            }
            $ordertaskid = -1;
            if(strtolower($ordpymnt->direction) === Menu::payment_outwards){
                $ordertaskid = $ordpymnt->ordertask->id;
            }
            $attributes = array(
                    "person_id" => $ordpymnt->person->id,
                    "account_id" => $ordpymnt->account->id,
                    "party_id" => $ordpymnt->party->id,
                    "order_id" => $ordpymnt->order->id,
                    "ordertask_id" => $ordertaskid,
                    "type" => $type,
                    "amount" => $amount,
                    "status" => $status,
                    "payment_at" => $payment_at,
                    "collected_at" => $clctdate,
                    "direction" => $ordpymnt->direction,
                    );            
            return $attributes;
        }        
        private function addOrUpdatePayments($id, $postedData){            
            try{
                try{
                    $data = \Payment::find($id);
                }catch (\ActiveRecord\RecordNotFound $ex) {
                    $data = null;
                }
                $attributes = $this->getAttrForpaymentsFromPost($postedData);
                $oldamount = 0;
                if(is_null($data)){
                    $data = \Payment::create($attributes);                                        
                }else{
                    $oldamount = $data->amount;
                    $data->update_attributes($attributes);
                }
                $paid = $data->account->paid + $data->amount - $oldamount;
                $this->updatePaidamntInAccount($data->account, $paid);
                if(strtolower($data->direction) === Menu::payment_inwards){
                    $paid = $data->order->paid + $data->amount - $oldamount;
                    $this->updatePaidamntInOrder($data->order, $paid);
                }
                $rtnmsg = "OK";
            }catch (\Slim\Exception $ex) {
                $rtnmsg = "Error";
            }
            catch (\Exception $ex) {
                $rtnmsg = "Error";
            }
            return $rtnmsg;
        }
        private function getAttrForproductsFromPost($product){
            $stckval = $product->unit_cp * $product->stock;
            $enableprdauxname = $product->enableprdauxname;
            $unitcp = $product->unit_cp;
            if($this->sptype === 0){
                $unitsp = $product->unit_sp;
                $unitgainpercent = ($unitsp - $unitcp) / $unitcp * 100;
            }else{
                $unitgainpercent = $product->gainpercent;
                $unitsp = $unitcp * $unitgainpercent / 100;
            }
            if($product->id <=0){
                if($this->isprdcodeauto){
                    $productcode = $this->generateCode(1, $product->name);
                }else{
                    $productcode = $product->code;
                }
            }else{
                $productcode = $product->code;
            }
            $attributes = array(
                    //"category_id" => $product->category->id,
                    "code" => $productcode,
                    "name" => $product->name,
                    "auxname" => $product->auxname,
                    "desc" => $product->desc,
                    "unit_cp" => $unitcp,
                    "unit_sp" => $unitsp,
                    "gainpercent" => $unitgainpercent,
                    "taxper" => $product->taxper,
                    "stock" => $product->stock,
                    "stockvalue" => $stckval,
                    "rol" => $product->rol,
                    "enableprdauxname" => $enableprdauxname,
                    "remarks" => $product->remarks
                    );
            return $attributes;
        }
        private function generateCode($forwhat, $codesource, $fixedcode='')
        {
            $fc = substr($codesource, 0, 1);
            $like = strtoupper($fc) . "%";
            $conditions = array('UPPER(`name`) LIKE ?', strtoupper($like));
            $optionsAry = array('conditions' => $conditions
                                , 'order' => 'id desc'
                                , 'limit' => 1);
            if($forwhat === 1){
                $result = \Product::find('all', $optionsAry);
            }else{//for people customer, supplier
                $result = \Person::find('all', $optionsAry);
            }
            $count = 1;
            $strtoneglect = $fixedcode . '-';
            if(count($result) > 0){
                $count = substr($result[0]->code, strlen($strtoneglect) + 1) + 1;
            }
            $codepart1 = strtoupper($fixedcode) . strtoupper($fc) . '-';
            $newcode = $codepart1 .  sprintf('%05d',$count++);
            return $newcode;
        }
        private function addOrUpdateProducts($id, $postedData)
        {
            try{
                try
                {
                    $data = \Product::find($id);
                }
                catch (\ActiveRecord\RecordNotFound $ex) 
                {
                    $data = null;
                }
                $attributes = $this->getAttrForproductsFromPost($postedData);
                if(is_null($data))
                {
                    $data = \Product::create($attributes);
                }
                else
                {
                    $isstackadjust = is_numeric($postedData->stockadjust) && $postedData->stockadjust != $postedData->stock;
                    if($isstackadjust){
                        $tmp = $postedData->stock - $postedData->stockadjust;                
                        $attributes['stock'] = $postedData->stockadjust;
                        $cday = date('Y-m-d');
                        if($tmp > 0){
                            $attributes['remarks'] .= "\nLost " . $tmp . " on " . $cday;
                        }else{
                            $attributes['remarks'] .= "\nGained " . $tmp . " on " . $cday;
                        }
                    }
                    $data->update_attributes($attributes);
                }
                $this->addorupdateProductCategories($data, $postedData);
                $this->addorupdateProductPeople($data, $postedData);
                $rtnmsg = "OK";
            }
            catch (\Slim\Exception $ex) 
            {
                $rtnmsg = "Error";
            }
            catch (\Exception $ex) 
            {
                $rtnmsg = "Error";
            }
            return $rtnmsg;
        }
        private function addorupdateProductCategories($data, $postedData)
        {
            $prodcutid = $data->id;
            $cats = $postedData->categories;
            $this->deleteProductCategoriesByPrdId($prodcutid);
            foreach($cats as $cat)
            {
                if(!is_null($cat->id))
                {
                   $attributes = array(
                           "product_id" => $prodcutid,
                           "category_id" => $cat->id
                           );
                   $data = \Productcategory::create($attributes);
                }
            }
        }
        private function deleteProductCategoriesByPrdId($productid)
        {
            $conditions = array('product_id=?', $productid);
            $result = \Productcategory::find('all', array('conditions' => $conditions));
            foreach($result as $data){
                $data->delete();
            }
        }
        private function addorupdateProductPeople($data, $postedData)
        {
            $productid = $data->id;
            $suppliers = $postedData->suppliers;
            $ppltype = Menu::ppl_type_supplier;
            $this->deleteProductPersonByPpltype($prodcutid, $ppltype);
            foreach($suppliers as $splr)
            {
                if(!is_null($splr->id))
                {
                   $attributes = array(
                           "product_id" => $productid,
                           "person_id" => $splr->id,
                           "type" => $ppltype
                           );
                   $data = \Productperson::create($attributes);
                }
            }
        }
        private function deleteProductPersonByPpltype($productid, $ppltype)
        {
            $conditions = array('product_id=? AND type=?', $productid, $ppltype);
            $result = \Productperson::find('all', array('conditions' => $conditions));
            foreach($result as $data){
                $data->delete();
            }
        }
        private function getAttrForPurchaesFromPost($postedData, $data = null){
            $purchase_number = $postedData->purchase_number;
            $purchase_at = $postedData->purchase_at;
            if(is_null($purchase_at)){
                $purchase_at = date('Y-m-d H:i:s');//expected start date start_at
            }
            $amount = 0;
            $taxper = 0;
            $taxamount = 0;
            $paid = 0;
            if($enableordrpayments === 0){
                $paid = (isset($postedData->paid) && is_numeric($postedData->paid))?$postedData->paid:0;
            }
            $attributes = array(
                            "purchase_number" => $purchase_number,                            
                            "purchase_at" => $purchase_at,
                            "amount" => $amount,
                            "taxper" => $taxper,
                            "tax" => $taxamount,
                            "paid" => $paid,
                            "remarks" => $postedData->remarks
                            );
            return $attributes;
        }        
        private function addOrUpdatePurchases($id, $postedData){
            try{
                try{
                    $data = \Purchase::find($id);
                }catch (\ActiveRecord\RecordNotFound $ex) {
                    $data = null;
                }
                $attributes = $this->getAttrForPurchaesFromPost($postedData, $data);
                $rolproducts = array();
                if(is_null($data)){
                    $data = \Purchase::create($attributes);
                }else{
                    $data->update_attributes($attributes);
                }
                $this->addorupdatePurchaseLineItems($data, $postedData, $rolproducts);
                if(count($rolproducts)>0 && $this->mail_for_rols){
                    $this->prepareMailForROLAlert($rolproducts);
                }
            }
            catch (\Slim\Exception $ex) {
                $rtnmsg = "Error";
            }
            catch (\Exception $ex) {
                $rtnmsg = "Error";
            }
            return $rtnmsg;            
        }
        private function deletePurchaselitemsByPurchase($orderid){
            $conditions = array('purchase_id=?', $orderid);
            $result = \Purchaseproduct::find('all', array('conditions' => $conditions));
            $stck = 0;
            foreach($result as $data){
                $stck = $data->quantity;
                $prdid = $data->product_id;
                $data->delete();
                if($this->enablestock){
                    $prd = \Product::find($prdid);
                    if($prd){
                        $newstock= $prd->stock - $stck;
                        $attributes = array(
                            "stock" => $newstock,
                            "stockvalue" => $newstock * $prd->unit_cp);
                        $prd->update_attributes($attributes);
                    }
                }
            }
        }
        private function addorupdatePurchaseLineItems($order, $postedData, &$rolproducts){
            $this->deletePurchaselitemsByPurchase($order->id);
            $totalamount = 0;
            $totaltaxamount = 0;
            foreach($postedData->purchaseproducts as $ordprod){
                $qnty = $ordprod->quantity;
                $vldqnty = (is_numeric($qnty) && $qnty > 0);
                if(!$vldqnty){
                    continue;
                }
                $prd = \Product::find($ordprod->product_id);
                if(!$prd){
                    continue;
                }
                if($prd->rol >= ($prd->stock + $qnty)){
                    $rolproducts[] = $prd->name;
                }
                $unit_cp = $ordprod->unit_cp;
                $amount = $qnty * $unit_cp;
                $taxamount = $amount * $prd->taxper / 100 ;
                $attributes = array(
                        "purchase_id" => $order->id,
                        "product_id" => $ordprod->product_id,
                        "quantity" => $ordprod->quantity,
                        "unit_cp" => $unit_cp,
                        "amount" => $amount,
                        "tax" => $taxamount,
                        );
                $data = \Purchaseproduct::create($attributes);
                $totalamount += $amount;
                $totaltaxamount += $taxamount;
                if($this->enablestock){
                    $newstock= $prd->stock + $qnty;
                    $attributes = array(
                        "stock" => $newstock,
                        "stockvalue" => $newstock * $unit_cp);
                    $prd->update_attributes($attributes);
                }
            }
            //updating order amounts with lineitems
            $taxper = $totaltaxamount / $amount * 100.0;//average tax % on this order
            $this->updateAmntTaxInPurchase($order, $totalamount, $taxper, $totaltaxamount);
        }
        private function updateAmntTaxInPurchase($order, $amount, $taxper, $tax){
            $attributes = array(
                        "amount" => $amount,
                        "taxper" => $taxper,
                        "tax" => $tax
                        );
            $order->update_attributes($attributes);
        }
        private function getAttrForaccountsFromPost($postedData, $data = null){
            if($postedData->status === Menu::sts_closed){
                $closed_at = date('Y-m-d H:i:s');
            }
            $surcharge = (isset($postedData->scamount)?$postedData->scamount:$this->invsurcharge);            
            $isnew = is_null($data);
            $acnt_no = $this->getOrderId($postedData, Menu::ord_type_invoice, $isnew, 'acnt_no');            
            $attributes = array(
                            "accounttype" => $postedData->accounttype,
                            "type" => $postedData->type,
                            "acnt_no" => $acnt_no,
                            "person_id" => $postedData->person->id,
                            "party_id" => $postedData->party->id,
                            "amount" => $postedData->amount,
                            "scamount" => $surcharge,
                            "remarks" => $postedData->remarks,
                            "status" => $postedData->status,
                            "closed_at" => $closed_at
                            );
            return $attributes;
        }
        private function saveAccountPurchases($purchases, $accountId){
            if(!isset($purchases)) return;
            foreach($purchases as $puchase){
                $ordertaskId = -1;
                $dummyorderid = 1;
                $purchaseId = (!is_null($puchase->id))?$puchase->id:0;
                if($purchaseId === 0) continue;
                $attributes = array(
                            "account_id" => $accountId,
                            "purchase_id" => $purchaseId,
                            );
                \Accountpurchase::create($attributes);
                $tmp = \Purchase::find($purchaseId);
                if(!is_null($tmp)){
                    $attributes = array(
                                "status" => Menu::sts_closed,
                                "invstatus" => Menu::sts_invoiced
                                );
                    $tmp->update_attributes($attributes);
                }
            }
        }
        private function saveAccountOrders($orders, $accountId){
            if(!isset($orders)) return;
            foreach($orders as $order){
                $ordertaskId = -1;
                $dummyorderid = 1;
                $orderId = (!is_null($order->id))?$order->id:$dummyorderid;
                $attributes = array(
                            "account_id" => $accountId,
                            "order_id" => $orderId,
                            "ordertask_id" => $ordertaskId,
                            //"addnlinfo" => $postedData->addnlinfo
                            );
                \Accountorder::create($attributes);
                $tmp = \Order::find($orderId);
                if(!is_null($tmp)){
                    $attributes = array(
                                "status" => Menu::sts_closed,
                                "invstatus" => Menu::sts_invoiced                            
                                );
                    $tmp->update_attributes($attributes);
                }
            }
        }
        private function saveAccountOrdertasks($ordertasks, $accountId){
            if(!isset($ordertasks)) return;
            foreach($ordertasks as $ordertask){
                $ordertaskId = (!is_null($ordertask->id))?$ordertask->id:0;
                if($ordertaskId === 0) continue;
                $dummyorderid = 1;
                $orderId = (!is_null($ordertask->order->id))?$ordertask->order->id:$dummyorderid;
                $attributes = array(
                            "account_id" => $accountId,
                            "order_id" => $orderId,
                            "ordertask_id" => $ordertaskId,
                            //"addnlinfo" => $postedData->addnlinfo
                            );
                \Accountorder::create($attributes);
                $tmp = \Ordertask::find($ordertaskId);
                if(!is_null($tmp)){
                    $attributes = array(
                                "status" => Menu::sts_closed,
                                "invstatus" => Menu::sts_invoiced                            
                                );
                    $tmp->update_attributes($attributes);
                }
            }
        }
        private function addAccountsFromOrder($order){
            $crtpeople = $order->ordrcreatedby;
            $customers = $order->ordrcustomers;
            foreach($crtpeople as $person){
               $crtOrMdfyBy = $person->id;
            }
            foreach($customers as $person){
               $party_id = $person->id;
            }
            $order_id = $order->id;
            $ordertaskId = 0;
            $acnt_no = $this->getOrderId($postedData, Menu::ord_type_invoice, true, 'acnt_no');
            $closed_at = null;
            $accounttype = Menu::acc_type_receivables;
            $type = Menu::ord_type_invoice;
            $amount = $order->amount - $order->disc;
            $acntstatus = Menu::sts_open;
            $attributes = array(
                    "accounttype" => $accounttype,
                    "type" => $type,
                    "acnt_no" => $acnt_no,
                    "person_id" => $crtOrMdfyBy,
                    "party_id" => $party_id,
                    "amount" => $amount,
                    "remarks" => '',
                    "status" => $acntstatus,
                    "closed_at" => $closed_at
                    );
            $this->createAccountsFromAttributes($attributes, array($order), array(), array());
        }
        private function createAccountsFromAttributes($attributes, $orders=array(), $ordertasks=array(), $purchases=array()){
            $data = \Account::create($attributes);
            if(is_null($data)) return;
            if($this->isordridauto){
                $this->updateLastId($data->type, $data->acnt_no);
            }
            if($data->accounttype === Menu::acc_type_receivables){
                $this->saveAccountOrders($orders, $data->id);
            }else{
                $this->saveAccountOrdertasks($ordertasks, $data->id);
                $this->saveAccountPurchases($purchases, $data->id);
            }
        }
        private function addOrUpdateAccounts($id, $postedData){
            try{
                $tmpid = -1;
                $accounttype = $postedData->accounttype;
                $accountparty = $postedData->party;
                $tmpPostedDataary = array();
                $ttlamount = array();
                $neworderamounts = array();
                $newordertaskamounts = array();
                if($accounttype === Menu::acc_type_receivables){
                    foreach($postedData->orders as $order){
                        $orderid = $order->id;
                        try{
                            if(!isset($orderid)) $orderid = -1;
                            $foundorder = \Order::find($orderid);                            
                        }catch (\ActiveRecord\RecordNotFound $ex) {
                            $foundorder = null;
                        }
                        if(!is_null($foundorder)){
                            $araccounts = $foundorder->araccounts;
                            if(count($araccounts)>0){
                                $extngAccount = $araccounts[0];
                                $id = $extngAccount->id;
                                $partyid = $foundorder->ordrcustomers[0]->id;
                                if(!isset($tmpPostedDataary[$partyid])){
                                    $tmpPostedData = new \stdClass();
                                    $tmpPostedData->id = $id;
                                    $tmpPostedData->applysurcharge = $postedData->applysurcharge;                                    
                                    $tmpPostedData->type = $extngAccount->type;
                                    $tmpPostedData->accounttype = $extngAccount->accounttype;
                                    $tmpPostedData->acnt_no = $extngAccount->acnt_no;
                                    $tmpPostedData->person = new \stdClass();
                                    $tmpPostedData->person->id = $extngAccount->person_id;
                                    $tmpPostedData->party = new \stdClass();
                                    $tmpPostedData->party->id = $partyid;
                                    $tmpPostedData->orders = array();
                                    $tmpPostedData->orders[] = $foundorder;
                                    $tmpPostedData->status = $extngAccount->status;
                                    $tmpPostedData->ismodifypymnts = $postedData->ismodifypymnts;
                                    $tmpPostedData->amount = $postedData->amount;
                                    $tmpPostedDataary[$partyid] = $tmpPostedData;
                                    $ttlamount[$partyid] = $order->amount;
                                }else{
                                    $tmpPostedDataary[$partyid]->orders[] = $order;
                                    $ttlamount[$partyid] += $order->amount;
                                }
                                $neworderamounts[$orderid] = $order->amount;
                            }else{
                                $partyid = $order->ordrcustomers[0]->id;
                                if(!isset($tmpPostedDataary[$partyid])){
                                    $tmpPostedData = new \stdClass();
                                    $tmpPostedData->id = $id;
                                    $tmpPostedData->applysurcharge = $postedData->applysurcharge;
                                    $tmpPostedData->type = $postedData->type;
                                    $tmpPostedData->accounttype = $accounttype;
                                    $tmpPostedData->acnt_no = $postedData->acnt_no;
                                    $tmpPostedData->person = $postedData->person;
                                    $tmpPostedData->party = new \stdClass();
                                    $tmpPostedData->party->id = $partyid;
                                    $tmpPostedData->orders = array();
                                    $tmpPostedData->orders[] = $order;
                                    $tmpPostedData->status = ((is_null($postedData->status))?Menu::sts_open:$postedData->status);
                                    $tmpPostedData->ismodifypymnts = $postedData->ismodifypymnts;
                                    $tmpPostedData->amount = $postedData->amount;
                                    $tmpPostedDataary[$partyid] = $tmpPostedData;
                                    $ttlamount[$partyid] = $order->amount;                            
                                    $tmpid = $partyid;
                                }else{
                                     $tmpPostedDataary[$partyid]->orders[] = $order;
                                     $ttlamount[$partyid] += $order->amount;
                                }
                                $neworderamounts[$orderid] = $order->amount;
                            }
                        }
                    }
                }else{
                    foreach($postedData->ordertasks as $ordertask){
                        $ordertaskid = $ordertask->id;
                        try{
                            if(!isset($ordertaskid)) $ordertaskid = -1;
                            $foundordertask = \Ordertask::find($ordertaskid);
                        }catch (\ActiveRecord\RecordNotFound $ex) {
                            $foundordertask = null;
                        }
                        if(!is_null($foundordertask)){
                            $apaccounts = $foundordertask->apaccounts;                            
                            if(count($apaccounts)>0){
                                $extngAccount = $apaccounts[0];
                                $id = $extngAccount->id;
                                $partyid = $foundordertask->ordertaskexternals[0]->id;
                                if(!isset($tmpPostedDataary[$partyid])){
                                    $tmpPostedData = new \stdClass();
                                    //$tmpPostedData->id = $id;
                                    $tmpPostedData->applysurcharge = $postedData->applysurcharge;                                    
                                    $tmpPostedData->type = $extngAccount->type;
                                    $tmpPostedData->accounttype = $extngAccount->accounttype;
                                    $tmpPostedData->acnt_no = $extngAccount->acnt_no;
                                    $tmpPostedData->person = new \stdClass();
                                    $tmpPostedData->person->id = $extngAccount->person_id;
                                    $tmpPostedData->party = new \stdClass();
                                    $tmpPostedData->party->id = $partyid;
                                    $tmpPostedData->ordertasks = array();
                                    $tmpPostedData->ordertasks[] = $foundordertask;
                                    $tmpPostedData->status = $extngAccount->status;
                                    $tmpPostedData->ismodifypymnts = $postedData->ismodifypymnts;
                                    $tmpPostedData->amount = $postedData->amount;
                                    $tmpPostedDataary[$partyid] = $tmpPostedData;
                                    $ttlamount[$partyid] = $ordertask->cost;
                                }else{
                                    $tmpPostedDataary[$partyid]->ordertasks[] = $ordertask;
                                    $ttlamount[$partyid] += $ordertask->cost;
                                }
                                $newordertaskamounts[$ordertaskid] = $ordertask->cost;
                            }else{
                                $partyid = $ordertask->ordertaskexternals[0]->id;
                                if(!isset($tmpPostedDataary[$partyid])){
                                    $tmpPostedData = new \stdClass();
                                    //$tmpPostedData->id = $id;
                                    $tmpPostedData->applysurcharge = $postedData->applysurcharge;
                                    $tmpPostedData->type = $postedData->type;
                                    $tmpPostedData->accounttype = $accounttype;
                                    $tmpPostedData->acnt_no = $postedData->acnt_no;
                                    $tmpPostedData->person = $postedData->person;
                                    $tmpPostedData->party = new \stdClass();
                                    $tmpPostedData->party->id = $partyid;
                                    $tmpPostedData->ordertasks = array();
                                    $tmpPostedData->ordertasks[] = $ordertask;
                                    $tmpPostedData->status = ((is_null($postedData->status))?Menu::sts_open:$postedData->status);
                                    $tmpPostedData->ismodifypymnts = $postedData->ismodifypymnts;
                                    $tmpPostedData->amount = $postedData->amount;
                                    $tmpPostedData->purchases = array();
                                    $tmpPostedDataary[$partyid] = $tmpPostedData;
                                    $ttlamount[$partyid] = $ordertask->cost;
                                    $tmpid = $partyid;
                                }else{
                                     $tmpPostedDataary[$partyid]->ordertasks[] = $ordertask;
                                     $ttlamount[$partyid] += $ordertask->cost;
                                }
                                $newordertaskamounts[$ordertaskid] = $ordertask->cost;
                            }
                        }
                    }
                }
                foreach($tmpPostedDataary as $partyid => $tmpPostedData){
                    try{
                        $id = (empty($tmpPostedData->id)? -1 : $tmpPostedData->id);
                        $data = \Account::find($id);
                    }catch (\ActiveRecord\RecordNotFound $ex) {
                        $data = null;
                    }
                    $attributes = $this->getAttrForaccountsFromPost($tmpPostedData, $data);
                    if($attributes['acnt_no'] === '-1'){
                        return;
                    }
                    if(isset($attributes['amount']) && $attributes['amount'] > 0){
                        //take the posted amount as it is
                    }else{
                        $attributes['amount'] = $ttlamount[$partyid];
                    }
                    if(!$tmpPostedData->applysurcharge)
                    {
                        $attributes['scamount'] = 0;
                    }
                    $isnew = is_null($data);
                    if($isnew)
                    {
                        $attributes['amount'] += $attributes['scamount'];
                        $this->createAccountsFromAttributes($attributes, $tmpPostedData->orders, $tmpPostedData->ordertasks, $tmpPostedData->purchases);
                    }
                    else
                    {
                        $attributes['amount'] = $data->amount - $data->scamount + $attributes['scamount'];
                        $data->update_attributes($attributes);
                    }
                    $ismodifypymnts = $this->enableinlinepayments === 1 
                                    && ((isset($tmpPostedData->ismodifypymnts))?$tmpPostedData->ismodifypymnts:false);
                    if($ismodifypymnts){
                        $this->addorupdateAccountPayments($data, $tmpPostedData);
                    }
                }
                foreach($neworderamounts as $orderid => $orderamount){
                    try{
                        if(!isset($orderid)) $orderid = -1;
                        $data = \Order::find($orderid);
                    }catch (\ActiveRecord\RecordNotFound $ex) {
                        $data = null;
                    }
                    if(!is_null($data)){
                        $attributes = array('amount' => $orderamount);
                        $prvamnt = $data->amount;
                        $data->update_attributes($attributes);
                        if(!$isnew)
                        {
                            $this->updateInvoiceFromOrders($data, $prvamnt, $tmpPostedData->applysurcharge);
                        }
                    }
                }
                foreach($newordertaskamounts as $otid => $otamount){
                    try{
                        if(!isset($otid)) $otid = -1;
                        $data = \Ordertask::find($otid);
                    }catch (\ActiveRecord\RecordNotFound $ex) {
                        $data = null;
                    }
                    if(!is_null($data)){
                        $attributes = array('cost' => $otamount);
                        $data->update_attributes($attributes);
                        $this->reupdateOrderCostAmountsFromOT($data->order_id);
                    }
                }
                $rtnmsg = "OK";
            }
            catch (\Slim\Exception $ex) {
                $rtnmsg = "Error";
            }
            catch (\Exception $ex) {
                $rtnmsg = "Error";
            }
            return $rtnmsg;
        }
        private function getPeopleCode($postedData){
            if($postedData->id <=0){
                if($postedData->type === Menu::ppl_type_customer
                    || $postedData->type === Menu::ppl_type_supplier
                    || $postedData->type === Menu::ppl_type_employee
                ){
                    $isauto = false;
                    switch($postedData->type){
                        case Menu::ppl_type_customer:
                            $fixedcode = 'C';
                            $isauto = $this->iscustcodeauto;
                            break;
                        case Menu::ppl_type_supplier:
                            $fixedcode = 'S';
                            $isauto = $this->issplrcodeauto;
                            break;
                        case Menu::ppl_type_employee:
                            $fixedcode = 'E';
                            $isauto = $this->ispplcodeauto;
                            break;
                        default:
                            $fixedcode = '';
                            $isauto = $this->ispplcodeauto;
                            break;
                    }
                    if($isauto){
                        $peoplecode = $this->generateCode(2, $postedData->name, $fixedcode);
                    }else{
                        $peoplecode = $postedData->code;
                    }
                }
            }else{
                $peoplecode = $postedData->code;
            }
            return $peoplecode;
        }
        private function getAttrForPeopleFromPost($data, $postedData){
            $geo_update_frq = $postedData->geo_update_frq;
            if(!is_numeric($geo_update_frq)){
                $geo_update_frq = 15;
            }
            $peoplecode = $this->getPeopleCode($postedData);
            $enablepplauxname = ((!is_null($data))? $data->enablepplauxname:$postedData->enablepplauxname);
            $enablecontact = ((!is_null($data))? $data->enablecontact:$postedData->enablecontact);
            $attributes = array(
                            "type" => $postedData->type,
                            "name" => $postedData->name,
                            "code" => $peoplecode,
                            "auxname" => $postedData->auxname,
                            "firstname" => $postedData->firstname,
                            "lastname" => $postedData->lastname,
                            "mobile" => $postedData->mobile,
                            "mobile_addnls" => $postedData->mobile_addnls,
                            "mail" => $postedData->mail,
                            "geo_update_frq" => $geo_update_frq,
                            "fax" => $postedData->fax,
                            "did" => $postedData->did,
                            "cost_center" => $postedData->cost_center,
                            "loginenabled" => $postedData->loginenabled,
                            "enablepplauxname" => $enablepplauxname,
                            "enablecontact" => $enablecontact
                            );
            return $attributes;
        }
        private function addOrUpdatePeople($id, &$postedData){
            $rtnmsg = 'Error';
            try{
               try{
                    $data = \Person::find($id);
                }catch (\ActiveRecord\RecordNotFound $ex) {
                    $data = null;
                }
                if($postedData->type !== Menu::ppl_type_customer
                    && $postedData->type !== Menu::ppl_type_supplier
                    && $postedData->type !== Menu::ppl_type_contractor
                    ){//&& $postedData->type !== Menu::ppl_type_receiver
                    $postedData->firstname = $data->name;
                    $postedData->lastname = $data->name;                
                }
                if(!isset($postedData->mobile)){
                    $postedData->mobile = "";
                }
                if(!isset($postedData->mail)){
                    $postedData->mail = "";
                }
                $attributes = $this->getAttrForPeopleFromPost($data, $postedData);
                if(is_null($data)){
                    $data = \Person::create($attributes);
                    $postedData->id = $id = $data->id;                
                }else{
                    $data->update_attributes($attributes);
                }
                $this->addOrUpdateLogins($id, $postedData);
                $this->addorupdateLcnsAndPrsnAddr($id, $postedData);
                $rtnmsg = 'Updated';
            }
            catch (\Slim\Exception $ex) {
                $rtnmsg = "Error";
            }
            catch (\Exception $ex) {
                $rtnmsg = 'Error';
            }            
            return $rtnmsg;
        }
        private function getPeopleType($domaintype){
            $ppltype = null;
            switch($domaintype){
                case Menu::domain_all:
                case '':
                    $ppltype = '';
                    break;
                case Menu::domain_customers:
                    $ppltype = Menu::ppl_type_customer;
                    break;
                case Menu::domain_contractors:
                    $ppltype = Menu::ppl_type_contractor;
                    break;
                case Menu::domain_employees:
                    $ppltype = Menu::ppl_type_employee;
                    break;
                case Menu::domain_suppliers:
                    $ppltype = Menu::ppl_type_supplier;
                    break;
                case Menu::ppl_type_created:
                    $ppltype = Menu::ppl_type_created;
                    break;
                case Menu::ppl_type_modified:
                    $ppltype = Menu::ppl_type_modified;
                    break;
                case Menu::ppl_type_incharge:
                    $ppltype = Menu::ppl_type_incharge;
                    break;
                case Menu::ppl_type_external:
                    $ppltype = Menu::ppl_type_external;
                    break;
            }
            return $ppltype;
        }
        private function deleteProduct($id){
            $rtnmsg = Menu::OK;
            try{
                if(is_numeric($id) && (int)$id > 0){
                    $conditions = array('id=?', $id);
                }
                $result = \Product::find('all', array('conditions' => $conditions));
                $unables = 0;
                foreach($result as $data){
                    $orders = count($data->orders);
                    $purchases = count($data->purchases);
                    $isanytranshappened = ($orders > 0 || $purchases > 0);
                    if(!$isanytranshappened){
                        $data->delete();
                    }else{
                        $unables++;
                    }
                }
                if($unables > 1){
                    $rtnmsg = "Can not delete. Reason: Transactions exists.";
                }
            }
            catch (\Slim\Exception $ex) {
                $rtnmsg = "Error";
            }
            catch (\Exception $ex) {
                $rtnmsg = "Error ";
            }
            return $rtnmsg;            
        }
        private function deletePeople($domaintype, $id){
            $rtnmsg = Menu::OK;
            try{
                if(is_numeric($domaintype) && (int)$domaintype > 0){
                    $conditions = array('id=?', $domaintype);
                }else{
                    if(is_numeric($id) && (int)$id > 0){
                        $conditions = array('id=?', $id);
                    }else{
                        $ppltype = $this->getPeopleType($domaintype);
                        if(!is_null($ppltype) && trim($ppltype) !== ''){
                            $conditions = array('type=?', $ppltype);
                        }else{
                            $conditions = array();
                        }
                    }
                }
                $tmpcondition = array('id!=?', 1);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
                $result = \Person::find('all', array('conditions' => $conditions));
                $unables = 0;
                foreach($result as $data){
                    foreach($data->logins as $rec){
                        $rec->delete();
                    }
                    $attributes = array('loginenabled' => 0);
                    $data->update_attributes($attributes);
                    //delete only if there is no transactions happened already
                    $employeeorders = count($data->employeeorders);
                    $createdorders = count($data->createdorders);
                    $modifiedorders = count($data->modifiedorders);
                    $customerorders = count($data->customerorders);
                    $employeeordertasks = count($data->employeeordertasks);
                    $inchargeordertasks = count($data->inchargeordertasks);
                    $externalordertasks = count($data->externalordertasks);
                    $createdordertasks = count($data->createdordertasks);
                    $modifiedordertasks = count($data->modifiedordertasks);
                    $supplierpurchases = count($data->supplierpurchases);
                    $supplierproducts = count($data->supplierproducts);
                    $createdproducts = count($data->createdproducts);
                    $accounts = count($data->accounts);
                    $payments = count($data->payments);
                    $partyaccounts = count($data->partyaccounts);
                    $isanytranshappened = 
                            ($employeeorders > 0
                            || $createdorders > 0
                            || $modifiedorders > 0
                            || $customerorders > 0
                            || $employeeordertasks > 0
                            || $inchargeordertasks > 0
                            || $externalordertasks > 0
                            || $createdordertasks > 0
                            || $modifiedordertasks > 0
                            || $supplierpurchases > 0
                            || $supplierproducts > 0
                            || $createdproducts > 0
                            || $accounts > 0
                            || $payments > 0
                            || $partyaccounts > 0
                            );
                    if(!$isanytranshappened){
                        foreach($data->allpersonaddresses as $rec){
                            $rec->delete();
                        }
                        foreach($data->personaddresses as $rec){
                            $rec->delete();
                        }
                        $data->delete();
                    }else{
                        $unables++;                        
                    }
                }
                if($unables > 0){
                   $rtnmsg = "Can not delete. Reason: Transactions exists."; 
                }
            }
            catch (\Slim\Exception $ex) {
                $rtnmsg = "Error";
            }
            catch (\Exception $ex) {
                $rtnmsg = "Error ";
            }
            return $rtnmsg;
        }
        private function addorupdateLcnsAndPrsnAddr($person_id, $postedData){
            //for person addresses.
            //office address
            $ofcaddrid = $postedData->ofcaddresses[0]->id;
            if($postedData->isofcaddress){
                $addrattributes = array(
                    "street" => $postedData->ofcaddresses[0]->street,
                    "locality" => $postedData->ofcaddresses[0]->locality,
                    "city" => $postedData->ofcaddresses[0]->city,
                    "state" => $postedData->ofcaddresses[0]->state,
                    "country" => $postedData->ofcaddresses[0]->country,
                    "pincode" => $postedData->ofcaddresses[0]->pincode,
                    "remarks" => $postedData->ofcaddresses[0]->remarks
                    );
                if($ofcaddrid > 0){
                    $addrdata = \Location::find($ofcaddrid);
                    $addrdata->update_attributes($addrattributes);
                }else{
                    $addrdata = \Location::create($addrattributes);
                    $this->createPersonAddress($person_id, $addrdata->id, "office");
                }
            }else{
                $this->deletePersonLocations($person_id, $ofcaddrid, "office");
            }
            
            //residence address
            $rsdaddrid = $postedData->rsdaddresses[0]->id;
            if($postedData->isrsdaddress){
                $addrattributes = array(
                    "street" => $postedData->rsdaddresses[0]->street,
                    "locality" => $postedData->rsdaddresses[0]->locality,
                    "city" => $postedData->rsdaddresses[0]->city,
                    "state" => $postedData->rsdaddresses[0]->state,
                    "country" => $postedData->rsdaddresses[0]->country,
                    "pincode" => $postedData->rsdaddresses[0]->pincode,
                    "remarks" => $postedData->rsdaddresses[0]->remarks
                    );
                if($rsdaddrid > 0){
                    $addrdata = \Location::find($rsdaddrid);
                    $addrdata->update_attributes($addrattributes);
                }else{
                    $addrdata = \Location::create($addrattributes);
                    $this->createPersonAddress($person_id, $addrdata->id, "residence");
                }
            }else{
                $this->deletePersonLocations($person_id, $rsdaddrid, "residence");
            }
            
            //other address
            $otheraddrid = $postedData->otheraddresses[0]->id;
            if($postedData->isotheraddress){
                $addrattributes = array(
                    "street" => $postedData->otheraddresses[0]->street,
                    "locality" => $postedData->otheraddresses[0]->locality,
                    "city" => $postedData->otheraddresses[0]->city,
                    "state" => $postedData->otheraddresses[0]->state,
                    "country" => $postedData->otheraddresses[0]->country,
                    "pincode" => $postedData->otheraddresses[0]->pincode,
                    "remarks" => $postedData->otheraddresses[0]->remarks
                    );
                if($otheraddrid > 0){
                    $addrdata = \Location::find($otheraddrid);
                    $addrdata->update_attributes($addrattributes);
                }else{
                    $addrdata = \Location::create($addrattributes);
                    $this->createPersonAddress($person_id, $addrdata->id, "other");
                }
            }else{
                $this->deletePersonLocations($person_id, $otheraddrid, "other");
            }
        }
        private function createPersonAddress($person_id, $location_id, $type){
            $persaddrattributes = array(
                    "type" => $type,
                    "person_id" => $person_id,
                    "location_id" => $location_id);
            \Personaddress::create($persaddrattributes);
        }
        private function deletePersonLocations($id, $loc_id, $addr_type){
            if(!is_array($loc_id)) $loc_id = array($loc_id);
            $result = \Location::find('all', array('conditions' => array('id IN (?)', $loc_id)));
            foreach($result as $data){
                $data->delete();
            }
            $this->deletePersonAddrData($id, $addr_type);
        }
        private function deletePersonAddrData($id, $addr_type){
            if(!is_array($addr_type)) $addr_type = array($addr_type);
            $result = \Personaddress::find('all', array('conditions' => array('person_id=? AND type IN (?)', $id, $addr_type)));
            foreach($result as $data){
                $data->delete();
            }
        }
        private function addOrUpdateLogins($person_id, $postedData){
            $logindata = \Login::find('all', array('conditions' => array('person_id=?', $person_id)));
            $attributes = array(
                            "person_id" => $person_id,
                            "login" => $postedData->logins[0]->login,
                            );
            if($postedData->loginenabled){
                if(count($logindata) === 0 || !$logindata[0]){
                    $attributes['pass'] = $postedData->logins[0]->pass;
                    \Login::create($attributes);
                }else{
                    if(count($logindata) === 1 && $logindata[0])
                    {
                        $ischngpwd = $postedData->chngpwd;
                        if($ischngpwd){
                            $attributes['pass'] = $postedData->logins[0]->pass;
                        }
                        $logindata[0]->update_attributes($attributes);
                    }else{
                        $this->deleteLoginsByPerson($person_id);
                        \Login::create($attributes);
                    }
                }
            }else{
                $this->deleteLoginsByPerson($person_id);
            }            
        }
        private function deleteLoginsByPerson($person_id){
            $result = \Login::find('all', array('conditions' => array('person_id=?', $person_id)));
            foreach($result as $data){
                $data->delete();
            }
        }
        private function getConditionforAccountsChart($month, $half){
            $fname = 'accounts.created_at';
            $tmpfrom = $this->curyear . '/' . $month . '/';
            if($half === 1){
                $tmpfrom .= '01';
            }else{
               $tmpfrom .= '16';
            }
            $tmpfrom = '"' . $tmpfrom . ' 00:00:00' . '"';
            $tmpto = $this->curyear . '/' . $month . '/';
            if($half === 1){
                $tmpto .= '15';
            }else{
               $tmpto .= '31'; 
            }
            $tmpto = '"' . $tmpto . ' 23:59:59' . '"';            
            $oprnle = '<=';
            $oprnge = '>=';
//SELECT party_id, direction, CASE direction WHEN 'Inwards' THEN SUM(amount) WHEN 'Outwards' THEN -SUM(amount) END 'amountgsm' 
//FROM payments 
//WHERE payment_at >= '2014/01/15 00:00:00' AND payment_at <= '2014/01/31 23:59:59' GROUP BY party_id, direction
            $tmpstr2 = $fname . $oprnge . $tmpfrom 
                        . ' AND ' 
                        . $fname . $oprnle . $tmpto;
            return $tmpstr2;
        }
        private function getConditionforPaymentsChart($month, $half){
            $fname = 'payments.payment_at';
            $tmpfrom = $this->curyear . '/' . $month . '/';
            if($half === 1){
                $tmpfrom .= '01';
            }else{
               $tmpfrom .= '16'; 
            }
            $tmpfrom = '"' . $tmpfrom . ' 00:00:00' . '"';
            $tmpto = $this->curyear . '/' . $month . '/';
            if($half === 1){
                $tmpto .= '15';
            }else{
               $tmpto .= '31'; 
            }
            $tmpto = '"' . $tmpto . ' 23:59:59' . '"';            
            $oprnle = '<=';
            $oprnge = '>=';
//SELECT party_id, direction, CASE direction WHEN 'Inwards' THEN SUM(amount) WHEN 'Outwards' THEN -SUM(amount) END 'amountgsm' 
//FROM payments 
//WHERE payment_at >= '2014/01/15 00:00:00' AND payment_at <= '2014/01/31 23:59:59' GROUP BY party_id, direction
            $tmpstr2 = $fname . $oprnge . $tmpfrom 
                        . ' AND ' 
                        . $fname . $oprnle . $tmpto;
            return $tmpstr2;
        }
        private function getConditionforLatestMilestones(){
            $fname = 'start_at';
            $stchkfrom = 'DATE(NOW())';
            $endchktype = 'DAY';
            $oprnle = '<=';
            $dateoprn = 'DATE_ADD';
            //SELECT * FROM milestones WHERE start_at <= DATE_ADD(NOW(), INTERVAL alertbefore DAY) AND STATUS != 'CLOSED'
            $tmpstr2 = $fname . $oprnle . $dateoprn . '(' . $stchkfrom . ', INTERVAL alertbefore ' . $endchktype . ')';
            $tmpstr2 .= ' AND status != "' . Menu::sts_closed . '"';
            return $tmpstr2;
        }
        private function getConditionforLatestMilestonesII(){
            $fname = 'start_at';
            $stchkfrom = 'DATE(NOW())';
            $daysforlatestmilestones = $this->daysforlatestmilestones;
            $chkdatetype = 'DAY';
            $oprnle = '<=';
            $oprnge = '>=';
            $dateoprn = 'DATE_ADD';
            //SELECT * FROM orders WHERE start_at >= NOW() AND start_at <= DATE_ADD(NOW(), INTERVAL 7 DAY)
            $tmpstr2 = $fname . $oprnge . $stchkfrom 
                        . ' AND ' 
                        . $fname . $oprnle . $dateoprn . '(' . $stchkfrom . ', INTERVAL '. $daysforlatestmilestones . ' ' . $chkdatetype . ')';
            $tmpstr2 .= ' AND status != "' . Menu::sts_closed . '"';
            return $tmpstr2;
        }
        private function getConditionforOverDueOrder(){
            $fname = 'end_at';
            $stchkfrom = 'DATE(NOW())';
            $endchknumber = $this->daystocheckforoverdue;
            $endchktype = 'DAY';
            $oprnle = '<=';
            $oprnge = '>=';
            $dateoprn = 'DATE_SUB';
            //SELECT * FROM orders WHERE end_at <= NOW() AND end_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            $tmpstr2 = $fname . $oprnle . $stchkfrom 
                        . ' AND ' 
                        . $fname . $oprnge . $dateoprn . '(' . $stchkfrom . ', INTERVAL '. $endchknumber . ' ' . $endchktype . ')';
            $tmpstr2 .= ' AND status != "' . Menu::sts_closed . '"';
            return $tmpstr2;
        }
        private function getConditionforDueOrder(){
            $fname = 'end_at';
            $stchkfrom = 'DATE(NOW())';
            $endchknumber = $this->daystocheckfordue;
            $endchktype = 'DAY';
            $oprnle = '<=';
            $oprnge = '>=';
            $dateoprn = 'DATE_ADD';
            //SELECT * FROM orders WHERE end_at >= NOW() AND end_at <= DATE_ADD(NOW(), INTERVAL 7 DAY)
            $tmpstr2 = $fname . $oprnge . $stchkfrom 
                        . ' AND ' 
                        . $fname . $oprnle . $dateoprn . '(' . $stchkfrom . ', INTERVAL '. $endchknumber . ' ' . $endchktype . ')';
            $tmpstr2 .= ' AND status != "' . Menu::sts_closed . '"';
            return $tmpstr2;
        }
        private function buildCndnsForPplOrOrder($domain, $reqid, $reqstatus, $reqtype, $reqdate = null){
            $conditions = array();
            $addaddnlqt = false;
            $addaddnlodr = false;
            if($reqid > 0){
                $tmpstr1 = $domain . ".id=?";
            }else{
                $tmpstr1 = '';
            }
            if(!is_null($reqstatus) && trim($reqstatus) !== ''){
                $stsarray = array(Menu::sts_created,Menu::sts_open,Menu::sts_pending,Menu::sts_assigned
                        ,Menu::sts_accepted,Menu::sts_rejected,Menu::sts_pickedup,Menu::sts_delivered,Menu::sts_closed);
                $issts = in_array(strtolower($reqstatus), array_map('strtolower', $stsarray));
                if($issts){
                    $tmpstr2 = 'UPPER(' . $domain . '.status)=?';
                    if($tmpstr1 !== ''){
                        $tmpstr2 = ' AND ' . $tmpstr2;
                    }
                }else{//special strings like due...
                    switch($reqstatus){
                        case 'due':
                            $tmpstr2 = $this->getConditionforDueOrder();
                            if($tmpstr1 !== ''){
                                $tmpstr2 = ' AND ' . $tmpstr2;
                            }
                        break;
                        case 'overdue':
                            $tmpstr2 = $this->getConditionforOverDueOrder();
                            if($tmpstr1 !== ''){
                                $tmpstr2 = ' AND ' . $tmpstr2;
                            }
                        break;
                        case 'undelivered':
                            $issts = true;
                            $tmpstr2 = 'UPPER(' . $domain . '.status) IN (?)';
                            if($tmpstr1 !== ''){
                                $tmpstr2 = ' AND ' . $tmpstr2;
                            }
                            $reqstatus = array('ASSIGNED','ACCEPTED','PICKEDUP');
                        break;
                        case 'exceptopenrejected':
                            $issts = true;
                            $tmpstr2 = 'UPPER(' . $domain . '.status) IN (?)';
                            if($tmpstr1 !== ''){
                                $tmpstr2 = ' AND ' . $tmpstr2;
                            }
                            $reqstatus = array('ASSIGNED','ACCEPTED','PICKEDUP','DELIVERED');
                        break;
                    }
                }
            }else{
                $tmpstr2 = '';
            }
            if(!is_null($reqtype) && trim($reqtype) !== ''){
//                $addaddnlqt = strtoupper($reqtype) === Menu::ord_type_quote;
//                $addaddnlodr = strtoupper($reqtype) === Menu::ord_type_order;
                if($tmpstr1 === '' && $tmpstr2 === ''){                    
                    $tmpstr3 = 'UPPER(' . $domain . '.type)=?';
                    if($addaddnlqt){
                        $tmpstr3 = "( " . $tmpstr3 . " OR " . "quote_qoi_id != '-1'" . ")"; 
                    }else if($addaddnlodr){
                        $tmpstr3 = "( " . $tmpstr3 . " OR " . "order_qoi_id != '-1'" . ")"; 
                    }
                }else{
                    $tmpstr3 = 'UPPER(' . $domain . '.type)=?';
                    if($addaddnlqt){
                        $tmpstr3 = " AND " . "( " .$tmpstr3 . " OR " . "quote_qoi_id != '-1'" . ")"; 
                    }else if($addaddnlodr){
                        $tmpstr3 = " AND " . "( " .$tmpstr3 . " OR " . "order_qoi_id != '-1'" . ")"; 
                    }else{
                        $tmpstr3 = " AND " . $tmpstr3;
                    }
                }
            }else{
                $tmpstr3 = '';
            }
            $tmp = $tmpstr1 . $tmpstr2 . $tmpstr3;
            if($tmp === ''){
                $conditions = array();
            }else{
                 if($tmpstr1 !== ''){//get by id and status if there
                    if($tmpstr2 !== '' && $tmpstr3 !== ''){
                        if($issts){
                            $tmpsts = is_array($reqstatus)? $reqstatus:strtoupper($reqstatus);
                            $conditions = array($tmp, $reqid, $tmpsts, strtoupper($reqtype));
                        }else{
                            $conditions = array($tmp, $reqid, strtoupper($reqtype));
                        }
                    }else if($tmpstr2 !== ''){
                        if($issts){
                            $tmpsts = is_array($reqstatus)? $reqstatus:strtoupper($reqstatus);
                            $conditions = array($tmp, $reqid, $tmpsts);
                        }else{
                            $conditions = array($tmp, $reqid);
                        }                        
                    }else if($tmpstr3 !== ''){
                       $conditions = array($tmp, $reqid, strtoupper($reqtype)); 
                    }else{
                        $conditions = array($tmp, $reqid);
                    }
                }else{//get by status if there
                    if($tmpstr2 !== '' && $tmpstr3 !== ''){
                        if($issts){
                            $tmpsts = is_array($reqstatus)? $reqstatus:strtoupper($reqstatus);
                            $conditions = array($tmp, $tmpsts, strtoupper($reqtype));
                        }else{
                            $conditions = array($tmp, strtoupper($reqtype)); 
                        }                        
                    }else if($tmpstr2 !== ''){
                        if($issts){
                            $tmpsts = is_array($reqstatus)? $reqstatus:strtoupper($reqstatus);
                            $conditions = array($tmp, $tmpsts);
                        }else{
                            $conditions = array($tmp);
                        }                        
                    }else if($tmpstr3 !== ''){
                       $conditions = array($tmp, strtoupper($reqtype)); 
                    }else{
                        $conditions = array();
                    }
                }
            }
            if(!empty($reqdate)){
                $tmpcondition = array('date(' .$domain . '.addnlinfo1)=?', $reqdate);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            return $conditions;
        }
        private function getConditionsForPeopleFind($wantedtype, $wantedid, $wantedstatus, $whowantsid, $whowantstype, $isperm = false){            
            //nor permission implemented            
            if($whowantstype === Menu::ppl_type_admin || $isperm){
                $reqid = $wantedid;
                $reqtype = $wantedtype;
                $reqstatus = $wantedstatus;
            }else{
                if($whowantsid > 0){
                    $reqid = $whowantsid;
                    $reqtype = '';
                    $reqstatus = '';
                }else{
                    $conditions = array('1=0');//anonymous access not allowed
                    return $conditions;
                }
            }
            $domaintype = Menu::domain_people;
            $conditions = $this->buildCndnsForPplOrOrder($domaintype, $reqid, $reqstatus, $reqtype);
            $rltnconditions = array($domaintype . '.type!=?', Menu::ppl_type_receiver);
            \ActiveRecord\Utils::add_condition($conditions, $rltnconditions);
            if($whowantstype !== Menu::ppl_type_admin && !$isperm)
            {
                if($whowantstype !== Menu::ppl_type_employee 
                        && $whowantstype !== Menu::ppl_type_incharge){
                    $rltnconditions = array($domaintype . '.id=?', $whowantsid);
                    \ActiveRecord\Utils::add_condition($conditions, $rltnconditions);
                }else{
                     $rltnconditions = array($domaintype . '.type!=?', Menu::ppl_type_admin);
                    \ActiveRecord\Utils::add_condition($conditions, $rltnconditions);   
                }
            }
            return $conditions;
        }
        private function getConditionsForOrdersFind($wantedtype, $wantedid, $wantedstatus, $wanteddate = null){
            //no permission implemented
            $reqid = $wantedid;
            $reqtype = $wantedtype;
            $reqstatus = $wantedstatus;
            $reqdate = $wanteddate;
            $conditions = $this->buildCndnsForPplOrOrder(Menu::domain_orders, $reqid, $reqstatus, $reqtype, $reqdate);
            return $conditions;
        }
        private function getGeolocations($wantedtype, $wantedid, $geotype = 'latest'){
            $fltdata = array();
            if($wantedtype !== Menu::ppl_type_employee){
                return $fltdata;
            }
            $include = array();
            $conditions = array();
            if($wantedid > 0){
                $conditions = array('type = ? AND id=?', $wantedtype, $wantedid);
            }else{
               $conditions = array('type = ?', $wantedtype); 
            }
            $data = \Person::find('all', array('conditions' => $conditions, 'order' => 'name asc'));//
            //$count = 0;
            foreach ($data as &$result) {
                $result = $result->to_array(array('include' => array('geolocations' => array('include' => array('person')))));
                if(count($result['geolocations']) === 0){
                    $result['geolocations'][0] = array();
                    $result['geolocations'][0] = array('id' => 'N/A', 'lat' => 'N/A',  'lng' => 'N/A', 'locname' => 'N/A', 'captured_at' => 'N/A'); 
                }
//                $fltdata[$count]["id"] = $result->id;
//                $fltdata[$count]["name"] = $result->name;
//                if(count($result->geolocations) === 0){
//                    $fltdata[$count]["geolocations"] = array();
//                    $fltdata[$count]["geolocations"][0] = array('id' => 'N/A', 'lat' => 'N/A',  'lng' => 'N/A', 'locname' => 'N/A', 'captured_at' => 'N/A');
//                }else{
//                    $lcnCount = 0;
//                    foreach ($result->geolocations as $result1) {
//                        $t1 = $result1->lng; $t2 = $result1->lat;
//                        $t3 = $result1->locname;
//
//                        $tmpdata = $result1->to_array(array('include' => $include));//array('include' => array('jobs'));
//                        $fltdata[$count]["geolocations"][$lcnCount] = $tmpdata;
//                        //$fltdata[$count]["geolocations"][$lcnCount]["locname"] = 'lat:' . $t1 . ', lng:' . $t2 ;//. $t3;
//                        $lcnCount++;
//                        if($lcnCount === 1 && $geotype === 'latest') break;
//                    }
//                }
//                $count++;
            }
            return $data;
            //return $fltdata;
        }
        private function getPeople($wantedtype, $wantedid, $wantedstatus, $whowantsid, $whowantstype, $wanted2ndtype, $issummary){//for display purpose or crud for admin
            $isperm = false;
            if($wantedtype !== Menu::domain_peopleslots)
            {
                $conditions = $this->getConditionsForPeopleFind($wantedtype, $wantedid, $wantedstatus, $whowantsid, $whowantstype, $isperm);
                $result = \Person::find('all', array('conditions' => $conditions, 'order' => 'type, name asc'));
                $result = $this->preparePeopleReult($result, $wantedtype, $wanted2ndtype, $issummary);
                return $result;
            }else{
                $slotdate = date('Y-m-d');
                $person = array();
                $person['id'] = $whowantsid;
                $person['type'] = $whowantstype;
                $result = $this->searchPeopleSlots($person, $slotdate);
                return $result;
            }
        }
        private function searchPeopleSlots($person, $slotdate){
            $result = $this->getPeopleSlots($person, $slotdate);
            $fltrdResult = array();
            foreach ($result as &$rec) {
                $fltrdResult[] = array('name' => $rec->name
                            ,'ts9' => $rec->ts9
                            ,'ts10' => $rec->ts10,'ts11' => $rec->ts11
                            ,'ts12' => $rec->ts12,'ts13' => $rec->ts13
                            ,'ts14' => $rec->ts14,'ts15' => $rec->ts15
                            ,'ts16' => $rec->ts16,'ts17' => $rec->ts17
                            ,'ts18' => $rec->ts18,'ts19' => $rec->ts19
                            ,'ts20' => $rec->ts20
                            );
            }
            return $fltrdResult;
        }
        private function getPeopleSlots($person, $slotdate){
            $whowantsid = $person['id'];
            $whowantstype = $person['type'];
            $isperm = false;
            //min conditions.
            $wantedtype = Menu::ppl_type_employee;
            $domaintype = Menu::domain_people;
            $conditions = array('LOWER(' . $domaintype . '.type)=?', $wantedtype);
            
            if($whowantstype !== Menu::ppl_type_admin && !$isperm)
            {
                $rltnconditions = array($domaintype . '.id=?', $whowantsid);
                \ActiveRecord\Utils::add_condition($conditions, $rltnconditions);
            }
            $isPplSlotsJoin = true;
            if($isPplSlotsJoin){
                $rltnconditions = array('DATE(persontimeslots.slotdate)=?', $slotdate);
                \ActiveRecord\Utils::add_condition($conditions, $rltnconditions);
            }
            $joins = '';
            if($isPplSlotsJoin){
                $joins .= ' LEFT OUTER JOIN persontimeslots on people.id = persontimeslots.person_id';
            }
            $optionsAry = array('conditions' => $conditions
                                , 'order' => 'people.name desc');
            if(trim($joins) !== ''){
                $optionsAry['joins'] = array($joins);
            }
            $optionsAry['select'] =  'people.*, persontimeslots.*';
            $result = \Person::find('all', $optionsAry);
            return $result;
        }
        private function calculateOrderAmounts(&$order, &$cost, &$amount, &$paid, &$paidopen){
            $cost = $order->cost;
            $amount = $order->amount;
            $paid=0;
            $paidopen=0;
            foreach ($order->payments as $pymntrec) {
                if(strtolower($pymntrec->direction) === Menu::payment_inwards){
                    if($pymntrec->status === Menu::sts_open){
                        $paidopen += $pymntrec->amount;
                    }
                    if($pymntrec->status === Menu::sts_collected){
                        $paid += $pymntrec->amount;
                    }
                }
            }
        }
        private function sumupAmountsForall(&$ordrec, &$cost, &$amount, &$paid){
            $costsngl = 0;
            $amountsngl = 0;
            $paidsngl = 0;
            $paidopensngl = 0;
            $this->calculateOrderAmounts($ordrec, $costsngl, $amountsngl, $paidsngl, $paidopensngl);
            $cost += $costsngl;
            $amount += $amountsngl;
            $paid += $paidsngl;
        }
        private function calculatePaid(&$orders, &$cost, &$amount, &$paid, &$paidopen, &$ordrCount, &$invcCount, $domaintype){
            $cost = 0;
            $amount = 0;
            $paid = 0;
            $paidopen =0;
            $ordrCount = 0;
            $invcCount = 0;
            foreach ($orders as $ordrec) {
                switch($domaintype){
                    case Menu::domain_all:
                    case '':
                        $amount += $amountsngl;
                        $paid += $paidsngl;
                        break;
                    case Menu::domain_quotes:
                        if($ordrec->type === Menu::ord_type_quote || $ordrec->quote_qoi_id !== '-1'){
                            $this->sumupAmountsForall($ordrec, $cost, $amount, $paid);
                            if($ordrec->quote_qoi_id !== '-1'){
                                $ordrCount++;
                            }
                        }
                        break;
                    case Menu::domain_orders:
                        if($ordrec->type === Menu::ord_type_order || $ordrec->order_qoi_id !== '-1'){
                           $this->sumupAmountsForall($ordrec, $cost, $amount, $paid);
                           $ordrCount++;
                           if($ordrec->order_qoi_id !== '-1'){
                                $invcCount++;
                           }
                        }
                        break;
                    case Menu::domain_invoices:
                        if($ordrec->type === Menu::ord_type_invoice){
                            $this->sumupAmountsForall($ordrec, $cost, $amount, $paid);
                            $invcCount++;
                        }
                        break;
                }
            }
        }
        private function preparePeopleReult($result, $wantedtype, $wanted2ndtype, $issummary)
        {
            $resultOnlyOrders = array();
            $fltrdResult = array();
            foreach ($result as &$rec) {
                if($wantedtype === Menu::domain_peopleslots){                   
                    $fltrdResult[] = array('name' => $rec->name
                            ,'ts10' => $rec->ts10,'ts11' => $rec->ts11
                            ,'ts12' => $rec->ts12,'ts13' => $rec->ts13
                            ,'ts14' => $rec->ts14,'ts15' => $rec->ts15
                            ,'ts16' => $rec->ts16,'ts17' => $rec->ts17
                            ,'ts18' => $rec->ts18,'ts19' => $rec->ts19
                            );
                    continue;
                }
                $cost = 0;
                $amount = 0;
                $paid = 0;
                $paidopen = 0;
                $ordrCount = 0;
                $invcCount = 0;
                switch($wantedtype){
                    case Menu::ppl_type_supplier:
                        $include = array('supplierproducts');
                        $except = array('mhcost', 'mhrate', 'work_hour_start', 'work_hour_end', 'created_at', 'updated_at');
                        break;
                    case Menu::ppl_type_customer:
                    default ://treat as admin -user management operations
                        if(!is_null($wanted2ndtype) && trim($wanted2ndtype) !== ''){
                            if($issummary){
                                $this->calculatePaid($rec->customerorders, $cost, $amount, $paid, $paidopen, $ordrCount, $invcCount, $wanted2ndtype);
                                $include = array();
                            }else{
                                $include = array( 'customerorders' => array('include' => array('ordrcustomers', 'ordrreceivers', 'ordremployees', 'ordrcreatedby', 'ordrmodifiedby') ) );
                            }
                            $except = array('mhcost', 'mhrate', 'work_hour_start', 'work_hour_end', 'created_at', 'updated_at');
                        }else{
                            $include = array( 'logins', 'ofcaddresses', 'rsdaddresses', 'otheraddresses');
                            if($rec->type === Menu::ppl_type_employee){
                                $except = array('created_at', 'updated_at');
                            }else{
                                $except = array('mhcost', 'mhrate', 'work_hour_start', 'work_hour_end', 'created_at', 'updated_at');
                            }
                        }
                }
                if($wantedtype === Menu::ppl_type_customer && $issummary){
                    if($wanted2ndtype === Menu::domain_quotes 
                            || $ordrCount > 0 || $invcCount > 0){
                        $rec = $rec->to_array(array('include' => $include, 'except' => $except));
                        $rec["listtype"] = $wanted2ndtype;
                        $rec["cost"] = $cost;
                        $rec["amount"] = $amount;
                        $rec["paid"] = $paid;
                        $qtandnorder = $wanted2ndtype === Menu::domain_quotes && $ordrCount === 0;
                        if(($paid == 0 && $amount == 0) || $amount < $paid || $qtandnorder){
                            $rec["paidstatus"] = "";
                        }else if($paid == 0 && $amount > 0){
                            $rec["paidstatus"] = "ZeroPaid!";
                        }else{
                            $rec["paidstatus"] = ($amount === $paid)?"Paid":"Pending";
                        }
                        $fltrdResult[] = $rec;
                    }
                }else{
                    $rec = $rec->to_array(array('include' => $include, 'except' => $except));
                    $rec['contact'] = $rec['firstname'] . ' ' . $rec['lastname'];
                    $fltrdResult[] = $rec;
                    $tmptype  = NULL;
                    switch($wanted2ndtype){
                        case Menu::domain_quotes:
                            $tmptype = Menu::ord_type_quote;
                            break;
                        case Menu::domain_orders:
                            $tmptype = Menu::ord_type_order;
                            break;
                        case Menu::domain_invoices:
                            $tmptype = Menu::ord_type_invoice;
                            break;
                        case Menu::domain_all:
                            $tmptype = '';
                    }
                    if(!is_null($tmptype)){
                        foreach ($rec['customerorders'] as $tmporder) {
                            if($tmptype === '' || $tmporder["type"] === $tmptype){
                                $resultOnlyOrders[] = $tmporder;
                            }
                        }
                    }
                }
            }
            if($wantedtype === Menu::ppl_type_customer 
                    && !$issummary && !is_null($tmptype)){
                $fltrdResult = $resultOnlyOrders;
            }
            return $fltrdResult;
        }
        private function addLastColumnInArray(&$ary, &$inhandary, $colHdr = 'N/A'
                , $rplcInhand = false, $totalInhand = 0)
        {
            $inhandary = array_merge(array($colHdr), $inhandary);
            $frow = $ary[0];
            $count = count($frow);
            $itr = 0;
            foreach($ary as &$row){
                if($rplcInhand)
                {
                    if($itr !== 0)//0 is header row
                    {
                        $inhandary[$itr] =  $totalInhand;
                    }                   
                }
                $row[$count] = $inhandary[$itr];
                $itr++;
            }
        }
        private function fillArray(&$ary){
            //normalize with first row always.
            $frow = $ary[0];
            $colcount = count($frow);
            $itr = 0;
            foreach($ary as &$row){
                if($itr === 0){
                    $itr++;
                    continue;
                }
                $tmpary = array();
                for($j = 0; $j< $colcount; $j++){
                    if(!isset($row[$j]) || empty($row[$j])){
                        if($j === 0 )
                        {
                            $tmpary[$j] = 'X' . $itr;
                        }
                        else
                        {
                            $tmpary[$j] = 0;    
                        }                       
                    }else{
                        $tmpary[$j] = $row[$j];
                    }
                }
                $row = $tmpary;
                $itr++;
            }
        }
        private function insertIn0throw(&$ary, $name){
            $count = count($ary);
            $found = false;
            $foundpos = $count;
            for($j = 1; $j<$count; $j++){
                if(strtolower($ary[$j]) === $name){ 
                    $found = true;
                    $foundpos = $j;
                    break;
                }
            }            
            if(!$found){
                $ary[$foundpos] = $name;
            }
            return $foundpos;
        }
        private function getAccountsForChart($wantedid){
            //customerwise
            //SELECT p.name,a.created_at,a.acnt_no,a.amount, b.amount,b.payment_at,b.details FROM people p LEFT OUTER JOIN accounts a ON p.id=a.party_id LEFT OUTER JOIN payments b ON b.account_id=a.id WHERE a.accounttype='Receivables'
            //SELECT p.name,SUM(a.amount), SUM(b.amount) FROM people p LEFT OUTER JOIN accounts a ON p.id=a.party_id LEFT OUTER JOIN payments b ON b.account_id=a.id  WHERE a.accounttype='Receivables' GROUP BY p.name AND p.id = 2
            //projectwise
            //SELECT op.id, p.name,SUM(a.amount) AS invoiced, SUM(b.amount) AS paid FROM people p LEFT OUTER JOIN orderpeople op ON p.id=op.person_id LEFT OUTER JOIN accounts a ON p.id=a.party_id LEFT OUTER JOIN payments b ON b.account_id=a.id  WHERE op.type='customer' AND a.accounttype='Receivables' GROUP BY op.id , p.name
            //SELECT op.id, p.name,SUM(a.amount) AS invoiced, SUM(b.amount) AS paid FROM people p LEFT OUTER JOIN orderpeople op ON p.id=op.person_id LEFT OUTER JOIN accounts a ON p.id=a.party_id LEFT OUTER JOIN payments b ON b.account_id=a.id  WHERE op.type='customer' AND a.accounttype='Receivables' AND op.id=6
            
            $inhandary = array();//here wantedid always refers orderid not invoice id.
            $fnlrslt = array();
            $row = 0;
            $fnlrslt[$row][] = 'Period';
            $row++;
            $totalInhand = 0;
            $totalPlus = 0;
            $totalMinus = 0;
            for ($month = 1; $month <= 12; $month++) {
                for ($half = 1; $half <= 2; $half++) {
                    $conditions =  array($this->getConditionforAccountsChart($month, $half));
                    $ordersjoin = false;
                    if($wantedid > 0){
                        $ordersjoin=true;
                        $tmpcondition = array('accountorders.order_id=?', $wantedid);
                        \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
                    }
                    $select = 'party_id, accounttype, sum(amount) as amount';
                    $group = 'party_id, accounttype';
                    if($half === 1){
                        $monthstr = $month . '[1 - 15]';
                    }else{
                       $monthstr = $month . '[16 - 31]';
                    }
                    $joins = '';
                    if($ordersjoin){
                        $joins .= ' JOIN accountorders on accounts.id = accountorders.account_id';
                    }
                    $optionsAry =  array(
                                    'select' => $select,
                                    'conditions' => $conditions
                                    , 'group' => $group
                                    );
                    if(trim($joins) !== ''){
                        $optionsAry['joins'] = array($joins);
                    }
                    $result = \Account::find('all', $optionsAry);
                    $except = array();
                    $fnlrslt[$row][] = $monthstr;
                    $inhand = 0;
                    $plus = 0;
                    $minus = 0;
                    foreach ($result as &$rec) {
                        $colnumber = $this->insertIn0throw($fnlrslt[0], $rec->party->name);
                        $amount = $rec->amount;
                        
                        if(strtolower($rec->accounttype) === strtolower(Menu::acc_type_payables)){//account is payable
                            $minus += $amount;
                            $amount = -$amount;
                        }else
                        {
                            $plus += $amount;
                        }
                        $inhand += $amount;
                        $fnlrslt[$row][$colnumber] = $amount;
//                        $include = array('party');
//                        $rec = $rec->to_array(array('include' => $include, 'except' => $except));                        
                    }
                    $inhandary[] = $inhand;
                    $totalInhand += $inhand;
                    $totalPlus += $plus;
                    $totalMinus += $minus;
                    $row = $row + 1;
                }
            }
            $this->fillArray($fnlrslt);
            $this->addLastColumnInArray($fnlrslt, $inhandary, 'Net', true, $totalInhand);
            $tmprslt = array();
            $tmprslt[] = $totalInhand;
            $tmprslt[] = $totalPlus;
            $tmprslt[] = $totalMinus;
            $tmprslt[] = $fnlrslt;
            $fnlrslt = $tmprslt;
            return $fnlrslt;
        }
        private function getPaymentsForChart($wantedid){
            $inhandary = array();//here wantedid always refers orderid not payments id.
            $fnlrslt = array();
            $row = 0;
            $fnlrslt[$row][] = 'Period';
            $row++;
            $totalInhand = 0;
            $totalPlus = 0;
            $totalMinus = 0;
            for ($month = 1; $month <= 12; $month++) {
                for ($half = 1; $half <= 2; $half++) {
                    $conditions =  array($this->getConditionforPaymentsChart($month, $half));
                    if($wantedid > 0){
                        $tmpcondition = array('order_id=?',$wantedid);
                        \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
                    }
                    $select = 'party_id, sum(amount) as amount, direction';
                    $group = 'party_id, direction';
                    if($half === 1){
                        $monthstr = $month . '[1 - 15]';
                    }else{
                       $monthstr = $month . '[16 - 31]';
                    }
                    $result = \Payment::find('all', array('select' => $select
                            , 'conditions' => $conditions
                            , 'group' => $group));
                    $except = array();
                    $fnlrslt[$row][] = $monthstr;
                    $inhand = 0;
                    $plus = 0;
                    $minus = 0;
                    foreach ($result as &$rec) {
                        $colnumber = $this->insertIn0throw($fnlrslt[0], $rec->party->name);
                        $amount = $rec->amount;
                        if(strtolower($rec->direction) === Menu::payment_outwards){//account is payable
                            $minus += $amount;
                            $amount = -$amount;
                        }
                        else
                        {
                            $plus += $amount;
                        }
                        $inhand += $amount;
                        $fnlrslt[$row][$colnumber] = $amount;
//                        $include = array('party');
//                        $rec = $rec->to_array(array('include' => $include, 'except' => $except));                        
                    }
                    $inhandary[] = $inhand;
                    $totalInhand += $inhand;
                    $totalPlus += $plus;
                    $totalMinus += $minus;
                    $row = $row + 1;
                }
            }
            $this->fillArray($fnlrslt);
            $this->addLastColumnInArray($fnlrslt, $inhandary, 'InHand', true, $totalInhand);
            $tmprslt = array();
            $tmprslt[] = $totalInhand;
            $tmprslt[] = $totalPlus;
            $tmprslt[] = $totalMinus;
            $tmprslt[] = $fnlrslt;
            $fnlrslt = $tmprslt;
            return $fnlrslt;
        }
        private function getPayments($wantedid, $wantedstatus, $wantedtype, $whowantsid, $whowantstype){
            $isperm = false;
            $conditions = array();
            if($wantedid > 0){
                $tmpcondition = array('id=?',$wantedid);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            if($wantedstatus !== ''){
                $tmpcondition = array('LCASE(status)=?', strtolower($wantedstatus));
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            if($wantedtype !== ''){
                $tmpcondition = array('LCASE(direction)=?', strtolower($wantedtype));
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            if(($whowantstype !== Menu::ppl_type_admin && !$isperm)){
                //whatever id, status been asked give if they are their related records only                
                $tmpcondition = array('person_id=?', $whowantsid);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            $result = \Payment::find('all', array('conditions' => $conditions, 'order' => 'updated_at desc'));
            
            $except = array();
            foreach ($result as &$rec) {
                $include = array('account' => array('include' => array('orders')),'party','order');
                if(strtolower($rec->direction) === Menu::payment_outwards){//account is payable
                    $include = array('account' => array('include' => array('orders' ,'ordertasks' => array('include' => array('task'))))
                                    ,'party'
                                    ,'order'
                                    ,'ordertask' => array('include' => array('task'))
                                    );
                }
                $rec = $rec->to_array(array('include' => $include, 'except' => $except));
            }
            return $result;
        }
        private function getAccounts($wantedid, $wantedstatus, $whowantsid, $whowantstype){
            $isperm = false;
            $conditions = array();
            if($wantedid > 0){
                $tmpcondition = array('id=?',$wantedid);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            if(trim($wantedstatus) !== ''){
                $tsts = strtolower(trim($wantedstatus));
                if($tsts !== strtolower(Menu::acc_type_payables)
                        && $tsts !== strtolower(Menu::acc_type_receivables))
                {
                    $tmpcondition = array('LCASE(status)=?', $tsts);
                }else{
                    $tmpcondition = array('LCASE(accounttype)=?', $tsts);
                }
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            if(($whowantstype !== Menu::ppl_type_admin && !$isperm)){
                $tmpcondition = array('party_id=?', $whowantsid);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            $result = \Account::find('all', array('conditions' => $conditions, 'order' => 'updated_at desc'));
            $count = count($result);
            $except = array();
            foreach ($result as &$rec) {
                if($count > 1){
                    $include = array('party' => array('include' => array('ofcaddresses')), 'orders', 'purchases', 'payments');
                    if($rec->accounttype === Menu::acc_type_payables){
                        $include = array('party' => array('include' => array('ofcaddresses')), 'orders', 'purchases', 'payments', 'ordertasks' => array('include' => array('task')));
                    }
                }else{
                    $include = array();
                    //'order' => array('include' => array('orderproducts' => array('include' => array('product'))))
                    $include = array('party' => array('include' => array('ofcaddresses')), 'orders', 'purchases', 'payments');
                    if($rec->accounttype === Menu::acc_type_payables){
                        $include = array('party' => array('include' => array('ofcaddresses')), 'orders', 'purchases', 'payments', 'ordertasks' => array('include' => array('task')));
                    }
                }
                $rec = $rec->to_array(array('include' => $include, 'except' => $except));
            }
            return $result;
        }
        private function getOrderTasks($wantedid, $wantedstatus, $whowantsid, $whowantstype, $forwhatOrder, $isonlysummary){
            $isperm = false;
            $conditions = array();
            if($forwhatOrder > 0)
            {
                $tmpcondition = array('order_id=?',$forwhatOrder);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            if($wantedid > 0){
                $tmpcondition = array('id=?',$wantedid);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            if($wantedstatus !== ''){
                $tmpcondition = array('LCASE(status)=?', strtolower($wantedstatus));
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            if(($whowantstype !== Menu::ppl_type_admin && !$isperm)){
                //whatever id, status been asked give if they are their related records only
                $tmpcondition = array('ordertaskpeople.person_id=? AND ordertaskpeople.type IN (?)', $whowantsid, array($whowantstype, "created", "modified", "incharge"));
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            
            if(($whowantstype !== Menu::ppl_type_admin && !$isperm)){                
                $result = \Ordertask::find('all', array('joins' => array('ordertaskpeople'), 'conditions' => $conditions, 'order' => 'end_at desc'));
            }else{
                $result = \Ordertask::find('all', array('conditions' => $conditions, 'order' => 'end_at desc'));
            }
            if($isonlysummary)
            {
                $include = array('task');
            }
            else
            {
                $include = array('order','task','ordertaskexternals', 'ordertaskemppeople', 'ordertaskprgrshistories');   
            }
            $except = array();
            foreach ($result as &$rec) {
                $rec = $rec->to_array(array('include' => $include, 'except' => $except));
            }
            return $result;
        }
        private function getMilestonesForAlertMail($wantedid, $wantedstatus, &$alertms){
            $conditions = array();
            if($wantedid > 0){//here wantedid always refers orderid not milestone id.
                $tmpcondition = array('order_id=?',$wantedid);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            if($wantedstatus !== ''){
                if(strtolower($wantedstatus) !== 'latest'){
                    $tmpcondition = array('LCASE(status)=?', strtolower($wantedstatus));
                    \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
                }else{
                    $tmpcondition =  array($this->getConditionforLatestMilestones());
                    \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
                }
            }
            $tmpcondition = array('mailcount<? AND (lastmailsent_at IS NULL OR (DATE(NOW()) - DATE(lastmailsent_at)) = ?)', $this->max_ms_mail_alters, $this->ms_mail_alters_freq);
            \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            $result = \Milestone::find('all', array('conditions' => $conditions, 'order' => 'start_at desc'));
            $alertms = array();
            foreach ($result as &$rec) {
                $alertms[$rec->id] = $rec->details;
            }
            return $result;
        }
        private function getMilestones($wantedid, $wantedstatus
                , $whowantsid, $whowantstype, $isForChart = false, &$chartData){
            $isperm = false;
            $conditions = array();
            if($isForChart){
                if($wantedid > 0){
                    $tmpcondition = array('order_id=?',$wantedid);
                    \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
                }
            }else{
                if($wantedid > 0){
                    $tmpcondition = array('id=?',$wantedid);
                    \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
                }
            }
            if($wantedstatus !== ''){
                if(strtolower($wantedstatus) !== 'latest'){
                    $tmpcondition = array('LCASE(status)=?', strtolower($wantedstatus));
                    \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
                }else{
                    $tmpcondition =  array($this->getConditionforLatestMilestones());
                    \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
                }
            }
            if(($whowantstype !== Menu::ppl_type_admin && !$isperm)){
                //whatever id, status been asked give if they are their related records only                
                $tmpcondition = array('person_id=?', $whowantsid);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            $result = \Milestone::find('all', array('select' => 'milestones.*, DATEDIFF(milestones.end_at, milestones.start_at) AS duration', 'conditions' => $conditions, 'order' => 'start_at'));            
            $include = array('order');
            $except = array();
//            "id":1, "text":"Project #1", "start_date":"01-04-2013", "duration":"11", "progress": 0.6, "open": true,
//            {"id": "dd2e7a97-1622-4521-a807-f29960218785", "description": "Create concept", "order": 3, "tasks": [
//                {"id": "9c17a6c8-ce8c-4426-8693-a0965ff0fe69", "subject": "Create concept", "color": "#F1C232", "from": new Date(2013,9,10,8,0,0), "to": new Date(2013,9,16,18,0,0)}
//            ]}
//{
//"cols": [
//        {"id":"Room","label":"Room","pattern":"","type":"string"},
//        {"id":"Name","label":"Name","pattern":"","type":"string"}
//        {"id":"Start","label":"Start","pattern":"","type":"date"},
//        {"id":"End","label":"End","pattern":"","type":"date"}
//      ],
//"rows": [
//        {"c":[{"v":"WATCH","f":null},{"v":"TODAYS","f":null},{"v": new Date(2013,10,10,01,46,0),"f":null},{"v": new Date(2013,10,10,06,31,0),"f":null}]},
//        {"c":[{"v":"WATCH","f":null},{"v":"AVERAGE","f":null},{"v": new Date(2013,10,10,01,52,0),"f":null},{"v": new Date(2013,10,10,06,37,0),"f":null}]}
//        
//      ]
//}            
            if(count($result) > 0){
                $chartData = array();
                $order = 0;
                $rowid = 1;
                if($isForChart){
                    switch(Menu::chart_type_current){
                        case Menu::chart_type_angulargantt:
                            $chartRow = array();
                            $chartRow["id"] = $rowid++;
                            $chartRow["description"] = "Milestones";
                            $chartRow["order"] = $order++;
                            $chartRow["tasks"] = array();
                            $chartData[] = $chartRow;
                            break;
                        case Menu::chart_type_googletimeline:
//                            $chartData = new \stdClass();
//                            $colary = array();
//                            $colobj = new \stdClass();
//                            $colobj->id= "Details";
//                            $colobj->label= "Details";
//                            $colobj->pattern= "";
//                            $colobj->type= "string";
//                            $colary[] = $colobj;
//                            $colobj = new \stdClass();
//                            $colobj->id= "Completed";
//                            $colobj->label= "Completed";
//                            $colobj->pattern= "";
//                            $colobj->type= "string";
//                            $colary[] = $colobj;
//                            $colobj = new \stdClass();
//                            $colobj->id= "Start";
//                            $colobj->label= "Start";
//                            $colobj->pattern= "";
//                            $colobj->type= "date";
//                            $colary[] = $colobj;
//                            $colobj = new \stdClass();
//                            $colobj->id= "End";
//                            $colobj->label= "End";
//                            $colobj->pattern= "";
//                            $colobj->type= "date";
//                            $colary[] = $colobj;
//                            $chartData->cols = $colary;
//                            $chartrows = array();
                            break;
                    }
                }
                foreach ($result as &$rec) {
                    //$rec = $rec->to_array(array('include' => $include, 'except' => $except));
                    if($isForChart){
                        switch(Menu::chart_type_current){
                            case Menu::chart_type_angulargantt:
                                $tmprec = array();
                                $this->fillRecForMstaskChart($tmprec, $rec);                                
                                $chartData[0]["tasks"][] = $tmprec;
                                break;
                            case Menu::chart_type_googletimeline:
                                $chartRow = array();
                                $chartRow[] = $rec->details;
                                $chartRow[] = 0;// number_format($rec->completed,0,'.','');//$rec->completed;//
                                $chartRow[] = $rec->start_at;
                                $chartRow[] = $rec->start_at;//$rec->end_at;
                                $chartRow[] = 1;
//                                //another method
//                                $chartrowobj = new \stdClass();
//                                $volobj = new \stdClass();
//                                $volobj->v = $rec['details'];
//                                //$volobj->f = null;
//                                $chartRow[] = $volobj;
//                                $volobj = new \stdClass();
//                                $volobj->v = number_format($rec['completed'],2,'.','');
//                                //$volobj->f = null;
//                                $chartRow[] = $volobj;
//                                $volobj = new \stdClass();
//                                $volobj->v = $this->formJSdateJson($rec['start_at']);
//                                //$volobj->f = null;
//                                $chartRow[] = $volobj;
//                                $volobj = new \stdClass();
//                                $volobj->v = $this->formJSdateJson($rec['end_at']);
//                                //$volobj->f = null;
//                                $chartRow[] = $volobj;
//                                $chartrowobj->c = $chartRow;
//                                $chartrows[] = $chartrowobj;
//                                $chartRow[] = $rec['details'];
//                                $chartRow[] = number_format($rec['completed'],2,'.','');
//                                $chartRow[] = $this->formJSdateJson($rec['start_at']);
//                                $chartRow[] = $this->formJSdateJson($rec['end_at']);
                                $chartData[] = $chartRow;
                                break;
                        }
                    }
                    $rec = $rec->to_array(array('include' => $include, 'except' => $except));
                }
                //$chartData->rows = $chartrows;
                if($isForChart){//collect ordertasks too.
                    $conditions = array();
                    if($wantedid > 0){
                        $tmpcondition = array('order_id=?',$wantedid);
                        \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
                    }
                    if(($whowantstype !== Menu::ppl_type_admin && !$isperm)){                
                        $allordertasksresult = \Ordertask::find('all', array('joins' => array('ordertaskpeople'), 'select' => 'ordertasks.*, DATEDIFF(ordertasks.end_at, ordertasks.start_at) AS duration', 'conditions' => $conditions, 'order' => 'start_at'));
                    }else{
                        $allordertasksresult = \Ordertask::find('all', array('select' => 'ordertasks.*, DATEDIFF(ordertasks.end_at, ordertasks.start_at) AS duration', 'conditions' => $conditions, 'order' => 'start_at'));
                    }
                    foreach ($allordertasksresult as &$otrec) {
                        //$otrec = $otrec->to_array(array('include' => $include, 'except' => $except));
                        switch(Menu::chart_type_current){
                            case Menu::chart_type_angulargantt://each task as each row
                                $chartRow = array();
                                $chartRow["id"] = $rowid++;
                                $chartRow["description"] = $otrec['details'];
                                $chartRow["order"] = $order++;

                                $chartRow["tasks"] = array();                            
                                $tmprec = array();
                                $this->fillRecForMstaskChart($tmprec, $otrec);                            
                                $chartRow["tasks"][] = $tmprec;

                                $chartData[] = $chartRow;
                                break;
                            case Menu::chart_type_googletimeline:
                                $chartRow = array();
                                $chartRow[] = $otrec->details;
                                $chartRow[] = number_format($otrec->completed,2,'.','');//number_format($otrec->completed,2,'.','');$rec->completed
                                $chartRow[] = $otrec->start_at;
                                $chartRow[] = $otrec->end_at;
                                $chartRow[] = 0;
    //                            $chartRow[] = $otrec['details'];
    //                            $chartRow[] = number_format($otrec['completed'],2,'.','');
    //                            $chartRow[] = $this->formJSdateJson($otrec['start_at']);
    //                            $chartRow[] = $this->formJSdateJson($otrec['end_at']);
                                $chartData[] = $chartRow;
                                break;
                        }
                        $otrec = $otrec->to_array(array('include' => $include, 'except' => $except));
                    }
                }
            }
            return $result;
        }
        private function formJSdateJson($datestr){
            $rtnstr = "Date(";
            list($date, $time) = split(" ",$datestr);
            list($year, $month, $day) = split('[/.-]', $date);
            list($h,$m,$s) = split(":", $time);
            if(is_null($s)){
                $s = "0";
            }
            $rtnstr .= (int)$year . "," . (int)$month . "," . (int)$day . "," . (int)$h . "," . (int)$m . "," . (int)$s . ")";
            return $rtnstr;
        }
        private function fillRecForMstaskChart(&$tmprec, $rec){                                
            $tmprec['id'] = $rec['id'];
            $tmprec['text'] = $rec['details'];
            $tmprec['subject'] = $rec['details'];
            $tmprec['start_date'] = $rec['start_at'];//$rec->start_at;
            $tmprec['from'] = $rec['start_at'];
            $tmprec['to'] = $rec['end_at'];
            $tmprec['duration'] = $rec['duration'];
            $tmprec['progress'] = $rec['completed'] * 1.0;
            $tmprec['open'] =  (($tmprec['progress'] < 100.0)?true:false);
        }
        private function getOrders($domaintype, $wantedtype, $wanted2ndtype, $wantedid
                , $wantedstatus, $wanteddate, $whowantsid, $whowantstype, $issummary, $searchCriteria = array(), $isshort = false){//for display purpose or crud for admin
            $isperm = false;
            if($issummary){
                if(count($searchCriteria) === 0){
                    switch($wantedtype){
                        case Menu::ord_type_quote:
                            $conditions = array('type=? OR quote_qoi_id != "-1"', $wantedtype);
                            break;
                        case Menu::ord_type_order:
                            $conditions = array('type=? OR order_qoi_id != "-1"', $wantedtype);
                            break;
                        case Menu::ord_type_invoice:
                            $conditions = array('type=?', $wantedtype);
                            break;
                        default:
                            $conditions = array();
                            break;
                    }
                }else{
                    $conditions = $searchCriteria;
                }
                //exclude dummy order whose id is always 1
                $dummyorderid = 1;
                $tmpcondition = array('orders.id!=?',$dummyorderid);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            
                $result = \Order::find('all', array('conditions' => $conditions, 'order' => 'end_at desc'));
                $totalcount = count($result);
                $cost = 0;
                $amount = 0;
                $paid = 0;
                $paidopen = 0;
                $ordrCount = 0;
                $invcCount = 0;
                $this->calculatePaid($result, $cost, $amount, $paid, $paidopen, $ordrCount, $invcCount, $domaintype);
                $include = array();
                $except = array();
                $summary = array();
                //$summary = $summary->to_array(array('include' => $include, 'except' => $except));
                $summary["name"] = $domaintype;
                $summary["totalcount"] = $totalcount;
                if($wantedtype === Menu::ord_type_quote){
                    $summary["convertedcount"] = $ordrCount;
                }
                else if($wantedtype === Menu::ord_type_order){
                   $summary["convertedcount"] = $invcCount; 
                }
                $summary["cost"] = $cost;
                $summary["amount"] = $amount;
                $summary["paid"] = $paid;
                $qtandnorder = $wantedtype === Menu::ord_type_quote && $ordrCount === 0;
                if(($paid == 0 && $amount == 0) || $amount < $paid || $qtandnorder){
                    $summary["paidstatus"] = "";
                }else if($paid == 0 && $amount > 0){
                    $summary["paidstatus"] = "ZeroPaid!";
                }else{
                    $summary["paidstatus"] = ($amount === $paid)?"Paid":"Pending";
                }
                $summary = array($summary);
                return $summary;
            }
            $wanted2ndtype = $this->getPeopleType($wanted2ndtype);
            $isreqfor = ((!is_null($wanted2ndtype) && trim($wanted2ndtype) !== ''));//orders for employees, customers or...
            if($isreqfor){//
                if(is_numeric($wantedid) && (int)$wantedid > 0){
                    $wanted2ndid = $wantedid;//wanted for this emp/cust id... only
                    $wantedid =  -1;
                }
            }
            if(count($searchCriteria) === 0){
                $conditions = $this->getConditionsForOrdersFind($wantedtype, $wantedid, $wantedstatus, $wanteddate);                                  
            }else{
                $conditions = $searchCriteria;
            }
            //exclude dummy order whose id is always 1
            $dummyorderid = 1;
            $tmpcondition = array('orders.id!=?',$dummyorderid);
            \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            if(($whowantstype !== Menu::ppl_type_admin && !$isperm) || $isreqfor){
                //whatever id, status been asked give if they are their related orders only
                //$ppltypearray = array($whowantstype, "created", "modified", "employee", "incharge");
                $ppltypearray = array($whowantstype);
                $rltnconditions = array('orderpeople.person_id=? AND orderpeople.type IN (?)', $whowantsid, $ppltypearray);
                \ActiveRecord\Utils::add_condition($conditions, $rltnconditions);
                
                $result = \Order::find('all', array('joins' => array('orderpeople'), 'conditions' => $conditions, 'order' => 'end_at desc'));
            }else{
                $result = \Order::find('all', array('conditions' => $conditions, 'order' => 'end_at desc'));
            }
            $this->prepareOrdersResult($result, $domaintype, $wantedtype, $isshort);
            return $result;
        }
        private function prepareOrdersResult(&$result, $domaintype, $wantedtype, $isshort = false, $bothcustandemp = false, $ename = ''){
            $except = array('updated_at');
            $shortinclude = array('blngaddresses', 'shpngaddresses', 'ordrcustomers','ordrreceivers');
            if($isshort){
                $include = $shortinclude;
                $fnlresult = array();
                foreach ($result as &$rec) {
                    $ordrempname = ((isset($rec->ordremployees[0]))?$rec->ordremployees[0]->name:'');
                    if($bothcustandemp){//ename empty is not possible actually.
                        $isempmatch = ( empty($ename) || (strpos(strtolower($ordrempname), strtolower($ename)) === 0));
                        if(!$isempmatch){
                            continue;
                        }
                    }
                    $fnlresult[] = $rec->to_array(array('include' => $include, 'except' => $except));
                }
                $result = $fnlresult;
                return;
            }else{
                $qtincld = array('quotetasks' => array('include' => array('order', 'task', 'quotetaskexternals', 'quotetaskemppeople', 'quotetaskprgrshistories')), 'quotetaskemployees', 'quotetaskincharges'
                            , 'quotetaskexternals', 'quotetaskcreatedby', 'quotetaskmodifiedby');
                $ordrincld = array('ordrtasks' => array('include' => array('order', 'task', 'ordertaskexternals', 'ordertaskemppeople', 'ordertaskprgrshistories')), 'ordertaskemployees', 'ordertaskincharges'
                                , 'ordertaskexternals', 'ordertaskcreatedby', 'ordertaskmodifiedby');
                $invincld = array('invoicetasks' => array('include' => array('order', 'task', 'invoicetaskexternals', 'invoicetaskemppeople', 'invoicetaskprgrshistories')), 'invoicetaskemployees', 'invoicetaskincharges'
                                , 'invoicetaskexternals', 'invoicetaskcreatedby', 'invoicetaskmodifiedby');
                $voidincld = array('voidtaskemployees', 'voidtaskincharges'
                                , 'voidtaskexternals', 'voidtaskcreatedby', 'voidtaskmodifiedby');
                $dtldinclude = array('ordremployees', 'ordrcreatedby', 'ordrmodifiedby'
                    ,'orderproducts' => array('include' => array('product','orderproductdns'))
                    ,'orderproductdns' => array('include' => array('orderproduct'=> array('include' => array('product'))))
                    ,'ordermilestones','payments','products'
                    ,'statushistories');
                $include = array_merge($shortinclude, $dtldinclude, $qtincld, $ordrincld, $invincld, $voidincld); 
            }
            $fnlresult = array();
            foreach ($result as &$rec) {
                $ordrempname = ((isset($rec->ordremployees[0]))?$rec->ordremployees[0]->name:'');
                if($bothcustandemp){//ename empty is not possible actually.
                    $isempmatch = ( empty($ename) || (strpos(strtolower($ordrempname), strtolower($ename)) === 0));
                    if(!$isempmatch){
                        continue;
                    }
                }
                
                //before converting into array do this start
                $cname = $rec->ordrcustomers[0]->name;
                $cid = $rec->ordrcustomers[0]->id;
                $costsngl = 0;
                $amountsngl = 0;
                $paidsngl=0;
                $paidopensngl=0;
                $this->calculateOrderAmounts($rec, $costsngl, $amountsngl, $paidsngl, $paidopensngl);
                //before converting into array do this end
                
                $tmprec = $rec->to_array(array('include' => $include, 'except' => $except));
                $fnlresult[] = $tmprec;
                //$rec = $rec->to_array(array('include' => $include, 'except' => $except));
                $tmprec["listtype"] = $domaintype;
                $tmprec["cid"] = $cid;
                $tmprec["cname"] = $cname;
                $tmpcreatedby = 'ordrcreatedby';
                $tmpmodifiedby = 'ordrmodifiedby';
                if(count($tmprec[$tmpmodifiedby]) === 0){
                    $tmprec[$tmpmodifiedby] = $tmprec[$tmpcreatedby];
                }
                $tmprec['paid'] = $paidsngl;
                $tmprec['paidopen'] = $paidopensngl;
                if(($paidsngl == 0 && $amountsngl == 0)
                        || $amountsngl < $paidsngl || $domaintype === Menu::domain_quotes){
                    $tmprec["paidstatus"] = "";
                }else if($paidsngl == 0 && $amountsngl > 0){
                    $tmprec["paidstatus"] = "ZeroPaid!";
                }else{
                    $tmprec["paidstatus"] = ($amountsngl === $paidsngl)?"Paid":"Pending";
                }
                //ordertask level
                $tmpcreatedby = '';
                $tmpmodifiedby = '';
                switch($wantedtype){
                    case Menu::ord_type_quote:
                        $tmpcreatedby = 'quotetaskcreatedby';
                        $tmpmodifiedby = 'quotetaskmodifiedby';
                        break;
                    case Menu::ord_type_order:
                        $tmpcreatedby = 'ordertaskcreatedby';
                        $tmpmodifiedby = 'ordertaskmodifiedby';
                        break;
                    case Menu::ord_type_invoice:
                        $tmpcreatedby = 'invoicetaskcreatedby';
                        $tmpmodifiedby = 'invoicetaskmodifiedby';
                        break;
                    case Menu::ord_type_void:
                        $tmpcreatedby = 'voidtaskcreatedby';
                        $tmpmodifiedby = 'voidtaskmodifiedby';
                        break;
                }
                if(count($tmprec[$tmpmodifiedby]) === 0){
                    $tmprec[$tmpmodifiedby] = $tmprec[$tmpcreatedby];
                }
                
                //ordertask level
                switch($tmprec['type']){
                    case Menu::ord_type_order:                        
                        if(count($tmprec['ordrtasks']) === 0) $tmprec['ordrtasks'] = $tmprec['quotetasks'];
                        break;
                    case Menu::ord_type_quote:
                        $tmprec['ordrtasks'] = $tmprec['quotetasks'];
                        break;
                    case Menu::ord_type_invoice:
                        //if empty take from order level [converted invoices]
                        if(count($tmprec['invoicetasks']) === 0) $tmprec['invoicetasks'] = $tmprec['ordrtasks'];                        
                        //again if empty take from quote level
                        if(count($tmprec['invoicetasks']) === 0) $tmprec['invoicetasks'] = $tmprec['quotetasks'];
                        
                        $tmprec['ordrtasks'] = $tmprec['invoicetasks'];
                        break;
                    case Menu::ord_type_void:
                        $tmprec['ordrtasks'] = $tmprec['voidtasks'];
                        break;
                }
                foreach ($tmprec['ordrtasks'] as &$ordertask) {
                    switch($tmprec['type']){
                        case Menu::ord_type_order:
                            if(count($ordertask['ordertaskemppeople']) === 0) $ordertask['ordertaskemppeople'] = $ordertask['quotetaskemppeople'];
                            break;
                        case Menu::ord_type_quote:
                            $ordertask['ordertaskemppeople'] = $ordertask['quotetaskemppeople'];
                            break;
                        case Menu::ord_type_invoice:
                            //if empty take from order level [converted invoices]
                            if(count($ordertask['invoicetaskemppeople']) === 0) $ordertask['invoicetaskemppeople'] = $ordertask['ordertaskemppeople'];
                            //again if empty take from quote level
                            if(count($ordertask['invoicetaskemppeople']) === 0) $ordertask['invoicetaskemppeople'] = $ordertask['quotetaskemppeople'];
                            $ordertask['ordertaskemppeople'] = $ordertask['invoicetaskemppeople'];                      
                            break;                    
                    }
                }
                switch($tmprec['type']){
                    case Menu::ord_type_order:
                        if(count($tmprec['ordertaskcreatedby']) === 0) $tmprec['ordertaskcreatedby'] = $tmprec['quotetaskcreatedby'];
                        if(count($tmprec['ordertaskmodifiedby']) === 0) $tmprec['ordertaskmodifiedby'] = $tmprec['quotetaskmodifiedby'];
                        if(count($tmprec['ordertaskemployees']) === 0) $tmprec['ordertaskemployees'] = $tmprec['quotetaskemployees'];
                        break;
                    case Menu::ord_type_quote:
                        $tmprec['ordertaskcreatedby'] = $tmprec['quotetaskcreatedby'];
                        $tmprec['ordertaskmodifiedby'] = $tmprec['quotetaskmodifiedby'];
                        $tmprec['ordertaskemployees'] = $tmprec['quotetaskemployees'];
                        break;
                    case Menu::ord_type_invoice:
                        //if empty take from order level [converted invoices]
                        if(count($tmprec['invoicetaskcreatedby']) === 0) $tmprec['invoicetaskcreatedby'] = $tmprec['ordertaskcreatedby'];
                        if(count($tmprec['invoicetaskmodifiedby']) === 0) $tmprec['invoicetaskmodifiedby'] = $tmprec['ordertaskmodifiedby'];
                        if(count($tmprec['invoicetaskemployees']) === 0) $tmprec['invoicetaskemployees'] = $tmprec['ordertaskemployees'];
                        //again if empty take from quote level
                        if(count($tmprec['invoicetaskcreatedby']) === 0) $tmprec['invoicetaskcreatedby'] = $tmprec['quotetaskcreatedby'];
                        if(count($tmprec['invoicetaskmodifiedby']) === 0) $tmprec['invoicetaskmodifiedby'] = $tmprec['quotetaskmodifiedby'];
                        if(count($tmprec['invoicetaskemployees']) === 0) $tmprec['invoicetaskemployees'] = $tmprec['quotetaskemployees'];
                        
                        $tmprec['ordertaskcreatedby'] = $tmprec['invoicetaskcreatedby'];
                        $tmprec['ordertaskmodifiedby'] = $tmprec['invoicetaskmodifiedby'];
                        $tmprec['ordertaskemployees'] = $tmprec['invoicetaskemployees'];
                        break;
                    case Menu::ord_type_void:
                        $tmprec['ordertaskcreatedby'] = $tmprec['voidtaskcreatedby'];
                        $tmprec['ordertaskmodifiedby'] = $rec['voidtaskmodifiedby'];
                        $tmprec['ordertaskemployees'] = $tmprec['voidtaskemployees'];
                        break;
                }
            }
            $result = $fnlresult;
        }
        private function getListsForPaymentCrud(&$rec){
            $except = array();
            $allarsresult = \Account::find('all', array('conditions' => array('accounttype=?', Menu::acc_type_receivables), 'order' => 'party_id asc'));
            foreach ($allarsresult as $allarsrec) {
                 $allarsrecary = $allarsrec->to_array(array('include' => array('party', 'orders'), 'except' => $except));
                 $rec["allars"][] = $allarsrecary;
            }
            $allapsresult = \Account::find('all', array('conditions' => array('accounttype=?', Menu::acc_type_payables), 'order' => 'party_id asc'));
            foreach ($allapsresult as $allapsrec) {
                 $allapsrecary = $allapsrec->to_array(array('include' => array('party', 'ordertasks' => array('include' => array('task','order')), 'orders'), 'except' => $except));
                 $rec["allaps"][] = $allapsrecary;
            }
            $this->getConfigs($rec);
        }
        private function getListsForProductCrud(&$rec){
            $except = array();
            $allcategoriesresult = \Category::find('all', array('conditions' => array(), 'order' => 'name asc'));
            foreach ($allcategoriesresult as $allcategoriesrec) {
                 $allcategoriesrecary = $allcategoriesrec->to_array(array('include' => array('party', 'order'), 'except' => $except));
                 $rec["allcategories"][] = $allcategoriesrecary;
            }
            $rec["allsuppliers"] = array();
            $allsuppliersresult = \Person::find('all', array('conditions' => array('type=?', Menu::ppl_type_supplier), 'order' => 'name asc'));
            foreach ($allsuppliersresult as $allsuppliersrec) {
                 $allsuppliersrecary = $allsuppliersrec->to_array(array('include' => array(), 'except' => $except));
                 $rec["allsuppliers"][] = $allsuppliersrecary;
            }
            $this->getConfigs($rec);
        }
        private function getListsForPurchaseCrud(&$rec, $noproducts = null){
            $except = array();
            $rec["allproducts"] = array();
            $rec["allsuppliers"] = array();
            if($this->enableordrlis){
                $allsuppliersresult = \Person::find('all', array('conditions' => array('type=?', Menu::ppl_type_supplier), 'order' => 'name asc'));
                foreach ($allsuppliersresult as $allsuppliersrec) {
                     $allsuppliersrecary = $allsuppliersrec->to_array(array('include' => array(), 'except' => $except));
                     $rec["allsuppliers"][] = $allsuppliersrecary;
                }
                if(is_null($noproducts) || trim($noproducts) === ''){
                    $allproductsresult = \Product::find('all', array('conditions' => array(), 'order' => 'name asc'));
                    foreach ($allproductsresult as $allprdrec) {
                         $allprdrecary = $allprdrec->to_array(array('include' => array('suppliers'), 'except' => $except));
                         $rec["allproducts"][] = $allprdrecary;
                    }
                }
            }
            $this->getConfigs($rec);
        }        
        private function getListsForAccountCrud(&$rec){
            $except = array();
            $rec["allcustomers"] = array();
            $allcustomersresult = \Person::find('all', array('conditions' => array('type=?', Menu::ppl_type_customer), 'order' => 'name asc'));
            //'customerorders' => array('include' => array('orderproducts'=>array('include'=>array('product'))))
            foreach ($allcustomersresult as $allcustomersrec) {
                 $allcustomersrecary = $allcustomersrec->to_array(array('include' => array('ofcaddresses','customerorders' => array('include' => array('orderproducts'=>array('include'=>array('product')), 'araccounts', 'apaccounts','blngaddresses','shpngaddresses') )), 'except' => $except));
                 $rec["allcustomers"][] = $allcustomersrecary;
            }
            $rec["allcontractors"] = array();
            $allcontractorsresult = \Person::find('all', array('conditions' => array('type=?', Menu::ppl_type_contractor), 'order' => 'name asc'));
            foreach ($allcontractorsresult as $allcontractorrec) {
                 $allcontractorrecary = $allcontractorrec->to_array(array('include' => array('ofcaddresses','externalordertasks' => array('include' => array('accounts','order','task'))), 'except' => $except));
                 $rec["allcontractors"][] = $allcontractorrecary;
            }
            $rec["allsuppliers"] = array();
            $allsplrsresult = \Person::find('all', array('conditions' => array('type=?', Menu::ppl_type_supplier), 'order' => 'name asc'));
            $tmpinclude = array('supplierpurchases'=> array('include' => array('purchaseproducts'=>array('include'=>array('product')), 'araccounts', 'apaccounts') ));
            foreach ($allsplrsresult as $allsplrrec) {
                 $allsplrrecary = $allsplrrec->to_array(array('include' => $tmpinclude, 'except' => $except));
                 $rec["allsuppliers"][] = $allsplrrecary;
            }
            $rec["allemployees"] = array();
            $allempresult = \Person::find('all', array('conditions' => array('type=?', 'employee'), 'order' => 'name asc'));
            foreach ($allempresult as $allemprec) {
                 $allemprecary = $allemprec->to_array(array('except' => $except));
                 $rec["allemployees"][] = $allemprecary;
            }
            $this->getAllOrders($rec, $except);
            $rec["allordertasks"] = array();
            $allordertasksresult = \Ordertask::find('all', array('conditions' => array(), 'order' => 'order_id, task_id asc'));
            foreach ($allordertasksresult as $allordertasksrec) {
                 $allordertasksrecary = $allordertasksrec->to_array(array('except' => $except));
                 $rec["allordertasks"][] = $allordertasksrecary;
            }
            $this->getConfigs($rec);
        }
        private function getAllOrders(&$rec, $except){
            $rec["allorders"] = array();
            $include = array('shpngaddresses');
            $allordersresult = \Order::find('all', array('conditions' => array('type=? AND id!=1', Menu::ord_type_order), 'order' => 'name asc'));
            foreach ($allordersresult as $allordersrec) {
                 $allordersrecary = $allordersrec->to_array(array('include' => $include, 'except' => $except));
                 $rec["allorders"][] = $allordersrecary;
            }
        }
        private function getListsForOrderTaskCrud(&$rec){
            $except = array();
            $rec["alltasks"] = array();
            $alltasksresult = \Task::find('all', array('conditions' => array(), 'order' => 'name asc'));
            foreach ($alltasksresult as $alltskrec) {
                 $alltskrecary = $alltskrec->to_array(array('except' => $except));
                 $rec["alltasks"][] = $alltskrecary;
            }
            $this->getAllOrders($rec, $except);            
            $allcontractorsresult = \Person::find('all', array('conditions' => array('type=?', Menu::ppl_type_contractor), 'order' => 'name asc'));
            foreach ($allcontractorsresult as $allcontractorsrec) {
                 $allcontractorsrecary = $allcontractorsrec->to_array(array('include' => array(), 'except' => $except));
                 $rec["allcontractors"][] = $allcontractorsrecary;
            }
            $this->getConfigs($rec);
        }
        private function getOrderslkuplist(&$rec){
            $except = array();
            $this->getAllOrders($rec, $except);
        }
        private function getListsForOrderCrud($whowantsid, $whowantstype, &$rec, $noproducts = null){//for order crud purpose
            $except = array();
            $rec["allproducts"] = array();
            if($this->enableordrlis && (is_null($noproducts) || trim($noproducts) === '')){
                $allproductsresult = \Product::find('all', array('conditions' => array(), 'order' => 'name asc'));
                foreach ($allproductsresult as $allprdrec) {
                     $allprdrecary = $allprdrec->to_array(array('except' => $except));
                     $rec["allproducts"][] = $allprdrecary;
                }
            }
            $rec["alltasks"] = array();
            if($this->enableordrtasks){
                $alltasksresult = \Task::find('all', array('conditions' => array(), 'order' => 'name asc'));
                foreach ($alltasksresult as $alltskrec) {
                     $alltskrecary = $alltskrec->to_array(array('except' => $except));
                     $rec["alltasks"][] = $alltskrecary;
                }
            }
            $this->getAllOrders($rec, $except);
            $rec["allcontractors"] = array();
            $allcontractorsresult = \Person::find('all', array('conditions' => array('type=?', Menu::ppl_type_contractor), 'order' => 'name asc'));
            foreach ($allcontractorsresult as $allcontractorsrec) {
                 $allcontractorsrecary = $allcontractorsrec->to_array(array('include' => array(), 'except' => $except));
                 $rec["allcontractors"][] = $allcontractorsrecary;
            }
            $rec["allemployees"] = array();
            $allempresult = \Person::find('all', array('conditions' => array('type=?', 'employee'), 'order' => 'name asc'));
            foreach ($allempresult as $allemprec) {
                 $allemprecary = $allemprec->to_array(array('except' => $except));
                 $rec["allemployees"][] = $allemprecary;
            }
            $rec["allcustomers"] = array();
            $custcondn = array('type=?', Menu::ppl_type_customer);
            if($whowantstype === Menu::ppl_type_customer){
                $custcondn = array('id=? and type=?', $whowantsid, Menu::ppl_type_customer);
            }
            $allcustresult = \Person::find('all', array('conditions' => $custcondn, 'order' => 'name asc'));
            foreach ($allcustresult as $allcustrec) {
                 $allcustrecary = $allcustrec->to_array(array('include' => array('allpersonaddresses','orderrltdaddresses'), 'except' => $except));
                 $allcustrecary["custalladdresses"] = array_merge($allcustrecary["allpersonaddresses"], $allcustrecary["orderrltdaddresses"]);
                 $rec["allcustomers"][] = $allcustrecary;
            }
            $this->getConfigs($rec);
        }
        private function getProducts($wantedid, $wantedtype, $whowantsid, $whowantstype){
            $isperm = false;
            $conditions = array();
            if($wantedid > 0){
                $tmpcondition = array('id=?',$wantedid);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            $iscategoryjoin = $wantedtype !== '';
            if($iscategoryjoin){
                $rltnconditions = array('productcategories.category_id=?', $wantedtype);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            
            $peoplejoin = ($whowantstype !== Menu::ppl_type_admin && !$isperm);
            if($peoplejoin){
                $rltnconditions = array('productpeople.person_id=? AND productpeople.type IN (?)', $whowantsid, array($whowantstype));
                \ActiveRecord\Utils::add_condition($conditions, $rltnconditions);
            }
            $joins = '';
            if($peoplejoin){
                $joins .= ' JOIN orderpeople on orders.id = orderpeople.order_id';
            }
            if($iscategoryjoin){
                $joins .= ' JOIN productcategories on products.id = productcategories.product_id';
            }

            $optionsAry =  array(
                            'conditions' => $conditions
                            , 'order' => 'name asc'
                            );
            if(trim($joins) !== ''){
                $optionsAry['joins'] = array($joins);
            }
            $isqryoffset = isset($this->qryoffset) && $this->qryoffset >= 0;
            $isqrylimit = isset($this->qrylimit) && $this->qrylimit >= 0;
            if($isqryoffset && $isqrylimit){
                $optionsAry['limit'] = $this->qrylimit;
                $optionsAry['offset'] = $this->qryoffset;
            }if(!$isqryoffset && $isqrylimit){
                $optionsAry['limit'] = $this->qrylimit;
            }
            $result = \Product::find('all', $optionsAry);
            $except = array();
            $include = array('categories','suppliers');
            try{
                foreach ($result as &$rec) {
                    $rec = $rec->to_array(array('include' => $include, 'except' => $except));
                }
            }catch(Exception $e){
                 $this->log->debug('Exception occured.');
            }
            return $result;
        }
        private function getPurchases($wantedid, $wantedtype, $whowantsid, $whowantstype){
            $isperm = false;
            $conditions = array();
            if($wantedid > 0){
                $tmpcondition = array('id=?',$wantedid);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }            
            if($wantedtype !== ''){
                $tmpcondition = array('purchase_number=?',$wantedtype);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);
            }
            if(($whowantstype !== Menu::ppl_type_admin && !$isperm)){
                //whatever id, status been asked give if they are their related orders only                
                $tmpcondition = array('person_id=?', $whowantsid);
                \ActiveRecord\Utils::add_condition($conditions, $tmpcondition);   
            }
            $result = \Purchase::find('all', array('conditions' => $conditions, 'order' => 'purchase_at desc'));            
            
            $except = array();
            $include = array('purchaseproducts' => array('include' => array('product')));
            foreach ($result as &$rec) {
                $rec = $rec->to_array(array('include' => $include, 'except' => $except));
            }
            return $result;
        }
        private function getMyHeaders(){
            $headers = '';
            foreach ($_SERVER as $name => $value)
            {
                if (substr($name, 0, 5) == 'HTTP_')
                {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
           return $headers;
        }
        private function parseRequestHeaders() {
            $headers = array();
            foreach($_SERVER as $key => $value) {
                if (substr($key, 0, 5) <> 'HTTP_') {
                        continue;
                }
                $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
                $headers[$header] = $value;
            }
            return $headers;
        }
        private function getHashId(){
            $hash_id = null;
            //$hash_id = $this->getMyHeaders()['hash_id']; - Notworking at all
            //1 for localhost[windows7] 2 for server[linux]
            // getallheaders() not working in server
            // $this->request()->headers('hash_id') not working in localhost
            //             
//            if($this->hdrs_fetch_method === '1'){
//                $hash_id = getallheaders()['hash_id'];
//            }else{
//                $hash_id = $this->request()->headers('hash_id');
//            }
            $hash_id = $this->request()->headers('hash_id');//1st try
            if(!isset($hash_id)){
                //$this->log->debug("request()->headers not worked");
                $headers = getallheaders();//2th try[actually alias for apache_request_headers                
                if(!isset($headers['hash_id']))
                {
                    //$this->log->debug("getallheaders not worked");
                    $headers = apache_request_headers();//3rd try                    
                    if(!isset($headers['hash_id']))
                    {
                        //$this->log->debug("apache_request_headers not worked");
                        $headers = $this->parseRequestHeaders();//4th try                                    
                        if(!isset($headers['hash_id']))
                        {
                            //$this->log->debug("parseRequestHeaders not worked");
                        }else{
                            //$this->log->debug("parseRequestHeaders worked");
                            $hash_id = $headers['hash_id'];
                        }
                    }else{
                        //$this->log->debug("apache_request_headers worked");
                        $hash_id = $headers['hash_id'];
                    }
                }else{
                    //$this->log->debug("getallheaders worked");
                    $hash_id = $headers['hash_id'];
                }
            }else{
                //$this->log->debug("request()->headers worked");
            }
            return $hash_id;
        }
        private function authenticate(){
            $hash_id = $this->getHashId();
            if(!isset($hash_id))
            {
                $data = array();
                $rtnCode = Menu::app_InvalidUserPassword;                        
                $message = "Unautherized user[hashmissing].";        
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                echo $data;
                return false;
            }
            $configOk = $this->setConfigsFromDB();
            if(!$configOk)
            {
                $data = array();
                $rtnCode = Menu::InternalServerError;
                $message = "Invalid Config.";
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                echo $data;
                return false;
            }
            $logindata = \Login::find('all', array('conditions' => array('hash_id=?', $hash_id)));
            $persondata = \Person::find('all', array('conditions' => array('id=?', $logindata[0]->person_id)));
            if((count($logindata) !== 1 || $logindata[0]->person_id <= 0)
                    || count($persondata) !== 1
            ){
                $data = array();
                $rtnCode = Menu::app_InvalidUserPassword;
                $message = "Unautherized user[wrong hash].";
                $data = json_encode(array('RetCode' => $rtnCode, 'data' => $data, 'message' => $message));
                echo $data;
                return false;
            }
            $person = array();
            $person["id"] = $persondata[0]->id;
            $person["type"] = $persondata[0]->type;
            return $person;
        }
        private function checkLogin($postedData, &$rtnarray, $ismbllogin){
            try{
                $logindata = \Login::find('all', array('conditions' => array('login=?', $postedData->login)));                
                if(count($logindata) != 1 || !$logindata[0]){
                    $rtnarray['RetCode'] = Menu::app_InvalidUserPassword;
                    $rtnarray['message'] = "Login not found";//$this->response()->getMessageForCode(Menu::Forbidden);
                    //"Given :" . count($logindata) . ":" + $postedData->login . "::::" . $postedData->pass . ":::";//
                }else{
                    $logindata = $logindata[0];
                    $ispassok = false;
                    if(!isset($postedData->isPassencoded))
                        $postedData->isPassencoded = 1;
                    if($postedData->isPassencoded === 1){
                        $salt = "d30bd965c0e92fae88258a8defa365ea415ed907";
                        $ispassok = $logindata->pass === $postedData->pass.'$'.$salt;
                    }else{
                        list($stored_pw, $stored_salt) = explode('$', $logindata->pass);
                        $ispassok = ($stored_pw === sha1($postedData->login.$postedData->pass.$stored_salt));
                    }
                    if($ispassok) {
                        $userdata = \Person::find($logindata->person_id);
                        $rec = array();
                        $rec['user']['id'] = $logindata->person_id;
                        $rec['user']['hash_id'] = $logindata->hash_id;
                        $rec['user']['login'] = $logindata->login;
                        $rec['user']['role'] = $userdata->type;
                        $rec['user']['geo_update_frq'] = $userdata->geo_update_frq;
                        if(!$ismbllogin){
                            $this->getConfigs($rec);
                        }
                        $rtnarray['data'] = $rec;
                        $rtnarray['RetCode'] = Menu::app_OK;
                        $rtnarray['message'] = "Login Success";
                        $this->setStatusMap(1);//1 is for orders
                        $this->checkAndSendMSAlertMail();
                    }else{
                        $rtnarray['RetCode'] = Menu::app_InvalidUserPassword;
                        $rtnarray['message'] = "Wrong password";
                    }
                }
            }
            catch (\ActiveRecord\DatabaseException $ex) {
                $rtnarray['RetCode'] = Menu::app_UnableToProcess;
                $rtnarray['message'] = "Unable able to process your request.";
                $this->log->debug($ex->getMessage());
            }
            catch (\Slim\Exception $ex) {
                $message = "Internal server error.";
                $rtnarray['RetCode'] = Menu::InternalServerError;
                $rtnarray['message'] = $message;
            }
            catch (\Exception $ex) {
                $message = "Internal server error.";
                $rtnarray['RetCode'] = Menu::InternalServerError;
                $rtnarray['message'] = $message;
            }
        }
        private function setStatusMap($ofwhich){
            //getting statuses from db;
            //statusMap array[key(ofwhichid-1-orders,2-ordertasks etc.,), array[key(statusnmae), value(stsordinalnumber)]
            $condition = array('ofwhich=?', $ofwhich);
            $result = \Statusmaster::find('all', array('conditions' => $condition));
            $stsarray = array();
            $fldnumber = 1;
            foreach ($result as &$rec) {
                $stsarray[$rec->name] = $fldnumber++;
            }
            $this->statusMap[$ofwhich] = $stsarray;
        }
        private function getStatusFieldFromName($ofwhich, $statusname, &$higherflds = array()){
            $this->setStatusMap($ofwhich);
            $statuses = $this->statusMap[$ofwhich];
            $countofstatuses = count($statuses);
            if(is_null($statuses)){
                $stsfld = null;
            }else{
                if($statusname === Menu::sts_delivered) $statusname = Menu::sts_closed;
                $stsfld = $statuses[$statusname];
                if(isset($stsfld)){
                    $num = $stsfld;
                    $stsfld = 'status' . $stsfld . 'dt';
                    $higherflds = array();
                    for($i = $num + 1; $i <= $countofstatuses; $i++){
                        $higherflds[] = 'status' . $i . 'dt';
                    }
                }
            }
            return $stsfld;
        }
        private function updatestatushistory($ofwhich, $ofwhichid, $statusname, $statusdt){//1 -order 2- ordertask etc.,
            $higherflds = array();
            $stsfldtoupdate = $this->getStatusFieldFromName($ofwhich, $statusname, $higherflds);
            if(is_null($stsfldtoupdate))
            {
                return;
            }
            $condition = array('ofwhich_id=?', $ofwhichid);
            $result = \Statushistory::find('all', array('conditions' => $condition));
            $attributes = array(
                    "$stsfldtoupdate" => $statusdt                    
                    );
            foreach($higherflds as $higerfld){
                $attributes["$higerfld"] = null;
            }
            if(isset($result) && count($result) > 0){
                $recid = isset($result[0]->id)?$result[0]->id:-1;
                try{
                    $data = \Statushistory::find($recid);
                }catch (\ActiveRecord\RecordNotFound $ex) {
                    $data = null;
                }
                if(!is_null($data)){
                    $data->update_attributes($attributes);
                }
            }else{
                $attributes["ofwhich_id"] = $ofwhichid;
                $data = \Statushistory::create($attributes);
            }
        }
        private function checkAndSendMSAlertMail(){
            if(!$this->enableordermilestones) return;
            $alertms = array();
            $msresult = $this->getMilestonesForAlertMail(-1, 'latest', $alertms);
            if(count($alertms)>0){
                $this->prepareMailForMSAlert($alertms, $msresult);
            }
        }
        private function getConfigs(&$rec){
            $appconfigs = array(
                                "enableordrlis" => $this->enableordrlis
                                ,"enableordrtasks" => $this->enableordrtasks
                                ,"enableordrtaskpeople" => $this->enableordrtaskpeople
                                ,"enableordrpayments" => $this->enableordrpayments
                                ,"enableordermilestones" => $this->enableordermilestones
                                ,"ordercostamountfrom" => $this->ordercostamountfrom
                                ,"ordertaskcostamountfrom" => $this->ordertaskcostamountfrom
                                ,"enablediscount" => $this->enablediscount
                                ,"orderdiscfor" => $this->orderdiscfor
                                ,"directorder" => $this->directorder
                                ,"directinvoice" => $this->directinvoice
                                ,"isinlineotentry" => $this->isinlineotentry
                                ,"isinlinemsentry" => $this->isinlinemsentry
                                ,"enableordrdn" => $this->enableordrdn
                                ,"discentry" => $this->discentry
                                ,"enableexpctdstartdt"=> $this->enableexpctdstartdt
                                ,"enableexpctdenddt"=> $this->enableexpctdenddt
                                ,"enableordername"=> $this->enableordername
                                ,"enableprdauxname"=> $this->enableprdauxname
                                ,"enablepplauxname"=> $this->enablepplauxname
                                ,"enablecontact"=> $this->enablecontact
                                ,"enablepurchase"=> $this->enablepurchase
                                ,"enablestock"=> $this->enablestock
                                ,"enablelocality"=> $this->enablelocality
                                ,"enablecity"=> $this->enablecity
                                ,"enablestate"=> $this->enablestate
                                ,"enablecountry"=> $this->enablecountry
                                ,"enabletax"=> $this->enabletax
                                ,"enableinlinepayments"=> $this->enableinlinepayments
                                ,"sptype"=> $this->sptype
                                ,"isordridauto"=> $this->isordridauto                    
                                ,"moperinvoice"=> $this->moperinvoice
                                ,"ispplcodeauto" => $this->ispplcodeauto
                                ,"iscustcodeauto" => $this->iscustcodeauto
                                ,"issplrcodeauto" => $this->issplrcodeauto
                                ,"isprdcodeauto" => $this->isprdcodeauto
                                ,"invsurcharge" => $this->invsurcharge);
            $rec['appconfigs'][] = $appconfigs;
        }
        private function setConfigsFromDB(){
            $result = \Config::find('all', array('conditions' => array()));
            foreach ($result as &$rec) {
                switch($rec->config_key){
                    case 'enableordrlis':
                        $this->enableordrlis = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enableordrtasks':
                        $this->enableordrtasks = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enableordrtaskpeople':
                        $this->enableordrtaskpeople = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enableordrpayments':
                        $this->enableordrpayments = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enableordermilestones':
                        $this->enableordermilestones = (($rec->config_val === '1')?true:false);
                    break;
                    case 'ordercostamountfrom':
                        $this->ordercostamountfrom = ((is_numeric($rec->config_val))?(int)$rec->config_val:null);
                    break;
                    case 'ordertaskcostamountfrom':
                        $this->ordertaskcostamountfrom = ((is_numeric($rec->config_val))?(int)$rec->config_val:null);
                    break;
                    case 'enablediscount':
                        $this->enablediscount = (($rec->config_val === '1')?true:false);
                    break;
                    case 'orderdiscfor':
                        $this->orderdiscfor = ((is_numeric($rec->config_val))?(int)$rec->config_val:null);
                    break;
                    case 'enableordername':
                        $this->enableordername = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enableprdauxname':
                        $this->enableprdauxname = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enablepplauxname':
                        $this->enablepplauxname = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enablecontact':
                        $this->enablecontact = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enablepurchase':
                        $this->enablepurchase = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enablestock':
                        $this->enablestock = (($rec->config_val === '1')?true:false);
                    break;                
                    case 'enablelocality':
                        $this->enablelocality = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enablecity':
                        $this->enablecity = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enablestate':
                        $this->enablestate = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enablecountry':
                        $this->enablecountry = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enabletax':
                        $this->enabletax = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enableinlinepayments':
                        $this->enableinlinepayments = (($rec->config_val === '1')?true:false);
                    break;
                    case 'sptype':
                        $this->sptype = ((is_numeric($rec->config_val))?(int)$rec->config_val:0);
                    break;
                    case 'isordridauto':
                        $this->isordridauto = ((is_numeric($rec->config_val))?(int)$rec->config_val:0);
                    break;
                    case 'moperinvoice':
                        $this->moperinvoice = (($rec->config_val === '1')?true:false);
                    break;
                    case 'ispplcodeauto':
                        $this->ispplcodeauto = ((is_numeric($rec->config_val))?(int)$rec->config_val:0);
                    break;
                    case 'iscustcodeauto':
                            $this->iscustcodeauto = ((is_numeric($rec->config_val))?(int)$rec->config_val:0);
                        break;
                    case 'issplrcodeauto':
                            $this->issplrcodeauto = ((is_numeric($rec->config_val))?(int)$rec->config_val:0);
                        break;
                    case 'isprdcodeauto':
                            $this->isprdcodeauto = ((is_numeric($rec->config_val))?(int)$rec->config_val:0);
                        break;
                    case 'daystocheckfordue':
                        $this->daystocheckfordue = ((is_numeric($rec->config_val))?(int)$rec->config_val:null);
                    break;
                    case 'daystocheckforoverdue':
                        $this->daystocheckforoverdue = ((is_numeric($rec->config_val))?(int)$rec->config_val:null);
                    break;
                    case 'taskppltax':
                        $this->taskppltax = ((is_numeric($rec->config_val))?(int)$rec->config_val:null);
                    break;
                    case 'directorder':
                        $this->directorder = (($rec->config_val === '1')?true:false);
                    break;
                    case 'directinvoice':
                        $this->directinvoice = (($rec->config_val === '1')?true:false);
                    break;
                    case 'isinlineotentry':
                        $this->isinlineotentry = (($rec->config_val === '1')?true:false);
                    break;
                    case 'isinlinemsentry':
                        $this->isinlinemsentry = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enableordrdn':
                        $this->enableordrdn = (($rec->config_val === '1')?true:false);
                    break;
                    case 'discentry':
                        $this->discentry = ((is_numeric($rec->config_val))?(int)$rec->config_val:null);
                    break;
                    case 'enableexpctdstartdt':
                        $this->enableexpctdstartdt = (($rec->config_val === '1')?true:false);
                    break;
                    case 'enableexpctdenddt':
                        $this->enableexpctdenddt = (($rec->config_val === '1')?true:false);
                    break;                    
                }
            }
            if(is_null($this->enableordrlis)
                    || is_null($this->enableordrtasks)
                    || is_null($this->enableordrtaskpeople)
                    || is_null($this->enableordrpayments)
                    || is_null($this->enableordermilestones)
                    || is_null($this->ordercostamountfrom)
                    || is_null($this->ordertaskcostamountfrom)
                    || is_null($this->enablediscount)
                    || is_null($this->orderdiscfor)
                    || is_null($this->enableordername)
                    || is_null($this->enableprdauxname)
                    || is_null($this->enablepplauxname)
                    || is_null($this->enablecontact)
                    || is_null($this->enablepurchase)
                    || is_null($this->enablestock)
                    || is_null($this->enablelocality)
                    || is_null($this->enablecity)
                    || is_null($this->enablestate)
                    || is_null($this->enablecountry)
                    || is_null($this->enabletax)
                    || is_null($this->enableinlinepayments)
                    || is_null($this->sptype)
                    || is_null($this->isordridauto)
                    || is_null($this->moperinvoice)
                    || is_null($this->ispplcodeauto)
                    || is_null($this->iscustcodeauto)
                    || is_null($this->issplrcodeauto)
                    || is_null($this->isprdcodeauto)
                    || is_null($this->daystocheckfordue)
                    || is_null($this->daystocheckforoverdue)
                    || is_null($this->taskppltax)
                    || is_null($this->directorder)
                    || is_null($this->directinvoice)
                    || is_null($this->isinlineotentry)
                    || is_null($this->isinlinemsentry)
                    || is_null($this->enableordrdn)
                    || is_null($this->discentry)
                    || is_null($this->enableexpctdstartdt)
                    || is_null($this->enableexpctdenddt)
            ){
                return false;
            }
            return true;
        }
        private function testLogins(){
            $salt = "d30bd965c0e92fae88258a8defa365ea415ed907";
            $a = sha1('admin'.'admin'.$salt);
            $b = sha1('employee1'.'test'.$salt);
            $c = sha1('employee2'.'test'.$salt);
            $d = sha1('employee3'.'test'.$salt);
            $e = sha1('customer1'.'test'.$salt);
            $f = sha1('customer2'.'test'.$salt);
        }
}