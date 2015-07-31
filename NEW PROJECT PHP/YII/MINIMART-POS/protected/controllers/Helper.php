<?php

class Helper
{
    const CONST_SU = 'SU';
    const CONST_Non_su = 'Non_su';
    const CONST_Admin = 'Admin';
    const CONST_Employee = 'Employee';
    const CONST_Sales = 'Sales';
    const CONST_Manager = 'Manager';
    const CONST_Customer = 'Customer';
    const CONST_Supplier = 'Supplier';
    const CONST_Contractor = 'Contractor';
    const CONST_Created = 'Created';
    const CONST_Modified = 'Modified';
    const CONST_From = 'From';
    const CONST_To = 'To';
    const CONST_Walk_in_Customer = 'Walk-in Customer';
    const CONST_CurrencySymbol = '$';
    const CONST_PercentSymbol = '%';
    const CONST_Percentage = 'Percentage';
    const CONST_Fixed  = 'Fixed';
    const CONST_No_Tax  = 'No Tax';
    const CONST_Number1 = 1;
    const CONST_Number0 = 0;
    const CONST_General = 'General';
    const CONST_General_Section = 'General_Section';
    
    const CONST_order_Creation = 'Creation';
    const CONST_order_Creation_Hold = 'Creation-Hold';
    const CONST_order_Creation_Refund = 'Creation-Refund';
    const CONST_order_Updation_Holdcancel = 'Updation-Hold-Cancel';
    const CONST_order_Updation_Refund = 'Updation-Refund';
    const CONST_order_Updation_Exchange = 'Updation-Exchange';
    
    const CONST_Office = 'Office';
    const CONST_Residence = 'Residence';
    const CONST_Other = 'Other';
    
    const CONST_REQUESTED = 'REQUESTED';
    const CONST_ACKNOWLEDGED = 'ACKNOWLEDGED';
    const CONST_OPEN = 'OPEN';
    const CONST_PENDING = 'PENDING';
    const CONST_CLOSED = 'CLOSED';
    const CONST_ASSIGNED = 'ASSIGNED';
    const CONST_ACCEPTED = 'ACCEPTED';
    const CONST_REJECTED = 'REJECTED';
    const CONST_PICKEDUP = 'PICKEDUP';
    const CONST_DELIVERED = 'DELIVERED';
    const CONST_TOORDER = 'TOORDER';
    const CONST_TOINVOICE = 'TOINVOICE';
    const CONST_UNDELIVERED = 'UNDELIVERED';
    const CONST_REFUNDOLD = 'REFUNDOLD';
    const CONST_REFUNDNEW = 'REFUNDNEW';
    const CONST_CANCELOLD = 'CANCELOLD';
    const CONST_CANCELNEW = 'CANCELNEW';
    const CONST_EXCHANGEOLD = 'EXCHANGEOLD';
    const CONST_EXCHANGENEW = 'EXCHANGENEW';
    const CONST_ExceptOpenRejected = 'ExceptOpenRejected';
    
    const CONST_INVSTS_UNINVOICED = 'UNINVOICED';
    const CONST_INVSTS_INVOICED = 'INVOICED';
    
    const CONST_Quote = 'Quote';
    const CONST_Order = 'Order';
    const CONST_Invoice = 'Invoice';
    const CONST_qotid_static_str = 'QOT';
    const CONST_odrid_static_str = 'ODR';
    const CONST_invid_static_str = 'INV';
    const CONST_Ordertask = 'Task';
    const CONST_Receivables = 'Receivables';
    const CONST_Payables = 'Payables';
    const CONST_Account = 'Account';
    const CONST_BillNumber = 'Bill No.';
    const CONST_OpenBalance = 'Open Balance';
    const CONST_CloseBalance = 'Close Balance';
    
    const CONST_Receivable_From = 'Receivable From';
    const CONST_Payable_To = 'Payable To';
    
    const CONST_Inwards = 'Inwards';
    const CONST_Outwards = 'Outwards';
    
    const CONST_Cash = 'Cash';
    const CONST_MasterVisa = 'Master/Visa';
    const CONST_Nets = 'Nets';
    const CONST_Debitcard = 'Debit Card';
    const CONST_Crditcard = 'Credit Card';
    const CONST_Cheque = 'Cheque';
    const CONST_OnAccount = 'On Account';
    const CONST_Paid = 'Paid';
    
    const CONST_Payment_COLLECTED = 'COLLECTED';
    
    const CONST_Received_From = 'Received From';
    const CONST_Paid_To = 'Paid To';
    
    const CONST_addrtype_Office='Office';
    const CONST_addrtype_Residence='Residence';
    const CONST_addrtype_Other='Other';
           
    const CONST_dlvrtype_Delivery ='Delivery';
    const CONST_dlvrtype_Collect='Collect';
    const CONST_dlvrtype_2_Way ='2-Way';
    const CONST_dlvrtype_Others='Others';
    
    const CONST_srvctype_EXPHalf='Express (1/2 Hour)';
    const CONST_srvctype_EXPOne='Express (1 Hour)';
    const CONST_srvctype_UrgentTwo='Urgent (2 Hours)';
    const CONST_srvctype_UrgentThree='Urgent (3 Hours)';
    const CONST_srvctype_UrgentFour='Urgent (4 Hours)';
    const CONST_srvctype_Normal='Normal';
    const CONST_srvctype_LateHrs='After Office Hours';
    
    const CONST_sctype_Envelope='Envelope';
    const CONST_sctype_Tube='Tube';
    const CONST_sctype_Carton='Carton';
    const CONST_sctype_Oversize='Oversize';
    const CONST_sctype_Overweight='Overweight';
    const CONST_sc_limit = 100;
    
    const CONST_UNKNOWN = 'UNKNOWN';
    const CONST_ALL = 'ALL';
    const CONST_DayBeforeYesterday = 'DayBeforeYesterday';
    const CONST_Yesterday = 'Yesterday';
    const CONST_Today = 'Today';
    const CONST_Tomorrow = 'Tomorrow';
    const CONST_DayAfterTomorrow = 'DayAfterTomorrow';
    const CONST_yellow_ordercount = 1;
    const CONST_red_ordercount = 2;
    
    const CONST_sitecontrollerid = 'site';
    const CONST_mobilecontrollerid = 'mobile';
    const CONST_ordercontrollerid = 'order';
     const CONST_stockadjustmentcontrollerid = 'stockadjustment';
    const CONST_reportscontrollerid = 'reports';
    const CONST_loginactionid = 'login';
    const CONST_logoutactionid = 'logout';
    const CONST_indexactionid = 'index';
    const CONST_erroractionid = 'error';
    const CONST_adminactionid = 'admin';
    const CONST_createactionid = 'create';
    const CONST_updateactionid = 'update';
    const CONST_customerPayments = 'customerPayments';
    const CONST_supplierPayments = 'supplierPayments';
    const CONST_contractorPayments = 'contractorPayments';
    
    const CONST_updateProduct = 'updateProduct';
    const CONST_updateProductAjax = 'updateProductAjax';
    const CONST_oe_loadcustaddresses = 'loadcustaddresses';
    const CONST_oe_getLocationById = 'getLocationById';    
    
    const CONST_ae_loadAccountDetails = 'loadAccountDetails';
    const CONST_ae_loadPartyAccounts = 'loadPartyAccounts';
    const CONST_ae_loadPartyOrdersOrTasks = 'loadPartyOrdersOrTasks';
    const CONST_ae_loadParties = "loadParties";
    const CONST_dba_ridershistory = 'ridershistory';
    const CONST_dba_submitschedule = 'submitschedule';
    const CONST_schedule = 'schedule';
    const CONST_dba_orderslistpdf = 'orderslistpdf';
    const CONST_ordermstasks = 'ordermstasks';
    const CONST_updateaccountsurcharge = 'updateaccountsurcharge';
    const CONST_updateaccountordersamount = 'updateaccountordersamount';
    const CONST_invoicepdf = 'invoicepdf';
    const CONST_posclient = 'posclient';
    const CONST_openedbills = 'openedbills';
    const CONST_possettings = 'possettings';
    const CONST_orderProducts = 'orderProducts';
    const CONST_sectionadmin = 'sectionadmin';
    const CONST_sectioncreate = 'sectioncreate';
    const CONST_sectionupdate = 'sectionupdate';
   
    
    const CONST_employeeadmin = 'employeeadmin';
    const CONST_employeecreate = 'employeecreate';
    const CONST_employeeupdate = 'employeeupdate';
    const CONST_salesadmin = 'salesadmin';
    const CONST_salescreate = 'salescreate';
    const CONST_salesupdate = 'salesupdate';
    const CONST_customeradmin = 'customeradmin';
    const CONST_customercreate = 'customercreate';
    const CONST_customerupdate = 'customerupdate';
    const CONST_paymentreceiptcreate = 'paymentreceiptcreate';
    const CONST_paymentreceiptupdate = 'paymentreceiptupdate';
    const CONST_paymentreceiptadmin = 'paymentreceiptadmin';
    const CONST_getSubproductLatestprice= 'getStockcnt';
    
    const CONST_supplieradmin = 'supplieradmin';
    const CONST_suppliercreate = 'suppliercreate';
    const CONST_supplierupdate = 'supplierupdate';
    const CONST_contractoradmin = 'contractoradmin';
    const CONST_contractorcreate = 'contractorcreate';
    const CONST_contractorupdate = 'contractorupdate';
    
    const CONST_adminEmail = 'gsmmgsm@gmail.com';
    const CONST_lazy_page_load = 1;
    const CONST_page_load_delay_ms = 200;//ms
    const CONST_db_auto_refresh_freq = 1;//mins
    const CONST_db_auto_refresh = 1;
    
    const CONST_pos_prdsupdate_freq = 100;//mins
    const CONST_pos_auto_refresh = 1;
    
    const CONST_gridTemplate = "{pager}{items}{pager}";
    const CONST_gridTemplate_items = "{items}";
    
    const CONST_gridPageSize = 25;
    const CONST_gridPageSizeDB = 5;
    
    const CONST_grid_PageSize_250 = 250;
    const CONST_grid_PageSize_25 = 25;
    const CONST_grid_PageSize_5 = 5;
    
    const CONST_grid_Height_200 = 200;
    const CONST_grid_Height_300 = 300;
    const CONST_grid_Height_400 = 400;
    const CONST_grid_Height_425 = 425;
    const CONST_grid_Height_450 = 450;
    const CONST_grid_Height_475 = 475;
    const CONST_grid_Height_500 = 500;
    const CONST_grid_Height_550 = 550;
    const CONST_grid_Height_600 = 600;
    
    const CONST_grid_Font_8 = 8;
    const CONST_grid_Font_10 = 10;
    const CONST_grid_Font_12 = 12;
    const CONST_grid_Font_14 = 14;
    
    const CONST_grid_Template_PSIP = "{pager}{summary}{items}{pager}";
    const CONST_grid_Template_PIP = "{pager}{items}{pager}";
    const CONST_grid_Template_SI = "{summary}{items}";
    const CONST_grid_Template_I = "{items}";
    
    const CONST_Default_SC_Amount = 5.5;
    const CONST_Default_SC_Limit = 100;
    
    const CONST_SG_Latitude = 1.360396;
    const CONST_SG_Longitude = 103.749573;
    
    const CONST_Thankyou = 'Thank you for your request. We have successfully received your request and will be in touch shortly';
    const CONST_Record_Updated = 'Record Updated';
    const CONST_Updation_Failed = 'Updation Failed';
    const CONST_NEWEMP_MAIL_SUB = 'Employee login is activated.';
    const CONST_INVALID_CONFIG = 'Invalid Config Settings';
    const CONST_HASH_MISSING = 'Unautherized user[hashmissing]';
    const CONST_WRONG_USER_PWD = 'Incorrect username or password.';
    const CONST_LOGIN_SUCCESS = 'Login Success.';    
    const CONST_Request_Not_Allowed = 'Request Not Allowed';
    const CONST_DVCTKN_SAVE_FAIL = "Device Token Updation Failed";
    const CONST_DVCTKN_SAVED = "Device Token Updated";
    const CONST_ORDER_STS_SAVED = "Job Status Updated";
    const CONST_ORDER_STS_SAVE_FAIL = "Job Status Updation Failed";
    const CONST_PERSON_GPS_SAVED = "Person Location Updated";
    const CONST_PERSON_GPS_SAVE_FAIL = "Person Location Updation Failed";
    const CONST_ORDER_FETCH_FAIL = "Failed to Retrieve Jobs";
    const CONST_ORDER_LIST = "Orders List";
    const CONST_POS_Masters = "Pos Masters";
    const CONST_ORDERPRD_LIST = "Order Products List";
    
    const CONST_NotImplemented = 501;
    const CONST_InternalServerError = 500;
    const CONST_InvalidUserPassword = 401;
    const CONST_Error_None = 0;
    const CONST_SaveError = -1;
    const CONST_Error = 1;
    const CONST_Error_Message = 'Error.';
    const CONST_NotFound_Message = 'Not Found.';
    const CONST_OldBillNotFound_Message = 'Old Bill Not Found.';
    const CONST_InvalidBillAmount_Message = 'Invalid Bill Amount';
    const CONST_Error_SomeOfRecordsFailed = 'Some of the records failed.';
    const CONST_registercollectionsummary = 'Register Collection Summary';
    
    const CONST_type = 'type';
    const CONST_RootCategory = 'Section';
    const CONST_Category = 'Category';
    const CONST_Product = 'Product';
    const CONST_OpenedBills_STR = 'Opened Bills';
    const CONST_PosSettings_STR = 'POS Settings';
    const CONST_sec_cat_products = 'sec_cat_products';
    const CONST_non_mngd_products = 'non_mngd_products';
    const CONST_allproducts_short = 'allproducts_short';
    const CONST_prdskuToIdMap = 'prdskuToIdMap';    
    const CONST_allcustomers = 'allcustomers';
    const CONST_default_customer_id = 'default_customer_id'; 
    const CONST_getOrderProductsForABill = 'getOrderProductsForABill';
    const CONST_getAllProducts = 'getAllProducts';
    const CONST_posSaveBill = 'posSaveBill';
    const CONST_logouturl = '/site/logout';
    const CONST_loginurl = '/site/login';
    const CONST_updateRegisterbalanceUrl = 'updateRegisterbalanceUrl';
    const CONST_creatPaymentEnabled = false;
    const CONST_getPricesForAProduct = 'getPricesForAProduct';
    const CONST_PRDPRICES_LIST = "Product Prices List";
    const CONST_multipriceproductsave = 'multipriceproductsave';
     const CONST_getProductlist = 'getProductlist';
     const CONST_getSubProductlist='getSubProductlist';
    const CONST_updateProductStockAjax = 'updateProductStockAjax';
    const CONST_bulkupdateProductStockAjax = 'bulkupdateProductStockAjax';
    const CONST_bulkAddProductsAjax = 'bulkAddProductsAjax';    
    const CONST_viewstockhistory = 'viewstockhistory';
    const CONST_viewProductPrices = 'viewProductPrices';
    const CONST_toggle = 'toggle';
    
    //reports constants
    const CONST_registerwisecollections = 'registerwisecollections';
    const CONST_customerdatewisepayments = 'customerdatewisepayments';
    const CONST_dailysales = 'dailysales';
    const CONST_periodWiseSales = 'periodWiseSales';
    const CONST_stockInventory = 'stockInventory';
     const CONST_StockReport = 'stockreport';
    const CONST_dailyItemSales = 'dailyItemSales';
    const CONST_exchange = 'exchange';
    const CONST_registerBalance = 'registerBalance';
    const CONST_registerBalanceII = 'registerBalanceII';
    const CONST_refund = 'refund';
    const CONST_cancel = 'cancel';
    const CONST_stockadjustment = 'stockadjustmentlist';
    const CONST_PDF = 'PDF';
    
    const CONST_TopProducts_days = 30;
    
    public static $timeslots = array(
                                    'ts1','ts2','ts3','ts4'
                                    ,'ts5','ts6','ts7','ts8'
                                    ,'ts9','ts10','ts11','ts12'
                                    ,'ts13','ts14','ts15','ts16'
                                    ,'ts17','ts18','ts19','ts20'
                                    ,'ts21','ts22','ts23','ts24'
                                );
    
    public static function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return false;
        }

        return (substr($haystack, -$length) === $needle);
    }
}
?>
