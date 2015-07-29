<?php
$hn_localhost = "http://localhost:7777/";
$hn_xvraws = "http://ec2-54-255-145-119.ap-southeast-1.compute.amazonaws.com/";
$hn_stnapps = "http://www.stnapps.com/";

$appIdALLINALL = "allinall";

$appIdCRM = "crm";//no more childs

$appIdCR = "cr";//courier
$appIdABCCR = "abc" . $appIdCR;
$appIdALLIANCECR = "alliance" . $appIdCR;

$appIdSALES = "sales";
$appIdHIMALAYASALES = "himalaya" . $appIdSALES;
$appIdLIANGYISALES = "liangyi" . $appIdSALES;
$appId3SSALES = "3s" . $appIdSALES;

$appIdPOS = "pos";

$appIdPC = "pc";//projectcosting
$appIdFTZPC = "ftz" . $appIdPC;
$appIdALIFPC = "alif" . $appIdPC;
$appIdSEAHORSEPC = "seahorse" . $appIdPC;
$appIdBMPPC = "bmp" . $appIdPC;
$appIdBPMPC = "bpm" . $appIdPC;
$appIdCSMEPC = "csme" . $appIdPC;
$appIdMCEPC = "mce" . $appIdPC;

//urls
$loginALLINALL = "allinall/";
$loginCRM = "crm/";

$loginCR = "courier/";
$loginABCCR = "abccourier/";
$loginALLIANCECR = "courier/";

$loginSALES = "sales/";
$loginHIMALAYASALES = "himalaya/";
$loginLIANGYISALES = "liangyi/";
$login3SSALES = "3s_inventory/";

$loginPC = "projectcosting/";
$loginFTZPC = "ftz_jobcosting/";
$loginALIFPC = "alif_jobcosting/";
$loginSEAHORSEPC = "seahorse_jobcosting/";
$loginBMPPC = "bmp/";
$loginBPMPC = "bpm/";
$loginCSMEPC = "csme/";
$loginMCEPC = "mce/";

$menuIDs = array(
    'Dashboard'
    ,'Category'
    ,'Taskmaster'
    ,'Statusmaster'
    ,'New Order'
    ,'Quote'
    ,'Order'
    ,'Job Assign'
    ,'Person'
    ,'Employee'
    ,'Customer'
    ,'Contractor'
    ,'Account'
    ,'Task'
    ,'Milestone'
    ,'Payment'
    ,'Supplier'
    ,'Purchase'
    ,'Product'
    ,'Profile'
    ,'Reports'
    ,'Logout'
    ,array('Masters'
            ,array(
                'Category'
                ,'Taskmaster'
                ,'Statusmaster'
            )
    )
    ,array('Persons'
        ,array(
            'Employee'
            ,'Customer'
            ,'Supplier'
            ,'Contractor'
        )
    )
    );
$allMenuIdx = array('all',array('logout','profile','Masters','Persons'));
$menuIdxCR = array('Dashboard','Logout', 'New Order', 'Order', 'Job Assign', 'Person', 'Account');
$menuIdxSALES = array('Dashboard','Logout', 'Customer','Supplier','Product','Order','Purchase','Account','Payment');
$menuIdxPC = array('Dashboard','Logout', 'Customer','Contractor','Order','Account','Payment');
$menuIdxPOS = array('Dashboard','Reports');

$menuMap = 
        array(
            $appIdALLINALL => $menuIdxSALES
            ,$appIdCRM => $allMenuIdx
            
            ,$appIdCR => $menuIdxCR
            ,$appIdALLIANCECR => $menuIdxCR
            ,$appIdABCCR => $menuIdxCR
            
            ,$appIdSALES => $menuIdxSALES
            ,$appIdHIMALAYASALES => $menuIdxSALES
            ,$appIdLIANGYISALES => $menuIdxSALES
            ,$appId3SSALES => $menuIdxSALES
            ,$appIdPOS => $menuIdxPOS
            
            ,$appIdPC => $menuIdxPC
            ,$appIdFTZPC => $menuIdxPC
            ,$appIdALIFPC => $menuIdxPC
            ,$appIdSEAHORSEPC => $menuIdxPC
            ,$appIdBMPPC => $menuIdxPC
            ,$appIdBPMPC => $menuIdxPC
            ,$appIdCSMEPC => $menuIdxPC
            ,$appIdMCEPC => $menuIdxPC
        );
$menuLabels_alt_CR = array('Order' => 'Jobs', 'Account' => 'Invoice', 'Employee' => 'Rider','Person' => 'User');
$menuLabels_alt_SALES = array('Account' => 'Invoice','Person' => 'User');//Account -> Invoice
$menuLabels_alt_PC = array('Order' => 'Project','Person' => 'User', 'Account' => 'Invoice', );//Order -> Project
$menuLabels_alt_POS = array('Order' => 'Sales', 'New Order' => 'POS', 'Person' => 'User', );

$menu_alt_Labels_map = array(
    $appIdALLINALL => $menuLabels_alt_SALES//if array() , no more alterations in labels - empty
    ,$appIdCRM => $menuLabels_alt_SALES

    ,$appIdCR => $menuLabels_alt_CR
    ,$appIdALLIANCECR => $menuLabels_alt_CR
    ,$appIdABCCR => $menuLabels_alt_CR
    
    ,$appIdSALES => $menuLabels_alt_SALES
    ,$appIdHIMALAYASALES => $menuLabels_alt_SALES
    ,$appIdLIANGYISALES => $menuLabels_alt_SALES
    ,$appId3SSALES => $menuLabels_alt_SALES
    ,$appIdPOS => $menuLabels_alt_POS
    
    ,$appIdPC => $menuLabels_alt_PC
    ,$appIdFTZPC => $menuLabels_alt_PC
    ,$appIdALIFPC => $menuLabels_alt_PC
    ,$appIdSEAHORSEPC => $menuLabels_alt_PC
    ,$appIdBMPPC => $menuLabels_alt_PC
    ,$appIdBPMPC => $menuLabels_alt_PC
    ,$appIdCSMEPC => $menuLabels_alt_PC
    ,$appIdMCEPC => $menuLabels_alt_PC   
    );
$menuURLs = array(//ordinally matched with $menuIDs array
    '/site/index'
    ,'/category/admin'
    ,'/task/admin'
    ,'statusmaster/admin'
    ,'/order/posclient'
    ,'/order/quoteadmin'
    ,'/order/orderadmin'
    ,'/order/schedule'
    ,'/person/admin'
    ,'/person/employeeadmin'
    ,'/person/customeradmin'
    ,'/person/contractoradmin'
    ,'/account/admin'
    ,'/ordertask/admin'
    ,'/milestone/admin'
    ,'/payment/admin'
    ,'/person/supplieradmin'
    ,'/purchase/admin'
    ,'/product/admin'    
    ,'/person/update'
    ,'/reports/index'
    ,'/site/logout' 
    ,array('#'
            ,array(
                '/category/admin'
                ,'/task/admin'
                ,'statusmaster/admin'
            )
    )
    ,array('/person/admin'
            ,array(
                '/person/employeeadmin'
                ,'/person/customeradmin'
                ,'/person/supplieradmin'
                ,'/person/contractoradmin'
            )
    )
    );
$menuIcons = array(//ordinally matched with $menuIDs array
    "<i class='fa iconfa-signout'></i>"
    ,"<i class='fa iconfa-signout'></i>"
    ,"<i class='fa iconfa-signout'></i>"
    ,"<i class='fa iconfa-signout'></i>"
    ,"<i class='fa iconfa-signout'></i>"
    ,"<i class='fa iconfa-signout'></i>"
    ,"<i class='fa iconfa-signout'></i>"
    ,"<i class='fa iconfa-signout'></i>"
    ,"<i class='fa iconfa-signout'></i>"
    ,"<i class='fa iconfa-signout'></i>"
    ,"<i class='fa iconfa-signout'></i>"
    ,"<i class='fa iconfa-signout'></i>"
    ,"<i class='fa iconfa-signout'></i>"
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
$defaultViewsMap = array();
$typ1ViewsMap = array(
                'form' => array(
                            'person' => 'type1',
                            'order' => 'type1',
                            ),
                'index' => array(
                            //'site' => 'type1',//index/dashboard
                            )
                );
$typ2ViewsMap = array(
                'form' => array(
                            'person' => 'type2',
                            'order' => 'type2',                            
                            'account' => 'type2',
                            ),
                'index' => array(                            
                            'site' => 'type2',//index/dashboard
                            ),
                'admin' => array(
                            'order' => 'type2',//index/dashboard
                            )
                );

$typ3ViewsMap = array(
                'form' => array(
//                            'person' => 'type3',
//                            'order' => 'type3',
//                            'account' => 'type3',
                            ),
                'index' => array(                            
                            //'site' => 'type3',//index/dashboard
                            ),
                'admin' => array(
                            //'order' => 'type3',//index/dashboard
                            )
                );

$viewsMap = array(
    $appIdALLINALL => $defaultViewsMap
    ,$appIdCRM => $typ1ViewsMap

    ,$appIdCR => $typ2ViewsMap
    ,$appIdALLIANCECR => $typ2ViewsMap
    ,$appIdABCCR => $typ2ViewsMap
    
    ,$appIdSALES => $typ1ViewsMap
    ,$appIdHIMALAYASALES => $typ1ViewsMap
    ,$appIdLIANGYISALES => $typ1ViewsMap
    ,$appId3SSALES => $typ1ViewsMap
    ,$appIdPOS => $typ1ViewsMap
    
    ,$appIdPC => $typ3ViewsMap
    ,$appIdFTZPC => $typ3ViewsMap
    ,$appIdALIFPC => $typ3ViewsMap
    ,$appIdSEAHORSEPC => $typ3ViewsMap
    ,$appIdBMPPC => $typ3ViewsMap
    ,$appIdBPMPC => $typ3ViewsMap
    ,$appIdCSMEPC => $typ3ViewsMap
    ,$appIdMCEPC => $typ3ViewsMap
    );

$defaultRolesMap = array();
$rolesMap1 = array(
                'Admin' => 'Admin',
                'Customer' => 'Customer',
                'Employee' => 'Rider',    
                );
$rolesMap2 = array(
                'Admin' => 'Admin',
                'Manager' => 'Manager',
                'Employee' => 'Employee',
                'Sales' => 'Sales',
                'Customer' => 'Customer',
                'Supplier' => 'Supplier',    
                );
$rolesMap3 = array(
                'Admin' => 'Admin',
                'Customer' => 'Customer',
                'Contractor' => 'Contractor'
                );
$rolesMap4 = array(
                'Admin' => 'Admin',
                'Manager' => 'Manager',
                'Employee' => 'Employee',
                'Customer' => 'Customer',
                'Contractor' => 'Contractor'
                );

$rolesMap = array(
    $appIdALLINALL => $rolesMap2
    ,$appIdCRM => $rolesMap2

    ,$appIdCR => $rolesMap1
    ,$appIdALLIANCECR => $rolesMap1
    ,$appIdABCCR => $rolesMap1
    
    ,$appIdSALES => $rolesMap2
    ,$appIdHIMALAYASALES => $rolesMap2
    ,$appIdLIANGYISALES => $rolesMap2
    ,$appId3SSALES => $rolesMap2
    ,$appIdPOS => $rolesMap2
    
    ,$appIdPC => $rolesMap3
    ,$appIdFTZPC => $rolesMap3
    ,$appIdALIFPC => $rolesMap3
    ,$appIdSEAHORSEPC => $rolesMap3
    ,$appIdBMPPC => $rolesMap3
    ,$appIdBPMPC => $rolesMap3
    ,$appIdCSMEPC => $rolesMap3
    ,$appIdMCEPC => $rolesMap3
    );
$defaulLayout = array(
                'login' => '//layouts/loginlayout',
                'main' => '//layouts/column2_2'
);
$appIdCRLayout = array(
                'login' => '//layouts/login_crlayout',
                'main' => '//layouts/crlayout'
);
$appIdPOSLayout = array(
                'login' => '//layouts/posloginlayout',
                'main' => '//layouts/poslayout',
                'sales' => '//layouts/possalesrolelayout',
                'reports' => '//layouts/posreportslayout'
);
$appIdSALESLayout = array(
                'login' => '//layouts/loginlayout',
                'main' => '//layouts/saleslayout'
);
$layoutsMap = array(
    $appIdALLINALL => $defaulLayout
    ,$appIdCRM => $defaulLayout

    ,$appIdCR => $appIdCRLayout
    ,$appIdALLIANCECR => $appIdCRLayout
    ,$appIdABCCR => $appIdCRLayout
    
    ,$appIdSALES => $appIdSALESLayout
    ,$appIdHIMALAYASALES => $appIdSALESLayout
    ,$appIdLIANGYISALES => $appIdSALESLayout
    ,$appId3SSALES => $appIdSALESLayout
    ,$appIdPOS => $appIdPOSLayout
    
    ,$appIdPC => $defaulLayout
    ,$appIdFTZPC => $defaulLayout
    ,$appIdALIFPC => $defaulLayout
    ,$appIdSEAHORSEPC => $defaulLayout
    ,$appIdBMPPC => $defaulLayout
    ,$appIdBPMPC => $defaulLayout
    ,$appIdCSMEPC => $defaulLayout
    ,$appIdMCEPC => $defaulLayout
    );
$redirectTypes1 = array('order' => array('create' => 'update'));
$redirectTypes2 = array('order' => array('create' => 'create', 'update' => 'admin'));
$appRedirectsMap = array(    
    $appIdCR => $redirectTypes2
    ,$appIdALLIANCECR => $redirectTypes2
    ,$appIdABCCR => $redirectTypes2
    
    ,$appIdSALES => $redirectTypes1
    ,$appIdHIMALAYASALES => $redirectTypes1
    ,$appIdLIANGYISALES => $redirectTypes1
    ,$appId3SSALES => $redirectTypes1
    ,$appIdPOS => $redirectTypes1
    
    ,$appIdPC => $redirectTypes1
    ,$appIdFTZPC => $redirectTypes1
    ,$appIdALIFPC => $redirectTypes1
    ,$appIdSEAHORSEPC => $redirectTypes1
    ,$appIdBMPPC => $redirectTypes1
    ,$appIdBPMPC => $redirectTypes1
    ,$appIdCSMEPC => $redirectTypes1
    ,$appIdMCEPC => $redirectTypes1
);
?>