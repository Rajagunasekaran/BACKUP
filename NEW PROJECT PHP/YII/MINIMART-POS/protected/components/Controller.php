<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array( );
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array( );
    public $subTitle = 'Title';
    protected $assetsBase;
    protected $imageRealPath;
    protected $imagePath;    
    public $appId;
    public $appMenuIDs;
    public $menuIDs;
    public $menuURLs;
    public $menuIcons;
    public $appViews;
    public $appRoles;
    public $appLayouts;
    public $appFormFields;
    public $appRedirects;
    public $controllerID;
    public $appSecurityStatus;
    public $isARCPermitted; //admin people of admin role creation
    public $dfltRole;
    public $appConfigKeys;
    public $statusNameToIdMap;
    
    public $page_load_delay_ms;
    public $db_auto_refresh_freq;
    public $db_auto_refresh;
    public $pos_auto_refresh;
    public $pos_prdsupdate_freq;
    public $pdfobj = null;
    public $mobileUser = null;
    
    public $cJuiDatePickerViewFormat = 'dd/mm/yy';//used in view control cJuiDatePicker
    public $boosterTbDateRangePickerFormat = 'DD/MM/YYYY H:mm';//case sensitive
    public $boosterTbDateRangePickerFormatHMS = 'DD/MM/YYYY H:mm:ss';
    public $boosterTbGVFormat = "d/MM/y";
    public $DDMMYYYY = 'DD/MM/YYYY';
    //
    //used when convertion using php date() function
    public $datetimemysqlformatDMY = 'd/m/Y';
    public $datetimemysqlformatYMD = 'Y-m-d';
    public $datetimemysqlformatYMDHIS = 'Y-m-d H:i:s';
    public $datetimemysqlformatDMYHI = 'd/m/Y H:i:s';
    
    public $ordertypes;
    public $addresstypes;  
    public $deliveryTypes;
    public $serviceTypes;
    public $surchargeTypes;
    public $orderInvStatuses;
    public $accountTypes;
    public $paymentDirections;
    
    public $statusToHistoryFieldsMap;
    public $statusHistoryFieldToStatusesMap;
    public $splseachStrings;
    public $reportsGroupbyStrings;
    public $paidstatuss;
    public $gmapLabelStyle;
    public $gmapPolylineColor = '#FF0000';
    
    public $curYear;
    public $curMonth;
    public $salt = "d30bd965c0e92fae88258a8defa365ea415ed907";
    public $paymenttypes;
    public function init()
    {
        $this->pageTitle = Yii::app()->params['name'];
        $this->controllerID = Yii::app()->controller->uniqueID;
        $this->appId = Yii::app()->params['appID'];
        $this->appConfigKeys = Yii::app()->params['appConfigKeys'];
        $rolesMap = Yii::app()->params['rolesMap'];
        $this->appRoles = $rolesMap[$this->appId];
        $this->isARCPermitted = false;
        $this->dfltRole = Helper::CONST_Employee;
        $this->splseachStrings = array(Helper::CONST_ALL, Helper::CONST_Today,  Helper::CONST_Yesterday, Helper::CONST_DayBeforeYesterday);
        $this->reportsGroupbyStrings = array(Helper::CONST_Product, Helper::CONST_Category, Helper::CONST_Supplier,  Helper::CONST_Customer);
        $this->paidstatuss = array(Helper::CONST_ALL,Helper::CONST_Paid, Helper::CONST_OnAccount);
        $this->curYear = date('Y');
        $this->curMonth = date('m');
        $this->paymenttypes = array ( Helper::CONST_Cash, Helper::CONST_MasterVisa,
            Helper::CONST_Nets, );
        
        if(  strtolower( $this->controllerID) !== strtolower(Helper::CONST_mobilecontrollerid))
        {
            $this->setupApplicationSettings();
        }
        parent::init();
    }
    private function setupApplicationSettings()
    {
        $this->page_load_delay_ms = Helper::CONST_page_load_delay_ms;
        $this->db_auto_refresh_freq = Helper::CONST_db_auto_refresh_freq * 60 * 1000;
        $this->db_auto_refresh = Helper::CONST_db_auto_refresh;
        $this->pos_auto_refresh = Helper::CONST_pos_auto_refresh;
        $this->pos_prdsupdate_freq = Helper::CONST_pos_prdsupdate_freq * 60 * 1000;
        if ( !isset( $this->appId ) || Yii::app()->user->isGuest )
        {
            Yii::app()->theme = Yii::app()->params['logintheme'];                
        }
        else
        {
            Yii::app()->theme = Yii::app()->params['maintheme']; //for classic & default                
        }
        $baseUrl = Yii::app()->request->baseUrl;            
        //$this->assetsBase = $_SERVER["DOCUMENT_ROOT"] . Yii::app()->booster->getAssetsUrl();
        if ( !is_null( Yii::app()->theme ) )
        {
            $this->assetsBase = $_SERVER["DOCUMENT_ROOT"] . Yii::app()->theme->baseUrl . '/assets';
        }
        else
        {
            $this->assetsBase = $_SERVER["DOCUMENT_ROOT"] . $baseUrl;
        }
        $this->imagePath = $baseUrl . Yii::app()->params['imagePath'];
        $this->imageRealPath = $_SERVER["DOCUMENT_ROOT"] . $this->imagePath;
        $this->menuIDs = Yii::app()->params['menuIDs'];
        $this->menuURLs = Yii::app()->params['menuURLs'];
        //$this->menuIcons = Yii::app()->params['menuIcons'];
        $this->menuIcons = array(//ordinally matched with $menuIDs array
"<img src=''>"
,"<i class='fa iconfa-signout'></i>"
,"<i class='fa iconfa-signout'></i>"
,"<i class='fa iconfa-signout'></i>"
,"<img src=''>"
,"<i class='fa iconfa-signout'></i>"
,"<img src='$baseUrl/css/images/jobs.png'>"
,"<img src='$baseUrl/css/images/schedule.png'>"
,"<img src='$baseUrl/css/images/users.png'>"
,"<i class='fa iconfa-signout'></i>"
,"<i class='fa iconfa-signout'></i>"
,"<i class='fa iconfa-signout'></i>"
,"<img src='$baseUrl/css/images/invoice.png'>"
,"<i class='fa iconfa-signout'></i>"
,"<i class='fa iconfa-signout'></i>"
,"<i class='fa iconfa-signout'></i>"
,"<i class='fa iconfa-signout'></i>"
,"<i class='fa iconfa-signout'></i>"
,"<i class='fa iconfa-signout'></i>"
,"<i class='fa iconfa-signout'></i>"
,"<i class='fa iconfa-signout'></i>"
,array("<i class='fa iconfa-signout'></i>"
        ,array(
            "<i class='fa iconfa-signout'></i>"
            ,"<i class='fa iconfa-signout'></i>"
            ,"<i class='fa iconfa-signout'></i>"
        )
)
,array("<i class='fa iconfa-signout'></i>"
        ,array(
            "<i class='fa iconfa-signout'></i>"
            ,"<i class='fa iconfa-signout'></i>"
            ,"<i class='fa iconfa-signout'></i>"
            ,"<i class='fa iconfa-signout'></i>"
        )
)
);
        $menuMap = Yii::app()->params['menuMap'];
        $this->appMenuIDs = $menuMap[$this->appId];
        $viewsMap = Yii::app()->params['viewsMap'];
        $this->appViews = $viewsMap[$this->appId];            
        $layoutsMap = Yii::app()->params['layoutsMap'];
        $this->appLayouts = $layoutsMap[$this->appId];
        $formFieldsMap = Yii::app()->params['formFieldsMap'];
        $this->appFormFields = $formFieldsMap[$this->appId];
        $appRedirectsMap = Yii::app()->params['appRedirectsMap'];
        $this->appRedirects = isset($appRedirectsMap[$this->appId])?$appRedirectsMap[$this->appId]:array();

        $this->ordertypes = array(Helper::CONST_Quote,Helper::CONST_Order,);
        $this->addresstypes = array(Helper::CONST_addrtype_Office,Helper::CONST_addrtype_Residence,Helper::CONST_addrtype_Other,);

        $this->deliveryTypes = array(Helper::CONST_dlvrtype_Delivery,Helper::CONST_dlvrtype_Collect,Helper::CONST_dlvrtype_2_Way,Helper::CONST_dlvrtype_Others,);
        $this->serviceTypes = array(Helper::CONST_srvctype_EXPHalf,Helper::CONST_srvctype_EXPOne,
            Helper::CONST_srvctype_UrgentTwo,Helper::CONST_srvctype_UrgentThree,
            Helper::CONST_srvctype_UrgentFour,Helper::CONST_srvctype_Normal,
            Helper::CONST_srvctype_LateHrs,
            );
        $this->surchargeTypes = array(Helper::CONST_sctype_Envelope,Helper::CONST_sctype_Tube,
            Helper::CONST_sctype_Carton,Helper::CONST_sctype_Oversize,
            Helper::CONST_sctype_Overweight,                
            );
        $this->orderInvStatuses = array(Helper::CONST_INVSTS_UNINVOICED,Helper::CONST_INVSTS_INVOICED,);
        $this->accountTypes = array(Helper::CONST_Receivables,Helper::CONST_Payables,);
        $this->paymentDirections = array(Helper::CONST_Inwards,Helper::CONST_Outwards,);
        $this->gmapLabelStyle = array(
                              'backgroundColor'=>'yellow',
                              'opacity'=>'0.75',
                              'width'=>'100px',
                              'color'=>'blue',
                              'border' => '2px solid black',  
                              'font-family' => '"Lucida Grande", "Arial", sans-serif',
                              'font-size' => '12px',
                              'font-weight' => 'bold',
                              'text-align' => 'center',
                              'opacity' => '0.75',
                              'white-space' => 'nowrap',
                            );            
        if ( isset( $this->appId ) && !Yii::app()->user->isGuest )
        {
            $this->layout = $this->appLayouts['main'];
            $this->setStatusNameToIdMap();
            $this->setStatusToHistoryFieldsMap(1);
            $this->setStatusHistoryFieldToStatusesMap(1);
        }
        else
        {
            $this->layout = $this->appLayouts['login'];
        }
    }
    public function setAllLookupsInState()
    {
        Yii::app()->controller->setStatusesLookupInState();
        Yii::app()->controller->setRolesLookupInState();
        Yii::app()->controller->setRootCategoriesLookupInState();
        Yii::app()->controller->setCategoriesLookupInState();
        Yii::app()->controller->setProductsLookupInState();
        Yii::app()->controller->setTaxratesLookupInState();
        Yii::app()->controller->setPeopleLookupInState(Helper::CONST_Manager);
        Yii::app()->controller->setPeopleLookupInState(Helper::CONST_Employee);
        Yii::app()->controller->setPeopleLookupInState(Helper::CONST_Customer);
        Yii::app()->controller->setPeopleLookupInState(Helper::CONST_Contractor);
        Yii::app()->controller->setPeopleLookupInState(Helper::CONST_Supplier);
    }
    public function setStatusesLookupInState()
    {
        $statuses = Statusmaster::model()->findAll(array('condition'=>'ofwhich = 1'));        
        $statuses = CHtml::listData($statuses, 'id', 'display');
        Yii::app()->user->setState('orderstatuses', $statuses);
        
        $statuses = Statusmaster::model()->findAll(array('condition'=>'ofwhich = 2'));        
        $statuses = CHtml::listData($statuses, 'id', 'display');
        Yii::app()->user->setState('taskstatuses', $statuses);
        $this->setStatusNameToIdMap();
        $this->setStatusToHistoryFieldsMap(1);
        $this->setStatusHistoryFieldToStatusesMap(1);
    }
    public function setStatusNameToIdMap()
    {
        $this->statusNameToIdMap = array();
        $this->statusNameToIdMap[1] = array();	
        $statuses = Statusmaster::model()->findAll(array('condition'=>'ofwhich = 1'));
        foreach($statuses as $status)
        {
            $this->statusNameToIdMap[1][strtolower($status->name)] = $status->id;
        }

        $statuses = Statusmaster::model()->findAll(array('condition'=>'ofwhich = 2'));   
        $this->statusNameToIdMap[2] = array();
        foreach($statuses as $status)
        {
            $this->statusNameToIdMap[2][strtolower($status->name)] = $status->id;
        }  
    }
    public function getStatusIdFromName($statusname, $ofwhich = 1)
    {
        if(empty($this->statusNameToIdMap[$ofwhich])) return null;
//        $arraykeys = array_keys($this->statusNameToIdMap[$ofwhich],strtolower($statusname));
//        if(empty($arraykeys)) return null;
//        return $this->statusNameToIdMap[$ofwhich][$statusname];
        $statusid = !empty($this->statusNameToIdMap[$ofwhich][strtolower($statusname)]);
        $statusid= ($statusid?$this->statusNameToIdMap[$ofwhich][strtolower($statusname)]:null);
        return $statusid;
    }
    public function setRolesLookupInState($includeInactive = false)
    {
        $cndn = 'LCASE(role)!=LCASE(:suRole)';
        $params = array();
        $params[':suRole'] = Helper::CONST_SU;
        if(!$includeInactive)
        {
            $cndn .= ' AND status=:status';
            $params[':status'] = 1;
        }
        
        $roles = Role::model()->findAll(array('condition'=> $cndn,
                                              'params' => $params));
        $fltdroles = array();
        foreach($roles as $role)
        {
            if(isset($this->appRoles[$role->role])
                    && ($role->role !== Helper::CONST_Admin
                            || $this->isARCPermitted)
            )
            {
               $role->role = $this->appRoles[$role->role];
               $fltdroles[] = $role; 
            }
        }
        $fltdroles = CHtml::listData($fltdroles, 'id', 'role');
        Yii::app()->user->setState('companyroles', $fltdroles);
    }
    public function setRootCategoriesLookupInState()
    {
        $categories = Category::model()->findAll('parent_id=0 and status=1');
        $categories = CHtml::listData($categories, 'id', 'name');
        Yii::app()->user->setState('rootcategories', $categories);
    }
    public function getCategoriesLookup()
    {
        $categories = Category::model()->findAll('parent_id>0 and status=1');
        $categories = CHtml::listData($categories, 'id', 'name');
        return $categories;
    }
    public function setCategoriesLookupInState()
    {
        $categorieslkup = $this->getCategoriesLookup();
        Yii::app()->user->setState('categories', $categorieslkup);
    }
    public function setProductsLookupInState()
    {
        $products = $this->getProducts();
        $products1 = CHtml::listData($products, 'id', 'display');
        Yii::app()->user->setState('products', $products1);
        
        $products2 = CHtml::listData($products, 'sku', 'display');
        Yii::app()->user->setState('productskus', $products2);
    }
    public function setTaxratesLookupInState()
    {
        $taxrates = Taxrate::model()->findAll();
        $taxrates = CHtml::listData($taxrates, 'id', 'display');
        Yii::app()->user->setState('taxrates', $taxrates);
    }
    public function getPeopleLookup($role = null)
    {
        $people = $this->getAllPeople($role);
        $peopleLkup = CHtml::listData($people, 'id', 'lookupDisplay');
        //$peopleLkup = array_merge(array('','-Select-'), $peopleLkup);
        return $peopleLkup;
    }
    public function setPeopleLookupInState($role = null, $name = null)
    {
        $peopleLkup = $this->getPeopleLookup($role);
        switch($role)
        {
            case Helper::CONST_Manager:
                if(!isset($name)) $name = 'companymanagers';
                Yii::app()->user->setState($name, $peopleLkup);
                break;
            case Helper::CONST_Employee:
                if(!isset($name)) $name = 'companyemployees';
                Yii::app()->user->setState($name, $peopleLkup);
                break;
            case Helper::CONST_Customer:
                if(!isset($name)) $name = 'companycustomers';
                Yii::app()->user->setState($name, $peopleLkup);
                break;
            case Helper::CONST_Contractor:
                if(!isset($name)) $name = 'companycontractors';
                Yii::app()->user->setState($name, $peopleLkup);
                break;
            case Helper::CONST_Supplier:
                if(!isset($name)) $name = 'companysuppliers';
                Yii::app()->user->setState($name, $peopleLkup);
                break;
            default:
                Yii::app()->user->setState('companypeople', $peopleLkup);
                break;
        }
    }
    public function getOrderType(&$ordertype)
    {
        $found = false;
        foreach ($this->ordertypes as $ot)
        {
            $found = strtolower($ordertype) === strtolower($ot);
            if($found)
            {
                $ordertype = $ot;
                break;
            }
        }
        if(!$found)
        {
            $ordertype = $this->ordertypes[1];
        }
        return $ordertype;
    }
    public function setStatusesLookupInStateForMobile()
    {
        $statuses = Statusmaster::model()->findAll(array('condition'=>'ofwhich = 1'));        
        $statuses = CHtml::listData($statuses, 'id', 'display');
        $this->mobileUser->orderstatuses = $statuses;
        
        $statuses = Statusmaster::model()->findAll(array('condition'=>'ofwhich = 2'));
        $statuses = CHtml::listData($statuses, 'id', 'display');
        $this->mobileUser->taskstatuses = $statuses;
        
        $this->setStatusNameToIdMap();
        $this->setStatusToHistoryFieldsMap(2);
        $this->setStatusHistoryFieldToStatusesMap(2);
    }
    public function beforeAction($action)
    {
        
        
        $isMobileClient = strtolower($this->controllerID)
                            === strtolower(Helper::CONST_mobilecontrollerid);                
        $hash_id =  $this->checkAppSecurityStatus($isMobileClient);
        $actionid = $this->action->id;
        $this->subTitle = ucwords( $actionid ) . ' ' . $this->getMenuLabels( ucwords( $this->controllerID ) );        
        if($actionid === Helper::CONST_loginactionid
                || $actionid === Helper::CONST_logoutactionid
                || $actionid === Helper::CONST_erroractionid)
        {
            return true;
        }        
        if( empty($this->appSecurityStatus) 
                && !$isMobileClient)
        {
            if($this->isPOSTypeAPP())
            {
                if($this->isSales()
                    ||
                    (strtolower($this->controllerID)
                                === strtolower(Helper::CONST_ordercontrollerid)
                                && $actionid === strtolower(Helper::CONST_posclient) )
                )
                {
                    $this->layout = $this->appLayouts['sales'];
                }
                $isreports = strtolower($this->controllerID)
                            === strtolower(Helper::CONST_reportscontrollerid);
                if($isreports)
                {
                    $this->layout = $this->appLayouts['reports'];
                }
            }
            return true;
        }
            
        if(!empty($hash_id) && $isMobileClient)
        {
            $record =  Personcompanyrole::model()
                        ->with(array(
                                'login' => array('condition'=>'login.hash_id="' . $hash_id . '"' . ' AND login.status = 1'),                            
                                )
                        )->together()->findAll();
            if(empty($record))
            {
                $RetCode = Helper::CONST_InvalidUserPassword;
                $data = array();
                $message = Helper::CONST_WRONG_USER_PWD;                
                $this->returnJsonResponse($RetCode, $data, $message);
            }
            else
            {
                $record = $record[0];
                $this->mobileUser = new stdClass();
                $this->mobileUser->person = $record->person;
                $this->mobileUser->role = $record->role;
                $this->mobileUser->login = $record->login;
                $this->mobileUser->company = $record->company;
                $this->setStatusesLookupInStateForMobile();
            }
            return true;
        }
                      
        if($isMobileClient)
        {
            $RetCode = $this->appSecurityStatus->code;
            $data = array();
            $message = $this->appSecurityStatus->message;
            $this->returnJsonResponse($RetCode, $data, $message);                            
        }
        else
        {    
            $logouturl = Yii::app()->createUrl('/site/logout');
            if($this->controllerID === Helper::CONST_sitecontrollerid
                   && $actionid === Helper::CONST_indexactionid)
            {
                if(!Yii::app()->user->isGuest)
                {
                    $this->redirect($logouturl);
                }
                else
                {
                    return true;
                }
            }
            else
            {                
                //  //CLEAR THE ASSETS FOLDER BY S
                // if(defined('YII_DEBUG') && YII_DEBUG){
                //     Yii::app()->assetManager->forceCopy = true;
                // }
                //     return parent::beforeAction($action);
                //      //CLEAR THE ASSETS FOLDER BY SN
                $this->redirect($logouturl);
                //return false;
              
            
            }
        }
    }
    public function getView($viewtype, $dfltView)
    {
        $rtn = $dfltView;
        if(!empty($this->appViews[$viewtype]))
        {
            $viewtypeviews = $this->appViews[$viewtype];
            if(!empty($viewtypeviews[$this->controllerID]))
            {
                $rtn .= '_' .$viewtypeviews[$this->controllerID];
            }
        }
        return $rtn;
    }
    public function checkForFieldInMap($fldName, $fldtype, $controller = null)
    {//example $fldName = 'mail', $fldtype = 'ff',  $controller = 'person',
        if(empty($controller)) $controller = $this->controllerID;
        $fldtypelist = $this->appFormFields[$fldtype];
        if(empty($fldtypelist))
        {
            return false;
        }
        else
        {
            $cntlrList = $fldtypelist[$controller];
            if(empty($cntlrList))
            {
                return false;
            }
            else
            {
                return $cntlrList[$fldName];
            }
        }
    }
    public function checkAppConfigs($refresh = true)
    {
        if($refresh)
        {
            $appConfigs = array();
            $configs = Config::model()->findAll(array());
            foreach($configs as $config)
            {
                $appConfigs[$config->config_key] = trim($config->config_val);
            }
        }else{
            $appConfigs = ((!empty(Yii::app()->user->appConfigs))?Yii::app()->user->appConfigs:array());
        }
        if(empty($appConfigs))
        {
            $isvalid = false;
        }
        else
        {
            $isvalid = true;
            foreach($this->appConfigKeys as $a => $b)
            {
                $isvalid = isset($appConfigs[$a]) && trim($appConfigs[$a]) !== '';               
                if(!$isvalid)
                {
                    break;
                }
            }
        }
        if($isvalid)
        {
            Yii::app()->user->setState('appConfigs', $appConfigs);
            return $appConfigs;
        }            
        return $isvalid;
    }
    public function checkAppSecurityStatus($ishashidcheck = true)
    {
        $hash_id = null;
        $statusOk = true;
        if($ishashidcheck)
        {
            $hash_id = $this->getHashId();
            $statusOk = !empty($hash_id);
            if(!$statusOk)
            {
                $this->appSecurityStatus = new stdClass();
                $this->appSecurityStatus->code = '401';
                $this->appSecurityStatus->message = Helper::CONST_HASH_MISSING;
                return false;
            }
        }
        
        $statusOk = $this->checkAppConfigs();
        if(!$statusOk)
        {
            $this->appSecurityStatus = new stdClass();
            $this->appSecurityStatus->code = '12';
            $this->appSecurityStatus->message = Helper::CONST_INVALID_CONFIG;
            return false;
        }
        if($statusOk)
        {
            $this->appSecurityStatus = null;            
        }
        return $hash_id;
    }
    public function getMenuLabels( $menuLabel )
    {
        $menu_alt_Labels_map = Yii::app()->params['menu_alt_Labels_map'];
        $menu_alt_Labels = $menu_alt_Labels_map[$this->appId];
        
        $altlabel = $menuLabel;
        if(isset( $menu_alt_Labels[$menuLabel]) 
                && !empty($menu_alt_Labels[$menuLabel])
        )
        {
            $altlabel = $menu_alt_Labels[$menuLabel];
        }
        return $altlabel;
    }
    private function checkInArray($needle, $haystackarray, $level = 0, $ignorecase = 1)
    {
        $found = false;
        if( !is_array( $haystackarray ) || count($haystackarray) === 0 )
        {
            return $found;
        }
        foreach ($haystackarray as $single)
        {
            if(  is_array( $single ) ) continue;
            if($ignorecase)
            {
                $found = (strtolower($needle) === strtolower($single));
            }
            else
            {
                $found = ($needle === $single);
            }
            if($found)
                break;
        }
        return $found;
    }
    private function isMenuAllowed($menuLabel, $superlabel = null)
    {
        if(strtolower($menuLabel) === 'profile' 
                    || strtolower($menuLabel) === 'logout')
        {//logout or profile //will be under usermenu 
            $rtn = false;
            return $rtn;
        }
        $rtn = $this->isEmployee()
                    && (strtolower($menuLabel) !== 'dashboard' 
                            && strtolower($menuLabel) !== 'new order');
        if($rtn) return !$rtn;
        $rtn = $this->isCustomer()
                 && (strtolower($menuLabel) !== 'new order');
        if($rtn) return !$rtn;
        
        $rtn = $this->isSales()
                 && (strtolower($menuLabel) !== 'order');
        if($rtn) return !$rtn;
        
        $rtn = $this->checkInArray($menuLabel, $this->appMenuIDs);
        if(!$rtn)
        {
            $rtn = count($this->appMenuIDs) === 1 && $this->appMenuIDs[0] === 'all';            
            if(count($this->appMenuIDs) > 1 && $this->appMenuIDs[0] === 'all')
            {
                $exceptary = $this->appMenuIDs[1];
                if(!is_null($superlabel))
                {//submenu search
                    $found = false;
                    foreach($exceptary as $tmp)
                    {
                        $splitup = explode(".", $tmp);
                        if(isset($splitup[0]) && isset($splitup[1]))
                        {
                           $found = (strtolower($splitup[0]) === strtolower($superlabel)
                                    &&  strtolower($splitup[1]) === strtolower($menuLabel)
                                   );
                           if($found){
                               break;
                           }
                        }
                    }
                    $rtn = !$found;
                }
                else
                {
                    $rtn = !$this->checkInArray($menuLabel, $exceptary);                    
                }
            }
        }
        return $rtn;
    }
    public function getDateFromNouns($nounstr)
    {
        $datestr = null;
        $datetime = new DateTime('today');
        switch(strtoupper($nounstr))
        {
            case strtoupper(Helper::CONST_Today):
                break;
            case strtoupper(Helper::CONST_DayBeforeYesterday):
                $datetime->modify('-2 day');
                break;
            case strtoupper(Helper::CONST_Yesterday):
                $datetime->modify('-1 day');
                break;
            case strtoupper(Helper::CONST_Tomorrow):
                $datetime->modify('+1 day');
                break;
            case strtoupper(Helper::CONST_DayAfterTomorrow):
                $datetime->modify('+2 day');
                break;
            default:
                $datetime = null;
                $datestr = Yii::app()->controller->getMysqlFormattedDatetime($nounstr, $this->datetimemysqlformatYMD);
                break;
        }
        if(!empty($datetime))
        {
            $datestr = $datetime->format($this->datetimemysqlformatYMD);
        }        
        return $datestr;
    }
    public function getMenu($menuCss)
    {
        $menuItems = array( );
        foreach ( $this->menuIDs as $menuID => $menuLabel)
        {
            if(is_array($menuLabel))
            {
                $toplabel = $menuLabel[0];
                if( !$this->isMenuAllowed($toplabel) ) continue;
                $bktoplabel = $toplabel;
                $toplabel = $this->getMenuLabels( $toplabel );
                $topicon = $this->menuIcons[$menuID][0];
                $topUrl = $this->menuURLs[$menuID][0];
                
                $innerLabels = $menuLabel[1];
                $innerIcons = $this->menuIcons[$menuID][1];
                $innerUrls = $this->menuURLs[$menuID][1];
                
                $innerItems = array();
                foreach($innerLabels as $innerMenuID => $innerLabel)
                {
                    if( !$this->isMenuAllowed($innerLabel, $bktoplabel)) continue;
                    $innerLabel = $this->getMenuLabels( $innerLabel );
                    $innerIcon = $innerIcons[$innerMenuID];
                    $innerUrl = $innerUrls[$innerMenuID];
                    $innerItem = array( 'label' => $innerIcon . $innerLabel
                    , 'url' => array( $innerUrl ) );
                    $innerItems[] = $innerItem;
                }
                $tmpItem = array(
                            'label' => $topicon . $toplabel . '<b class="caret"></b>'
                            , 'url' => array( $topUrl )
                            , 'itemOptions' => array( 'class' => 'dropdown user-dropdown' )
                            , 'linkOptions' => array( 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown' )
                            , 'items' => $innerItems
                            , 'submenuOptions' => array( 'class' => 'dropdown-menu' )
                            );
            }
            else
            {
                if(!$this->isMenuAllowed($menuLabel)) continue;                
                $menuLabel = $this->getMenuLabels( $menuLabel );
                $icon = $this->menuIcons[$menuID];
                $menuUrl = $this->menuURLs[$menuID];
                if(strtolower($menuLabel) === 'profile')
                {
                    $menuUrl .= Yii::app()->user->person->id;
                }
                $tmpItem = array(
                            'label' => $icon . $menuLabel
                            , 'url' => array( $menuUrl ) 
                            );
            }
            if(!is_null( $tmpItem))
            {
                $menuItems[] = $tmpItem;
            }
        }
        $mainmenuItems = $menuItems;
        $menu = $this->widget( 'zii.widgets.CMenu', array(
                    'items' => $mainmenuItems,
                    'htmlOptions' => array( 'class' => $menuCss ),
                    'encodeLabel' => false
                        ), true );
//        if ( !Yii::app()->user->isGuest )
//        {
//            $menu .= $this->getUserMenu();
//        }
        return $menu;
    }
    public function getUserMenu()
    {        
        if($this->isPOSTypeAPP() && $this->isSales())
        {
            $usersubmenuitems = array(
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Logout'
                        ,'url' => array( '#' )
                        ,'linkOptions' => array('onclick' => 'js:logout(event);')
                    ),
            );
        }
        else
        {
            $lurl = Helper::CONST_logouturl;
            $usersubmenuitems = array(
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Logout'
                        ,'url' => array( $lurl )                        
                    ),
            );
        }        
        $usermenuItems = array(
            array( 'label' => '<i class="fa iconfa-user"></i>' . Yii::app()->user->name . '<b class="caret"></b>'
                , 'url' => array( '#' )
                , 'itemOptions' => array( 'class' => 'dropdown user-dropdown')
                , 'linkOptions' => array( 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown' )
                , 'items' => $usersubmenuitems
                , 'submenuOptions' => array( 'class' => 'dropdown-menu' )
            ),
        );
        $usermenu = $this->widget( 'zii.widgets.CMenu', array(
                    'items' => $usermenuItems,
                    'htmlOptions' => array( 'class' => 'nav navbar-nav navbar-right navbar-user' ),
                    'encodeLabel' => false,
                    'activateParents' => true,
                    'itemCssClass' => 'displayblock',            
                    //'submenuHtmlOptions' => array( 'class' => 'dropdown-menu' ),
//                    'linkLabelWrapper' => 'label',
//                    'linkLabelWrapperHtmlOptions' => array('style'=>'display:block;'),
                        ), true );
        return $usermenu;
    }
    public function getSalesMenu()
    {
        $submenuItems = array(
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>List ' . Helper::CONST_Sales
                    , 'url' => array( '/order/admin' ) ),
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>List ' . Helper::CONST_OpenedBills_STR
                    , 'url' => array( '/order/openedbills' ) ),
            );
        $mainmenuItems = array(
            array( 'label' => '<i class="fa iconfa-user"></i>' . Helper::CONST_Sales . '<b class="caret"></b>'
                , 'url' => array( '#' )
                , 'itemOptions' => array( 'class' => 'dropdown user-dropdown' )
                , 'linkOptions' => array( 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown' )
                , 'items' => $submenuItems
                , 'submenuOptions' => array( 'class' => 'dropdown-menu' )
            ),
        );
        $menu = $this->widget( 'zii.widgets.CMenu', array(
                    'items' => $mainmenuItems,
                    'htmlOptions' => array( 'class' => 'nav navbar-nav navbar-right navbar-user' ),
                    'encodeLabel' => false,
                    'activateParents' => true,
                    'itemCssClass' => 'displayblock',            
                    //'submenuHtmlOptions' => array( 'class' => 'dropdown-menu' ),
//                    'linkLabelWrapper' => 'label',
//                    'linkLabelWrapperHtmlOptions' => array('style'=>'display:block;'),
                        ), true );
        return $menu;
    }
    public function getProductsMenu()
    {
        $submenuItems = array(
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>List ' . Helper::CONST_Product
                    , 'url' => array( '/subproductprice/adminproduct' ) ),
              array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Create ' . Helper::CONST_Product
                    , 'url' => array( '/purchaseentry/create' ) ),
                 array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>List Purchase'
                    , 'url' => array( '/productprice/admin' ) ),
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Purchase ' . Helper::CONST_Product
                    , 'url' => array( '/product/create' ) ),
//                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Quick Add Products'
//                    , 'url' => array( '/product/' . Helper::CONST_bulkAddProductsAjax ) ),
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Stock Adjustment'
                    , 'url' => array( '/subproductprice/admin' ) ),
                            array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Stock Enquiry'
                    , 'url' => array( '/productprice/stockreport' ) ),
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Expiry Product List'
                    , 'url' => array( '/productprice/Expirydateproductlist' ) ),
            );
        $mainmenuItems = array(
            array( 'label' => '<i class="fa iconfa-user"></i>' . Helper::CONST_Product . '<b class="caret"></b>'
                , 'url' => array( '#' )
                , 'itemOptions' => array( 'class' => 'dropdown user-dropdown' )
                , 'linkOptions' => array( 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown' )
                , 'items' => $submenuItems
                , 'submenuOptions' => array( 'class' => 'dropdown-menu' )
            ),
        );
        $menu = $this->widget( 'zii.widgets.CMenu', array(
                    'items' => $mainmenuItems,
                    'htmlOptions' => array( 'class' => 'nav navbar-nav navbar-right navbar-user' ),
                    'encodeLabel' => false,
                    'activateParents' => true,
                    'itemCssClass' => 'displayblock',            
                    //'submenuHtmlOptions' => array( 'class' => 'dropdown-menu' ),
//                    'linkLabelWrapper' => 'label',
//                    'linkLabelWrapperHtmlOptions' => array('style'=>'display:block;'),
                        ), true );
        return $menu;
    }
    public function getCategoriesMenu()
    {
        $submenuItems = array(
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>List ' . Helper::CONST_RootCategory
                    , 'url' => array( '/category/' . Helper::CONST_sectionadmin ) ),
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Create ' . Helper::CONST_RootCategory
                    , 'url' => array( '/category/' . Helper::CONST_sectioncreate ) ),
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>List ' . Helper::CONST_Category
                    , 'url' => array( '/category/admin' ) 
                    , 'template' => '{menu}'
                    ),               
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Create ' . Helper::CONST_Category
                    , 'url' => array( '/category/create' ) ),
            );
        $mainmenuItems = array(
            array( 'label' => '<i class="fa iconfa-user"></i>' . 'Sections & Categories' . '<b class="caret"></b>'
                , 'url' => array( '#' )
                , 'itemOptions' => array( 'class' => 'dropdown user-dropdown' )
                , 'linkOptions' => array( 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown' )
                , 'items' => $submenuItems
                , 'submenuOptions' => array( 'class' => 'dropdown-menu' )
            ),
        );
        $menu = $this->widget( 'zii.widgets.CMenu', array(
                    'items' => $mainmenuItems,
                    'htmlOptions' => array( 'class' => 'nav navbar-nav navbar-right navbar-user' ),
                    'encodeLabel' => false,
                    'activateParents' => true,
                    'itemCssClass' => 'displayblock',            
                    //'submenuHtmlOptions' => array( 'class' => 'dropdown-menu' ),
//                    'linkLabelWrapper' => 'label',
//                    'linkLabelWrapperHtmlOptions' => array('style'=>'display:block;'),
                        ), true );
        return $menu;
    }
    
    public function getCustomersMenu()
    {
        $submenuItems = array(
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>List ' . Helper::CONST_Customer
                    , 'url' => array( '/person/' . Helper::CONST_customeradmin ) ),
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Create ' . Helper::CONST_Customer
                    , 'url' => array( '/person/' . Helper::CONST_customercreate ) ),
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>List Customer Payment'
                , 'url' => array( '/paymentreceipt/admin' ) ),
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Create Customer Payment'
                , 'url' => array( '/paymentreceipt/create' ) ),
                
            );
        $mainmenuItems = array(
            array( 'label' => '<i class="fa iconfa-user"></i>' . Helper::CONST_Customer . '<b class="caret"></b>'
                , 'url' => array( '#' )
                , 'itemOptions' => array( 'class' => 'dropdown user-dropdown' )
                , 'linkOptions' => array( 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown' )
                , 'items' => $submenuItems
                , 'submenuOptions' => array( 'class' => 'dropdown-menu' )
            ),
        );
        $menu = $this->widget( 'zii.widgets.CMenu', array(
                    'items' => $mainmenuItems,
                    'htmlOptions' => array( 'class' => 'nav navbar-nav navbar-right navbar-user' ),
                    'encodeLabel' => false,
                    'activateParents' => true,
                    'itemCssClass' => 'displayblock',            
                    //'submenuHtmlOptions' => array( 'class' => 'dropdown-menu' ),
//                    'linkLabelWrapper' => 'label',
//                    'linkLabelWrapperHtmlOptions' => array('style'=>'display:block;'),
                        ), true );
        return $menu;
    }
    public function getSuppliersMenu()
    {
        $submenuItems = array(
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>List ' . Helper::CONST_Supplier
                    , 'url' => array( '/person/' . Helper::CONST_supplieradmin ) ),
                array( 'label' => '<i class="glyphicon glyphicon-log-out"></i>Create ' . Helper::CONST_Supplier
                    , 'url' => array( '/person/' . Helper::CONST_suppliercreate ) ),
            );
        $mainmenuItems = array(
            array( 'label' => '<i class="fa iconfa-user"></i>' . Helper::CONST_Supplier . '<b class="caret"></b>'
                , 'url' => array( '#' )
                , 'itemOptions' => array( 'class' => 'dropdown user-dropdown' )
                , 'linkOptions' => array( 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown' )
                , 'items' => $submenuItems
                , 'submenuOptions' => array( 'class' => 'dropdown-menu' )
            ),
        );
        $menu = $this->widget( 'zii.widgets.CMenu', array(
                    'items' => $mainmenuItems,
                    'htmlOptions' => array( 'class' => 'nav navbar-nav navbar-right navbar-user' ),
                    'encodeLabel' => false,
                    'activateParents' => true,
                    'itemCssClass' => 'displayblock',            
                    //'submenuHtmlOptions' => array( 'class' => 'dropdown-menu' ),
//                    'linkLabelWrapper' => 'label',
//                    'linkLabelWrapperHtmlOptions' => array('style'=>'display:block;'),
                        ), true );
        return $menu;
    }
    public function setDefaultGVProviderOptions( &$options , 
            $pageSize = false, $sort = false)
    {
        if($pageSize)
        {
            $options['pagination'] = array( 'pageSize' => $pageSize );
        }
        else
        {
            $options['pagination'] = false;
        }
        $options['sort'] = $sort;
    }

    public function setDefaultGVOptions( &$options,
                                $height=Helper::CONST_grid_Height_400,
                                $fontsize=Helper::CONST_grid_Font_12,
                                $template = Helper::CONST_grid_Template_SI
                    )
    {
        $htmlOptions = array(
                        'style'=>"height:".$height."px;
                                font-size:".$fontsize."px !important;
                                overflow-y:auto;
                                overflow-x:auto;"
                            );
        $options['htmlOptions'] = $htmlOptions;
        $options['template'] = $template;
        
        $options['type'] = 'stripped bordered';
        $options['filterPosition'] = 'body';        
        $options['emptyText'] = 'No Records Found!';
        $options['enableHistory'] = false;        
        //$options['loadingCssClass']='loader';
        //$options['showTableOnEmpty'] = true;                
//        $options['template'] = '{add} {summary} {items}';
//        $options['buttons'] = array(
//                                'add' => array
//                                            (
//                                            'label'=>'model attribute',
//                                            'icon'=>'plus',
//                                            'url'=>'Yii::app()->createUrl("person/create")',
//                                            'options'=>array(
//                                            'class'=>'btn btn-small',
//                                            )
//                                )
//                            );
    }
    private function getHashId()
    {
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
//        $hash_id = $this->request()->headers('hash_id');//1st try
//        if(!isset($hash_id)){        
            $headers = getallheaders();//2th try[actually alias for apache_request_headers            
            if(!isset($headers['hash_id']))
            {
                $headers = apache_request_headers();//3rd try                
                if(!isset($headers['hash_id']))
                {
                    $headers = $this->parseRequestHeaders();//4th try                                
                    if(!isset($headers['hash_id']))
                    {
                        //$this->log->debug("parseRequestHeaders not worked");
                    }
                    else
                    {
                        //$this->log->debug("parseRequestHeaders worked");
                        $hash_id = $headers['hash_id'];
                    }
                }else
                {
                    //$this->log->debug("apache_request_headers worked");
                    $hash_id = $headers['hash_id'];
                }
            }else
            {
                //$this->log->debug("getallheaders worked");
                $hash_id = $headers['hash_id'];
            }
//        }else{
//            //$this->log->debug("request()->headers worked");
//        }
        return $hash_id;
    }
    private function parseRequestHeaders() 
    {
        $headers = array();
        foreach($_REQUEST as $key => $value) {
            $d = $key;
        }
        foreach($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                    continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }
    public function isSUStrict(){
        return !Yii::app()->user->isGuest 
                && isset(Yii::app()->user->SU) 
                && Yii::app()->user->SU;        
    }
    public function isSU(){
        return !Yii::app()->user->isGuest && (
                                            (isset(Yii::app()->user->SU) && Yii::app()->user->SU) 
                                            || (isset(Yii::app()->user->Non_Su) && Yii::app()->user->Non_Su)
                                        );
    }
    public function isAdmin(){
        return !Yii::app()->user->isGuest && isset(Yii::app()->user->Admin) && Yii::app()->user->Admin;
    }
    public function isSUorAdmin(){
        return $this->isSU() || $this->isAdmin();
    }
    public function isCustomer()
    {
        return !Yii::app()->user->isGuest && !$this->isSUorAdmin() && (strtolower(Yii::app()->user->role->role) 
                                    === strtolower(Helper::CONST_Customer));
    }
    public function isEmployee()
    {
        return !Yii::app()->user->isGuest && !$this->isSUorAdmin() && (strtolower(Yii::app()->user->role->role) 
                                    === strtolower(Helper::CONST_Employee));
    }
    public function isSales()
    {
        return !Yii::app()->user->isGuest &&  !$this->isSUorAdmin() && (strtolower(Yii::app()->user->role->role) 
                                    === strtolower(Helper::CONST_Sales));
    }
    public function isAuthorizedPersonForLeave(){
        $id = $_GET['id'];
        $rtn = $this->isSUorAdmin();
        if(!$rtn){
            $model=Leave::model()->findByPk($id);
            if($model!==null){
                $rtn = (!Yii::app()->user->isGuest && Yii::app()->user->person->id === $model->person_id);
            }else{
                $rtn = false;
            }
        }
        return $rtn;
    }
    public function isAuthorizedPersonForLoan(){
        $id = $_GET['id'];
        $rtn = $this->isSUorAdmin();
        if(!$rtn){
            $model=Loan::model()->findByPk($id);
            if($model!==null){
                $rtn = (!Yii::app()->user->isGuest && Yii::app()->user->person->id === $model->person_id);
            }else{
                $rtn = false;
            }
        }
        return $rtn;
    }
    public function isAuthorizedPerson(){
        $id = $_GET['id'];
        $rtn = $this->isSUorAdmin()
                || (!Yii::app()->user->isGuest && Yii::app()->user->person->id === $id);
        return $rtn;
    }
    public function isAuthPersonINCompanyForView(){
        $id = $_GET['id'];
        $rtn = $this->isSU() 
                || ($this->isAdmin() 
                        && Yii::app()->user->company->id === $id);
        return $rtn;
    }
    public function isAuthPersonINCompanyForUpdate(){
        $id = $_GET['id'];
        $rtn=$this->isSU() 
                || ($this->isAdmin() 
                        && Yii::app()->user->company->id === $id);
        return $rtn;
    }    
    public function getProducts($prdname = null, $category = null, $iscatid = false)
    {
        $catcondition = array();
        if(!empty($category))
        {
            $catconditionstr = 'LCASE(categories.name)="' . strtolower($category) . '"';            
            if($iscatid)
            {
                $catconditionstr = 'categories.id=' . $category;
            }
            $catconditionstr .= ' AND categories.status = 1';
            $catcondition = array('condition'=> $catconditionstr);
        }
        
        $prdcondition = array();
        if(!empty($prdname))
        {
            $prdcondition = array('condition' => 't.status =1 AND LCASE(t.name) LIKE '  . '"%' . strtolower($prdname) . '%"');
        }
        $products = Product::model()->with(
                            array(
                                'categories' => $catcondition
                            )
                        )->findAll(
                                $prdcondition);
        return $products;
    }
    public function getUrlParams($isarray = false, $typeparamvalue=null, $roleparamvalue=null)
    {
        $qrykey = '';
        $qryval = '';
        if(empty($typeparamvalue))
        {
            $typeparamvalue = (isset( $_REQUEST['type'] )?$_REQUEST['type']:'');
        }
        if(empty($roleparamvalue))
        {
            $roleparamvalue = (isset( $_REQUEST['role'] )?$_REQUEST['role']:'');
        }        
        if(!empty($typeparamvalue))
        {
            $qrykey = 'type';
            $qryval = $typeparamvalue;
        }
        else if(!empty($roleparamvalue))
        {
            $qrykey = 'role';
            $qryval = $roleparamvalue;
        }
        if($isarray)
        {
            if(empty($qryval))
            {
                $params = array();
            }
            else
            {
                $params = array($qrykey => $qryval);
            }
        }
        else
        {
            if(empty($qryval))
            {
                $params = '';
            }
            else
            {
                $params = "?$qrykey=$qryval";
            }
        }
        return $params;
    }
    public function getRedirectView($controller, $actionId = 'create', $default = 'admin')
    {
        $rtn = $default;
        $ctrlViewRedirects = $this->appRedirects[$controller];
        if(isset($ctrlViewRedirects) && isset($ctrlViewRedirects[$actionId]))
        {
            $rtn = $this->appRedirects[$controller][$actionId];
        }
        return $rtn;
    }
    public function getEditUrl($isupdate = false, $id = null, $controller = null, $typeparamvalue=null, $roleparamvalue=null)
    {
        if(empty($controller)) $controller = $this->controllerID;
        $action = "$controller/create";
        if($isupdate)
        {
            $action = "$controller/update/$id";
        }
        $params = $this->getUrlParams(false, $typeparamvalue, $roleparamvalue);
        $action .= $params;
        $url = Yii::app()->createUrl($action);        
        return $url;
    }
    public function getRedirectUrl($prefix = null, $viewname=null, $params=array())
    {
        $controller = $this->controllerID;        
        if(empty($viewname))
        {
            $viewname = "admin";            
        }
        if(empty($prefix)) $prefix='';
        $action = "$controller/". strtolower($prefix) . $viewname;
        
        $rtnurl = Yii::app()->createUrl($action, $params);
        return $rtnurl;
    }
    public function getAllPeople($role, $isRoleName = true)
    {
        $peopleCriteria = $this->getPeopleCriteria($role);
        return Person::model()->findAll($peopleCriteria);
    }    
    public function getAllTasks()
    {
        $tasks = Task::model()->findAll();
        $tasks = CHtml::listData($tasks, 'id', 'name');
        return $tasks;
    }
    public function getPeopleCriteria($role =  null, $isRoleName = true, $includeInactive = false)
    {
        $user = Yii::app()->user;
        $criteria=new CDbCriteria;
        
        if((!isset($user->company)
                    || $user->company->id <= 0)
        )
        {
            if($this->isSU())
            {
                //no criteria - all of all 
            }
            else
            {
                $criteria=new CDbCriteria(array(
                    'condition'=>'id=:personID ',
                    'params'=>array(':personID'=>-1),
                    ));
            }
        }
        else
        {
            if($this->isSUorAdmin())
            {   
                $params = array();
                $cndn = 'personcompanyroles.company_id=:companyID';
                $params[':companyID'] = $user->company->id;
                if(isset($role))
                {
                    if($isRoleName)
                    {
                        $cndn .= ' AND LCASE(role.role)=LCASE(:role)';                        
                    }
                    else
                    {
                        $cndn .= ' AND role.id=:role';
                    }
                    $params[':role'] = $role;
                }
                else
                {
                    $lowerroles = array_map("strtolower", array_keys($this->appRoles));
                    $role = '';
                    $lastindex = count($lowerroles) - 1;
                    $i = 0;
                    foreach($lowerroles as $tmp)
                    {
                        $role .= "\"" . $tmp . "\"";
                        if($i != $lastindex)
                            $role .= ",";
                        
                        $i++;
                    }                    
                    $cndn .= ' AND LCASE(role.role) IN (' . $role .')';
                }
                if($this->isAdmin())
                {
                    $cndn .= ' AND personcompanyroles.person_id!=:adminID';
                    $params[':adminID'] = $user->person->id;
                }
                if(!$includeInactive)
                {
                    $cndn .= ' AND t.status=:status';
                    $params[':status'] = 1;
                }
                $rltnCondn = array(
                    'together'=>true,
                    'select'=>false,
                    'joinType'=>'INNER JOIN',
                    'condition'=> $cndn,
                    'with' => array('role'),
                );
                $criteria=new CDbCriteria(array(
                            'order'=>'name asc',));
                $criteria->with = array('personcompanyroles'=>$rltnCondn);
                $criteria->params = $params;
            }
            else if(isset($user->person))
            {
                $cndn = 'id=:personID ';                
                if(!$includeInactive)
                {
                    $cndn .= ' AND t.status = 1';
                }
                $params = array(':personID'=>$user->person->id);
                $criteria=new CDbCriteria(array(
                        'condition'=>$cndn,
                        'params'=>$params,
                    ));
            }else
            {
                $criteria=new CDbCriteria(array(
                        'condition'=>'id=:personID ',
                        'params'=>array(':personID'=>-1),
                        ));
            }
        }
        return $criteria;
    }
    public function getAllPeopleNoRestriction($role =  null)
    {
        $cndn = 'LCASE(role.role)=LCASE(:role)'; 
        $params[':role'] = $role;

        $rltnCondn = array(
                            'together'=>true,
                            'select'=>false,
                            'joinType'=>'INNER JOIN',
                            'condition'=> $cndn,
                            'with' => array('role'),
                        );

        $peopleCriteria=new CDbCriteria(array(
                                    'order'=>'name asc',));
        $peopleCriteria->with = array('personcompanyroles'=>$rltnCondn);
        $peopleCriteria->params = $params;
        $customers = Person::model()->findAll($peopleCriteria);
        $allcustomers = CHtml::listData($customers, 'id', 'name');
        return $allcustomers;
    }
    protected function getPaymenttypesList()
    {
        $objary = array ( );
        $i = 1;
        foreach ( $this->paymenttypes as $st )
        {
            $tmp = new StaticLookup;
            $tmp->id = $st;
            $tmp->name = $st;
            $objary[] = $tmp;
        }
        $listdata = CHtml::listData( $objary, 'id', 'name' );
        return $listdata;
    }
    public function getPeopleCode($postedData)
    {
        if($postedData->id <=0)
        {
            $isauto = false;
            switch($postedData->rolename)
            {                
                case Helper::CONST_Customer:
                    $fixedcode = 'C';
                    $isauto = $this->getEnableautocustcode();
                    break;
                case Helper::CONST_Supplier:
                    $fixedcode = 'S';
                    $isauto = $this->getEnableautosplrcode();
                    break;                
                default:
                    switch($postedData->rolename)
                    {
                        case Helper::CONST_Employee:
                            $fixedcode = 'E';
                            break;
                         case Helper::CONST_Contractor:
                            $fixedcode = 'CN';
                            break;
                        default:
                            $fixedcode = '';
                            break;
                    }
                    $isauto = $this->getEnableautopplcode();
                    break;
            }
            if($isauto){
                $peoplecode = $this->generateCode(2, $postedData->name, $fixedcode);
            }else{
                $peoplecode = $postedData->code;
            }
        }else
        {
            $peoplecode = $postedData->code;
        }
        return $peoplecode;
    }
    public function generateCode($forwhat, $codesource, $fixedcode='')
    {
        $fc = substr($codesource, 0, 1);
        $like = strtoupper($fc) . "%";
        $criteria=new CDbCriteria(array(
                            'order'=>'id asc',
                            'limit' => 1,
                            ));

        $criteria->compare('UPPER(`name`)', strtoupper($like), true);
        
        if($forwhat === 1){
            $result= Product::model()->findAll($criteria);
        }else{//for people customer, supplier
            $result= Person::model()->findAll($criteria);
        }
        $count = 1;
        $strtoneglect = $fixedcode . '-';
        if(count($result) > 0){
            $count = substr($result[0]->code, strlen($strtoneglect) + 1) + 1;
        }
        $codepart1 = strtoupper($fixedcode) . strtoupper($fc) . '-';
        $newcode = $codepart1 .  sprintf('%05d',$count);
        return $newcode;
    }
    
    public function getEnableordername()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableordername']];
    }
    public function getEnableordrprd()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableordrprd']];
    }
    public function getEnableordrtasks()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableordrtasks']];
    }
    public function getEnableordrtaskpeople()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableordrtaskpeople']];
    }
    public function getEnableordrpayments()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableordrpayments']];
    }
    public function getEnableordermilestones()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableordermilestones']];
    }
    public function getOrdercostamountfrom()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['ordercostamountfrom']];
    }
    public function getOrdertaskcostamountfrom()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['ordertaskcostamountfrom']];
    }
    public function getEnablediscount()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enablediscount']];
    }
    public function getOrderdiscfor()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['orderdiscfor']];
    }
    public function getDiscentry()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['discentry']];
    }
    public function getAccountamountfrom()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['accountamountfrom']];
    }
    public function getEnableautopplcode()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableautopplcode']];
    }
    public function getEnableautosplrcode()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableautosplrcode']];
    }
    public function getEnableautocustcode()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableautocustcode']];
    }
    public function getEnablepplcode()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enablepplcode']];
    }
    public function getEnablepplauxname()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enablepplauxname']];
    }    
    public function getEnablecontact()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enablecontact']];
    }
    public function getEnableprdcode()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableprdcode']];
    }
    public function getEnableautoprdcode()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableautoprdcode']];
    }
    public function getEnableprdauxname()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableprdauxname']];
    }
    public function getEnableautoordrid()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableautoordrid']];
    }
    public function getEnableordrpeople()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableordrpeople']];
    }
    public function getEnableinlinepayments()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['enableinlinepayments']];
    }
    public function getMoperinvoice()
    {
        return Yii::app()->user->appConfigs[$this->appConfigKeys['moperinvoice']];
    }
    
    public function isAutoPeopleCode($rolename)
    {
        switch($rolename)
        {
            case Helper::CONST_Customer:
                return $this->getEnableautocustcode();
                break;
            case Helper::CONST_Supplier:
                return $this->getEnableautosplrcode();
                break;
            default:
                return $this->getEnableautopplcode();
                break;
        }
    }
    public function getOrderAutoId(&$type, $isnew, $extvalue, &$isautogenerated, $isconvert = false)
    {
        if(!$this->getEnableautoordrid()
                || (!$isnew && (!$isconvert || $type === Helper::CONST_Order)
                        )
        )
        {
            $isautogenerated = false;
            return $extvalue;
        }
        $newid = $this->curYear . '/' . $this->curMonth . '/';
        $typeforid = $type;
        switch($type)
        {
            case Helper::CONST_Quote:                
                if($isconvert)
                {
                    $staticstr = Helper::CONST_odrid_static_str;
                    $typeforid = Helper::CONST_Order; 
                    $type = Helper::CONST_Order;
                }
                else
                {
                    $staticstr = Helper::CONST_qotid_static_str;
                }
            break;
            case Helper::CONST_Order:
                if($isconvert)
                {
                    $staticstr = Helper::CONST_invid_static_str;
                    $typeforid = Helper::CONST_Invoice;
                }
                else
                {
                    $staticstr = Helper::CONST_odrid_static_str;
                }                
            break;
            case Helper::CONST_Invoice:
                $staticstr = Helper::CONST_invid_static_str;
            break;
        }
        $newid .= $staticstr;

        $condition = 'forwhat="' . $typeforid . '"';
        $condition .= ' AND foryear = ' . $this->curYear;
        $condition .= ' AND formonth = ' . $this->curMonth;

        $criteria = new CDbCriteria;
        $criteria->select = array( 'lastid' );
        $criteria->condition = $condition;
        $result = Idmaster::model()->findAll( $criteria );                
        if(count($result) > 0)
        {
            $tmpid = $result[0]->lastid + 1;
            $newid .= sprintf('%05d',$tmpid);
        }
        else
        {
            $tmpid = 1;
            $newid .= sprintf('%05d',$tmpid);
        }
        $isautogenerated = true;
        return $newid;
    }
    public function updateOrderAutoId($newId)
    {
        list($year, $month, $id) = explode("/", $newId);
        $tmpType = substr($id, 0, 3);
        $forwhat = '';
        switch(strtolower($tmpType))
        {
            case strtolower(Helper::CONST_qotid_static_str):
                $forwhat = Helper::CONST_Quote;
                break;
            case strtolower(Helper::CONST_odrid_static_str):
                $forwhat = Helper::CONST_Order;
                break;
            case strtolower(Helper::CONST_invid_static_str):
                $forwhat = Helper::CONST_Invoice;
                break;
        }
        $lastId = substr($id, strlen($tmpType));
        
        $condition = 'forwhat="' . $forwhat . '"';
        $condition .= ' AND foryear = ' . $year;
        $condition .= ' AND formonth = ' . $month;

        $criteria = new CDbCriteria;
        $criteria->condition = $condition;
        $result = Idmaster::model()->findAll( $criteria );                
        if(count($result) > 0)
        {
            $idmastermodel = $result[0];
        }
        else
        {
            $idmastermodel = new Idmaster;
        }
        $idmastermodel->foryear = $year;
        $idmastermodel->formonth = $month;
        $idmastermodel->forwhat = $forwhat;
        $idmastermodel->lastid = $lastId;
        
        return $idmastermodel->save();
    }
    public function updatePurchase($Id, &$amount)
    {
        $model = Purchase::model()->findByPk($Id);
        $amount = $model->amount;
        $ttlamount = 0;
        foreach($model->purchaseproducts as $product)
        {
            $ttlamount += $product->amount;
        }
        $model->amount= $ttlamount;
        $status = $model->save();
        if($status)
        {
            $amount = $ttlamount;
        }
        return $status;
    }
    public function updateOrder($Id, &$amount)
    {
        $model = Order::model()->findByPk($Id);
        $amount = $model->amount;
        $ttlamount = 0;
        foreach($model->orderproducts as $product)
        {
            $ttlamount += $product->amount;
        }
        $model->amount= $ttlamount;
        $status = $model->save();
        if($status)
        {
            $amount = $ttlamount;
        }
        return $status;
    }
    public function getMysqlFormattedDatetime( $datestr, $format = null, $tomysql = true)
    {
        $mysqldate = null;
        try{
            if(empty($format))
            {
                if($tomysql)
                {
                    $format = $this->datetimemysqlformatYMDHIS;
                }
                else
                {
                   $format = $this->datetimemysqlformatDMY;//$this->cJuiDatePickerViewFormat;
                }
            }
            if($tomysql)
            {
                $datestr = str_replace( "/", "-", $datestr );
            }
            else
            {
               $datestr = str_replace( "-", "/", $datestr );
            }
            $mkdate = strtotime( $datestr );
            if($mkdate == FALSE || $mkdate <= 0)
            {
                return $mysqldate;
            }
            $mysqldate = date( $format , $mkdate );
        }catch(Exception $e)
        {
            $mysqldate = null;
        }
        return $mysqldate;
    }
    public function writeToCookie($cookiename, $data)
    {
        if(!empty($cookiename))
        {
            $is_cookie = isset(Yii::app()->request->cookies[$cookiename]);
            if($is_cookie)
            {
                unset(Yii::app()->request->cookies[$cookiename]);
            }
            Yii::app()->request->cookies[$cookiename] = new CHttpCookie($cookiename, $data);
        }
    }
    public function readFromCookie($cookiename, $todelete)
    {
        $value = '';
        if(!empty($cookiename))
        {
            $is_cookie = isset(Yii::app()->request->cookies[$cookiename]);
            if($is_cookie)
            {
                $value = Yii::app()->request->cookies[$cookiename];
                if($todelete)
                {
                    unset(Yii::app()->request->cookies[$cookiename]);
                }
            }
        }
        return $value;
    }
    public function getJsonOfData($RetCode = 1, $data = array(), $message = 'dummy')
    {
        $rtndata = array('RetCode' => $RetCode, 'data' => $data, 'message' => $message);        
        $data = CJSON::encode($rtndata);
        $data = str_replace('\/', '/', $data);
        return $data;
    }
    public function returnJsonAsCookie($RetCode = 1, $data = array(), $message = 'dummy', $cookiename = null)
    {
        $data = $this->getJsonOfData($RetCode, $data, $message);
        $this->writeToCookie($cookiename, $data);
        Yii::app()->end();
    }
    public function returnJsonResponse($RetCode = 1, $data = array(), $message = 'dummy')
    {
        $data=$this->getJsonOfData($RetCode, $data, $message);
        $this->echoJsondata($data);        
    }
    public function returnJsonResponseII($data)
    {        
        $data = CJSON::encode($data);
        $data = str_replace('\/', '/', $data);
        $this->echoJsondata($data);
    }
    public function echoJsondata($data)
    {
        header('Content-type: application/json');
        echo $data;
        Yii::app()->end();       
    }
    public function greaterthanzero($gvnnumber)
    {
        return $gvnnumber > 0;
    }
    public function getOrdertypesLookup()
    {
        $objary = array();
        $i = 1;
        foreach ($this->ordertypes as $type){
            $tmp = new stdClass();
            $tmp->id = $type;
            $tmp->name = $type;
            $objary[] = $tmp;
        }
        $listdata = CHtml::listData($objary, 'id', 'name');
        return $listdata;
    }
    public function getAddresstypesLookup()
    {
        $objary = array();
        $objary['']='Select';
        $i = 1;
        foreach ($this->addresstypes as $type){
            $tmp = new stdClass();
            $tmp->id = $type;
            $tmp->name = $type;
            $objary[] = $tmp;
        }
        $listdata = CHtml::listData($objary, 'id', 'name');
        return $listdata;
    }
    public function getAccounttypesLookup()
    {        
        $objary = array();       
        foreach ($this->accountTypes as $type)
        {
            $tmp = new stdClass();
            $tmp->id = $type;
            $tmp->name = $type;
            $objary[] = $tmp;
        }
        $listdata = CHtml::listData($objary, 'id', 'name');
        return $listdata;
    }
    public function getPaymentdirectionsLookup()
    {        
        $objary = array();       
        foreach ($this->paymentDirections as $type)
        {
            $tmp = new stdClass();
            $tmp->id = $type;
            $tmp->name = $type;
            $objary[] = $tmp;
        }
        $listdata = CHtml::listData($objary, 'id', 'name');
        return $listdata;
    }
    public function getDeliverytypesLookup()
    {
        $objary = array();
        $i = 1;
        foreach ($this->deliveryTypes as $type){
            $tmp = new stdClass();
            $tmp->id = $type;
            $tmp->name = $type;
            $objary[] = $tmp;
        }
        $listdata = CHtml::listData($objary, 'id', 'name');
        return $listdata;
    }
    public function getServicetypesLookup()
    {
        $objary = array();
        foreach ($this->serviceTypes as $type){
            $tmp = new stdClass();
            $tmp->id = $type;
            $tmp->name = $type;
            $objary[] = $tmp;
        }
        $listdata = CHtml::listData($objary, 'id', 'name');
        return $listdata;
    }
    public function getSurchargeTypesLookup()
    {
        $objary = array();
        foreach ($this->surchargeTypes as $type){
            $tmp = new stdClass();
            $tmp->id = $type;
            $tmp->name = $type;
            $objary[] = $tmp;
        }
        $listdata = CHtml::listData($objary, 'id', 'name');
        return $listdata;
    }
    public function getOrderInvStatusesLookup()
    {
        $objary = array();
        foreach ($this->orderInvStatuses as $type)
        {
            $tmp = new stdClass();
            $tmp->id = $type;
            $tmp->name = $type;
            $objary[] = $tmp;
        }
        $listdata = CHtml::listData($objary, 'id', 'name');
        return $listdata;
    }
    public function getReportsGroupbyStrings()
    {
        $objary = array();
        foreach ($this->reportsGroupbyStrings as $type)
        {
            $tmp = new stdClass();
            $tmp->id = $type;
            $tmp->name = $type;
            $objary[] = $tmp;
        }
        $listdata = CHtml::listData($objary, 'id', 'name');
        return $listdata;
    }
    public function getSplseachStringsLookup()
    {
        $objary = array();
        foreach ($this->splseachStrings as $type)
        {
            $tmp = new stdClass();
            $tmp->id = $type;
            $tmp->name = $type;
            $objary[] = $tmp;
        }
        $listdata = CHtml::listData($objary, 'id', 'name');
        return $listdata;
    }
    public function getPaidStatusLookup()
    {
        $objary = array();
        foreach ($this->paidstatuss as $type)
        {
            $tmp = new stdClass();
            $tmp->id = $type;
            $tmp->name = $type;
            $objary[] = $tmp;
        }
        $listdata = CHtml::listData($objary, 'id', 'name');
        return $listdata;
    }
    public function alwaysApplyOrderCriteria(&$criteria, $excludeinactive=true)
    {
        if(!Yii::app()->controller->isSUorAdmin())
        {//return only those jobs belong to loggedin person.
            $loggedinppltype = Yii::app()->user->role->role;
            $person_id = Yii::app()->user->person->id;
            $criteria->compare('orderpeople.person_id', $person_id);
            $criteria->compare('LCASE(orderpeople.type)',strtolower($loggedinppltype));
        }
        $this->exculdeDefaultOrderRecord($criteria, $excludeinactive);
    }
    public function exculdeDefaultOrderRecord(&$criteria, $excludeinactive = true)
    {
        $criteria->addCondition('LCASE(qoi_id) != "dummy"');
        $this->criteriaForActiveOrderRecord($criteria, $excludeinactive);
    }
    public function exculdeDefaultProductPriceRecord(&$criteria, $excludeinactive = true)
    {
        $criteria->addCondition('LCASE(code) != "dummy_prd"');
        $this->criteriaForActiveProductPriceRecord($criteria, $excludeinactive);
    }
    public function criteriaForActiveOrderRecord(&$criteria, $excludeinactive=true)
    {
        if($excludeinactive)
        {
            $criteria->addCondition('t.status != 0');
        }
    }
    public function criteriaForActiveProductPriceRecord(&$criteria, $excludeinactive=true)
    {
        if($excludeinactive)
        {
            $criteria->addCondition('t.status != 0');
        }
    }
    public function getOrdersLookup()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'name asc';
        $this->alwaysApplyOrderCriteria($criteria);
        $models = Order::model()->findAll($criteria);
        $models = CHtml::listData($models, 'id', 'name');
        return $models;
    }
    public function saveOrUpdateLogin($model, &$person = null)
    {
        $prvlogin = strtolower($model->login);
        $model->attributes = $_POST['Login'];
        $model->login = strtolower($model->login);
        $model->pass = strtolower($model->pass);
        $isnew = empty($model->id);
        $success_saving_all = false;
        try
        {
            if(empty($person)) return $success_saving_all;
            if($isnew || $prvlogin !== $model->login)
            {
                $record =  Personcompanyrole::model()->with(array(
                'company' => array('condition'=>'company.id = ' . Yii::app()->user->company->id),
                'login' => array('condition'=>'login.login="' . $model->login . '"'),
                ))->together()->findAll();
                $isduplicate = count($record) > 0 && isset($record[0]);
            }
            else
            {
                $isduplicate = false;
            }
            if($isduplicate)
            {
               return $success_saving_all; 
            }
            if($isnew)
            {
                $model->created_at = new CDbExpression('NULL'); 
                $model->updated_at = new CDbExpression('NULL');                
            }
            else
            {
                $model->updated_at = new CDbExpression('NULL');
            }
            $withary = array(
                        'company' => array('condition'=>'company.id = ' . Yii::app()->user->company->id),            
                        'person' => array('condition'=>'person.id = ' . $person->id),                        
                        'login'
                    );
            $records =  Personcompanyrole::model()->with($withary)->together()->findAll();
            $found = count($records) > 0;
            if($found)
            {
                foreach($records as $record)
                {
                    if($record->role_id === $person->role_id)
                    {
                        $login = $record->login;
                        break;
                    }
                }
                if(empty($login))
                {
                    $login = new Login;
                }
                $login->login = $model->login;
                $login->pass = $model->pass;
                $login->status = 1;
                $success_saving_all = $login->save();
                $person->login = $login;
            }
            else
            {
                $success_saving_all = $model->save();
                $person->login = $model;
            }
        }
        catch (Exception $e)
        {
            $success_saving_all = false;
            Yii::log("Error occurred while saving/activating person. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
        }
        return $success_saving_all;
    }
    public function deleteLogin($id)
    {
        $model=Login::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        $model->status = 0;
        return $model->save();
    }
    public function saveOrUpdateAddress($model, &$person = null)
    {        
        $model->attributes = $_POST['Location'];
        $isnew = empty($model->id);
        $success_saving_all = false;
        try
        {
            if(empty($person)) return $success_saving_all;
            if($isnew)
            {
                $model->created_at = new CDbExpression('NULL'); 
                $model->updated_at = new CDbExpression('NULL');                
            }
            else
            {
                $model->updated_at = new CDbExpression('NULL');
            }
            $success_saving_all = $model->save();
            $person->address = $model;
        }
        catch (Exception $e)
        {
            $success_saving_all = false;
            Yii::log("Error occurred while saving/activating person. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
        }
        return $success_saving_all;
    }
    public function deleteAddress($id)
    {
        $model=Location::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model->delete();
    }
    public function setStatusToHistoryFieldsMap($forwhat = 1)//1 web client 2 mobile client
    {
        $stsarray = array();
        $this->statusToHistoryFieldsMap = $stsarray;
        $this->statusToHistoryFieldsMap[1] = $stsarray;//for orderstatuses
        $this->statusToHistoryFieldsMap[2] = $stsarray;//for taskstatuses
        
        //getting statuses from db;
        //statusMap array[key(ofwhichid-1-orders,2-ordertasks etc.,), array[key(statusnmae), value(stsordinalnumber)]
        
        if($forwhat === 1)
        {
            $statuses = Yii::app()->user->orderstatuses;
        }
        else
        {
            $statuses = $this->mobileUser->orderstatuses;
        }
        if(!empty($statuses))
        {
            $stsarray = array();
            $fldnumber = 1;//history table fieldnames
            foreach ($statuses as $id=>$status)
            {
                $stsarray[$id] = $fldnumber++;
            }
            $this->statusToHistoryFieldsMap[1] = $stsarray;
        }        
        if($forwhat === 1)
        {
            $statuses = Yii::app()->user->taskstatuses;
        }
        else
        {
            $statuses = $this->mobileUser->taskstatuses;
             
        }
        if(!empty($statuses))
        {
            $stsarray = array();
            $fldnumber = 1;//history table fieldnames
            foreach ($statuses as $id=>$status)
            {
                $stsarray[$id] = $fldnumber++;
            }
            $this->statusToHistoryFieldsMap[2] = $stsarray;
        }
    }
    public function setStatusHistoryFieldToStatusesMap($forwhat = 1)
    {
        $stsarray = array();
        $this->statusHistoryFieldToStatusesMap = $stsarray;
        $this->statusHistoryFieldToStatusesMap[1] = $stsarray;
        $this->statusHistoryFieldToStatusesMap[2] = $stsarray;        
    }
    public function getStatusHistoryFieldFromId($ofwhich, $status, &$higherflds = array())
    {
        $stsfld = null;
        $statuses = (isset($this->statusToHistoryFieldsMap[$ofwhich])?$this->statusToHistoryFieldsMap[$ofwhich]:array());        
        if(empty($statuses))
        {
            return $stsfld;
        }
        else
        {
            $countofstatuses = count($statuses);
            if(!empty($statuses[$status]))
            {
                $num = $statuses[$status];
                $stsfld = 'status' . $num . 'dt';
                $higherflds = array();
                for($i = $num + 1; $i <= $countofstatuses; $i++){
                    $higherflds[] = 'status' . $i . 'dt';
                }
            }
        }
        return $stsfld;
    }
    public function setAdddressesForACustomer(&$model)
    {
        if(empty($model->customer)) return;
        $isnewfrom = isset($_POST['isnewfrom'])?$_POST['isnewfrom']:false;
        if($isnewfrom)
        {
            $model->fromaddr = new Location;
        }
        else
        {
            if(empty($model->id))
            {
                if(count($model->customer->myaddresses)>0)
                {
                    $model->fromaddr = $model->customer->myaddresses[0];
                }else if(count($model->customer->orderfromaddresses)>0)
                {
                    $model->fromaddr = $model->customer->orderfromaddresses[0];
                }
            }
            if(empty($model->fromaddr))
            {
                $model->fromaddr = new Location;
            }
        }
        $isnewto = isset($_POST['isnewto'])?$_POST['isnewto']:false;
        if($isnewto)
        {
            $model->toaddr = new Location;
        }
        else
        {
            if(empty($model->id))
            {
                if(count($model->customer->ordertoaddresses)>0)
                {
                    $model->toaddr  = $model->customer->ordertoaddresses[0];
                }
            }
            if(empty($model->toaddr))
            {
                $model->toaddr = new Location;
            }
        }
        $model->fromaddr_id = $model->fromaddr->id;    
        $model->isnewfrom = empty($model->fromaddr_id);
        
        $model->toaddr_id = $model->toaddr->id;
        $model->isnewto = empty($model->toaddr_id);
        if($model->isnewto)
        {
            $model->toperson_name =  '';
            $model->toperson_mbl = '';
        }
        else
        {
            foreach($model->orderaddresses as $ordaddr)
            {
               if(strtolower($ordaddr->type) === strtolower(Helper::CONST_To)
                       && $ordaddr->location_id === $model->toaddr_id)
               {
                   $model->toperson_name = $ordaddr->name;
                   $model->toperson_mbl = $ordaddr->mobile;
               }
            }
        }
    }
    public function setToAddressNameDetails($model)
    {
        $namedtls = array();
        $namedtls['name'] = '';
        $namedtls['mobile'] = '';        
        $model->toperson_name =  $namedtls['name'];
        $model->toperson_mbl = $namedtls['mobile'];
    }
    public function updatestatushistory($ofwhich, $ofwhichid, $status, $statusdt)
    {//1 -order 2- ordertask etc.,
//            $statusmodel = Statusmaster::model()->getStatusByNameOrId($status, $ofwhich, true);
//            if(empty($statusmodel))
//            {
//                return;
//            }
//            $status = $statusmodel->name;
        $rtn = false;
        try
        {
            $higherflds = array();
            $stsfldtoupdate = $this->getStatusHistoryFieldFromId($ofwhich, $status, $higherflds);
            if(empty($stsfldtoupdate))
            {
                return;
            }
            $cndn = 'ofwhich_id=:ofwhich';
            $params = array(':ofwhich' => $ofwhichid);
            $criteria=new CDbCriteria(array(
                                    'condition' => $cndn,
                                    'params'=> $params,
                            ));
            $result = Statushistory::model()->findAll($criteria);            
            $attributes = array(
                    "$stsfldtoupdate" => $statusdt
                    );
            foreach($higherflds as $higerfld)
            {
                $attributes["$higerfld"] = null;
            }
            if(!empty($result) && !empty($result[0]))
            {
                $record = Statushistory::model()->findByPk($result[0]->id);
            }
            else
            {
                $record = new Statushistory;
                $attributes["ofwhich_id"] = $ofwhichid;
            }
            if(!empty($record))
            {
                $record->attributes = $attributes;
                $rtn = $record->save();
            }
        }
        catch(Exception $e)
        {
           $rtn = false; 
        }
        return $rtn;
    }
    public function prepareOrderGridOptions(
                        $actionname, 
                        $height=Helper::CONST_grid_Height_400,
                        $fontsize=Helper::CONST_grid_Font_12,
                        $template = Helper::CONST_grid_Template_SI
    )
    {
        $columns = $this->prepareOrderGridColumns($actionname);
        $options = array(
                        'columns' => $columns,
                        //'filter' => $model,
                    );
        $this->setDefaultGVOptions($options, $height, $fontsize, $template);
        return $options;
    }
    public function prependDesc(&$flds)
    {
        $tmp = array();
        $desc = array('name' => 'desc',
                        'header' => 'Jobs',
                        'type' => 'raw',
                        'value' => '$data->displayDesc');
        $tmp['desc'] = $desc;
        $flds = array_merge($tmp, $flds);
    }
    public function prependIndicator(&$flds)
    {
        $tmp = array();
        $indicator = array('name' => 'indicator', 'header'=> 'Type'
                                ,'type' => 'raw', 'value'=>'$data->displayIndicator');
        $tmp['indicator'] = $indicator;
        $flds = array_merge($tmp, $flds);
    }
    public function prependSerial(&$flds)
    {
        $tmp = array();
        $serial = array('name' => 'serial', 'header'=> 'S.No.'
                                ,'type' => 'raw', 'value'=>'++$row');
        $tmp['serial'] = $serial;
        $flds = array_merge($tmp, $flds);
    }
    public function arrangeOrderGridForAdminAction(&$flds)
    {        
        $this->prependDesc($flds);
        $this->prependIndicator($flds);
        $flds['customer_id'] = array('name' => 'customer_id'
                            ,'type' => 'raw'
                            ,'value' => '$data->displayCustomer2'
                        );
        $flds['amount'] =  array('name' => 'amount');
        $flds['invstatus'] =  array('name' => 'invstatus',
                                'type' => 'raw',
                                'value'=>'$data->displayInvStatus');
    }
    public function arrangeOrderGridForIndexAction(&$flds)
    {
        if($this->isCustomer())
        {
            unset($flds['employee_id']);
            unset($flds['addnlinfo3']);
        }
        else
        {
            $this->prependIndicator($flds);
        }
        $flds['customer_id'] = array('name' => 'customer_id'
                                        ,'type' => 'raw'
                                        ,'value' => '$data->displayCustomer'
                                    );
        if($this->isSUorAdmin())
        {
            $flds['dummy'] = array('name' => 'dummy', 'header'=> 'ASSIGN'
                                ,'type' => 'raw', 'value'=>'$data->empDropdown');
        }
    }
    public function arrangeOrderGridForRidersHistoryAction(&$flds)
    {
        unset($flds['customer_id']);
        unset($flds['addnlinfo3']);
        $flds['fromaddr_id'] = array('name' => 'fromaddr_id','header'=>'From','type' => 'raw','value' => '$data->displayPickedupStatus');
        $flds['toaddr_id'] = array('name' => 'toaddr_id','header'=>'To','type' => 'raw','value' => '$data->displayClosedStatus');
        $tmp = array();
        $tmp['employee_id'] = $flds['employee_id'];
        unset($flds['employee_id']);
        $flds = array_merge($tmp, $flds);
    }
    public function arrangeOrderGridForOrderslistpdfAction(&$flds)
    {
        //serial number column;
        //$flds = array_merge(array('Serial' => array('name' => 'Serial', 'header' => 'Serial')),$flds);
        $tmp = array();     
        $tmp['addnlinfo'] = $flds['addnlinfo'];
        $tmp['addnlinfo1'] = $flds['addnlinfo1'];
        $tmp['customer_id'] = $flds['customer_id'];
        unset($flds['addnlinfo']);
        unset($flds['addnlinfo1']);
        unset($flds['customer_id']);
        $flds = array_merge($tmp, $flds);
        $this->prependSerial($flds);
        $flds['customer_id'] = array('name' => 'customer_id'
                            ,'type' => 'raw'
                            ,'value' => '$data->displayCustomer2'
                        );
    }
    public function prepareOrderGridColumns($actionname)
    {
        $btncols = array();
        $columns = array();
        $flds = $this->appFormFields['lf']['order'];        
        $flds['employee_id'] = array('name' => 'employee_id','type' => 'raw','value' => '$data->displayEmployee');        
        $flds['fromaddr_id'] = array('name' => 'fromaddr_id','header'=>'From','type' => 'raw','value' => '$data->displayFrom');
        $flds['toaddr_id'] = array('name' => 'toaddr_id','header'=>'To','type' => 'raw','value' => '$data->displayTo');
        $flds['status'] = array('name' => 'status','value' => '$data->displayStatus');
        switch(strtolower($actionname))
        {
            case strtolower(Helper::CONST_adminactionid):
                $this->arrangeOrderGridForAdminAction($flds);
                break;
            case strtolower(Helper::CONST_indexactionid):
                $this->arrangeOrderGridForIndexAction($flds);
                break;
            case strtolower(Helper::CONST_dba_ridershistory):
                $this->arrangeOrderGridForRidersHistoryAction($flds);                
                break;
            case strtolower(Helper::CONST_dba_orderslistpdf):
                $this->arrangeOrderGridForOrderslistpdfAction($flds);                
                break;
            default:
                break;
        }
        $columns = array_merge( $btncols, $flds );
        return $columns;
    }
    private function setMPdf( $mode = 'bn', $paper = 'A4' )
    {
        $this->pdfobj = Yii::app()->ePdf->mpdf( $mode, $paper ); //bangali  bn
        $docroot = $_SERVER["DOCUMENT_ROOT"];
        $boosterpath = $docroot . Yii::app()->components['booster']->getAssetsUrl();
        $css1 = $boosterpath . '/bootstrap/css/bootstrap.min.css';        
        $css2 = $boosterpath . '/css/bootstrap-yii.css';
        $css3 = $boosterpath . '/css/jquery-ui-bootstrap.css';
        $appcss1 = $this->assetsBase . '/css/main_cr/core/core.css';        
        $appcss2 = $this->assetsBase . '/css/main_cr/reset.css';
        $appcss3 = $this->assetsBase . '/css/main_cr/app.css';
        //$t1 = file_get_contents($css1);
        $this->pdfobj->WriteHTML(file_get_contents($css1),1);
        $this->pdfobj->WriteHTML(file_get_contents($css2),1);
        $this->pdfobj->WriteHTML(file_get_contents($css3),1);
        $this->pdfobj->WriteHTML(file_get_contents($appcss1),1);
        $this->pdfobj->WriteHTML(file_get_contents($appcss2),1);
        $this->pdfobj->WriteHTML(file_get_contents($appcss3),1);
    }
    public function writeToPdf( $html, $mode = 'bn', $paper = 'A4', $dest = '', $name = '' )
    {
        if ( is_null( $this->pdfobj ) )
        {
            $this->setMPdf( $mode, $paper );
        }
        $this->pdfobj->WriteHTML( $html );
        # Outputs ready PDF
        $this->pdfobj->Output( $name, $dest );
    }
     public function directPrint($header,$dataArray,$XaxisArray=array(0,30,220,270,340),$Yaxis=30)
    {
               
$your_printer_name = "EPSON TM-U220 Receipt";
$p=printer_open($your_printer_name);
printer_start_doc($p,"Testpage");
printer_start_page($p);
$pen = printer_create_pen(PRINTER_PEN_DOT, 1, "000000");
$font = printer_create_font("Draft Condensed",20,6, PRINTER_FW_ULTRALIGHT, false, false, false, 0);

printer_select_pen($p, $pen);
printer_select_font($p, $font);






printer_draw_text($p,"SALVA'S MART @ ESPLANADE",100,0);
printer_draw_text($p,"8, RAFFLES AVENUE, #01-08A, Singapore (039802)",50,30);
printer_draw_text($p,"Date :".date('d/m/Y'),0,60);
printer_draw_text($p,"Time :".date('h:i A'),270,60);
printer_draw_line($p, 0,90, 500, 90);     
   
printer_draw_text($p,$header,0,110);

$noofRows=count($dataArray);
$yStart=140;
for($i=0; $i<$noofRows; $i++){
$y=($i*$Yaxis)+$yStart;
$tdCount=count($dataArray[0]);
		for($j=0; $j<$tdCount; $j++){
		$x=$XaxisArray[$j];
                printer_draw_text($p,$dataArray[$i][$j],$x,$y);		
	}

}
printer_draw_text($p,"Thank You!!! Visit Again!!!",100,$y+50);


printer_delete_font($font);
printer_delete_pen($pen);
printer_end_page($p);
printer_end_doc($p);
printer_close($p);
        
    }
    public function getAppType()
    {
        //todo
    }
    public function isAppIDEndswith($suffix)
    {
        $appid = strtolower($this->appId);
        return Helper::endsWith($appid, $suffix);
    }
    public function isCRMTypeAPP()
    {
        $suffix = strtolower(Yii::app()->params['appIdCRM']);
        return $this->isAppIDEndswith($suffix);
    }
    public function isCRTypeAPP()
    {
        $suffix = strtolower(Yii::app()->params['appIdCR']);
        return $this->isAppIDEndswith($suffix);
    }
    public function isSALESTypeAPP()
    {
        $suffix = strtolower(Yii::app()->params['appIdSALES']);
        return $this->isAppIDEndswith($suffix);
    }
    public function isPOSTypeAPP()
    {
        $suffix = strtolower(Yii::app()->params['appIdPOS']);
        return $this->isAppIDEndswith($suffix);
    }
    public function isPCTypeAPP()
    {
        $suffix = strtolower(Yii::app()->params['appIdPC']);
        return $this->isAppIDEndswith($suffix);
    }
    public function checkForLoginModel($model, $extroleid, $isNew)
    {
        $rtn = true;
        if($model->enablelogin && (empty($model->login->id) || $model->editpassword))
        {
            $rtn = $this->saveOrUpdateLogin($model->login, $model);
        }
        else if(!$model->enablelogin && !empty($model->login) && $model->login->id > 0)
        {
            $rtn = $this->deleteLogin($model->login->id);
        }
        if($rtn)
        {
            $rtn = $this->saveOrUpdateRole($model, $extroleid);
        }
        return $rtn;
    }
    public function checkForAddress($model)
    {
        $rtn = true;        
        if(!empty($model->addresstype))
        {
            $rtn = !empty($_POST['Location']);
            if(!$rtn) return true;//location is not posted and it is optional
            $rtn = $this->saveOrUpdateAddress($model->address, $model);
            if($rtn)
            {
                if($this->isCRTypeAPP())
                {
                    $rtn = $this->saveOrUpdatePersonAddress($model, null);//only one type address is allowed.
                }
                else
                {
                   $rtn = $this->saveOrUpdatePersonAddress($model, $model->addresstype);
                }
            }
        }
        return $rtn;
    }
    public function saveOrUpdatePersonAddress($model, $addrtype = null)
    {
        $rtn = true;
        $paramarray = array(
                                'person_id'=> $model->id,
                                'location_id'=> $model->address->id,                                
                            );
        if(!empty($addrtype))
        {
            $paramarray['type'] = $addrtype;
        }
        $records = Personaddress::model()->findAllByAttributes($paramarray);
        $found = count($records) > 0;
        if($found)
        {
            $record = $records[0];
        }
        else
        {
            $record = new Personaddress;
        }
        $record->type = $model->addresstype;
        $record->person_id = $model->id;
        $record->location_id = $model->address->id;
        $rtn = $record->save();
        $model->address = $record;
        return $rtn;
    }
    public function checkForContact(&$model)
    {        
        switch($model->rolename)
        {
            case Helper::CONST_Supplier:
            case Helper::CONST_Customer:
            case Helper::CONST_Contractor:
                $model->enablecontact = 1;
                break;
            default:
                $model->enablecontact = 0;
                break;
        }
    }
    public function postProcessForPersonSave($model, $extroleid, $isnew)
    {
        $rtn = $this->checkForLoginModel($model, $extroleid, $isnew);
        if($rtn)
        {
            $rtn = $this->checkForAddress($model);
            if($rtn)
            {
                $this->setPeopleLookupInState($model->rolename);//refresh
                //$rtn = $this->prepareMailForNewEmployee($model);
                $rtn = true;
            }
        }
        return $rtn;
    }
    public function saveOrUpdateRole($model, $extroleid = null)
    {
        $person_id = $model->id;
        $role_id = empty($extroleid)?$model->role_id:$extroleid;
        $company_id = Yii::app()->user->company->id;
        $login_id =  (empty($model->login->id)?0:$model->login->id);
        
        $condition = 'person_id=' . $person_id;
        $condition .= ' AND company_id = ' . $company_id;
        $condition .= ' AND role_id = ' . $role_id;
        
        $criteria = new CDbCriteria;
        $criteria->select = array( 'id' );
        $criteria->condition = $condition;
        $result = Personcompanyrole::model()->findAll( $criteria );                
        if(count($result) === 1)
        {
            $percomprole = Personcompanyrole::model()->findByPk( $result[0]->id );
            $percomprole->updated_at = new CDbExpression('NULL');
        }
        else
        {
            $percomprole = new Personcompanyrole;
            $percomprole->created_at = new CDbExpression('NULL'); 
            $percomprole->updated_at = new CDbExpression('NULL');
        }
        $percomprole->person_id = $person_id;
        $percomprole->company_id = $company_id;
        $percomprole->role_id = $model->role_id;
        $percomprole->login_id = $login_id;
        $percomprole->status = $model->status;
        return $percomprole->save();
    }
    public function setPeopleConfigs($model)
    {
        $model->enablepplcode = $this->getEnablepplcode();
        $model->enablepplauxname = $this->getEnablepplauxname();
        $model->enablecontact = $this->getEnablecontact() 
                                 && $model->rolename !== Helper::CONST_Employee;
    }    
    public function addOrUpdatePersonTimeSlots($personId, $slotdate, $slotvalue)
    {
        if(empty($slotdate)) return false;
        $t1 = '';
        $t2 = '';
        $this->splitCT($slotdate, $t1, $t2);
        $slot = $this->getSlotfromCT($t1);
        $rtn = $slot !== null;
        if(!$rtn) return $rtn;
        
        $criteria=new CDbCriteria();
        $criteria->addCondition('person_id =' . $personId);
        $criteria->addCondition('DATE(slotdate) >= DATE("'. $t1 .'")');
        $result = Persontimeslot::model()->findAll($criteria);
        //$slotdatestr = $slotdate->format('Y-m-d');
        //Yii::app()->controller->getMysqlFormattedDatetime($slotdate)
        if(count($result) > 0)
        {
            $rec= $result[0];
        }
        else if($slotvalue > 0)
        {
            $rec = new Persontimeslot;
        }
        else
        {
            return true;//no work. meaningless.
        }
        $oldvalue = (is_null($rec->$slot))?0:$rec->$slot;
        $newvalue = $oldvalue + $slotvalue;
        if($newvalue <= 0) $newvalue = null;
        $attributes = array('person_id' => $personId
                            ,'slotdate' => $t1
                            ,"$slot" => $newvalue
                            );
        $rec->attributes = $attributes;
        $rtn = $rec->save();
        return $rtn;
    }
    public function getSlotfromCT($ct)
    {
        $slot = null;
        if(empty($ct)) return $slot;
        $timeslots = Helper::$timeslots;         
        $hrs = (int)$this->getMysqlFormattedDatetime($ct, 'H');
        $slot = $timeslots[$hrs];
        return $slot;
    }
    public function splitCT($datetimerange, &$t1, &$t2)
    {
        list($t1, $t2) = explode('-', $datetimerange);
        $t1 = Yii::app()->controller->getMysqlFormattedDatetime($t1);
        $t2 = Yii::app()->controller->getMysqlFormattedDatetime($t2);
    }
    public function checkForNon_Company($rolename, $username)
    {
        $record =  Personcompanyrole::model()
                    ->with(array(
                            'login' => array('condition'=>'login.login="' . strtolower($username) . '"' . ' AND login.status = 1'),
                            'role' => array('condition'=>'role.role="' . $rolename . '"' . ' AND role.status = 1'),
                            )
                    )->together()->findAll();
        return $record;
    }
    public function checkForLogin($username, $password, $isPassencoded, &$appConfigs, $rolename, &$rtnisnonsu)
    {
        $record = $this->checkForNon_Company($rolename, $username);
        $found = count($record) > 0 && isset($record[0]);
        
        if(strtolower( $rolename) === strtolower(Helper::CONST_SU))
        {
            if(!$found)
            {
                return $found;
            }
            $rtnisnonsu = false;
            $rtn = $this->checkPassword($record, true, false, $username, $password, $isPassencoded, $appConfigs);
            $result = $this->saveLoginHistory($rtn);
            if(!$result) return Helper::CONST_InternalServerError;
            return $rtn;
        }
        else
        {
            $isNonSu = strtolower( $rolename) === strtolower(Helper::CONST_Non_su);
            $found = $found && $isNonSu;
            $rtnisnonsu = $found;
            if(!$found)
            {
                $record =  Personcompanyrole::model()->with(array(
                    'login' => array('condition'=>'login.login="' . strtolower($username) . '"' . ' AND login.status = 1'),
                    'role' => array('condition'=>'role.status = 1'),
                    'company' => array('condition'=>'company.status = 1'),
                    'person' => array('condition'=>'person.status = 1')
                    ))->together()->findAll();
                $found = count($record) > 0 && isset($record[0]);
                if(!$found) return $found;
            }            
            $rtn = $this->checkPassword($record, false, $isNonSu, $username, $password, $isPassencoded, $appConfigs);
            
            if(!is_a($rtn, 'Personcompanyrole')) return $rtn;
            $result = $this->saveLoginHistory($rtn);
            if(!$result) return Helper::CONST_InternalServerError;            
            return $rtn;
        }
    }
    public function saveLoginHistory($rtn)
    {
        $loginhistory = new Loginhistory;
        $loginhistory->login_id = $rtn->login->id;
        $loginhistory->role_id = $rtn->role->id;
        $loginhistory->login_time = date($this->datetimemysqlformatYMDHIS);
        $result = $loginhistory->save();
        return $result;
    }
    public function checkPassword($record, $issu, $isnonsu, $username, $password, $isPassencoded, &$appConfigs)
    {
        $record = $record[0];
        if(!isset($isPassencoded) || $isPassencoded === 1)
        {
            $ispassok = $record->login->pass === strtolower($password).'$'. $this->salt;
        }
        else
        {
            if(strpos($record->login->pass,'$') !== false)
            {
                list($stored_pw, $stored_salt) = explode('$', $record->login->pass);
            }
            else
            {
                $stored_pw = $record->login->pass;
                $stored_salt = '';
            }                
            $ispassok = ($stored_pw === sha1(strtolower($username).strtolower($password).$stored_salt));
        }
        if(!$ispassok)
        {
            return Helper::CONST_InvalidUserPassword;
        }
        else
        {            
            $appConfigs = Yii::app()->controller->checkAppConfigs();
            if(!$appConfigs)
            {
                return Helper::CONST_InternalServerError;
            }
            return $record;
        }
    }
    public function backupAdditionalFields(&$bkup, $model)
    {
        $bkup['employee_id'] = $model->employee_id;
        $bkup['customer_id'] = $model->customer_id;
        $bkup['fromaddr_id'] = $model->fromaddr_id;
        $bkup['toaddr_id'] = $model->toaddr_id;
        $bkup['toperson_name'] = $model->toperson_name;
        $bkup['toperson_mbl'] = $model->toperson_mbl;
        $bkup['isnewcustomer'] = $model->isnewcustomer;
        $bkup['isnewfrom'] = $model->isnewfrom;
        $bkup['isnewto'] = $model->isnewto;
        $bkup['paidopen'] = $model->paidopen;
        $bkup['new_order_id'] = $model->new_order_id;
        $bkup['cust_cc'] = $model->cust_cc;
        $bkup['acnt_no'] = $model->acnt_no;
        $bkup['splsearch'] = $model->splsearch;
    }
    public function restoreAdditionalFields($bkup, &$model)
    {
        $model->employee_id = $bkup['employee_id'];
        $model->customer_id = $bkup['customer_id'];
        $model->fromaddr_id = $bkup['fromaddr_id'];
        $model->toaddr_id = $bkup['toaddr_id'];
        $model->toperson_name = $bkup['toperson_name'];
        $model->toperson_mbl = $bkup['toperson_mbl'];
        $model->isnewcustomer = $bkup['isnewcustomer'];
        $model->isnewfrom = $bkup['isnewfrom'];
        $model->isnewto = $bkup['isnewto'];
        $model->paidopen = $bkup['paidopen'];
        $model->new_order_id = $bkup['new_order_id'];
        $model->cust_cc = $bkup['cust_cc'];
        $model->acnt_no = $bkup['acnt_no'];
        $model->splsearch = $bkup['splsearch'];
    }
    public function updateOrderStatus($model, $prvct, $curct, $prvsts, $newsts, $prvemp, $curemp)
    {
        $model->status = $newsts;
        $rtn = $model->save(false);
        if($rtn)
        {
            $bkup = array();
            $this->backupAdditionalFields($bkup, $model);
            $model->refresh();
            $this->restoreAdditionalFields($bkup, $model);
            $statuschanged = strtolower($newsts) !== strtolower($prvsts);
            $rtn = !$statuschanged;
            if(!$rtn)
            {
                $rtn = $this->updatestatushistory(1, $model->id, $newsts, date($this->datetimemysqlformatYMDHIS));//1 -order 2- ordertask etc.,
            }
            if($rtn)
            {
                $openid = Yii::app()->controller->getStatusIdFromName(Helper::CONST_OPEN,1);
                $rejectid = Yii::app()->controller->getStatusIdFromName(Helper::CONST_REJECTED,1);
                $pickedupid = Yii::app()->controller->getStatusIdFromName(Helper::CONST_PICKEDUP,1);
                $closedid = Yii::app()->controller->getStatusIdFromName(Helper::CONST_CLOSED,1);                                
                
                $acceptedid = Yii::app()->controller->getStatusIdFromName(Helper::CONST_ACCEPTED,1);
                $assignedid = Yii::app()->controller->getStatusIdFromName(Helper::CONST_ASSIGNED,1);
                
                $stsplusvalueary = array($acceptedid, $assignedid);
                $stsminusvalueary = array($openid, $rejectid, $pickedupid, $closedid);
                
                if(in_array( $newsts, $stsplusvalueary ))
                {
                    if(!empty($curemp))
                    {
                        if(  !in_array( $prvsts, $stsplusvalueary ) )
                        {
                            $rtn = $this->addOrUpdatePersonTimeSlots($curemp, $curct, 1);
                        }
                        else if($curemp !== $prvemp)
                        {
                            $rtn = $this->addOrUpdatePersonTimeSlots($curemp, $curct, 1);
                            if($rtn)
                            {
                                $rtn = $this->addOrUpdatePersonTimeSlots($prvemp, $prvct, -1);
                            }                            
                        }
                    }
                }
                else
                {
                    if(!empty($prvemp))
                    {
                        if(  !in_array( $prvsts, $stsminusvalueary ) )
                        {
                            $rtn = $this->addOrUpdatePersonTimeSlots($prvemp, $prvct, -1);
                        }
                    }                                        
                }
            }
        }
        return $rtn;
    }
    public function addOrderStatusCriteria(&$criteria, $statusname = null)
    {
        if(empty($statusname)) return;
        $statusname = strtolower($statusname);
        if($statusname !== strtolower(Helper::CONST_UNDELIVERED)
            && $statusname !== strtolower(Helper::CONST_ExceptOpenRejected)
        )
        {
            $criteria->compare('LCASE(statusmaster.name)',strtolower($statusname));
        }else
        {
            switch($statusname)
            {
                case strtolower(Helper::CONST_UNDELIVERED):
                    $statusarray = array(strtolower(Helper::CONST_ASSIGNED),
                                        strtolower(Helper::CONST_ACCEPTED),
                                        strtolower(Helper::CONST_PICKEDUP),
                                    );
                    break;
                case strtolower(Helper::CONST_ExceptOpenRejected):
                    $statusarray = array(strtolower(Helper::CONST_ASSIGNED),
                                        strtolower(Helper::CONST_ACCEPTED),
                                        strtolower(Helper::CONST_PICKEDUP),
                                        strtolower(Helper::CONST_CLOSED)        
                                    );
                    break;
                default:
                    $statusarray = array();
                    break;
            }
            $criteria->addInCondition('LCASE(statusmaster.name)', $statusarray);                       
        }
    }
    public function addDateSearch(&$criteria,
            $ctasrange = null,
            $splsearch = null,
            $isjoinalias = false)
    {
        $fldname = 'DATE(addnlinfo1)';//do not add t.
        if($isjoinalias)
        {
            $fldname = 'DATE(t.addnlinfo1)';//add t.
        }
        if(!empty($ctasrange))
        {
            $t1 = '';
            $t2 = '';
            Yii::app()->controller->splitCT($ctasrange, $t1, $t2);
            //$criteria->compare('addnlinfo1',$this->addnlinfo1,true);
            $criteria->addCondition('DATE(t.addnlinfo1) >= DATE("'. $t1 .'")');
            $criteria->addCondition('DATE(t.addnlinfo1) <= DATE("'. $t2 .'")');
        }
        if(!empty($splsearch)
                && strtolower( $splsearch ) !== strtolower( Helper::CONST_ALL ))
        {
            $reqdate = Yii::app()->controller->getDateFromNouns($splsearch);
            $criteria->addCondition($fldname . ' = DATE("'. $reqdate .'")');
        }
    }
    public function addOrderDateSearch(&$criteria,$splsearch)
    {
        $fldname = 'DATE(updated_at)';//do not add t.
        if(!empty($splsearch)
                && strtolower( $splsearch ) !== strtolower( Helper::CONST_ALL ))
        {
            $reqdate = Yii::app()->controller->getDateFromNouns($splsearch);
            $criteria->addCondition($fldname . ' = DATE("'. $reqdate .'")');
        }
    }
    public function getFirstOrNewPerson($rolename = Helper::COSNT_Customer, $searchname = null)
    {
        $persons = array();
        $rsltrolename = null;
        switch(strtolower($rolename))
        {
            case strtolower(Helper::CONST_Manager):
                $persons = Yii::app()->user->companymanagers;
                break;
            case strtolower(Helper::CONST_Employee):
                $persons = Yii::app()->user->companyemployees;
                break;            
            case strtolower(Helper::CONST_Contractor):
                $persons = Yii::app()->user->companycontractors;
                break;
            case strtolower(Helper::CONST_Supplier):
                $persons = Yii::app()->user->companysuppliers;
                break;
            case strtolower(Helper::CONST_Customer):
            default:
                $persons = Yii::app()->user->companycustomers;
                break;                
        }
        $person = new Person;
        if(!empty($persons))
        {
            if(empty($searchname))
            {
                $person_ids = array_keys($persons);
            }
            else
            {
                $person_ids = array_keys(array_map('strtolower', $persons), strtolower($searchname));
            }
            $person_id = (!empty($person_ids)?$person_ids[0]:0);
            $person = Person::model()->findByPk($person_id);
            if(empty($person)) $person = new Person;
        }
        $role = Role::model()->getRoleByName($rolename);
        if(!empty($role))
        {
            $person->rolename = $role->role;
            $person->role_id = $role->id;
        }        
        return $person;
    }
    public function imageList($filenames) {
        $imageList = array();
        foreach ($filenames as $key => $value) {
            $imageList[$key] = CHtml::image(
                            Yii::app()->baseUrl . Yii::app()->params['imagePath'] . $value,
                            $value
            );
        }//foreach $filenames
        return $imageList;
    }
    public function getPostedData()
    {
        $reqData = Yii::app()->request->getRawBody();
        //$reqData =  file_get_contents('php://input');
        //$postedData = json_decode($reqData);
        $postedData = CJSON::decode($reqData);
        return $postedData;
    }
    public function getPersonByName($personname)
    {
        $dfltcustomer = Person::model()
                                ->findAll('LCASE(name) = "'. strtolower($personname) .'"');
        $dfltcustomerid = -1;
        if(!empty($dfltcustomer))
        {
            $dfltcustomerid = $dfltcustomer[0]->id;
        }
       return $dfltcustomerid;
    }
    public function checkIfAskBalance($type)
    {
        $rtn = 0;
        if($type === 1){
            $register = (empty(Yii::app()->user->register)?null:Yii::app()->user->register);
            $askbalance = (!empty($register) && is_null($register->op_balance));        
            if($askbalance) $rtn = '1'; else $rtn = '2';
        }
        if($type === 2){
            $register = (empty(Yii::app()->user->register)?null:Yii::app()->user->register);
            $askbalance = (!empty($register) && is_null($register->cl_balance));        
            if($askbalance) $rtn = '1'; else $rtn = '2';
        }
        return $rtn;
    }
    public function updateRegisterOpeningBalance($balance)
    {
        $register = (empty(Yii::app()->user->register)?null:Yii::app()->user->register);
        if(!empty($register))
        {
            $register->open_time = date(Yii::app()->controller->datetimemysqlformatYMDHIS);
            $register->op_balance = $balance;
            $register->save();
        }
    }
    public function updateRegisterClosingBalance($balance)
    {
        $register = (empty(Yii::app()->user->register)?null:Yii::app()->user->register);
        if(!empty($register))
        {
            $register->close_time = date(Yii::app()->controller->datetimemysqlformatYMDHIS);
            $register->cl_balance = $balance;
            $register->net_collection = $balance - $register->op_balance;
            $register->save();
        }
    }
    public function getRegisterBalanceReport($person = null)
    {
        $rsltObject = new stdClass();
        $personid = Yii::app()->user->person->id;
        $loginid = Yii::app()->user->login->id;
        $roleid = Yii::app()->user->role->id;
        $date = null;
        if(!empty($person))
        {
            $personid = (!empty($person->id)?$person->id:-1);
            $date = $person->selected_date;
            if(!empty($date))
            {
                $date = Yii::app()->controller->getMysqlFormattedDatetime($date);
            }
            $criteria=new CDbCriteria;
            $criteria->order = 't.id ASC';
            $criteria->with = array('roles'=> array('together'=>true));
            $criteria->limit = '1';
            $condition = "t.id = " . $personid;
            $condition .= " AND LCASE(roles.role) = '" . strtolower(Helper::CONST_Sales) . "'";
            $criteria->addCondition($condition);
            $result = Person::model()->findAll($criteria);
            foreach($result as $row)
            {
                $loginid = $row->personcompanyroles[0]->login_id;
                $roleid = $row->personcompanyroles[0]->role_id;
                break;
            }
        }
        $this->salesIncludesRefundCancel($rsltObject, $personid, $date);
        $this->totalRefunds($rsltObject, $personid, $date);
        $this->totalCancels($rsltObject, $personid, $date);
        $rsltObject->salesexclrfndcncl = $rsltObject->salesinclrfndcncl 
                + $rsltObject->totalrefunds + $rsltObject->totalcancels;
        $rsltObject->salesafterdisc = $rsltObject->salesexclrfndcncl 
                - $rsltObject->totaldisc;
        $rsltObject->salesafterroundoff = $rsltObject->salesafterdisc 
                + $rsltObject->netroundoff;
        $rsltObject->saleswithtax = $rsltObject->salesafterroundoff 
                + $rsltObject->totaltax;
        $this->paymentTypewiseSummary($rsltObject, $personid, $loginid, $roleid, $date);
        return $rsltObject;
    }
    public function paymentTypewiseSummary(&$rsltObject, $personid, $loginid, $roleid, $date = null)
    {
        $ttlCashSales = 0;
        $rsltObject->cashsummary = array();
        foreach(Yii::app()->controller->paymenttypes as $paymenttype)
        {
            $criteria=new CDbCriteria;                
            $criteria->select = array(
                new CDbExpression("IFNULL(SUM(t.amount),0) as tmptotal"),                
                                    );
            $condition = " LCASE(type) = '" . strtolower($paymenttype) . "'";
            $criteria->addCondition($condition);
            if(!empty($date))
            {
                $condition = " DATE(created_at) = DATE('". $date . "')";
            }
            else
            {
                $condition = "DATE(created_at) = DATE(NOW())";
            }
            $criteria->addCondition($condition);
            $condition = "person_id = " . $personid;
            $criteria->addCondition($condition);
            $result = Payment::model()->findAll($criteria);
            foreach($result as $row)
            {
                $rsltObject->cashsummary[] = array($paymenttype, $row->tmptotal);
                if($paymenttype == Helper::CONST_Cash)
                {
                    $ttlCashSales = $row->tmptotal;
                }
                break;
            }
        }
        $rsltObject->ttlcashSales = $ttlCashSales;
        $this->getRegisterOPBalance($rsltObject, $loginid, $roleid);
        $this->getRegisterCLBalance($rsltObject, $loginid, $roleid);
        $rsltObject->expectedCB = $rsltObject->ttlcashSales + $rsltObject->op_balance;
    }
    public function getRegisterOPBalance(&$rsltObject, $loginid, $roleid)
    {
        $rsltObject->op_balance = 0;
        //SELECT op_balance FROM registers WHERE DATE(created_at) = DATE(NOW()) ORDER BY id ASC LIMIT 1 
        $criteria=new CDbCriteria;
        $criteria->order = 'id ASC';
        $criteria->limit = '1';
        if(!empty($date))
        {
            $condition = " DATE(created_at) = DATE('". $date . "')";
        }
        else
        {
            $condition = "DATE(created_at) = DATE(NOW())";
        }
        $criteria->addCondition($condition);            
        $condition = "login_id = " . $loginid;
        $condition .= " AND role_id = " . $roleid;
        $criteria->addCondition($condition);
        $result = Register::model()->findAll($criteria);
        foreach($result as $row)
        {
            $rsltObject->op_balance = $row->op_balance;                
            break;
        }
    }
    public function getRegisterCLBalance(&$rsltObject, $loginid, $roleid)
    {
        $rsltObject->cl_balance = 0;
        //SELECT op_balance FROM registers WHERE DATE(created_at) = DATE(NOW()) ORDER BY id ASC LIMIT 1 
        $criteria=new CDbCriteria;
        $criteria->order = 'id DESC';
        $criteria->limit = '1';
        if(!empty($date))
        {
            $condition = " DATE(created_at) = DATE('". $date . "')";
        }
        else
        {
            $condition = "DATE(created_at) = DATE(NOW())";
        }
        $criteria->addCondition($condition);
        $condition = "login_id = " . $loginid;
        $condition .= " AND role_id = " . $roleid;
        $criteria->addCondition($condition);
        $result = Register::model()->findAll($criteria);
        foreach($result as $row)
        {
            $rsltObject->cl_balance = $row->cl_balance;                
            break;
        }
    }
    public function salesIncludesRefundCancel(&$rsltObject, $personid = -1, $date)
    {
        $criteria=new CDbCriteria;
        $criteria->with = array('statusmaster');
        $criteria->select = array(
            new CDbExpression("IFNULL(SUM(t.amount),0) as salesinclrfndcncl"),            
                                );
        Yii::app()->controller->exculdeDefaultOrderRecord($criteria);
        $condition = "LCASE(statusmaster.name) != '" . strtolower(Helper::CONST_CANCELNEW) . "'";
        $condition .= " AND LCASE(statusmaster.name) != '" . strtolower(Helper::CONST_REFUNDNEW) . "'";
        $criteria->addCondition($condition);
        if(!empty($date))
        {
            $condition = " DATE(created_at) = DATE('". $date . "')";
        }
        else
        {
            $condition = " DATE(created_at) = DATE(NOW())";
        }
        $criteria->addCondition($condition);
        $condition = "modified_id = " . $personid;
        $criteria->addCondition($condition);
        $result = Order::model()->findAll($criteria);
        $rsltObject->salesinclrfndcncl = 0;
        $rsltObject->totaldisc = 0;
        $rsltObject->totaltax = 0;
        foreach($result as $row)
        {
            $rsltObject->salesinclrfndcncl = $row->salesinclrfndcncl;            
            break;
        }
        
        $criteria=new CDbCriteria;
        $criteria->with = array('statusmaster');
        $criteria->select = array(
            new CDbExpression("IFNULL(SUM(t.disc),0) as totaldisc"),
            new CDbExpression("IFNULL(SUM(t.tax),0) as totaltax"),
            new CDbExpression("IFNULL(SUM(t.roundoff),0) as netroundoff"),
                                );
        Yii::app()->controller->exculdeDefaultOrderRecord($criteria);
        $condition = "LCASE(statusmaster.name) != '" . strtolower(Helper::CONST_CANCELNEW) . "'";
        $condition .= " AND LCASE(statusmaster.name) != '" . strtolower(Helper::CONST_REFUNDNEW) . "'";
        $condition .= " AND LCASE(statusmaster.name) != '" . strtolower(Helper::CONST_CANCELOLD) . "'";
        $condition .= " AND LCASE(statusmaster.name) != '" . strtolower(Helper::CONST_REFUNDOLD) . "'";
        $criteria->addCondition($condition);
        if(!empty($date))
        {
            $condition = " DATE(created_at) = DATE('". $date . "')";
        }
        else
        {
            $condition = "DATE(created_at) = DATE(NOW())";
        }
        $criteria->addCondition($condition);
        $condition = "modified_id = " . $personid;
        $criteria->addCondition($condition);
        $result = Order::model()->findAll($criteria);
        $rsltObject->totaldisc = 0;
        $rsltObject->totaltax = 0;
        $rsltObject->netroundoff = 0;
        foreach($result as $row)
        {
            $rsltObject->totaldisc = $row->totaldisc;
            $rsltObject->totaltax = $row->totaltax;
            $rsltObject->netroundoff = $row->netroundoff;            
            break;
        }
        $rsltObject->salesinclrfndcncl = $rsltObject->salesinclrfndcncl + $rsltObject->totaldisc - $rsltObject->totaltax - $rsltObject->netroundoff;
    }
    public function totalRefunds(&$rsltObject, $personid = -1)
    {
        $criteria=new CDbCriteria;
        $criteria->with = array('statusmaster');
        $criteria->select = array(
            new CDbExpression("IFNULL(SUM(t.amount),0) as totalrefunds"),                
                                );
        Yii::app()->controller->exculdeDefaultOrderRecord($criteria);
        $condition = "LCASE(statusmaster.name) = '" . strtolower(Helper::CONST_REFUNDNEW) . "'";
        $criteria->addCondition($condition);
        if(!empty($date))
        {
            $condition = " DATE(created_at) = DATE('". $date . "')";
        }
        else
        {
            $condition = "DATE(created_at) = DATE(NOW())";
        }
        $criteria->addCondition($condition);
        $condition = "modified_id = " . $personid;
        $criteria->addCondition($condition);
        $result = Order::model()->findAll($criteria);
        $rsltObject->totalrefunds = 0;
        foreach($result as $row)
        {
            $rsltObject->totalrefunds = $row->totalrefunds;                
            break;
        }
    }
    public function totalCancels(&$rsltObject, $personid = -1)
    {
        $criteria=new CDbCriteria;
        $criteria->with = array('statusmaster');
        $criteria->select = array(
            new CDbExpression("IFNULL(SUM(t.amount),0) as totalcancels"),                
                                );
        Yii::app()->controller->exculdeDefaultOrderRecord($criteria);
        $condition = "LCASE(statusmaster.name) = '" . strtolower(Helper::CONST_CANCELNEW) . "'";
        $criteria->addCondition($condition);
        if(!empty($date))
        {
            $condition = " DATE(created_at) = DATE('". $date . "')";
        }
        else
        {
            $condition = "DATE(created_at) = DATE(NOW())";
        }
        $criteria->addCondition($condition);
        $condition = "modified_id = " . $personid;
        $criteria->addCondition($condition);
        $result = Order::model()->findAll($criteria);
        $rsltObject->totalcancels = 0;
        foreach($result as $row)
        {
            $rsltObject->totalcancels = $row->totalcancels;                
            break;
        }
    }
    public function getAllProducts()
    {
        $product =  Product::model()->findAll();
        $productname = CHtml::listData($product, 'id', 'name');
        //$peopleLkup = array_merge(array('','-Select-'), $peopleLkup);
        return $productname;
    }
    public function getProductBarcode()
    {
        $prd= Subproductprice::model()->findAll();
        $prd = CHtml::listData($prd, 'sku', 'sku');
        return $prd;
    }
    public function getCodeLookup()
   {
       $code = Subproductprice::model()->findAll();
       $code = CHtml::listData($code, 'code', 'code');
       return $code;
   }
    public function getInvoiceLookup()
    {
        $invno= Productprice::model()->findAll();
        $invno = CHtml::listData($invno, 'invno', 'invno');
        return $invno;
    }
   public function getProductPriceCodeLookup()
    {
        $code = Subproductprice::model()->findAll();
        $code = CHtml::listData($code, 'code', 'code');
        return $code;
    }
    public function getProductPriceInvoiceLookup()
    {
        $invno= Productprice::model()->findAll();
        $invno = CHtml::listData($invno, 'invno', 'invno');
        return $invno;
    }
    public function getProductProductLookup()
    {
        $prd= Product::model()->findAll();
        $prd = CHtml::listData($prd, 'name', 'name');
        return $prd;
    }
    //AUTOCOMPLETE FUNCTION FOR  BILL NO
   protected function getOrderId()
    {
        $result = Order::model()->findAll();
        if ( count( $result ) > 0 )
        {
            $listdata = CHtml::listData( $result, 'id', 'qoi_id' );
        }
        else
        {
            $listdata = CHtml::listData( array ( ), 'id', 'qoi_id' );
        }
        return $listdata;
    }
//Autocomplete for barcode
    protected function getBarcodeId()
    {
        $result = Productprice::model()->findAll();
        if ( count( $result ) > 0 )
        {
            $listdata = CHtml::listData( $result, 'id', 'sku' );
        }
        else
        {
            $listdata = CHtml::listData( array ( ), 'id', 'sku' );
        }
        return $listdata;
    }
}