<?php
require_once('constants.php' );

$hostname = $hn_localhost;
//$hostname = $hn_stnapps;


$appConfigKeys = array(
    'enablepplcode' => 'enablepplcode','enableautopplcode'=>'enableautopplcode'
    ,'enableautocustcode' => 'enableautocustcode','enableautosplrcode' => 'enableautosplrcode'
    ,'enablepplauxname' => 'enablepplauxname','enablecontact' => 'enablecontact'
    ,'enablelocality' => 'enablelocality','enablecity' => 'enablecity'
    ,'enablestate' => 'enablestate','enablecountry' => 'enablecountry'
    
    ,'directorder' => 'directorder','directinvoice' => 'directinvoice'
    ,'moperinvoice' => 'moperinvoice','daystocheckfordue' => 'daystocheckfordue'
    ,'daystocheckforoverdue' => 'daystocheckforoverdue'
    
    ,'enableautoordrid' => 'enableautoordrid','enableordername' => 'enableordername'
    ,'enableordrdn' => 'enableordrdn','ordercostamountfrom' => 'ordercostamountfrom'
    ,'sptype' => 'sptype','enabletax' => 'enabletax'
    ,'enablediscount' => 'enablediscount','orderdiscfor' => 'orderdiscfor'
    ,'discentry' => 'discentry', 'accountamountfrom' => 'accountamountfrom', 'enableordrpeople' => 'enableordrpeople'
    
    ,'enableordrprd' => 'enableordrprd','enablecategory' => 'enablecategory'
    ,'enableprdcode' => 'enableprdcode','enableautoprdcode' => 'enableautoprdcode'
    ,'enableprdauxname' => 'enableprdauxname','enablestock' => 'enablestock'
    ,'enablepurchase' => 'enablepurchase'
    
    ,'enableordrtasks' => 'enableordrtasks','enableinlineotentry' => 'enableinlineotentry'
    ,'enableexpctdstartdt' => 'enableexpctdstartdt','enableexpctdenddt' =>'enableexpctdenddt'
    ,'ordertaskcostamountfrom' => 'ordertaskcostamountfrom','enableordrtaskpeople' => 'enableordrtaskpeople'
    , 'taskppltax' => 'taskppltax'
    
    ,'enableordermilestones' => 'enableordermilestones','enableinlinemsentry' => 'enableinlinemsentry'
    
    ,'enableordrpayments' => 'enableordrpayments','enableinlinepayments' => 'enableinlinepayments'
        );
$appConfigs = array(
    'enablepplcode' => null,'enableautopplcode' => null
    ,'enableautocustcode' => null,'enableautosplrcode' => null
    ,'enablepplauxname' => null,'enablecontact' => null
    ,'enablelocality' => null,'enablecity' => null
    ,'enablestate' => null,'enablecountry' => null
    
    ,'directorder' => null,'directinvoice' => null
    ,'moperinvoice' => null,'daystocheckfordue' => null
    ,'daystocheckforoverdue' => null
    
    ,'enableautoordrid','enableordername' => null
    ,'enableordrdn','ordercostamountfrom' => null
    ,'sptype' => null,'enabletax' => null
    ,'enablediscount' => null,'orderdiscfor' => null,'discentry' => null
    
    ,'enableordrprd' => null,'enablecategory' => null
    ,'enableprdcode' => null,'enableautoprdcode' => null
    ,'enableprdauxname' => null,'enablestock' => null
    ,'enablepurchase' => null
    
    ,'enableordrtasks' => null,'enableinlineotentry' => null
    ,'enableexpctdstartdt' => null,'enableexpctdenddt' => null
    ,'ordertaskcostamountfrom' => null,'enableordrtaskpeople' => null
    ,'taskppltax' => null
    
    ,'enableordermilestones' => null,'enableinlinemsentry' => null
    
    ,'enableordrpayments' => null,'enableinlinepayments' => null
        );
$LF_person_Type1 = array('role_id' => array( 'name' => 'role_id'), 'name' => array( 'name' => 'name'),
    'contact' => array( 'name' => 'contact'), 'mobile' => array( 'name' => 'mobile'), 'mail' => array( 'name' => 'mail'));//list fields for person list

$LF_product_Type1 = array('code' => array( 'name' => 'code'),
    'name' => array( 'name' => 'name'),
    'unit_cp' => array( 'name' => 'unit_cp'),
    'unit_sp' => array( 'name' => 'unit_sp'),
    'disc' => array( 'name' => 'disc'),
    'tax' => array( 'name' => 'tax'),
    'stock' => array( 'name' => 'stock'),
    'stockvalue' => array( 'name' => 'stockvalue'));//list fields for product list

$LF_product_Type2 = array(
    'category_id' => array( 'name' => 'category_id'),
    'name' => array( 'name' => 'name'),
    'desc' => array( 'name' => 'desc'),
    'remarks' => array( 'name' => 'remarks'),
    'discper' => array( 'name' => 'discper'),
    'taxrate_id' => array( 'name' => 'taxrate_id'),
    );//list fields for product list

$LF_productprice_Type1 = array(
    'code' => array( 'name' => 'code'),
    'sku' => array( 'name' => 'sku'),
    'product_id' => array( 'name' => 'product_id'),
    'supplier_id' => array( 'name' => 'supplier_id'),
    'unit_cp' => array( 'name' => 'unit_cp'),
    'unit_sp' => array( 'name' => 'unit_sp'),
    'stock' => array( 'name' => 'stock'),
    'stockvalue' => array( 'name' => 'stockvalue'),
    'rol' => array( 'name' => 'rol'),
    'moq' => array( 'name' => 'moq'),
    );

$LF_purchase_Type1 = array('purchase_at','purchase_number','amount','remarks');


$LF_order_Type1 = array('status' => array( 'name' => 'status'),'qoi_id' => array( 'name' => 'qoi_id'),'customer_id' => array( 'name' => 'customer_id'),'end_at' => array( 'name' => 'end_at'),'amount' => array( 'name' => 'amount'),'disc' => array( 'name' => 'disc'),'invstatus' => array( 'name' => 'invstatus'));
$LF_order_Type2 = array('customer_id' => array( 'name' => 'customer_id'),'addnlinfo' => array( 'name' => 'addnlinfo'),'addnlinfo1' => array( 'name' => 'addnlinfo1'),'fromaddr_id' => array( 'name' => 'fromaddr_id'),'toaddr_id' => array( 'name' => 'toaddr_id'),'addnlinfo3' => array( 'name' => 'addnlinfo3'),'employee_id' => array( 'name' => 'employee_id'));

$LF_account_Type1 = array('accounttype','acnt_no','party_id','order_id','amount','paid','remarks');
$LF_account_Type2 = array('acnt_no' => array( 'name' => 'acnt_no'),
    'party_id' => array( 'name' => 'party_id'),
    'amount' => array( 'name' => 'amount'),
    'id' => array( 'name' => 'id'),
    'remarks' => array( 'name' => 'remarks'));
$LF_account_Type3 = array('accounttype' => array( 'name' => 'accounttype')
    ,'acnt_no' => array( 'name' => 'acnt_no'),'party_id' => array( 'name' => 'party_id')
    ,'order_or_ot_id' => array( 'name' => 'order_or_ot_id')
    ,'amount' => array( 'name' => 'amount')
    ,'paid' => array( 'name' => 'paid'),'remarks' => array( 'name' => 'remarks'));

$LF_payment_Type1 = array('direction' => array( 'name' => 'direction'),
    'party_id' => array( 'name' => 'party_id'),'account_id' => array( 'name' => 'account_id')
    ,'order_or_ot_id' => array( 'name' => 'order_or_ot_id')
    ,'amount' => array( 'name' => 'amount'),'payment_at' => array( 'name' => 'payment_at'));
$LF_payment_Type3 = array('direction' => array( 'name' => 'direction'),
    'party_id' => array( 'name' => 'party_id'),'account_id' => array( 'name' => 'account_id')
    ,'order_or_ot_id' => array( 'name' => 'order_or_ot_id')
    ,'amount' => array( 'name' => 'amount'),'payment_at' => array( 'name' => 'payment_at'));


$FF_product_Type1 = array('code' => 1, 'name' => 1, 'auxname' => 1, 'supplier_id' => 1, 'desc' => 1, 'unit_cp' => 1, 'unit_sp' => 1, 'stock' => 1, 'remarks' => 1);
$FF_person_Type3 = array('enablecontact' => 2);//enabled first name , last name seperate
$FF_person_Type2 = array('enablecontact' => 1, 'geo_update_frq' =>1, 'fax' => 1, 'did' => 1, 'cost_center' => 1);//enabled first name , last name combined

$LF_timeslot_Type2 = array(
    'slotdate' => array( 'name' => 'slotdate'),
    'person' => array( 'name' => 'person'),
    'ts9' => array( 'name' => 'ts9', ),
    'ts10' => array( 'name' => 'ts10', ),
    'ts11' => array( 'name' => 'ts11', ),
    'ts12' => array( 'name' => 'ts12', ),
    'ts13' => array( 'name' => 'ts13', ),
    'ts14' => array( 'name' => 'ts14', ),
    'ts15' => array( 'name' => 'ts15', ),
    'ts16' => array( 'name' => 'ts16', ),
    'ts17' => array( 'name' => 'ts17', ),
    'ts18' => array( 'name' => 'ts18', ),
    'ts19' => array( 'name' => 'ts19', ),
    'ts20' => array( 'name' => 'ts20', ),
    ); 

$formFieldsMap = array(
            $appIdALLINALL => array(
                            'ff' => array(),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type1
                                ,'payment' => $LF_payment_Type1
                                ,'order' => $LF_order_Type1)
                        )
            ,$appIdCRM => array(
                            'ff' => array(),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type1
                                ,'payment' => $LF_payment_Type1
                                ,'order' => $LF_order_Type1)
                        )
            
            ,$appIdCR => array(
                            'ff' => array('person' => $FF_person_Type2),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type2
                                ,'payment' => $LF_payment_Type1
                                ,'order' => $LF_order_Type2
                                ,'timeslot' => $LF_timeslot_Type2
                                )                                
                            )
            ,$appIdALLIANCECR => array(
                            'ff' => array('person' => $FF_person_Type2),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type2
                                ,'payment' => $LF_payment_Type1
                                ,'order' => $LF_order_Type2
                                ,'timeslot' => $LF_timeslot_Type2
                                )
                            )
            ,$appIdABCCR => array(
                            'ff' => array('person' => $FF_person_Type2),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type2
                                ,'payment' => $LF_payment_Type1
                                ,'order' => $LF_order_Type2
                                ,'timeslot' => $LF_timeslot_Type2
                                )
                            )
            ,$appIdSALES => array(
                            'ff' => array(),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type3
                                ,'payment' => $LF_payment_Type1
                                ,'order' => $LF_order_Type1)
                        )                            
            ,$appIdHIMALAYASALES => array(
                            'ff' => array(),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type1
                                ,'payment' => $LF_payment_Type1
                                ,'order' => $LF_order_Type1)
                        )
            ,$appIdLIANGYISALES => array(
                            'ff' => array(),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type1
                                ,'payment' => $LF_payment_Type1
                                ,'order' => $LF_order_Type1)
                        )
            ,$appId3SSALES => array(
                            'ff' => array(),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type1
                                ,'payment' => $LF_payment_Type1
                                ,'order' => $LF_order_Type1)
                        )
            ,$appIdPOS => array(
                            'ff' => array(),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type2
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type3
                                ,'payment' => $LF_payment_Type1
                                ,'order' => $LF_order_Type1)
                        )
            ,$appIdPC => array(
                            'ff' => array('person' => $FF_person_Type3),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type3
                                ,'payment' => $LF_payment_Type3
                                ,'order' => $LF_order_Type1)
                        )
            ,$appIdFTZPC => array(
                            'ff' => array('person' => $FF_person_Type3),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type3
                                ,'payment' => $LF_payment_Type3
                                ,'order' => $LF_order_Type1)
                        )
            ,$appIdALIFPC => array(
                            'ff' => array('person' => $FF_person_Type3),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type3
                                ,'payment' => $LF_payment_Type3
                                ,'order' => $LF_order_Type1)
                        )
            ,$appIdSEAHORSEPC => array(
                            'ff' => array('person' => $FF_person_Type3),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type3
                                ,'payment' => $LF_payment_Type3
                                ,'order' => $LF_order_Type1)
                        )
            ,$appIdBMPPC => array(
                            'ff' => array('person' => $FF_person_Type3),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type3
                                ,'payment' => $LF_payment_Type3
                                ,'order' => $LF_order_Type1)
                        )
            ,$appIdBPMPC => array(
                            'ff' => array('person' => $FF_person_Type3),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type3
                                ,'payment' => $LF_payment_Type3
                                ,'order' => $LF_order_Type1)
                        )
            ,$appIdCSMEPC => array(
                            'ff' => array('person' => $FF_person_Type3),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type3
                                ,'payment' => $LF_payment_Type3
                                ,'order' => $LF_order_Type1)
                        )
            ,$appIdMCEPC => array(
                            'ff' => array('person' => $FF_person_Type3),
                            'lf' => array('person' => $LF_person_Type1
                                ,'product' => $LF_product_Type1
                                ,'productprice' => $LF_productprice_Type1
                                ,'purchase' => $LF_purchase_Type1
                                ,'account' => $LF_account_Type3
                                ,'payment' => $LF_payment_Type3
                                ,'order' => $LF_order_Type1)
                        )
        );
return array (
    'hostname' => $hostname,
    'logintheme' => 'logintheme',
    'maintheme' => 'default',
    'appIdCRM' => $appIdCRM,
    'appIdCR' => $appIdCR,
    'appIdSALES' => $appIdSALES,
    'appIdPC' => $appIdPC,
    'appIdPOS' => $appIdPOS,
    'menuIDs' => $menuIDs,
    'menuURLs' => $menuURLs,
    'menuIcons' => $menuIcons,
    'menuMap' => $menuMap,
    'menu_alt_Labels_map' => $menu_alt_Labels_map,
    'viewsMap' => $viewsMap,
    'rolesMap' => $rolesMap,
    'layoutsMap' => $layoutsMap,
    'appRedirectsMap' => $appRedirectsMap,
    'formFieldsMap' => $formFieldsMap,
    'appConfigKeys' => $appConfigKeys,
    'appConfigs' => $appConfigs,
    'imagePath' => '/protected/assets/images/',
);
?>