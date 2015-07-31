var dfyyyymmdd = "YYYY/MM/DD";
var dfyyyymmdd12 = "YYYY/MM/DD h:m:s A";
var dfyyyymmdd24 = "YYYY/MM/DD H:m:s";
var dfddmmyyyy = "DD/MM/YYYY";
var dfddmmyyyy12 = "DD/MM/YYYY h:m:s A";
var dfddmmyyyy24 = "DD/MM/YYYY h:m:s";
var dateFormat = "DD/MM/YYYY h:m:s A";
var dateFormat2 = "DD/MM/YYYY";
var dateFormat3 = "dd/mm/yy";
var dateFormat4 = "dd/MM/yyyy";
var dateFormat5 = "DD/MM/YYYY H:m:s";
var dateFormat6 = "YYYY/MM/DD";
var delimeterminus = "-";
var delimeterslash = "/";
var bkupcustomer_id = '';
var bkupfromaddr_id = '';
var bkuptoaddr_id = '';
var askopbalance;
var askclbalance;
var updateRegisterbalanceUrl;
var rgstrBlRprt = null;
var orderproductsarray = [];
var oldorder = {};
var plusitemscount = 0;
var minusitemscount = 0;
var allproducts_short=[];
var allsubproducts=[];
var non_mngd_products=[];
var sec_cat_products = [];
var allcustomers = [];
var default_customer_id = -1;
var oTable = null;
var oTableApi = null;
var heldBills = {};
var currentmode = 0;
var minusmode = 0;
var splopinprogress = 0;
var maintableRowIndex = -1;
var maintableRowData = null;
var numPadOperation = 0;
var numPadInputValue = 0;

var oTable_heldbills = null;
var oTable_heldbills_Api = null;
var postingBill = {};

var toreplace1 = '@dynamiccontent1@';
var toreplace2 = '@dynamiccontent2@';
var toreplace3 = '@dynamiccontent3@';
var ultag = '<ul class="g">'+ toreplace1 +'</ul>'
var litag = '<li class="">'+ toreplace1 +'</li>'

var coverdivtag ='<div class="">'+ toreplace1 +'</div>';
var ahreftag ='<a href="'+ toreplace2 +'" class="" onclick="'+ toreplace3 +'">'+ toreplace1 +'</a>';
//var imgtag='<img src="'+ toreplace1 +'" alt="' + toreplace2 +'" class="img-responsive img-thumbnail"/>';
var imgtag='<span> <img src="'+ toreplace1 +'"  onerror="fixit(this)" class="img-responsive img-thumbnail"/>' + toreplace2 +'</span>';
var hdrtag = '<span style="display:block"><strong>'+ toreplace1 +'</strong></span>';

var curproduct = {};
var curproductpricesarray = [];
var oPrdPriceTable = null;
var oPrdPriceTableApi = null;
var slctdproductpriceindex = -1;
var slctdproductprice = null;
var dflt_supplier_id = -1;
var billnums=null;
/**
 * Number.prototype.format(n, x, s, c)
 *
 * @param integer n: length of decimal
 * @param integer x: length of whole part
 * @param mixed   s: sections delimiter
 * @param mixed   c: decimal delimiter
 */
Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ''));
};
function fixit(img)
{
    img.style.display = 'none';
    return true;

}
function stringToJsDate(gvndate, includetime)
{
    var srcformat = dateFormat2;
    var dtfrmtstr = "";
    //dtfrmtstr = moment(gvndate).format(srcformat);
    dtfrmtstr = gvndate.split(/[\s:\/]/);
    //dtfrmtstr = dtfrmtstr.split(/[\s:-]/);
    var year = dtfrmtstr[2];
    var month = dtfrmtstr[1]-1;
    var date = dtfrmtstr[0];
    var jsdate = new Date(year,month,date);
    includetime = (typeof(includetime) !== 'undefined')?includetime:false;
    if(includetime){
        if(typeof(dtfrmtstr[5]) === 'undefined')
        {
            dtfrmtstr[5] = 0;
        }
        jsdate = new Date(year,month,date,dtfrmtstr[3],dtfrmtstr[4],dtfrmtstr[5]);
    }
    return jsdate;
}

//autocomplete for bill number by sarada
function autocompleteBillnum(){
    $.ajax({
        type: 'POST',
        url: '/pos/order/getbillnumber',
        //data:JSON.stringify(dataarray),
        success:function(data)
        {
            billnums=JSON.parse(data);
            $( "#qoi_id" ).autocomplete({
                source: billnums
            });
        }
    });
}
function jsDateToString(currentdate, includetime, hrs24){
    if(typeof(includetime)==='undefined'){
        includetime = false;
    }
    var curr_date = currentdate.getDate();
    var curr_month = currentdate.getMonth() + 1; //Months are zero based
    var curr_year = currentdate.getFullYear();
    var cdtime = curr_year + delimeterslash + curr_month + delimeterslash + curr_date;//match with mysql;
    if(includetime){
        if(typeof(hrs24)==='undefined') hrs24 = false;
        var hours = currentdate.getHours();
        var mins = currentdate.getMinutes();
        if(!hrs24){
            var mid='am';
            if(hours>12){
                hours=hours%12;
                mid='pm';
            }
            cdtime += " " + hours + ":" + mins + " " + mid;
        }else{
            cdtime += " "  + hours + ":" + mins;
        }
    }
    return cdtime;
}
function formatMstaskforchartdata(mstaskforchartdata){
    var tmprows = [];//first row not header
    var tmprow = [];
    for(var i=0; i < mstaskforchartdata.length; i++){
        if(mstaskforchartdata[i] !== null){
            tmprow = [];
            var stdatestr = '';
            var eddatestr = '';
            for(var j= 0; j < 4; j++){
                if(j === 2 || j === 3){
                    if(mstaskforchartdata[i][j] !== null){
                        var jsdate = stringToJsDate(mstaskforchartdata[i][j]);
                        tmprow.push(jsdate);
                        if(j === 2){
                            stdatestr = moment(mstaskforchartdata[i][j]).format(dateFormat2);//dtfrmtstr;
                        }else{
                            eddatestr = moment(mstaskforchartdata[i][j]).format(dateFormat2);
                        }
                    }else{
                        tmprow.push('');
                    }
                }else{
                    tmprow.push(mstaskforchartdata[i][j]);
                }
            }
            tmprows.push(tmprow);
        }
    }
    mstaskforchartdata = tmprows;
    return mstaskforchartdata;
}
function sayMessage(msg){
    if(typeof(msg) !== 'undefined' && msg.trim() !== ''){
        alert(msg);
    }
}
function submittourl(formid, url)
{
    $('#'+formid).attr('action', url);
    $('#'+formid).submit();
}
function submitGivenForm(formid)
{
    $('#'+formid).submit();
}
function changerole_personentry()
{
    var slctdrole = $('#Person_role_id option:selected').text();
    var isrider = slctdrole === 'Rider';
    var iscustomer = slctdrole === 'Customer';
    $('#Person_role_id').val($('#Person_role_id').val());
    if(isrider)
    {
        $('#emp_fld_1').show();
        $('#cust_fld_1').hide();
    }
    else if(iscustomer)
    {
        $('#emp_fld_1').hide();
        $('#cust_fld_1').show();
    }
}
function toggleenablelogin_personentry()
{
    var t = $("#Person_enablelogin").is(':checked');
    if(t)
    {
        $('#logindiv').show();
    }
    else
    {
        $('#logindiv').hide();
    }
}
function toggleeditpwd_personentry()
{
    var t = $("#Person_editpassword").is(':checked');
    var isloginavail = $("#Login_id").val() > 0;
    if(t)
    {
        $('#pwddiv').show();
        $('#Login_pass').val('');
    }
    else if(isloginavail)
    {
        $('#pwddiv').hide();
    }
}
function purchaseamountcalc_purchaseentry()
{
    var qnty = $('#Purchaseproduct_quantity').val();
    var up = $('#Purchaseproduct_unit_cp').val();
    var amount = qnty * up;
    $('#Purchaseproduct_amount').val(amount);
}
function afterUpdateProduct_purchaseentry(data)
{
    // display data returned from action
    $("#results").html(data.message);
    if(data.RetCode === 0)
    {
        $("#Purchase_amount").val(data.data);
    }
    $('#Purchaseproduct_quantity').val(1);
    $('#Purchaseproduct_unit_cp').val(0);
    $('#Purchaseproduct_amount').val(0);
    $('#s2id_autogen1').focus();
    // refresh your grid
    $.fn.yiiGridView.update('purchaseproduct-grid');
}
function getisnewcustomer()
{
    var t = $("#Order_isnewcustomer").is(':checked');
    if(t)
    {
        return 1;
    }
    else
    {
        return 0;
    }
}
function getisnewfrom()
{
    var t = $("#Order_isnewfrom").is(':checked');
    if(t)
    {
        return 1;
    }
    else
    {
        return 0;
    }
}
function getisnewto()
{
    var t = $("#Order_isnewto").is(':checked');
    if(t)
    {
        return 1;
    }
    else
    {
        return 0;
    }
}
function fillFromaddress(data)
{
    if(data !== "")
    {
        $("#fromaddr_street").val(data.data.street);
        $("#fromaddr_pincode").val(data.data.pincode);
    }
    else
    {
        $("#fromaddr_street").val("");
        $("#fromaddr_pincode").val("");
    }
}
function fillToaddress(data)
{
    if(data !== "")
    {
        $("#toaddr_street").val(data.data.street);
        $("#toaddr_pincode").val(data.data.pincode);
        $("#Order_toperson_name").val(data.data.name);
        $("#Order_toperson_mbl").val(data.data.mobile);
    }
    else
    {
        $("#toaddr_street").val("");
        $("#toaddr_pincode").val("");
        $("#Order_toperson_name").val("");
        $("#Order_toperson_mbl").val("");
    }
}
function redrawselect2boxes()
{
    jQuery('#Order_fromaddr_id').select2({'placeholder':'From','width':'resolve'});
    jQuery('#Order_toaddr_id').select2({'placeholder':'To','width':'resolve'});
}
function togglenewcustomer_orderentry()
{
    var t = $("#Order_isnewcustomer").is(':checked');
    if(t)
    {
        $('#Order_customer_id').attr('disabled','disabled');
    }else
    {
        $('#Order_customer_id').removeAttr('disabled');
    }
    $('#Order_customer_id').change();
}
function togglenewfrom_orderentry()
{
    var t = $("#Order_isnewfrom").is(':checked');

    if(t)
    {
        $('#Order_fromaddr_id').attr('disabled','disabled');
    }else
    {
        $('#Order_fromaddr_id').removeAttr('disabled');
    }
    $('#Order_customer_id').change();
}
function togglenewto_orderentry()
{
    var t = $("#Order_isnewto").is(':checked');

    if(t)
    {
        $('#Order_toaddr_id').attr('disabled','disabled');
    }else
    {
        $('#Order_toaddr_id').removeAttr('disabled');
    }
    $('#Order_customer_id').change();
}
function orderamountcalc_orderentry()
{
    var qnty = $('#Orderproduct_quantity').val();
    var up = $('#Orderproduct_unit_sp').val();
    var amount = qnty * up;
    $('#Orderproduct_amount').val(amount);
}
function afterUpdateProduct_orderentry(data, gridid)
{
    // display data returned from action
    $("#results").html(data.message);
    if(data.RetCode === 0)
    {
        $("#Order_amount").val(data.data);
    }
    $('#Orderproduct_quantity').val(1);
    $('#Orderproduct_unit_sp').val(0);
    $('#Orderproduct_amount').val(0);
    $('#Orderproduct_product_id').focus();
    // refresh your grid
    $.fn.yiiGridView.update(gridid);
}
function changeproduct_orderentry()
{
    var sp = 0;
    var prd = $('#Orderproduct_product_id option:selected').text();
    var n1 = prd.indexOf(" [ ");
    var n2 = prd.indexOf(" ] ");
    if(n1 >= 0 && n2 >= 0)
    {
        var tmp = prd.substring(n1 + 3, n2-1);
        tmp = parseFloat(tmp);
        if(!isNaN(tmp)) sp = tmp;
    }
    $('#Orderproduct_unit_sp').val(sp);
}
function changecustomer_orderentry(response)
{
    var data = response.data;
    if(data.billaddr_id > 0)
    {
        $('#Order_billaddr_id option[value=' + data.billaddr_id + ']').prop('selected', true);
        $('#billaddr_street').val(data.billaddr.street);
        $('#billaddr_pincode').val(data.billaddr.pincode);
    }
    else
    {
        $('#Order_billaddr_id option[value=""]').prop('selected', true);
        $('#billaddr_street').val('');
        $('#billaddr_pincode').val('');
    }
    if(data.shipaddr_id > 0)
    {
        $('#Order_shipaddr_id option[value="' + data.shipaddr_id + '"]').prop('selected', true);
        $('#shipaddr_street').val(data.shipaddr.street);
        $('#shipaddr_pincode').val(data.shipaddr.pincode);
    }
    else
    {
        $('#Order_shipaddr_id option[value=""]').prop('selected', true);
        $('#shipaddr_street').val('');
        $('#shipaddr_pincode').val('');
    }
}
function updateDBOrderGrid(idorclass)
{
    toggletimeslotgrid();
    $(idorclass).submit();
    return false;
}
function submitDBOrderGrid(idorclass, actionname)
{
    $(idorclass).attr('action', actionname);
    $(idorclass).submit();
    return false;
}
function updateGridSubmitResult(msg)
{
    $('#gridsubmitresult').text(msg);
}
function resetDBActionBtns()
{
    $('#ridersHistoryBtn').show();
    $('#submitScheduleBtn').show();
    $('#ordersListpdfBtn').show();
    $('#indexBtn').hide();
}
function ridersHistory(ridershistory)
{
    $('#Order_hdnactionname').val(ridershistory);
    updateGridSubmitResult("Wait...");
    $('#submitScheduleBtn').hide();
    updateDBOrderGrid(".search-form form");
}
function ordersListpdf(orderslistpdf)
{
    $('#Order_hdnactionname').val(orderslistpdf);
    updateGridSubmitResult("Wait...");
    $('#submitScheduleBtn').hide();
    updateDBOrderGrid(".search-form form");
}
function submitDBOrderGridCallback(data, searchform)
{
    $('#gridsubmitresult').text(data);
    if(typeof(searchform) !== 'undefined')
    {
        updateDBOrderGrid(searchform);//".search-form form"
    }
    return false;
}
function afterCreateInvoiceFromOrder(data, searchform)
{
    $('#gridsubmitresult').text(data.message);
    if(typeof(searchform) !== 'undefined')
    {
        updateDBOrderGrid(searchform);//".search-form form"
    }
}
function updateGrid(gridid, data, datadisplaydivid)
{
    if(typeof(datadisplaydivid) !== 'undefined'
        && typeof(data) !== 'undefined')
    {
        $('#' + datadisplaydivid).html(data.message);
        if(data.RetCode === 0)
        {
            $("#Account_amount").val(data.data);
            var sclimit = $("#sclimit").val();
            if(data.data >= sclimit)
            {
                $('#scamountdiv').hide();
            }
            else
            {
                $('#scamountdiv').show();
            }
        }
    }
    $.fn.yiiGridView.update(gridid);
}
function dbAfterAjaxUpdate()
{
    updateGridSubmitResult('');
    jQuery('.popover').remove();
    jQuery('[data-toggle=popover]').popover();
    jQuery('.tooltip').remove();
    jQuery('[data-toggle=tooltip]').tooltip();
}

function toggletimeslotgrid()
{
    var enabletimeslot =  $('#enable_timeslot').val();
    if(enabletimeslot == 0)
    {
        $('#timeslotgriddiv').hide();
    }
    else
    {
        var hdnactionname = $('#Order_hdnactionname').val();
        var constindex = $('#const_index').val();
        var splsearch = $('#Order_splsearch').val();
        var constall = $('#const_all').val();
        var iscustomer = $('#iscustomer').val() === '1';
        toshow = !iscustomer && (hdnactionname === constindex && splsearch !== constall);
        if(toshow)
        {
            $('#timeslotgriddiv').show();
        }
        else
        {
            $('#timeslotgriddiv').hide();
        }
    }
}
function fillorderdetails(consignment, from, ctime, id)
{
    var dtls = "Consignment: " + consignment;
    dtls += "<br />Pickup: " + from;
    dtls += "<br />Time: " + ctime;
    $('#jobdetails').html(dtls);
    $('#hdn_orderid').val(id);
}
function fillassigndetails(name, id)
{
    var dtls = "Rider: " + name;
    $('#empdetails').html(dtls);
    $('#hdn_empid').val(id);
}
function beforeSchedule()
{
    var orderid = $('#hdn_orderid').val();
    var empid = $('#hdn_empid').val();
    if(orderid === '' || empid === '')
    {
        $('#gridsubmitresult').text('Select Job and Rider');
        return true;
    }
    else
    {
        $('#gridsubmitresult').text('Wait...');
    }
    return false;
}
function afterSchedule(data)
{
    $('#hdn_orderid').val('');
    $('#hdn_empid').val('');
    $('#jobdetails').html('');
    $('#empdetails').html('');
    updateGridSubmitResult(data);
}
function afterSaveOrder(data)
{
    $("#AjaxLoader").hide();
    if(data.RetCode==0)
    {
        $("#formResult").html(data.message);
        alert(data.message);
        document.location.href=data.data;
    }
    else{
        //alert("Error while saving.");
        var msg = 'Error.';
        $.each(data.data, function(key, val) {
//        $("#order-form #"+key+"_em_").text(val);
//        $("#order-form #"+key+"_em_").show();
            msg += '\n' + val[0];
        });
        $('#formResult').text(msg);
        alert(msg);
    }
}
function getAccounttype_accountentry()
{
    var accounttype = $('#Account_accounttype').val();
    return accounttype;
}
function afterSaveAccountForm(data, formid, resultdivid, loaderdivid)
{
    $("#" + loaderdivid).hide();
    if(data.RetCode==0)
    {
        $("#" + resultdivid).html(data.message);
        alert(data.message);
        document.location.href=data.data;
    }
    else{
        data = $.parseJSON(data);
        var msg = '';
        $.each(data, function(key, val) {
            $("#" + formid + " #"+key+"_em_").text(val);
            $("#" + formid + " #"+key+"_em_").show();
            msg += '\n' + val;
        });
        alert(msg);
    }
}
function ajaxAccountFormSubmit(formid, resultdivid, loaderdivid, loadmessage, url)
{
    loader = $("#AjaxLoader");
    loader.text(loadmessage);
    loader.show();
    var data=$("#"+formid).serialize();
    $.ajax({
        type: 'POST',
        url: url,
        data:data,
        success:function(data){
            afterSaveAccountForm(data, formid, resultdivid, loaderdivid);
        },
        error: function(data){ // if error occured
            alert("Error occured.please try again");
            //alert(data);
        }
    });
}
function getPaymentdirection_accountentry()
{
    var direction = $('#Payment_direction').val();
    return direction;
}
function toggleMSDiv(divid, todisable)
{
////This will disable just the div
//$("#"+divid).prop('disabled',todisable);
////This will disable everything contained in the div
//$("#"+divid).children().prop('disabled',todisable);
    todisable = !$("#Order_ismsedit").is(':checked');
    $("#Milestone_details").prop('disabled',todisable);
    $("#Milestone_start_at").prop('disabled',todisable);
    $("#Milestone_remarks").prop('disabled',todisable);
    $("#Milestone_alertbefore").prop('disabled',todisable);
    $("#Milestone_mailids").prop('disabled',todisable);
    $("#msGridId").prop('disabled',todisable);
}
function toggleOTDiv(divid, todisable)
{
    todisable = !$("#Order_isotedit").is(':checked');
    $("#Ordertask_task_id").prop('disabled',todisable);
    $("#Ordertask_details").prop('disabled',todisable);
    $("#Ordertask_start_at").prop('disabled',todisable);
    $("#Ordertask_end_at").prop('disabled',todisable);
    $("#Ordertask_completed").prop('disabled',todisable);
    $("#Ordertask_completed_at").prop('disabled',todisable);
    $("#Ordertask_completed_remarks").prop('disabled',todisable);
    $("#Ordertask_cost").prop('disabled',todisable);
    $("#Ordertask_amount").prop('disabled',todisable);
}
function toggleOPDiv(divid, todisable)
{
    todisable = !$("#Order_isopedit").is(':checked');
    $("#Orderproduct_product_id").prop('disabled',todisable);
    $("#Orderproduct_quantity").prop('disabled',todisable);
    $("#Orderproduct_unit_sp").prop('disabled',todisable);
    $("#Orderproduct_amount").prop('disabled',todisable);
}
var substringMatcher =
    function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, "i");

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {//gsm
                if (substrRegex.test(str.value)
                    || substrRegex.test(str.label)
                    ) {
                    // the typeahead jQuery plugin expects suggestions to a
                    // JavaScript object, refer to typeahead docs for more info
                    matches.push({label: str.value,value: str.label});
                }
            });

            cb(matches);
        };
    };
function getOrderProductsForABill(e, opurl)
{
    /*if (e.keyCode != 13) {
     return;
     }*/
    e.preventDefault();
    splopinprogress = 1;
    var qoi_id = $('#qoi_id').val();
    if(typeof(qoi_id) === 'undefined'
        || qoi_id.trim() === "")
    {
        alert("Enter Bill Number.");
        $('#qoi_id').focus();
        return;
    }
    var data = {'billnumber': qoi_id};
    $.ajax(
        {
            type: 'POST',
            url: opurl,
            data: JSON.stringify(data),
            dataType: 'json',
            success:function(data){
                if(data.data.length >0)
                {
                    oldorder = data.data[0];
                    orderproductsarray = oldorder.orderproducts;
                    if(currentmode == "1" || currentmode == "3")
                    {
                        if(currentmode == "1")
                        {
                            $('#refundconfirmbtn').show();
                            $('#refundconfirmbtn').text('Confirm Refund');
                        }
                        if(currentmode == "3")
                        {
                            $('#cancelconfirmbtn').show();
                            $('#cancelconfirmbtn').text('Confirm Cancel');
                        }
                        checkForExchangeItems(null, true);
                    }
                    if(currentmode == "2")
                    {
                        recreateOrderProductsTable();
                    }
                    $('#getBillModal').modal('hide');
                    togglePaymentSubmitBtn();
                }
                else
                {
                    alert(data.message);
                    oldorder = {};
                }
                $('#qoi_id').focus();
            },
            error: function(data)
            { // if error occured
                alert('Error occured.please try again');
                oldorder = {};
                refreshBillentry();
                $('#getBillModal').modal('hide');
                $('#qoi_id').focus();
            }
        }
    );
}
function recreateOrderProductsTable()
{
    alert("use +/- button for returning item row");
    var column = oTableApi.column( 7 );
    column.visible( true );
    refreshBillentry();
}
function promptOPBalance(askopenbalance, askclosebalance, updateregisterblurl)
{
    askopbalance = askopenbalance;
    askclbalance = askclosebalance;
    updateRegisterbalanceUrl = updateregisterblurl;
    if(askopbalance == 1)
    {
        updateRegisterbalance(1);
    }
}
function syncProductMasters(prdsurl, throautorefresh)
{
    loadSecCatProducts(prdsurl, throautorefresh);
}
function loadSecCatProducts(url, throautorefresh)
{
    autocompleteBillnum();
    if( throautorefresh != 5)
        setOrderProductsDataTable();
    if( throautorefresh != 1)
    {
        $('#prdmstrupdatemsg').text('Products Master being updated...!');
    }
    $.ajax(
        {
            type: 'GET',
            url: url,
            //data:data,
            success:function(data)
            {
                //                var prdsckiename = $('#prdsckieid').val();
//                var prdsckie = $.cookie(prdsckiename);
//                sec_cat_products = $.parseJSON(prdsckie).sec_cat_products;
                allproducts_short = data.data.allproducts_short;
                non_mngd_products = data.data.non_mngd_products;
                sec_cat_products = data.data.sec_cat_products;
                allcustomers = data.data.allcustomers;
                default_customer_id = data.data.default_customer_id;
                if( throautorefresh != 5)
                    setupPOSScreen(2, throautorefresh);
            },
            error: function(data)
            { // if error occured
                allproducts_short = [];
                non_mngd_products = [];
                sec_cat_products = [];
                allcustomers = [];
                default_customer_id = -1;
            }
        }
    );
}
function setOrderProductsDataTable()
{
    if ( !$.fn.dataTable.isDataTable( '#orderproducts' ) )
    {
        oTable = $('#orderproducts').dataTable(
            {
                'bProcessing': true,
                'bSort':false,
                'bPaginate':false,
                'bFilter':false,
                'bInfo':false,
                'bDestroy':true,
                "scrollY":"200px",
                //"scrollCollapse": true,
                //"scrollX": true,
                "oLanguage": {
                    "sEmptyTable": ' '
                },
                "aoColumns": [
                    {"sTitle": "X", "sClass": "center", "sWidth": "6%"},
                    {"sTitle": "Product", "sClass": "left", "sWidth": "24%"},
                    {"sTitle": "Tax" , "sClass": "right", "sWidth": "8%"},
                    {"sTitle": "Qnty", "sClass": "center", "sWidth": "18%"},
                    {"sTitle": "Price",  "sClass": "center", "sWidth": "20%"},
                    {"sTitle": "Disc.",  "sClass": "right", "sWidth": "8%"},
                    {"sTitle": "Total",  "sClass": "right", "sWidth": "8%"},
                    {"sTitle": "+/-",  "sClass": "right", "sWidth": "8%"}
                ],
                'columnDefs':[
                    {'mData': null, 'aTargets':[0], 'bVisible': true,
                        "mRender": function (data, type, row) {
                            var tmp = '<span style="display:block;" class="glyphicon glyphicon-remove-sign row-delete"></span>';
                            return tmp;
                        }
                    },
                    {'mData': 'product', 'aTargets':[1],
                        "mRender": function (data, type, row) {
                            var tmp = '';
                            if((typeof(row.productprice) !== 'undefined') && row.productprice.length > 0)
                            {
                                tmp = row.productprice[0].name;
                            }
                            return tmp;
                        }
                    },
                    {'mData': 'tax', 'aTargets':[2]},
                    {'mData': 'quantity', 'aTargets':[3],
                        "mRender": function (data, type, row) {
                            var tmp = row.quantity;
                            tmp = '<span  class="row-quantity"><button type="button" class="row-quantity btn btn-default btn-info">Edit</button>&nbsp;'+tmp+'</span>';
                            return tmp;
                        }
                    },
                    {'mData': 'unit_sp', 'aTargets':[4],
                        "mRender": function (data, type, row) {
                            var tmp = row.unit_sp;
                            tmp = '<span style="display:block;" class="row-unitsp" ><button type="button" class="row-quantity btn btn-default btn-info">Edit</button>&nbsp;&nbsp;'+tmp+'</span>';
                            return tmp;
                        }
                    },
                    {'mData': 'disc', 'aTargets':[5], 'bVisible': false,
                        "mRender": function (data, type, row) {
                            var tmp = row.disc;
                            tmp = '<span style="display:block;" class="row-disc glyphicon glyphicon-pencil" >'+tmp+'</span>';
                            return tmp;
                        }
                    },
                    {'mData': 'amount', 'aTargets':[6]},
                    {'mData': null, 'aTargets':[7], 'bVisible': (currentmode == '2'),
                        "mRender": function (data, type, row) {
                            var tmp = '';
                            if((typeof(row.productprice) !== 'undefined') && row.productprice.length > 0)
                            {
                                var prdid = row.productprice[0].id;
                                tmp = '<button onclick="checkForExchangeItems('+ prdid +')">' + '+/-' + '</button>';
                                return tmp;
                            }
                            return tmp;
                        }
                    },
                ]
            }
        );
        $('#orderproducts tbody').on( 'click', 'span.row-delete', function () {
            removeDataFromOrderProduct(this, null);
        } );
        $('#orderproducts tbody').on( 'click', 'span.row-quantity', function () {
            quantityBtnClickInMainTable(this);
        } );
        $('#orderproducts tbody').on( 'click', 'span.row-unitsp', function () {
            priceBtnClickInMainTable(this);
        } );
        $('#orderproducts tbody').on( 'click', 'span.row-disc', function () {
            discountMTBtnClickInMainTable(this);
        } );
    }
    else
    {
        oTable = $('#orderproducts').dataTable();
    }
    oTableApi = $('#orderproducts').DataTable();
}
function clearOrderProductsDataTable()
{
    //oTableApi.clear();
    oTable.fnClearTable();
    $('#billtotalqnty').text('');
    $('#billtotalamount').text('');
    $('#billdiscount').text('');
    $('#billsubtotal').text('');
    $('#billtax').text('');
    $('#billnetamount').text('');
}
function resetALL()
{
    refreshBillentry();
    currentmode = 0;
    minusmode = 0;
    splopinprogress = 0;
    numPadOperation = 0;
    oldorder = {};
    $('#refundBtn').prop('disabled', false);
    $('#exchangeBtn').prop('disabled', false);
    $('#cancelBtn').prop('disabled', false);
    $('#normalsubmit').prop('disabled', false);
    $('#holdBtn').prop('disabled', false);
    $('#heldBillsBtn').prop('disabled', false);
    $('#clsRgstrBtn').prop('disabled', false);
    $('#syncPrdMstrBtn').prop('disabled', false);
    $('#txtcurrentmode').text('');
    $('#roundoff').val(0);
    $('#roundoffcheck').prop('checked', false);
    var column = oTableApi.column( 7 );
    // Toggle the visibility
    column.visible( false );
}
function refreshBillentry()
{
    clearOrderProductsDataTable();
    orderproductsarray = [];
    postingBill = {};
    $('#customer_id').val(default_customer_id);
    $('#customer_id').change();
    var cashconst = $('#cashconst').val();
    $('#payment_mode input[value="'+cashconst+'"]').prop('checked',true);
    //$('#payment_mode').find(':checked').click();
    $('#heldbillref').val('');
    $('#qoi_id').val('');
    $('#paymentdetails').val('');
    $('#totalpayable').val('');
    $('#tenderedamount').val('');
    $('#balancereturned').val('');
    $('#paymentModal').modal('hide');
    $('#refundconfirmbtn').hide();
    $('#cancelconfirmbtn').hide();
    //$('#prd_skus').focus();
}

function setDataForOrderProductsDataTable()
{
    clearOrderProductsDataTable();
    if(orderproductsarray.length > 0)
    {
        oTable.fnAddData(orderproductsarray);
        updateBillAmounts();
    }
}
function getRowByID(foundID, searchinlist)
{
    var foundObj = null;
    var foundRow = -1;
    var rtnObj = {};
    $.each(searchinlist, function(i, obj)
    {
        if(obj !== null
            && typeof(obj.productprice) !== 'undefined'
            && obj.productprice.length !== 0
            && typeof(obj.productprice[0].name) !== 'undefined'
            )
        {
            if(obj.productprice[0].id == foundID)
            {
                foundObj = obj;
                foundRow = i;
                return false;//will not continue the each loop. it stops here
            }
        }
    });
    rtnObj.foundRow = foundRow;
    rtnObj.foundObj = foundObj;
    return rtnObj;
}
function addDataForOrderProduct(product, quantity, price)
{
    if(!(currentmode == '2') && typeof(product) === 'undefined' || product === null)
    {
        $('#prd_skus').val('');
        //$('#prd_skus').focus();
        return;
    }
    if((currentmode == '2') && typeof(product) === 'undefined' || product === null)
    {
        var tmp = getRowByID(null, oldorder.orderproducts);
        if(tmp.foundObj !== null)
        {
            product = tmp.foundObj.product[0];
        }
    }
    var id = product.id;
    orderproductsarray = oTable.fnGetData();
    var rtnObj = getRowByID(id, orderproductsarray);
//    var data={"id":$('#Productpricecode').val(),"sku":product.sku};
//    var testurl=$('#latestPriceSubprd').val();
//   $.ajax({
//         type: 'POST',
//         url: testurl,
//         data:JSON.stringify(data),
//         success:function(data){
//             data=JSON.parse(data);
//             price=data[0].unit_sp-product.disc;
//             //foundObj.unit_sp=data[0].unit_sp-product.disc;
//             product.spminusdisc=data[0].unit_sp-product.disc;
    if(rtnObj.foundObj !== null)
    {
        var foundObj = rtnObj.foundObj;
        var foundRow = rtnObj.foundRow;
        updateItem(foundObj, foundRow, quantity, price);
    }
    else
    {
        addNewItem(product, quantity, price);
    }
//         },
//         error: function(data){ // if error occured
//             alert("Error occured.please try again");
//         }
//     });

    $('#prd_skus').val('');
    //$('#prd_skus').focus();
}
//function addDataForOrderProduct(product, quantity, price)
//{
//    if(!(currentmode == '2') && typeof(product) === 'undefined' || product === null)
//    {
//        $('#prd_skus').val('');
//        //$('#prd_skus').focus();
//        return;
//    }
//    if((currentmode == '2') && typeof(product) === 'undefined' || product === null)
//    {
//        var tmp = getRowByID(null, oldorder.orderproducts);
//        if(tmp.foundObj !== null)
//        {
//            product = tmp.foundObj.product[0];
//        }
//    }
//    var id = product.id;
//    orderproductsarray = oTable.fnGetData();
//    var rtnObj = getRowByID(id, orderproductsarray);
//    if(rtnObj.foundObj !== null)
//    {
//        var foundObj = rtnObj.foundObj;
//        var foundRow = rtnObj.foundRow;
//        updateItem(foundObj, foundRow, quantity, price);
//    }
//    else
//    {
//        addNewItem(product, quantity, price);
//    }
//    $('#prd_skus').val('');
//    //$('#prd_skus').focus();
//}
function updateItem(foundObj, foundRow, quantity, price)
{
    var finalizedprice = parseFloat(((typeof(price) === 'undefined')?foundObj.unit_sp:price));
    var finalizedquantity = parseFloat(((typeof(quantity) === 'undefined')?1:quantity));
    finalizedprice = Math.round(finalizedprice * 100) / 100;
    finalizedquantity = Math.round(finalizedquantity * 100) / 100;

    foundObj.quantity = foundObj.quantity + finalizedquantity;
    foundObj.unit_sp = finalizedprice;

    var amount = Math.round((foundObj.quantity * foundObj.unit_sp) * 100) / 100;
    var taxamount = Math.round((foundObj.quantity * foundObj.productprice[0].tax) * 100) / 100;
    foundObj.amount = amount - foundObj.disc;
    foundObj.tax = taxamount;
    foundObj.unit_sp = foundObj.unit_sp.format(2,3);
    foundObj.tax = foundObj.tax.format(2,3);
    foundObj.amount = foundObj.amount.format(2,3);
    oTable.fnUpdate( foundObj, foundRow ); // Row
    updateBillAmounts();
}
function addNewItem(product, quantity, price)
{
    var itemtoadd = null;
    var finalizedprice = parseFloat(((typeof(price) === 'undefined')?product.spminusdisc:price));
    var finalizedquantity = parseFloat(((typeof(quantity) === 'undefined')?1:quantity));
    finalizedprice = Math.round(finalizedprice * 100) / 100;
    finalizedquantity = Math.round(finalizedquantity * 100) / 100;
    var amount = Math.round((finalizedprice * finalizedquantity) * 100) / 100;
    var taxamount = Math.round((product.tax * finalizedquantity) * 100) / 100;
    var opdisc = 0;
    amount = amount.format(2,3);
    taxamount = taxamount.format(2,3);
    finalizedprice = finalizedprice.format(2,3);
    itemtoadd = {
        'id': 0,
        'productprice':[product],
        'tax': taxamount,
        'quantity': finalizedquantity,
        'unit_sp': finalizedprice,
        'disc': opdisc,
        'amount': amount
    }
    oTableApi.row.add(itemtoadd).draw();
    updateBillAmounts();
}
function removeDataFromOrderProduct(rowobj, sku)
{
    oTableApi
        .row( $(rowobj).parents('tr') )
        .remove()
        .draw();
    updateBillAmounts();
}
function quantityBtnClickInMainTable(eventtarget)
{
    setMainttableRowIndexAndData(eventtarget);
    openNumberPadModal(3);
//    $('#quantityModal').modal('show');
//    $('#quantityModal').on('shown.bs.modal', function() {
//        $('#quantity').focus();
//    });
}
function priceBtnClickInMainTable(eventtarget)
{
    setMainttableRowIndexAndData(eventtarget);
    openNumberPadModal(4);
//    $('#priceModal').modal('show');
//    $('#priceModal').on('shown.bs.modal', function() {
//        $('#price').focus();
//    });
}
function discountMTBtnClickInMainTable(eventtarget)
{
    setMainttableRowIndexAndData(eventtarget);
    openNumberPadModal(2);
//    $('#discountMTModal').modal('show');
//    $('#discountMTModal').on('shown.bs.modal', function() {
//        $('#discount').focus();
//    });
}
function applyQuantityInMainTable(e)
{
    if (e.keyCode != 13) {
        return;
    }
    e.preventDefault();
    var newquantity = $('#quantity').val();
    if(typeof(newquantity) === 'undefined'
        || newquantity.trim() === "")
    {
        alert("Enter valid Quantity.");
        $('#quantity').focus();
        return;
    }
    $('#quantityModal').modal('hide');
    $('#quantity').val('');
    updateTableRowWithNewQuantity(newquantity);
}
function applyPriceInMainTable(e)
{
    if (e.keyCode != 13) {
        return;
    }
    e.preventDefault();
    var newprice = $('#price').val();
    if(typeof(newprice) === 'undefined'
        || newprice.trim() === "")
    {
        alert("Enter valid Price.");
        $('#price').focus();
        return;
    }
    $('#priceModal').modal('hide');
    $('#price').val('');
    updateTableRowWithNewPrice(newprice);
}
function applyDiscountInMainTable(e)
{
    if (e.keyCode != 13) {
        return;
    }
    e.preventDefault();
    var newdiscount = $('#discount').val();
    if(typeof(newdiscount) === 'undefined'
        || newdiscount.trim() === "")
    {
        alert("Enter valid Discount.");
        $('#discount').focus();
        return;
    }
    $('#discountMTModal').modal('hide');
    $('#discount').val('');
    updateTableRowWithNewDiscount(newdiscount);
}
function updateTableRowWithNewQuantity(newquantity)
{
    newquantity = Math.abs(newquantity);
    if((currentmode == '2') && maintableRowData.quantity < 0)
    {
        newquantity = -newquantity;
    }
    maintableRowData.quantity = newquantity;
    recalculateRowInMainTable();
}
function updateTableRowWithNewPrice(newprice)
{
    maintableRowData.unit_sp = newprice;
    recalculateRowInMainTable();
}
function updateTableRowWithNewDiscount(newdiscount, is_percent)
{
    if(typeof(is_percent) == 'undefined') is_percent = false;
    if(is_percent)
    {
        newdiscount = (newdiscount/maintableRowData.amount) * 100;
        newdiscount = Math.round(newdiscount * 100) / 100;
    }
    maintableRowData.disc = newdiscount;
    recalculateRowInMainTable();
}
function recalculateRowInMainTable()
{
    var quantity = maintableRowData.quantity
    var prdprice = maintableRowData.unit_sp;
    var rowdisc = maintableRowData.disc;
    var product = maintableRowData.productprice[0];
    var prdtax = product.tax;
    maintableRowData.tax = Math.round((quantity * prdtax) * 100) / 100;
    maintableRowData.amount = Math.round((quantity * prdprice - rowdisc) * 100) / 100;

    if(typeof(maintableRowData.disc) == 'number')
    {
        maintableRowData.disc = maintableRowData.disc.format(2,3);
    }
    if(typeof(maintableRowData.unit_sp) == 'number')
    {
        maintableRowData.unit_sp = maintableRowData.unit_sp.format(2,3);
    }
    maintableRowData.tax = maintableRowData.tax.format(2,3);
    maintableRowData.amount = maintableRowData.amount.format(2,3);
    oTable.fnUpdate( maintableRowData, maintableRowIndex );
    updateBillAmounts();
    maintableRowData = null;
    maintableRowIndex = -1;
}
function setMainttableRowIndexAndData(eventtarget)
{
//getting rowdata from row DOM.
//    var rowdom = $(eventtarget).parents('tr');
//    var rowdata = oTable._(rowdom);
    //getting index and then data
    var cellobj = $(eventtarget).parents('td');//array returns
    var indexobj = oTable.fnGetPosition( cellobj[0] );//cell obj. gives [rowindex, columnindex]
    maintableRowIndex = indexobj[0];
    maintableRowData = oTable.fnGetData( maintableRowIndex );
}
function checkForExchangeItems(prdid, isoutsidedata)
{
    var factor = -1;
    if('undefined' === typeof(isoutsidedata))
    {
        orderproductsarray = oTable.fnGetData();
    }
    $.each(orderproductsarray, function(i, obj){
        if((currentmode == '1' || currentmode == '3') || obj.productprice[0].id == prdid)
        {
            var foundOldItem = null;
            var tmp = getRowByID(obj.productprice[0].id, oldorder.orderproducts);
            if(tmp.foundObj !== null)
            {
                foundOldItem = tmp.foundObj;
            }
            if((currentmode == '2') && obj.quantity > 0 && foundOldItem != null)
            {
                minusmode = 1;
                obj.unit_sp = foundOldItem.unit_sp;
                obj.disc = foundOldItem.disc;
                obj.tax = foundOldItem.tax;
                obj.quantity = foundOldItem.quantity * factor;
                var subtotal = obj.unit_sp * obj.quantity;
                obj.amount = subtotal - (obj.disc * factor);//discount to added not subtracted
            }
            else if((currentmode == '2') && obj.quantity <= 0 && foundOldItem != null)
            {
                minusmode = 0;
                obj.disc = 0;
                obj.quantity = obj.quantity * factor;
                obj.unit_sp = obj.productprice[0].unit_sp;
                subtotal = obj.unit_sp * obj.quantity;
                obj.amount = subtotal - (obj.disc * factor);
                obj.tax = obj.productprice[0].tax * obj.quantity;
            }
            else
            {
                minusmode = 0;
                obj.tax = obj.tax;
                obj.disc = obj.disc;
                obj.quantity = obj.quantity * factor;
                subtotal = obj.unit_sp * obj.quantity;
                obj.amount = subtotal - (obj.disc * factor);
            }
            obj.amount = Math.round(obj.amount * 100) / 100;
        }
    });
    setDataForOrderProductsDataTable();
}
function updateBillAmounts()
{
    orderproductsarray = oTable.fnGetData();
    plusitemscount  = 0;
    minusitemscount  = 0;
    var totalqnty = 0;
    var totalamount = 0;
    var totaltax = 0;
    $.each(orderproductsarray, function(i, obj){
        if(obj.quantity > 0)
        {
            plusitemscount++;
        }
        else
        {
            minusitemscount++;
        }
        totalqnty += parseFloat(obj.quantity);
        totalamount += parseFloat(obj.amount);
        totaltax += parseFloat(obj.tax);
    });
    totalqnty = Math.round(totalqnty * 100) / 100;
    totaltax = Math.round(totaltax * 100)/100;
    totalamount = Math.round(totalamount * 100)/100;

    totalamount = totalamount.format(2,3);
    totaltax = totaltax.format(2,3);
    $('#billtotalqnty').text(totalqnty);
    $('#billtotalamount').text(totalamount);
    $('#billtax').text(totaltax);

    var tmp = $('#billdiscount').text();
    if(currentmode == '1' || currentmode == '3')
    {
        tmp = oldorder.disc;
    }
    var billdiscount = parseFloat(tmp);
    if(isNaN(billdiscount)) billdiscount = 0;
    updateDiscount(billdiscount, false, 2);
}
function onSelectProductFromMain(e, item)
{
    // prevent autocomplete from updating the textbox
//    e.preventDefault();
//    // manually update the textbox
//    $(this).val(item.value);
    var idcombined = item.label;
    if(typeof(idcombined) === 'undefined'
        || idcombined === null
        || idcombined.trim() === '') return;
    var idcombinedary = idcombined.split(":");
    if(idcombinedary.length === 3)
    {
        var prdid = idcombinedary[0];
        var catid = idcombinedary[1];
        var topcatid = idcombinedary[2];
        var product = getProduct(prdid, catid, topcatid);

        addDataForOrderProduct(product);
    }
    $('#prd_skus').val('');
    //$('#prd_skus').focus();
}
function heldBillsBtnClick()
{
    var tmpAry=[];
    $.each(heldBills, function(i, bill)
    {
        var tmpRow = {};
        tmpRow.billref = i;
        var total = 0;
        $.each(bill, function(j, item){
            total += parseFloat(item.amount);
        });
        total=parseFloat(total).toFixed(2);
        tmpRow.billamount = "$ "+total;
        tmpAry.push(tmpRow);
    });
    if(tmpAry.length > 0)
    {
        setHeldbillsDataTable();
        $('#heldBillsModal').modal('show');
        $('#heldBillsModal').on('shown.bs.modal', function() {
            oTable_heldbills.fnClearTable();
            oTable_heldbills.fnAddData(tmpAry);
        });
    }
    else
    {
        $('#heldBillsModal').modal('hide');
        alert("No Bills in Hold");
    }
}
function holdBillBtnClick()
{
    var tmplen = oTable.fnGetData();
    if(tmplen.length === 0)
    {
        alert('No bills to hold.');
    }
    else
    {
//        $('#holdBillModal').modal('show');
//        $('#holdBillModal').on('shown.bs.modal', function() {
//            $('#txtbillref').focus();
//        });
        holdABill();
    }
}
function holdABill(e)
{
//    if (e.keyCode != 13) {
//       return;
//    }
//    e.preventDefault();
//    //var billref = $('#txtbillref').val();
//    if(typeof(billref) === 'undefined'
//    || billref.trim() === "")
//    {
//        alert("Enter Bill Refrence/Note. Must.");
//        $('#txtbillref').focus();
//        return;
//    }
//    $('#holdBillModal').modal('hide');
    var count = 0;
    for (k in heldBills) if (heldBills.hasOwnProperty(k)) count++;
    var billref = count+1;
    if(billref > 3)
    {
        alert('You can not hold more than 3 Bills!');
    }
    else
    {
//    var billref = Object.keys(heldBills).length + 1;
        var bill = oTable.fnGetData();
        heldBills[billref] = bill;
        refreshBillentry();
    }
}
function setHeldbillsDataTable()
{
    if ( !$.fn.dataTable.isDataTable( '#heldBillsDataTable' ) )
    {
        oTable_heldbills = $('#heldBillsDataTable').dataTable(
            {
                'bProcessing': true,
                'bSort':false,
                'bPaginate':false,
                'bFilter':false,
                'bInfo':false,
                'bDestroy':true,
                "oLanguage": {
                    "sEmptyTable": ' '
                },
                'columnDefs':[
                    {'mData': null, 'aTargets':[0], 'bVisible': true,
                        "mRender": function (data, type, row) {
                            var tmp = '<button class="buntton-delete" onclick="removeHeldBill(\'' + row.billref  + '\')">' + 'X' + '</button>';
                            return tmp;
                        }
                    },
                    {'mData': null, 'aTargets':[1], 'bVisible': true,
                        "mRender": function (data, type, row) {
                            var tmp = '<button onclick="bringBackHeldBill(\'' + row.billref  + '\')">' + 'LOAD' + '</button>';
                            return tmp;
                        }
                    },
                    {'mData': 'billref', 'aTargets':[2]},
                    {'mData': 'billamount', 'aTargets':[3]}
                ]
            }
        );
    }
    else
    {
        oTable_heldbills = $('#heldBillsDataTable').dataTable();
    }
    oTable_heldbills_Api = $('#heldBillsDataTable').DataTable();
}
function setDataForHeldBillsDataTable()
{
    setHeldbillsDataTable();
    oTable_heldbills.fnClearTable();
    var tmpAry = [];
    $.each(heldBills, function(i, bill)
    {
        var tmpRow = {};
        tmpRow.billref = i;
        var total = 0;
        $.each(bill, function(j, item){
            total += item.amount;
        });
        total=parseFloat(total).toFixed(2);
        tmpRow.billamount = "$ "+total;
        tmpAry.push(tmpRow);
    });
    if(tmpAry.length > 0)
    {
        oTable_heldbills.fnAddData(tmpAry);
    }
}
function removeHeldBill(billref)
{
    if(typeof(heldBills[billref]) !== 'undefined')
    {
        delete heldBills[billref];
        setDataForHeldBillsDataTable();
    }
}
function bringBackHeldBill(billref)
{
    if(typeof(heldBills[billref]) !== 'undefined')
    {
        $('#heldbillref').val(billref);
        orderproductsarray = heldBills[billref];
        $('#heldBillsModal').modal('hide');
        setDataForOrderProductsDataTable();
        //removeHeldBill(billref);
    }
}
function posSaveBillNormal(url)
{
    var tmplen = oTable.fnGetData();
    if(tmplen.length === 0)
    {
        alert('No Bill selected for payment.');
        return;
    }
    posSaveBill(url, 0);
}
function confirmRefund(url)
{
    var oldorderid = orderproductsarray[0]['order_id'];
    posSaveBill(url, oldorderid);
}
function confirmCancel(url)
{
    var oldorderid = orderproductsarray[0]['order_id'];
    posSaveBill(url, oldorderid);
}
function posSaveBillExchange(url)
{
    var tmplen = oTable.fnGetData();
    if(tmplen.length === 0)
    {
        alert('No Bill selected for payment.');
        return;
    }
    var payable = parseFloat($('#billnetamount').text());
    if(isNaN(payable)) payable = 0;
    if((currentmode == '2') && payable <= 0 && plusitemscount <= 0)
    {
        alert('Please Add atleast ONE PLUS ITEM in bill.');
        return;
    }
    var oldorderid = oldorder.id;
    posSaveBill(url, oldorderid);
}

function posSaveBill(url, oldorderid)
{
    $('#tenderrow').show();
    $('#balancerow').show();
    var tendered = parseFloat($('#tenderedamount').val());
    if(isNaN(tendered)) tendered = 0;
    var payable = parseFloat($('#billnetamount').text());//$('#totalpayable').val()
    if(isNaN(payable)) payable = 0;
    var balancereturned = ((tendered == 0)?0:(tendered - payable));
    if(currentmode != '1' && currentmode != '3' && payable <= 0)
    {
        if((currentmode == '2' && plusitemscount <= 0) || currentmode != '2')
        {
            alert('Payable Amount should be > 0');
            return;
        }
    }
    else if(tendered < payable)
    {
        if(($('#payment_mode').find(':checked').val() !='Master/Visa') && ($('#payment_mode').find(':checked').val() !='Nets'))
        {
            alert('Please Tender the Payable amount.');
            $('#tenderedamount').focus();
            $('#tenderrow').show();
            $('#balancerow').show();
            return;
        }
        else
        {
            $('#tenderrow').hide();
            $('#balancerow').hide();
        }
//         if(($('#payment_mode').find(':checked').val() !='Master/Visa') && ($('#payment_mode').find(':checked').val() !='Nets'))
//         {
//        alert('Please Tender the Payable amount.');
//        $('#tenderedamount').focus();
//        return;
//    }
    }
    postingBill.exchange = 0;
    if(currentmode == '2' && payable < 0)
    {
        postingBill.exchange = -payable;
    }
    postingBill.currentmode = currentmode;
    postingBill.oldorderid = oldorderid;
    postingBill.customer_id = $('#customer_id option:selected').val();
    if(payable <=0)
    {
        postingBill.payment_mode = 'Cash';
        postingBill.tenderedamount = 0;
        postingBill.balancereturned = 0;
    }
    else
    {
        postingBill.payment_mode = $('#payment_mode').find(':checked').val();
        postingBill.payment_modecheck = -1;
        var t = $("#payment_modecheck").is(':checked');
        if(t)
        {
            postingBill.payment_modecheck = 1;
        }
        postingBill.tenderedamount = tendered;
        postingBill.balancereturned = balancereturned;
    }
    postingBill.paymentdetails = $('#paymentdetails').val();
    postingBill.billdiscount = $('#billdiscount').text();
    postingBill.roundoff = $('#roundoff').val();
    postingBill.lineItems = oTable.fnGetData();
    $.ajax(
        {
            type: 'POST',
            url: url,
            data:JSON.stringify(postingBill),
            dataType:'json',
            success:function(data)
            {
//                 alert(data+JSON.stringify(data))
                removeHeldBill($('#heldbillref').val());
                resetALL();
                alert(data.message);
                autocompleteBillnum();
            },
            error: function(data)
            { // if error occured
//                                  alert(data+JSON.stringify(data))

                refreshBillentry();
                alert('Error.');
                autocompleteBillnum();
            }
        }
    );
}
function paymentModalBtnClick(url)
{
    var tmplen = oTable.fnGetData();
    if(tmplen.length === 0)
    {
        alert('No Bill selected for payment.');
        return;
    }
    var payable = parseFloat($('#billnetamount').text());
    if(isNaN(payable)) payable = 0;
    if((currentmode == '2') && payable <= 0 && plusitemscount <= 0)
    {
        alert('Please Add atleast ONE PLUS ITEM in bill.');
        return;
    }
    if((currentmode == '2') && payable <= 0)
    {
        posSaveBillExchange(url);
    }
    else if(currentmode != '1' && currentmode != '3' && payable > 0)
    {
        $('#paymentModal').modal('show');
        $('#paymentModal').on('shown.bs.modal', function()
        {
            $('#customer_id').val(default_customer_id);
            var tmp = "Cash";
            $("input[name=payment_mode][value='" + tmp + "']").prop('checked', true);
            $('#totalpayable').val($('#billnetamount').text());
            $('#totalpayable').prop('disabled','disabled');
            $('#balancereturned').prop('disabled','disabled');
            if((currentmode == '2')){
                $('#exchangesubmit').show();
                $('#normalsubmit').hide();
            }else
            {
                $('#exchangesubmit').hide();
                $('#normalsubmit').show();
            }
            $('#tenderedamount').focus();
            oncustomerChange_Payment();
        });
    }
}
function oncustomerChange_Payment()
{
    var slctdcustomerid = $('#customer_id option:selected').val();
    if(default_customer_id !== slctdcustomerid)
    {
        $('#payment_modecheck').prop('disabled', false);
    }
    else
    {
        $('#payment_modecheck').prop('checked', false);
        $('#payment_modecheck').prop('disabled', true);
    }
}
function UpdatePaymentBalance()
{
    $tendered = $('#tenderedamount').val();
    $totalpayable = $('#billnetamount').text();// $('#totalpayable').val();
    $balance = Math.round(($tendered - $totalpayable) * 100)/100;
    $balance = $balance.format(2,3);
    $('#balancereturned').val($balance);
}
function refundBtnClick()
{
    currentmode = 1;
    $('#txtcurrentmode').text('Refund-Mode');
    $('#refundBtn').prop('disabled', true);
    $('#cancelBtn').prop('disabled', true);
    $('#exchangeBtn').prop('disabled', true);
    $('#normalsubmit').prop('disabled', true);
    $('#holdBtn').prop('disabled', true);
    $('#heldBillsBtn').prop('disabled', true);
    $('#clsRgstrBtn').prop('disabled', true);
    $('#syncPrdMstrBtn').prop('disabled', true);
    openGetBillModal();
}
function cancelBtnClick()
{
    currentmode = 3;
    $('#txtcurrentmode').text('Bill Cancel-Mode');
    $('#cancelBtn').prop('disabled', true);
    $('#refundBtn').prop('disabled', true);
    $('#exchangeBtn').prop('disabled', true);
    $('#normalsubmit').prop('disabled', true);
    $('#holdBtn').prop('disabled', true);
    $('#heldBillsBtn').prop('disabled', true);
    $('#clsRgstrBtn').prop('disabled', true);
    $('#syncPrdMstrBtn').prop('disabled', true);
    openGetBillModal();
}
function exchangeBtnClick()
{
    currentmode = 2;
    $('#txtcurrentmode').text('Exchange-Mode');
    $('#exchangeBtn').prop('disabled', true);
    $('#refundBtn').prop('disabled', true);
    $('#cancelBtn').prop('disabled', true);
    $('#normalsubmit').prop('disabled', true);
    $('#holdBtn').prop('disabled', true);
    $('#heldBillsBtn').prop('disabled', true);
    $('#clsRgstrBtn').prop('disabled', true);
    $('#syncPrdMstrBtn').prop('disabled', true);
    openGetBillModal();
}
function openGetBillModal()
{
    $('#getBillModal').modal('show');
    $('#getBillModal').on('shown.bs.modal', function() {
        $('#qoi_id').focus();
    });
    $('#getBillModal').on('hidden.bs.modal', function() {
        if(splopinprogress != 1)
        {
            resetALL();
        }
    });
//    var modaldialog = $('#getBillModal');
//    modaldialog.keydown(function(evt){
//            if (evt.keyCode === $.ui.keyCode.ESCAPE) {
//                modaldialog.modal('hide');
//                resetALL();
//            }
//            evt.stopPropagation();
//        });
}
function loadTopCategories()
{
    $('#topcatModal').modal('show');
    $('#topcatModal').on('shown.bs.modal', function()
    {
        fillTopCatDiv();
    });
}
function fillNon_Mngd_PrdsDiv()
{
    if(typeof(non_mngd_products) === 'undefined') non_mngd_products = null;
    $('#non_mngd_productsDiv').html('');
    var htmlcontent = prepareImageList(non_mngd_products,'selectNon_Mngd_ProductOnClick', null, null);
    $('#non_mngd_productsDiv').html(htmlcontent);
}
function fillTopCatDiv()
{
    if(typeof(sec_cat_products) === 'undefined') sec_cat_products = null;
    var htmlcontent = prepareImageList(sec_cat_products, 'fillNonTopCatDiv');
    $('#topcatDiv').html(htmlcontent);
    $('#nontopcatDiv').html('');
    $('#productsDiv').html('');
}
function fillNonTopCatDiv(topcatid)
{
    var nontopcategories = getNonTopCategories(topcatid);
    $('#nontopcatDiv').html('');
    var htmlcontent = prepareImageList(nontopcategories, 'fillproductsDiv', topcatid);
    $('#nontopcatDiv').html(htmlcontent);
    $('#productsDiv').html('');
    $('#productspaneltitle').text('');
}
function fillproductsDiv(catid, topcatid)
{
    var products = getProducts(catid, topcatid);
    $('#productsDiv').html('');
    var htmlcontent = prepareImageList(products,'selectProductOnClick', catid, topcatid);
    $('#productsDiv').html(htmlcontent);
    $('#productspaneltitle').text(sec_cat_products[topcatid].categories[catid].name);
}
function prepareImageList(objslist, clickevent, key2, key3)
{
    var htmlcontent = '';
    var licontents = '';
    if(objslist === null) return htmlcontent;
    var product_array=[];
    $.each(objslist, function(key, val)
        {
            if(val !== null || typeof(val) !== 'undefined')
            {
                var imgdisptext = val.name;

                var imgfilename = val.imagepath;
                var res=product_array.indexOf(imgdisptext)
                if(res==-1)
                {
                    product_array.push(imgdisptext);
                    var imgfullpath = $('#imagepath').val() + imgfilename;
                    var orgimgtag =  imgtag.replace(toreplace1, imgfullpath);
                    orgimgtag = orgimgtag.replace(toreplace2, imgdisptext);
                    var orgahreftag = ahreftag.replace(toreplace1, (orgimgtag));
                    orgahreftag = orgahreftag.replace(toreplace2, "#");
                    orgahreftag = orgahreftag.replace(toreplace3, (clickevent + "(" + key + "," + key2 + "," + key3 + ");"));
                    var orglitag = litag.replace(toreplace1, orgahreftag);
                    licontents += orglitag;
                }
            }
        }
    );
    var orgultag = ultag.replace(toreplace1, licontents);
    htmlcontent = orgultag;
    //htmlcontent = coverdivtag.replace(toreplace1, orgultag);
    return htmlcontent;
}
function loadNonTopCategories(topcatid, key2)
{
    $('#nontopcatModal').modal('show');
    $('#nontopcatModal').on('shown.bs.modal', function()
    {
        fillNonTopCatDiv(topcatid, key2);
    });
}
function loadProducts(catid, topcatid)
{
    $('#productsModal').modal('show');
    $('#productsModal').on('shown.bs.modal', function()
    {
        fillproductsDiv(catid, topcatid);
    });
}
function selectProductOnClick(prdid, catid, topcatid)
{
    var product = getProduct(prdid, catid, topcatid);
    addDataForOrderProduct(product);
}
//function selectProductOnClick(prdid, catid, topcatid)
//{
//    var product = getProduct(prdid, catid, topcatid);
//    addDataForOrderProduct(product);
//}
function selectNon_Mngd_ProductOnClick(prdid)
{
    var product = non_mngd_products[prdid];
    addDataForOrderProduct(product);
}
function getNonTopCategories(topcatid)
{
    var cats = null;
    if(typeof(sec_cat_products) === 'undefined'
        || typeof(sec_cat_products[topcatid]) === 'undefined') return cats;
    var topcat = sec_cat_products[topcatid];
    cats = topcat.categories;
    if(typeof(cats) === 'undefined') cats = null;
    return cats;
}
function getProducts(catid, topcatid)
{
    var products = null;
    var cats = getNonTopCategories(topcatid);
    if(cats === null
        || typeof(cats[catid]) === 'undefined') return products;
    var cat = cats[catid];
    products = cat.subproductprices;
    if(typeof(products) === 'undefined') products = null;
    return products;
}
function getProduct(prdid, catid, topcatid)
{
    var products = getProducts(catid, topcatid);
    var product = null;
    if(products === null) return product;
    product = products[prdid];
    return product;
}
function loadOrdPrdEntry(prdid, catid, topcatid)
{
    var product = getProduct(prdid, catid, topcatid);
    $('#ordPrdEntryModal').modal('show');
    $('#ordPrdEntryModal').on('shown.bs.modal', function()
    {
        $('#prdtopcatid').val(topcatid);
        $('#prdcatid').val(catid);
        $('#prdid').val(product.id);
        $('#prdsku').val(product.sku);
        $('#prdspminusdisc').val(product.spminusdisc);
        $('#prdquantity').val(1);
        $('#prdquantity').focus();
    });
}
function onSelectProductFromModal(what)
{
    //what 1 add and stay in
    //what 2 add close and back to main window.
    var sku = $('#prdsku').val();
    var prdid = $('#prdid').val();
    var topcatid = $('#prdtopcatid').val();
    var catid = $('#prdcatid').val();
    var product = getProduct(prdid, catid, topcatid);
    addDataForOrderProduct(product, $('#prdquantity').val(), $('#prdspminusdisc').val());
    $('#ordPrdEntryModal').modal('hide');
    if(what == 2)
    {
        $('#productsModal').modal('hide');
        $('#nontopcatModal').modal('hide');
        $('#topcatModal').modal('hide');
    }
}
function onchangeprdmargin_prdentry()
{
    var marginpercent = $('#Subproductprice_unit_sp_per').val();
    if(typeof(marginpercent) === 'undefined'
        || marginpercent.trim() === "") marginpercent = 0;
    marginpercent = parseFloat(marginpercent);
    var cost = $('#Subproductprice_unit_cp').val();
    if(typeof(cost) === 'undefined'
        || cost.trim() === "") cost = 0;
    cost = parseFloat(cost);
    var gain = marginpercent/100 * cost;
    gain = Math.round(gain * 100) / 100;
    var sp = cost + gain;
    sp = Math.round(sp * 100) / 100;
    $('#Subproductprice_unit_sp').val(sp);
}
function editBillDiscountBtnClick()
{
    openNumberPadModal(1);
//    $('#discountModal').modal('show');
//    $('#discountModal').on('shown.bs.modal', function() {
//        $('#editbilldiscount').focus();
//    });
}
function applyDiscount(e)
{
    if (e.keyCode != 13) {
        return;
    }
    e.preventDefault();
    var billdiscount = parseFloat($('#editbilldiscount').val());
    if(isNaN(billdiscount)) billdiscount = 0;
    if(billdiscount < 0)
    {
        alert('Please enter valid discount amount');
        $('#editbilldiscount').focus();
    }
    else
    {
        var is_percent = false;//need to check input with % symbol to set true.
        updateDiscount(billdiscount,is_percent, 1);
        $('#discountModal').modal('hide');
        $('#editbilldiscount').val('');
    }
}
function updateDiscount(billdiscount, is_percent, isonentryorrecalculation)
{//isonentryorrecalculation = 1 means comes from discount entry, otherwise by adding items recalculations
    var totalamount = parseFloat($('#billtotalamount').text());
    if(isNaN(totalamount)) totalamount = 0;
    if(typeof(is_percent) == 'undefined') is_percent = false;
    if(is_percent && totalamount > 0)
    {
        billdiscount = (billdiscount/100) * totalamount;
        billdiscount = Math.round(billdiscount * 100) / 100;
    }
    var billsubtotal = Math.round((totalamount - billdiscount) * 100) / 100;
    if(currentmode == '1' || currentmode == '3'
    //|| (currentmode == '2' && isonentryorrecalculation == 1)
        )
    {
        billsubtotal = Math.round((totalamount - (billdiscount * -1)) * 100) / 100;
    }

    var billtax = parseFloat($('#billtax').text());
    if(isNaN(billtax)) billtax = 0;
    billnetamount = Math.round((billsubtotal + billtax) * 100) / 100;
    if(currentmode == '1' || currentmode == '3'
        || (currentmode == '2' && minusmode == 1)
        )
    {
        billnetamount = Math.round((billsubtotal + (billtax * -1)) * 100) / 100;
    }

    if(currentmode == '1' || currentmode == '3'
        || (currentmode == '2' && minusmode == 1)
        )
    {
        var tmp = parseFloat(oldorder.roundoff);
        if(isNaN(tmp)) tmp = 0;
        $('#roundoff').val(tmp);
        $('#roundoffcheck').prop('checked', tmp != 0);
        //billnetamount += (tmp > 0?-tmp:tmp);
        billnetamount -= tmp;
    }
    else
    {
        $('#roundoff').val(0);
        $('#roundoffcheck').prop('checked', false);
    }
    var tendered = parseFloat($('#tenderedamount').val());
    if(isNaN(tendered)) tendered = 0;
    if(tendered > 0)
    {
        var blnc = tendered - billnetamount;
        blnc = blnc.format(2,3);
        $('#balancereturned').val(blnc);
    }
    billdiscount = billdiscount.format(2,3);
    billsubtotal = billsubtotal.format(2,3);
    billnetamount = billnetamount.format(2,3);
    $('#billdiscount').text(billdiscount);
    $('#billsubtotal').text(billsubtotal);
    if(currentmode == '2' && billnetamount < 0)
    {
        billnetamount = 0;
    }
    $('#billnetamount').text(billnetamount);
    return true;
}
function applyRoundOff()
{
    var existingroundoff = parseFloat($('#roundoff').val());
    if(isNaN(existingroundoff)) existingroundoff = 0;
    var orgbillnet = parseFloat($('#billnetamount').text());
    if(isNaN(orgbillnet)) orgbillnet = 0;

    var rndoffbillnet = orgbillnet;
    var t = $("#roundoffcheck").is(':checked');
    if(t)
    {
        rndoffbillnet = Math.round(orgbillnet * 10) / 10;
        var roundoff = rndoffbillnet - orgbillnet;
        $('#roundoff').val(roundoff);
    }
    else
    {
        rndoffbillnet = orgbillnet - existingroundoff;
        $('#roundoff').val(0);
    }
    rndoffbillnet = rndoffbillnet.format(2,3);
    $('#billnetamount').text(rndoffbillnet);
}
function logout(e)
{
    e.preventDefault();
    if(askclbalance == 1)
    {
        //updateRegisterbalance(2, true);
        alert('Please Close Register Before logout');
    }
    else
    {
        doLogout();
    }
}
function doLogout()
{
    //$('#clbalance').val(clbalance);
    $('#logoutform').submit();
}
function updateRegisterbalance(whichbalance, dologouttoo)
{
    if(typeof(dologouttoo) === 'undefined') dologouttoo = false;
    var promptstr = $('#openblconst').val();
    if(whichbalance === 2)
    {
        promptstr = $('#closeblconst').val();
    }
    var balance = prompt("Please Enter " + promptstr, "");
    if (balance != null) {
        var tmp = parseFloat(balance);
        if(isNaN(tmp) || tmp < 0)
        {
            alert('Enter valid amount. Please.');
            return;
        }
        else
        {
            var data= {'balance':balance,'type':whichbalance};
            $.ajax({
                type: 'POST',
                url: updateRegisterbalanceUrl,
                data:data,
                success:function(data){
                    if(whichbalance == 2)
                    {
                        openRgstrBlRprtModal(data.data, dologouttoo);
                    }
                },
                error: function(data){ // if error occured
                    alert('Error in updating balance.');
                }
            });
        }
    }
    else if(whichbalance == 1)
    {
        updateRegisterbalance(whichbalance, dologouttoo);
    }
}
function openRgstrBlRprtModal(rprtdata, dologouttoo)
{
    rgstrBlRprt = rprtdata[0];
    $('#rgstrBlRprtModal').modal('show');
//    if(dologouttoo)
//    {
//        $('#numberPadModal').on('hidden.bs.modal', function() {
//            doLogout();
//        });
//    }

    $('#rgstrBlRprtModal').on('shown.bs.modal', function() {
        var htmlstr = '<table>';
        var rowstr = '<tr><td>Open Balance</td>';
        rowstr += '<td class="right">'+ rgstrBlRprt.op_balance +'</td></tr>';
        htmlstr += rowstr;
        $.each(rgstrBlRprt.cashsummary, function(key, value)
        {
            rowstr = '<tr><td>'+value[0]+'</td>';
            rowstr += '<td class="right">'+ value[1] +'</td></tr>';
            htmlstr += rowstr;
        });
        rowstr = '<tr><td>Expected Cash In Register</td>';
        rowstr += '<td class="right">'+ rgstrBlRprt.expectedCB +'</td></tr>';
        htmlstr += rowstr;
        rowstr = '<tr><td>Actual Cash In Register</td>';
        rowstr += '<td class="right">'+ rgstrBlRprt.cl_balance +'</td></tr>';
        htmlstr += rowstr;
        htmlstr += '</table>';
        $('#rgstrBlRprtModalBody').html(htmlstr);

    });
}
function confirmAskclbalance()
{
    askclbalance = 2;//updated
}
function onONAccountClick(){
    var t = $("#payment_modecheck").is(':checked');
    if(t)
    {
        $('#tenderedamount').val($('#billnetamount').text());
    }
    else
    {
        $('#tenderedamount').val('');
    }
}
function doWork(e)//check it this gsm
{
    var evt = e || window.event;

    if (evt.stopPropagation) {
        evt.stopPropagation();
    }
    else {
        evt.cancelBubble = true;
    }

    alert('button');
}
function registerNumberPadEvents(){
    $('#numberPadModal').on('hidden.bs.modal', function() {
        resetNumpad();
    });
//    var modaldialog = $('#numberPadModal');
//    modaldialog.keydown(function(evt){
//            if (evt.keyCode === $.ui.keyCode.ESCAPE) {
//                resetNumpad();
//                modaldialog.modal('hide');
//            }
//            evt.stopPropagation();
//        });
    $('#numPadInput').click(function(){
        //$('#n_keypad').fadeToggle('fast');
    });
    $('.done').click(function(){
        //$('#n_keypad').hide('fast');
    });
    $('.numero').click(function(){
        var curvalue = $('#numPadInput').val();
        var percentidx = curvalue.indexOf("%");
        var is_percent = (percentidx > -1);
        var valueWOpercent = curvalue;
        if(is_percent)
        {
            valueWOpercent = curvalue.substring(0, percentidx);
        }
        if (!isNaN(valueWOpercent)) {
            var finalvalue = valueWOpercent;
            if(is_percent)
            {
                var curlen = valueWOpercent.length;
                var dotidx = valueWOpercent.indexOf(".");
                if ($(this).text() == '.' || (dotidx == curlen -1)){
                    if($(this).text() == '.'){
                        finalvalue = getDotSubstituedValue(valueWOpercent, is_percent);
                    }
                    else
                    {
                        finalvalue = valueWOpercent + $(this).text();
                    }
                } else {
                    finalvalue = $(this).text();
                }
                finalvalue = finalvalue + '%';
            }
            else
            {
                if (valueWOpercent.indexOf(".") == -1 && parseFloat(valueWOpercent) == 0) {
                    finalvalue = $(this).text();
                } else {
                    finalvalue = valueWOpercent + $(this).text();
                }
            }
            $('#numPadInput').val(finalvalue);
        }
    });
    $('.numeric_overwrite').click(function(){
        var curvalue = $('#numPadInput').val();
        var percentidx = curvalue.indexOf("%");
        var is_percent = (percentidx > -1);
        var valueWOpercent = curvalue;
        if(is_percent)
        {
            valueWOpercent = curvalue.substring(0, percentidx);
        }
        if (!isNaN(valueWOpercent)) {
            var finalvalue = $(this).text();
            if(is_percent)
            {
                finalvalue += '%';
            }
            $('#numPadInput').val(finalvalue);
        }
    });
//      $('.neg').click(function(){
//          if (!isNaN($('#numPadInput').val()) && $('#numPadInput').val().length > 0) {
//            if (parseInt($('#numPadInput').val()) > 0) {
//              $('#numPadInput').val(parseInt($('#numPadInput').val()) - 1);
//            }
//          }
//      });
//      $('.pos').click(function(){
//          if (!isNaN($('#numPadInput').val()) && $('#numPadInput').val().length > 0) {
//            $('#numPadInput').val(parseInt($('#numPadInput').val()) + 1);
//          }
//      });
    $('.del').click(function(){
        $('#numPadInput').val($('#numPadInput').val().substring(0,$('#numPadInput').val().length - 1));
    });
    $('.clear').click(function(){
        $('#numPadInput').val('');
    });
    $('.zero').click(function(){
        var curvalue = $('#numPadInput').val();
        var percentidx = curvalue.indexOf("%");
        var is_percent = (percentidx > -1);
        var valueWOpercent = curvalue;
        if(is_percent)
        {
            valueWOpercent = curvalue.substring(0, percentidx);
        }
        if (!isNaN(valueWOpercent)) {
            var finalvalue = valueWOpercent;
            if (parseFloat(valueWOpercent) != 0) {
                finalvalue = valueWOpercent + $(this).text();
            }
            else
            {
                var dotidx = curvalue.indexOf(".");
                if(dotidx > -1)
                {
                    finalvalue = valueWOpercent + $(this).text();
                }
            }
            if(is_percent)
            {
                finalvalue += '%';
            }
            $('#numPadInput').val(finalvalue);
        }
    });
    $('.decimalpoint').click(function(){
        var curvalue = $('#numPadInput').val();
        var percentidx = curvalue.indexOf("%");
        var is_percent = (percentidx > -1);
        var valueWOpercent = curvalue;
        if(is_percent)
        {
            valueWOpercent = curvalue.substring(0, percentidx);
        }
        $('#numPadInput').val(getDotSubstituedValue(valueWOpercent, is_percent));
    });
    $('.percent').click(function(){
        var curvalue = $('#numPadInput').val();
        if (curvalue.indexOf("%") == -1)
        {
            if (curvalue.length == 0)
            {
                curvalue = '0';
            }
            $('#numPadInput').val(curvalue + $(this).text());
        }
    });
}
function getValueWOpercent()
{
    var curvalue = $('#numPadInput').val();
    var percentidx = curvalue.indexOf("%");
    var is_percent = (percentidx > -1);
    var valueWOpercent = curvalue;
    if(is_percent)
    {
        valueWOpercent = curvalue.substring(0, percentidx);
    }
    return valueWOpercent;
}
function getDotSubstituedValue(curvalue, is_percent)
{
    var tobeinserted = '.';
    var rtn = curvalue;
    if (curvalue.indexOf(".") == -1)
    {
        if (curvalue.length == 0)
        {
            curvalue = '0';
        }
        rtn = curvalue + tobeinserted;
    }
    if(is_percent){
        rtn += '%';
    }
    return rtn;
}

function openNumberPadModal(operation)
{
    numPadOperation = operation;
    //$('#numberPadModal').modal('show');
}
function closeNumberPadModal()
{
    var curvalue = $('#numPadInput').val();
    var percentidx = curvalue.indexOf("%");
    var is_percent = (percentidx > -1);

    var valueWOpercent = curvalue;
    if(is_percent && numPadOperation == 1 || numPadOperation == 2)
    {
        valueWOpercent = curvalue.substring(0, percentidx);
    }
    valueWOpercent = parseFloat(valueWOpercent);
    if(isNaN(valueWOpercent)) valueWOpercent = 0;
    numPadInputValue = valueWOpercent;
    switch(numPadOperation){
        case 1://billdiscount
            if(valueWOpercent < 0)
            {
                alert('Please enter valid discount amount');
            }
            updateDiscount(valueWOpercent, is_percent, 1);
            break;
        case 2:
            updateTableRowWithNewDiscount(valueWOpercent, is_percent);
            break;
        case 3:
            updateTableRowWithNewQuantity(numPadInputValue);
            break;
        case 4:
            updateTableRowWithNewPrice(numPadInputValue);
            break;
        case 5:
            $('#prdquantity').val(numPadInputValue);
            break;
        case 6:
            $('#prdspminusdisc').val(numPadInputValue);
            break;
        case 7:
            numPadInputValue = numPadInputValue.format(2,3);
            $('#tenderedamount').val(numPadInputValue);
            UpdatePaymentBalance();
            break;
    }
    resetNumpad();
}
function resetNumpad()
{
    $('#numPadInput').val('');
    numPadOperation = 0;
    $('#numberPadModal').modal('hide');
}
function KeyPressHappened(e)
{
    switch(e.which)
    {
        case 65:
            alert('hi');
            break;
    }
    return true;
}
function setupPOSScreen(visible, throautorefresh)
{
    if(visible == 1)
    {
        $('#actionpanel').find('input,button,textarea').attr('disabled', 'disabled');
        $('#tablpanel').find('input,button,textarea').attr('disabled', 'disabled');
        $('#billdiscounthref').removeAttr('onclick');
    }
    else
    {
        fillTopCatDiv();
        fillNon_Mngd_PrdsDiv();
        if(throautorefresh == 1)
        {
            $('#actionpanel').find('input,button,textarea').removeAttr('disabled');
            $('#tablpanel').find('input,button,textarea').removeAttr('disabled');
            $('#billdiscounthref').attr('onclick', 'editBillDiscountBtnClick();');
            $('#numberPadModal').find('button').addClass('btn btn-primary btn-lg');
            $('#numberPadModal .modal-dialog').addClass('width400');
            //$('#prd_skus').focus();
            jQuery('#prd_skus').typeahead(
                {'hint':true,'highlight':true,'minLength':1},
                {
                    source: substringMatcher(allproducts_short)
                }
            );
            jQuery('#prd_skus').on('typeahead:selected', function (e, item) {
                onSelectProductFromMain(e, item);
            }).on('typeahead:autocompleted', function (e, item) {
                    onSelectProductFromMain(e, item);
                });
        }
        else
        {
//            var autocomplete = $('#prd_skus').typeahead();
//            autocomplete.data('typeahead').source = allproducts_short; //where newSource is your own array
            jQuery('#prd_skus').typeahead(
                {'hint':true,'highlight':true,'minLength':1},
                {
                    source: substringMatcher(allproducts_short)
                }
            );
        }
    }
    if(throautorefresh == 1) //need to check for the current bill.
    {
        refreshBillentry();
    }
    togglePaymentScreen();
    $('#prdmstrupdatemsg').text('');
}
function togglePaymentScreen()
{
    oncustomerChange_Payment();
    togglePaymentSubmitBtn();
}
function togglePaymentSubmitBtn()
{
    if((currentmode == '2')){
        $('#exchangesubmit').show();
        $('#normalsubmit').hide();
    }else
    {
        $('#exchangesubmit').hide();
        $('#normalsubmit').show();
    }
}
function setSubproductpricesDataTable()
{
    var datatbldelbtn=true;
    if(window.location.href.match("/purchaseentry/update"))
    {
        datatbldelbtn=false;
    }
    if ( !$.fn.dataTable.isDataTable( '#subproductprices' ) )
    {
        oPrdPriceTable = $('#subproductprices').dataTable(
            {
                'bProcessing': true,
                'bSort':false,
                'bPaginate':false,
                'bFilter':false,
                'bInfo':false,
                'bDestroy':true,
                "scrollY":"200px",
                //"scrollCollapse": true,
                //"scrollX": true,
                "oLanguage": {
                    "sEmptyTable": ' '
                },
                "aoColumns": [
                    {"sTitle": "X", "sClass": "center", "sWidth": "5%"},
                    {"sTitle": "E", "sClass": "center", "sWidth": "5%"},
                    {"sTitle": "Supplier", "sClass": "left", "sWidth": "40%"},
                    {"sTitle": "Code", "sClass": "left", "sWidth": "20%"},
                    {"sTitle": "SKU", "sClass": "left", "sWidth": "20%"},
                    {"sTitle": "Quantity", "sClass": "right", "sWidth": "5%"},
                    {"sTitle": "Pur.Pr.", "sClass": "right", "sWidth": "5%"},
                    {"sTitle": "Sel.Pr.", "sClass": "right", "sWidth": "5%"},
                    {"sTitle": "Sel.Pr.%", "sClass": "center", "sWidth": "1%"},

                    {"sTitle": "Don't", "sClass": "center", "sWidth": "1%"},
                    {"sTitle": "Rol", "sClass": "center", "sWidth": "1%"},
                    {"sTitle": "", "sClass": "center", "sWidth": "1%"},

                ],
                'columnDefs':[
                    {'mData': null, 'aTargets':[0], 'bVisible': datatbldelbtn,
                        "mRender": function (data, type, row) {
                            var tmp = '';
                            tmp = '<span style="display:block;" class="glyphicon glyphicon-remove-sign row-delete"></span>';
                            return tmp;
                        }
                    },
                    {'mData': null, 'aTargets':[1], 'bVisible': true,
                        "mRender": function (data, type, row) {
                            var tmp = '';
                            tmp = '<span style="display:block;" class="glyphicon glyphicon-edit row-edit"></span>';
                            return tmp;
                        }
                    },
                    {'mData': 'supplier_id', 'aTargets':[2],
                        "mRender": 0, 'bVisible': false
                    },
                    {'mData': 'code', 'aTargets':[3]},
                    {'mData': 'sku', 'aTargets':[4]},
                    {'mData': 'stock', 'aTargets':[5], 'bVisible': false, "mRender": 0},
                    {'mData': 'unit_cp', 'aTargets':[6]},
                    {'mData': 'unit_sp', 'aTargets':[7], 'bVisible': true, "mRender": 0},
                    {'mData': 'unit_sp_per', 'aTargets':[8], 'bVisible': false,"mRender": 0},

                    {'mData': 'dontsyncwithstock', 'aTargets':[9], 'bVisible': false},
                    {'mData': 'rol', 'aTargets':[10], 'bVisible': true,"mRender": 0},
                    {'mData': 'moq', 'aTargets':[11], 'bVisible': false,"mRender": 0},

                ]
            }
        );
        $('#subproductprices tbody').on( 'click', 'span.row-delete', function () {
            removeDataFromProductpriceTable(this, null);
        } );
        $('#subproductprices tbody').on( 'click', 'span.row-edit', function () {
            setCurProductpriceRowIndexAndData(this);
        } );
    }
    else
    {
        oPrdPriceTable = $('#subproductprices').dataTable();
    }
    oPrdPriceTableApi = $('#subproductprices').DataTable();
}
function setProductpricesDataTable()
{
    var datatbldelbtn=true;
    if(window.location.href.match("/product/update"))
    {
        datatbldelbtn=false;
    }
    if ( !$.fn.dataTable.isDataTable( '#productprices' ) )
    {
        oPrdPriceTable = $('#productprices').dataTable(
            {
                'bProcessing': true,
                'bSort':false,
                'bPaginate':false,
                'bFilter':false,
                'bInfo':false,
                'bDestroy':true,
                "scrollY":"200px",
                //"scrollCollapse": true,
                //"scrollX": true,
                "oLanguage": {
                    "sEmptyTable": ' '
                },
                "aoColumns": [
                    {"sTitle": "X", "sClass": "center", "sWidth": "5%"},
                    {"sTitle": "E", "sClass": "center", "sWidth": "5%"},
                    {"sTitle": "Supplier", "sClass": "left", "sWidth": "40%"},
                    {"sTitle": "Code", "sClass": "left", "sWidth": "20%"},
                    {"sTitle": "SKU", "sClass": "left", "sWidth": "20%"},
                    {"sTitle": "Quantity", "sClass": "right", "sWidth": "5%"},
                    {"sTitle": "Pur.Pr.", "sClass": "right", "sWidth": "5%"},
                    {"sTitle": "Sel.Pr.", "sClass": "right", "sWidth": "5%"},
                    {"sTitle": "Sel.Pr.%", "sClass": "center", "sWidth": "1%"},
                    {"sTitle": "Expiry Date", "sClass": "center", "sWidth": "1%"},
                    {"sTitle": "Don't", "sClass": "center", "sWidth": "1%"},
                    {"sTitle": "", "sClass": "center", "sWidth": "1%"},
                    {"sTitle": "", "sClass": "center", "sWidth": "1%"},
                    {"sTitle": "", "sClass": "center", "sWidth": "1%"},
                    {"sTitle": "", "sClass": "center", "sWidth": "1%"},
                    {"sTitle": "", "sClass": "center", "sWidth": "1%"},
                    {"sTitle": "", "sClass": "center", "sWidth": "1%"},
                ],
                'columnDefs':[
                    {'mData': null, 'aTargets':[0], 'bVisible': datatbldelbtn,
                        "mRender": function (data, type, row) {
                            var tmp = '';
                            tmp = '<span style="display:block;" class="glyphicon glyphicon-remove-sign row-delete"></span>';
                            return tmp;
                        }
                    },
                    {'mData': null, 'aTargets':[1], 'bVisible': true,
                        "mRender": function (data, type, row) {
                            var tmp = '';
                            tmp = '<span style="display:block;" class="glyphicon glyphicon-edit row-edit"></span>';
                            return tmp;
                        }
                    },
                    {'mData': 'supplier_id', 'aTargets':[2],
                        "mRender": function (data, type, row) {
                            var tmp = '';
                            if((typeof(row.supplier) !== 'undefined') && row.supplier.length >0)
                            {
                                tmp = row.supplier[0].lookupDisplay;
                            }
                            return tmp;
                        }
                    },
                    {'mData': 'code', 'aTargets':[3]},
                    {'mData': 'sku', 'aTargets':[4]},
                    {'mData': 'stock', 'aTargets':[5], 'bVisible': true},
                    {'mData': 'unit_cp', 'aTargets':[6]},
                    {'mData': 'unit_sp', 'aTargets':[7]},
                    {'mData': 'unit_sp_per', 'aTargets':[8], 'bVisible': false},
                    {'mData': 'expdate', 'aTargets':[9], 'bVisible': true,
                        "mRender": function (data, type, row) {
                            var tmp = '';
                            if((typeof(row.expdate) !== 'undefined') && row.expdate != null)
                            {
                                tmp = FormTableDateFormat(row.expdate);
                            }
                            else
                            {
                                tmp='';
                            }
                            row.expdate=tmp;
                            return tmp;
                        }},
                    {'mData': 'dontsyncwithstock', 'aTargets':[10], 'bVisible': false},
                    {'mData': 'rol', 'aTargets':[11], 'bVisible': false},
                    {'mData': 'moq', 'aTargets':[12], 'bVisible': false},
                    {'mData': 'invno', 'aTargets':[13], 'bVisible': false},
                    {'mData': 'invdate', 'aTargets':[14], 'bVisible': false},
                    {'mData': 'product_id', 'aTargets':[15], 'bVisible': false},
                    {'mData': 'category_id', 'aTargets':[16], 'bVisible': false},
                ]
            }
        );
        $('#productprices tbody').on( 'click', 'span.row-delete', function () {
            removeDataFromProductpriceTable(this, null);
        } );
        $('#productprices tbody').on( 'click', 'span.row-edit', function () {
            setCurProductpriceRowIndexAndData(this);
        } );
    }
    else
    {
        oPrdPriceTable = $('#productprices').dataTable();
    }
    oPrdPriceTableApi = $('#productprices').DataTable();
}

function clearProductpricesDataTable()
{
    oPrdPriceTable.fnClearTable();
    clearNewProductpriceentry();
}
function clearNewProductpriceentry()
{
    dflt_supplier_id = $('#dflt_supplier_id').val();
    $('#Productprice_supplier_id').val(0);
    $('#Productprice_id').val(0);
    $('#Productprice_code').val('');
    $('#Productprice_sku').val('');
    $('#Productprice_dontsyncwithstock').prop('checked',false);
    $('#Productprice_stock').val('');
    $('#Productprice_rol').val('');
    $('#Productprice_moq').val('');
    $('#expdate').val('');
    $('#Productpricecode').val(0);
    $('#Subproductprice_code').val('');
    $('#Subproductprice_sku').val('');
    $('#Subproductprice_unit_sp').val('');
    $('#Productprice_unit_cp').val('0.00');
    $('#Productprice_unit_sp').val('0.00');
    $('#Productprice_unit_sp_per').val('0.00');
    //added on 11/11 to clear sub product price id for unique code n barcode
    $('#Subproductprice_unit_cp').val('0.00');
    $('#Subproductprice_id').val("");
    $('#Subproductprice_rol').val("");
    $('#Subproductprice_unit_sp_per').val("");
    slctdproductpriceindex = -1;
    slctdproductprice = null;
}
function getPricesForAProductmaster(prdpricesurl)
{
    setSubproductpricesDataTable();
    var prd_id = $('#Product_id').val();
    if(typeof(prd_id) === 'undefined'
        || prd_id.trim() === "")
    {
        return;
    }
    var data = {'product_id': prd_id};
    $.ajax(
        {
            type: 'POST',
            url: prdpricesurl,
            data: JSON.stringify(data),
            dataType: 'json',
            success:function(data){
                if(data.data.length >0)
                {
                    curproduct = data.data[0];
                    curproductpricesarray = curproduct.subproductprices;

                }
                else
                {
                    alert(data.message);
                    curproduct = {};
                    curproductpricesarray = [];
                }
                setDataForProductpricesDataTable();
            },
            error: function(data)
            { // if error occured
                alert('Error in Retrieving Prices.');
                curproduct = {};
                curproductpricesarray = [];
            }
        }
    );
}
function getPricesForAProduct(prdpricesurl)
{
    setProductpricesDataTable();
    var prd_id = $('#Productprice_id').val();
    if(typeof(prd_id) === 'undefined'
        || prd_id.trim() === "")
    {
        return;
    }
    var data = {'Productprice_id': prd_id,'Product_id':$('#Product_id').val()};
//     alert(JSON.stringify(data.data[0].id));
    $.ajax(
        {
            type: 'POST',
            url: '/pos/productprice/getPricesForAProduct',
            data: JSON.stringify(data),
            dataType: 'json',
            success:function(data){
                var invdate=data.data[0].invdate;
                var date=FormTableDateFormat(invdate);
//             alert(JSON.stringify(data.data[0]));
                if(data.data.length >0)
                {
                    allsubproducts= data.data;
                    curproduct = data.data;
                    curproductpricesarray = curproduct;
                    $('#Productprice_invno').val(data.data[0].invno);
                    $('#invdate').val(date);
                    var opt='<option>Select</option>';
                    for(var u=0;u<data.data.length;u++){
                        opt +='<option value='+data.data[u].id+'>'+data.data[u].code+'</option>'
                    }
                    $('#Productpricecode').html(opt);
                    $('#Productpricecode').val(0);
                    $('#selectPrdname').val(data.data[0].product_id);
                    onchangeProduct();
                    // $('#selectPrdname').val(data.data[0].product_id);
                }
                else
                {
                    alert(data.message);
                    curproduct = {};
                    curproductpricesarray = [];
                }
                setDataForProductpricesDataTable();
            },
            error: function(data)
            { // if error occured
                alert('Error in Retrieving Prices.');
                curproduct = {};
                curproductpricesarray = [];
            }
        }
    );
}
function setDataForProductpricesDataTable()
{
    clearProductpricesDataTable();
    if(curproductpricesarray.length > 0)
    {
        oPrdPriceTable.fnAddData(curproductpricesarray);
    }
}
function addDataForProductprice()
{
    if($('#Productprice_invno').val()=='')
    {
        alert('Enter Invoice Number');
        return false;
    }
    if($('#invdate').val()=='')
    {
        alert('Select Invoice Date');
        return false;
    }
    if($('#selectPrdCategory').val()==0)
    {
        alert('Select Category');
        return false;
    }
    if($('#selectPrdname').val()==0)
    {
        alert('Select Product');
        return false;
    }
    if($('#Productprice_supplier_id').val()==0)
    {
        alert('Select a Supplier');
        return false;
    }
    if($('#Productpricecode').val()==0)
    {
        alert('Select a Code');
        return false;
    }
    if(($('#Productprice_unit_cp').val()=='0.00') || ($('#Productprice_unit_cp').val()==''))
    {
        alert('Enter Purchase Price');
        return false;
    }
    if($('#Productprice_stock').val()=='')
    {
        alert('Please enter the quantity');
        return false;
    }
//    if(($('#Productprice_unit_cp').val()=='') || ($('#Productpricecode').val()==0) || ($('#Productprice_stock').val()=='') ){
////        $('#Productprice_unit_cp').val('');$('#Productpricecode').val(0);$('#Productprice_stock').val('');$('#expdate').val('');$('#Productprice_supplier_id').val(0)
//        return false;
//        if($('#Productprice_supplier_id').val()==0)
//            return false;
//        }
//         }
    if(slctdproductpriceindex >=0 )
    {
        var val=$('#productbtn').val();
        updateProductprice(slctdproductprice, slctdproductpriceindex,val);
    }
    else
    {
        var rtnObj = getProductPriceRowForUnique();
        if(rtnObj.foundRow >= 0)
        {
            alert('duplicate Entry');
            return false;
        }
        else
        {
            addNewProductprice();
        }
    }
    curproductpricesarray = oPrdPriceTable.fnGetData();
    clearNewProductpriceentry();
}
function getProductPriceRowForUnique()
{
    curproductpricesarray = oPrdPriceTable.fnGetData();
    var supplierid = $('#Productprice_supplier_id').val();
    var unitcp = parseFloat($('#Productprice_unit_cp').val());
    if(isNaN(unitcp)) unitcp = 0;
    var unitsp = parseFloat($('#Productprice_unit_sp').val());
    if(isNaN(unitsp)) unitsp = 0;
    var foundObj = null;
    var foundRow = -1;
    var rtnObj = {};
    $.each(curproductpricesarray, function(i, obj)
    {
        var objunitcp = parseFloat(obj.unit_cp);
        if(isNaN(objunitcp)) objunitcp = 0;
        var objunitsp = parseFloat(obj.unit_sp);
        if(isNaN(objunitsp)) objunitsp = 0;
        if(window.location.href.match("/purchaseentry/create"))
        {
            if((obj.supplier_id === supplierid
                && objunitcp === unitcp
                && objunitsp === unitsp)||(obj.code ===$('#Productpricecode option:selected').text()))
            {
                foundObj = obj;
                foundRow = i;
                return false;//will not continue the each loop. it stops here
            }
        }
        else
        {
            if((obj.code ===$('#Productpricecode option:selected').text()))
            {
                foundObj = obj;
                foundRow = i;
                return false;//will not continue the each loop. it stops here
            }
        }
    });
    rtnObj.foundRow = foundRow;
    rtnObj.foundObj = foundObj;
    return rtnObj;
}
function updateProductprice(foundObj, foundRow,val)
{
    loadFromProductpriceEntry(foundObj, false,val);
    oPrdPriceTable.fnUpdate( foundObj, foundRow );
}
function addNewProductprice()
{
    var val=$('#productbtn').val();
    var foundObj = {};
    loadFromProductpriceEntry(foundObj, true,val);
    oPrdPriceTableApi.row.add(foundObj).draw();
}
function removeDataFromProductpriceTable(rowobj)
{
    oPrdPriceTableApi
        .row( $(rowobj).parents('tr') )
        .remove()
        .draw();
}
function setCurProductpriceRowIndexAndData(eventtarget)
{
    var cellobj = $(eventtarget).parents('td');//array returns
    var indexobj = oPrdPriceTable.fnGetPosition( cellobj[0] );//cell obj. gives [rowindex, columnindex]
    slctdproductpriceindex = indexobj[0];
    slctdproductprice = oPrdPriceTable.fnGetData( slctdproductpriceindex );
    var expirydate=slctdproductprice.expdate;
    var date=expirydate;
//    var date=expirydate;
    loadToProductpriceEntry(date);
}
function loadToProductpriceEntry(date)
{
    if(slctdproductpriceindex < 0) return;
    $('#Productprice_id').val(slctdproductprice.id);
    $('#Subproductprice_id').val(slctdproductprice.id);
    if($('#Productpricecode').val()!==undefined){
        $('#loader').text('Wait process is going on.....');
        $('#selectPrdCategory').val(slctdproductprice.category_id);
        $('#selectPrdname').val(slctdproductprice.product_id);
        $('#Productprice_supplier_id').val(slctdproductprice.supplier_id);
        var data={"id":$('#Productpricecode').val(),"sku":slctdproductprice.sku};
        $.ajax({
            type: 'POST',
            url: '/pos/subproductprice/getStockcnt',
            data:JSON.stringify(data),
            success:function(data){
                data=JSON.parse(data);
                $('#Productprice_stockinhand').val(data[0].initial_stock);
                $('#Productprice_latestprice').val(data[0].unit_cp);
                if(data[0].invdate!==null)
                    data[0].invdate=FormTableDateFormat(data[0].invdate)
                $('#Productprice_latestinvdate').val(data[0].invdate);
                $('#Productprice_latestinvno').val(data[0].invno);
                // afterSaveAccountForm(data, formid, resultdivid, loaderdivid);
            },
            error: function(data){ // if error occured
                alert("Error occured.please try again");
                //alert(data);
            }
        });
        onchangecategory();
    }
    else
        $('#Subproductprice_unit_sp_per').val(slctdproductprice.unit_sp_per);
    $('#Subproductprice_rol').val(slctdproductprice.rol);
    $('#Subproductprice_code').val(slctdproductprice.code);
    if($('#Productprice_sku').val()!==undefined)
        $('#Productprice_sku').val(slctdproductprice.sku);
    else
        $('#Subproductprice_sku').val(slctdproductprice.sku);
    $('#Productprice_dontsyncwithstock').prop('checked', (slctdproductprice.dontsyncwithstock == 1));
    $('#Productprice_stock').val(slctdproductprice.stock);
    $('#Productprice_supplier_id').val(slctdproductprice.supplier_id);
    if($('#Productprice_unit_cp').val()!==undefined)
        $('#Productprice_unit_cp').val(slctdproductprice.unit_cp);
    else
        $('#Subproductprice_unit_cp').val(slctdproductprice.unit_cp);
    if($('#Productprice_unit_sp').val()!==undefined)
        $('#Productprice_unit_sp').val(slctdproductprice.unit_sp);
    else
        $('#Subproductprice_unit_sp').val(slctdproductprice.unit_sp);
    $('#Productprice_unit_sp_per').val(slctdproductprice.unit_sp_per);
    if($('#Productprice_expdate').val()!==undefined)
        $('#expdate').val(date);
    else
        $('#expdate').val(date);
}
function loadFromProductpriceEntry(foundObj, isnew,val)
{
    var supplierid = $('#'+val+'price_supplier_id').val();
    var supplierdisplay = $('#'+val+'price_supplier_id option:selected').text();
    if($('#Productprice_id').val()!==undefined)
        foundObj.id=$('#Productprice_id').val();
    else
        foundObj.id=$('#Subproductprice_id').val();
    if($('#'+val+'price_supplier_id').val() === undefined)
        var supplierid =0;
    if($('#'+val+'price_supplier_id').val() === undefined)
        var supplierdisplay =0;
    foundObj.supplier_id = supplierid;
    if(isnew)
    {
        foundObj.supplier = new Array();
    }
    foundObj.supplier[0] = {'id':supplierid,'lookupDisplay':supplierdisplay};
    //foundObj.id = "";
    var t = $("#Productprice_dontsyncwithstock").is(':checked');
    if(t)
    {
        t= '1';
    }
    else
    {
        t = '2';
    }
    foundObj.dontsyncwithstock = t;
    foundObj.code = $('#'+val+'price_code').val();
    if(val=='Product')
        foundObj.code = $('#'+val+'pricecode option:selected').text();
    foundObj.sku = $('#'+val+'price_sku').val();
    var tmpcp = parseFloat($('#'+val+'price_unit_cp').val());
    if(isNaN(tmpcp)) tmpcp = 0;
    foundObj.unit_cp = tmpcp.format(2,3);
    var tmpsp = parseFloat($('#'+val+'price_unit_sp').val());
    if(isNaN(tmpsp)) tmpsp = 0;
    foundObj.unit_sp = tmpsp.format(2,3);
    foundObj.unit_sp_per = $('#'+val+'price_unit_sp_per').val();
    if($('#'+val+'price_unit_sp_per').val()===undefined){
        foundObj.unit_sp_per = 0;
    }
    foundObj.invdate =  $('#invdate').val();
    if($('#invdate').val()===undefined){
        foundObj.invdate = 0;
    }
    foundObj.invno =  $('#'+val+'price_invno').val();
    if($('#'+val+'price_invno').val()===undefined){
        foundObj.invno = 0;
    }
    foundObj.stock = $('#'+val+'price_stock').val();
    foundObj.expdate = $('#'+val+'price_expdate').val();
    if($('#'+val+'price_stock').val() === undefined)
        foundObj.stock =0;
    if($('#'+val+'price_rol').val() === undefined||$('#'+val+'price_rol').val() ==="")
    {
        foundObj.rol=0;
    }
    else
    {
        foundObj.rol =$('#'+val+'price_rol').val();
    }

    foundObj.moq = 0;
    if(val=='Product'){
        foundObj.expdate =$('#expdate').val();
        foundObj.category_id =$('#selectPrdCategory').val();
        foundObj.product_id =$('#selectPrdname').val();}
}
function submitMultipriceproduct()
{
    curproductpricesarray = oPrdPriceTable.fnGetData();
//    alert(curproductpricesarray)
    var len = (curproductpricesarray.length > 0);
    var url = $('#multipriceproductsaveUrl').val();
    if(len)
    {

        var postObj = {};
        postObj['Product'] = {};
        postObj['productprices'] = curproductpricesarray;
        var formdata=$("#product-form").serializeArray();
        if(url =='/pos/product/multipriceproductsave'){
            $.each(curproductpricesarray, function(i, obj)
            {
                obj.invno =$("#Productprice_invno").val();
                obj.invdate =$("#invdate").val();
            }); postObj['productprices'] = curproductpricesarray;
//                var chkInvoice=onchangeinvoice();
//                if(chkInvoice == false)
//                    return false;
            postObj['Product'] = {"id":$("#selectPrdname").val(),"category_id":$("#selectPrdCategory").val(),"invno":$("#Productprice_invno").val()};

        }else{
            //  $('#img').val($('#Product_imagepath').val());
//            alert($('#Product_imagepath').val());
            jQuery.each( formdata, function( i, field ) {
                var fldname = field.name;
                var ptrn = /Product\[([\w.]+)]/i;
                var res = fldname.match(ptrn);
                if(res !== null){
                    postObj['Product'][res[1]] = field.value;
//if(field.name==='Product[imagepath]')
//                            postObj['Product'][res[1]] = $('#Product_imagepath').val();
                    if(field.name==='Product[imagepath]') {
//done by puni on 21/11/2014 - start
//fake path in product image
                        if ($('#Product_imagepath').val().toString().toLowerCase().match("fakepath"))
                        {
                            postObj['Product'][res[1]]=$('#Product_imagepath').val().split("fakepath\\")[1];
                        }
                        else
                        {
                            postObj['Product'][res[1]]=$('#Product_imagepath').val();
                        }
                        if (postObj['Product'][res[1]]===""){postObj['Product'][res[1]]=null;}

                    }
                    //done by puni on 21/11/2014 - end
                }

            });
            $.each(curproductpricesarray, function(i, obj)
            {
                obj.category_id =$("#selectPrdCategoryid").val();
            });
        }
        //postObj = {"Product":{"id":"10","category_id":"5"},"productprices":[{"supplier_id":"7","supplier":[{"id":"7","lookupDisplay":"  [] hari"}],"id":"","dontsyncwithstock":"2","code":"Dal 10 kg","sku":"dal 1200kg","unit_cp":"110.00","unit_sp":"100.00","unit_sp_per":0,"invdate":0,"invno":"invlast900","stock":"99","expdate":"28/10/2014","rol":0,"moq":0},{"supplier_id":"8","supplier":[{"id":"8","lookupDisplay":"  [] jacky"}],"id":"","dontsyncwithstock":"2","code":"Dal 10 kg","sku":"1122dallll","unit_cp":"110.00","unit_sp":"100.00","unit_sp_per":0,"invdate":0,"invno":"invlast900","stock":"55","expdate":"28/10/2014","rol":0,"moq":0}]}
        postObj = JSON.stringify(postObj);

        $.ajax({
            type: 'POST',
            url: url,
            enctype: 'multipart/form-data',
            data:postObj,
            success:function(data){
                if(data.RetCode == 0){
                    if((window.location.href.match("/product/create")) || (window.location.href.match("purchaseentry/create")))
                    {
                        alert("Record Saved")
                    }
                    else
                    {
                        alert(data.message);
                    }
                    $("#product-form").submit();
                    //document.location.href=data.data;
                }
                else
                {
                    var msg = 'Error.';
                    $.each(data.data, function(key, val) {
                        msg += '\n' + val[0];
                    });
                    //$('#formResult').text(msg);
                    alert(msg);
                }
            },
            error: function(data){ // if error occured
                alert("Error occured.please try again"+JSON.stringify(data));
            }
        });
        return true;
    }
    else
    {
//        alert('Please enter atleast one price row');
        if(url =='/pos/product/multipriceproductsave')
        {
            alert('Please enter atleast one price row');
        }
        else
        {
            alert('Please enter atleast one subproduct,barcode row');
        }
    }
    return false;
}
function toggleProductCodeDetails()
{
    var t = $("#Productprice_dontsyncwithstock").is(':checked');
    if(t)
    {
        $('#productcodedetails').find('input,button,textarea').attr('disabled', 'disabled');
    }
    else
    {
        $('#productcodedetails').find('input,button,textarea').removeAttr('disabled');
    }
}
function getProductTax(barCode){
    for(var o=0;o<=allproducts_short.length;o++){
        var value=allproducts_short[o].value;
        var productCat=value.split(':');
        if(barCode.value === sec_cat_products[productCat[2]].categories[productCat[1]].productprices[productCat[0]].sku){
            var objProductAllVal=sec_cat_products[productCat[2]].categories[productCat[1]].productprices[productCat[0]];
            break;
        }
    }
    addDataForOrderProduct(objProductAllVal);}
function getProductTax(tet){
    $("#prd_skus").val( $("#prd_skus1").val())
}
//CHANGE FUNCTION FOR PRODUCTS IN PURCHASE FORM
function onchangeProduct(){
    if(($('#selectPrdname').val()!=null) && ($('#selectPrdname').val()!=0))
    {
        var productIdobj={'productId':$('#selectPrdname').val()};
        productIdobj= JSON.stringify(productIdobj)  ;
        $.ajax({
            type: 'POST',
            url: $('#subproductCatesaveUrl').val(),
            enctype: 'multipart/form-data',
            data:productIdobj,
            success:function(data){
                if(data.RetCode == 0){
                    for(var s=0;s<data.data.tax.length;s++){
                        if(data.data.allproducts_short[0].taxrate_id==data.data.tax[s].id)
                            var salesTax=data.data.tax[s].taxname;
                    }
                    $('#Product_taxrate_id').val(salesTax);
                    $('#Product_discper').val(data.data.allproducts_short[0].discper);
                    $('#Product_desc').val(data.data.allproducts_short[0].desc);
                    $('#Product_remarks').val(data.data.allproducts_short[0].remarks);
                    $('#Productpricecode').html('');
                    var opt='<option value=0>Select</option>';
                    allsubproducts=data.data.sec_cat_products;
                    for(var u=0;u<data.data.sec_cat_products.length;u++){
                        opt +='<option value='+data.data.sec_cat_products[u].id+'>'+data.data.sec_cat_products[u].code+'</option>';
                        if((slctdproductprice!==null) && (data.data.sec_cat_products[u].code === slctdproductprice.code ))
                            var subproductId=data.data.sec_cat_products[u].id;
                    }
                    $('#Productpricecode').html(opt);
                    if(subproductId== undefined)
                    {
                        $('#Productpricecode').val(0);
                    }
                    else
                    {
                        $('#Productpricecode').val(subproductId);
                    }
                    $('#loader').text('');
                }
                else
                {
                    var msg = 'Error.';
                    $.each(data.data, function(key, val) {
                        msg += '\n' + val[0];
                    });
                    //$('#formResult').text(msg);
                    alert(msg);
                }
            },
            error: function(data){ // if error occured
                alert("Error occured.please try again");
            }
        });
    }
}
//CHANGE FUNCTION FOR SUBPRODUCTS IN PURCHASE FORM
$(document).ready(function(){
    //to load product based on the category for purchase form start
    if(window.location.href.match("/product/create"))
    {   var opt="<option value=0>Select</option>";
        $('#selectPrdname').html(opt);
    }
    else if(window.location.href.match("/product/update"))
    {
        if($('#selectPrdCategory').val()!=undefined){
            onchangecategory();
        }
    }
//done by sarada 29/11/2014 - check trans. in purchase form
    $(document).on('change','#selectPrdCategoryid',function(){
        if(window.location.href.match("/purchaseentry/update")){
            var data={"productId":$('#Product_id').val()};
            $.ajax({
                type: 'POST',
                url: '/pos/purchaseentry/checktrans',
                data:JSON.stringify(data),
                success:function(data){
                    data=JSON.parse(data);
                    if(data.flag==false){
                        alert('PRODUCT HAVING TRANSACTION CANT CHANGE');
                        $('#selectPrdCategoryid').val(data.catId)
                    }   },
                error: function(data){
                    alert("Error occured.please try again");
                }
            });
        }
    });
    //to load product based on the category for purchase form end
    $(document).on('change','#Productpricecode',function(){
        for(var u=0;u<allsubproducts.length;u++){
            if( $('#Productpricecode option:selected').text()===allsubproducts[u].code){
                $('#Productprice_stockinhand').val(allsubproducts[u].initial_stock);
                $('#Productprice_unit_sp').val(allsubproducts[u].unit_sp);
                $('#Productprice_latestprice').val(allsubproducts[u].unit_cp);
                if(allsubproducts[0].invdate!==null)
                    allsubproducts[0].invdate=FormTableDateFormat(allsubproducts[0].invdate);
                $('#Productprice_latestinvdate').val(allsubproducts[0].invdate);
                $('#Productprice_latestinvno').val(allsubproducts[0].invno);
// $('#Productprice_unit_cp').val(''); $('#expdate').val('');
                $('#Productprice_sku').val(allsubproducts[u].sku);
                var data={"id":$('#Productpricecode').val(),"sku":$('#Productprice_sku').val()};
//   $.ajax({
//         type: 'POST',
//         url: '/pos/subproductprice/getstockcnt',
//         data:JSON.stringify(data),
//         success:function(data){
//          $('#Productprice_qnty').val(data);
//            // afterSaveAccountForm(data, formid, resultdivid, loaderdivid);
//         },
//         error: function(data){ // if error occured
//             alert("Error occured.please try again");
//             //alert(data);
//         }
//     });
                break;}
        }
    });
    $(document).on('mouseover','#prd_skus_over',function(){
        for(var o=0;o<=allproducts_short.length;o++){
            var value=allproducts_short[o].value;
            var productCat=value.split(':');
            if($(this).val()=== sec_cat_products[productCat[2]].categories[productCat[1]].subproductprices[productCat[0]].sku){
                var objProductAllVal=sec_cat_products[productCat[2]].categories[productCat[1]].subproductprices[productCat[0]];
                break;
            }
        }
        addDataForOrderProduct(objProductAllVal);
        $('#prd_skus_over').val('');

    });
    //FUNCTION FOR ALLOW JPEG & <=100MB
    $(document).on('change','#Product_imagepath,#Category_imagepath',function(){
        var ext = this.value.match(/\.(.+)$/)[1];
        switch(ext)
        {
            case 'jpg':
//        case 'png':
//        case 'png':
//        case 'tif':
                // alert('allowed');
                break;
            default:
                alert('CAN UPLOAD  EXTENSION WITH JPEG IMAGE ONLY');
                this.value='';
        }
        var fileSize = this.files[0];
//     alert(this.files[0].size);
        var sizeInMb = fileSize.size/1024;
        var sizeLimit= 1024*100;
        if (fileSize.size > 100000) {
//    if (sizeInMb > sizeLimit) {
            alert('CAN UPLOAD LESS THAN OR EQUAL TO 100 KB');
            this.value='';
        }
    });
//              function getProductTax(barCode){
//    alert(barcode)
//for(var o=0;o<=allproducts_short.length;o++){
//    var value=allproducts_short[o].value;
//    var productCat=value.split(':');
//                if(barCode.value === sec_cat_products[productCat[2]].categories[productCat[1]].productprices[productCat[0]].sku){
//            var objProductAllVal=sec_cat_products[productCat[2]].categories[productCat[1]].productprices[productCat[0]];
//            break;
//        }
//}
//addDataForOrderProduct(objProductAllVal);}
});
//AJAX VALIDATION FOR INVOICE NUMBER
function onchangeinvoice(){
    var invoiceno={'InvoiceNO':$('#Productprice_invno').val(),'Id':$('#Productprice_id_inv').val()};
    invoiceno= JSON.stringify(invoiceno)  ;
    $.ajax({
        type: 'POST',
        url: '/pos/productprice/getinvoiceno',
        data:invoiceno,
        success:function(data) {
            if(data=='true')
            {
                alert("Invoice Number already exists Give another one");
                $('#Productprice_invno').val('').focus();
//                    return false;
            }
//                else
//                    true;

        }
    });
}
//Date format
function dateformat(date){
    var mysqldate=new Date(date);
    var month=mysqldate.getMonth()+1;
    var year=mysqldate.getFullYear();
    var date=mysqldate.getDate();
    var formatdate=date + "/" + month + "/" + year;
    return formatdate;
}
function FormTableDateFormat(inputdate){
    var string  = inputdate.split("-");
    if(string[2]=== undefined)
        return inputdate;
    else
        return string[2]+'/'+ string[1]+'/'+string[0];
}
//CHECK UNIQUE CODE
function onchangecode(){
    curproductpricesarray = oPrdPriceTable.fnGetData();
    var len = (curproductpricesarray.length > 0);
    var checkcode=false;
    if(len)
    {
        $.each(curproductpricesarray, function(i, obj)
        {
            if(window.location.href.match("/purchaseentry/update"))
            {
                if(($('#Subproductprice_id').val()!=obj.id&&$('#Subproductprice_id').val()!="")||$('#Subproductprice_id').val()=="")
                {
                    if($('#Subproductprice_code').val().trim().toString().toLowerCase()==obj.code.trim().toString().toLowerCase())
                    {
                        checkcode=true;
                    }
                }
            }
            else
            {
                if($('#Subproductprice_code').val().trim().toString().toLowerCase()==obj.code.trim().toString().toLowerCase())
                {
                    checkcode=true;
                }
            }
        });
    }
    if(checkcode==false)
    {
        var code={'code':$('#Subproductprice_code').val(),'id':$('#Subproductprice_id').val()};
        code= JSON.stringify(code)  ;
        $.ajax({
            type: 'POST',
            url: '/pos/subproductprice/getcode',
            data:code,
            success:function(data) {
                if(data=='true')
                {
                    checkcode=true;
                    DuplicateCodedisplay_errmsg("code")
                }

            },
            error: function(data){ // if error occured
                alert("Error occured in checking code");
//             alert( JSON.stringify(data));
            }
        });
    }
    if(checkcode==true){
        DuplicateCodedisplay_errmsg("code");
    }
}
function DuplicateCodedisplay_errmsg(field)
{
    if(field=="code")
    {
        alert("Code already exists");
        $('#Subproductprice_code').val('').focus();
    }
    else if(field=="sku")
    {
        alert("SKU[Barcode] already exists");
        $('#Subproductprice_sku').val('').focus();
    }
    else
    {
        alert("Name already exists");
        $('#Product_name').val('').focus();
    }
}

//CHECK UNIQUE BARCODE
function onchangesku(){
    curproductpricesarray = oPrdPriceTable.fnGetData();
    var len = (curproductpricesarray.length > 0);
    var checksku=false;
    if(len)
    {
        $.each(curproductpricesarray, function(i, obj)
        {
            if(window.location.href.match("/purchaseentry/update"))
            {
                if(($('#Subproductprice_id').val()!=obj.id&&$('#Subproductprice_id').val()!="")||$('#Subproductprice_id').val()=="")
                {
                    if($('#Subproductprice_sku').val().trim().toString().toLowerCase()==obj.sku.trim().toString().toLowerCase())
                    {
                        checksku=true;
                    }
                }
            }
            else
            {
                if($('#Subproductprice_sku').val().trim().toString().toLowerCase()==obj.sku.trim().toString().toLowerCase())
                {
                    checksku=true;
                }
            }
        });
    }
    if(checksku==false)
    {
        var sku={'sku':$('#Subproductprice_sku').val(),'id':$('#Subproductprice_id').val()};
        sku= JSON.stringify(sku)  ;
        $.ajax({
            type: 'POST',
            url: '/pos/subproductprice/getsku',
            data:sku,
            success:function(data) {
                if(data=='true')
                {
                    checksku=true;
                    DuplicateCodedisplay_errmsg("sku")
                }

            },
            error: function(data){ // if error occured
                alert("Error occured in checking SKU[Barcode]");
//             alert( JSON.stringify(data));
            }
        });
    }
    if(checksku==true){
        DuplicateCodedisplay_errmsg("sku");
    }
}
//CHANGE FUNCTION FOR CATEGORY IN PURCHASE FORM TO GET PRODUCT NAME
function onchangecategory()
{
    var productcategobj={'productcategory':$('#selectPrdCategory').val()};
    productcategobj= JSON.stringify(productcategobj)  ;
    $.ajax({
        type: 'POST',
        url: '/pos/product/getCategoryProducts',
        enctype: 'multipart/form-data',
        data:productcategobj,
        success:function(data){
            var msg=[];
            if(data){
                var prodnamearray = JSON.parse(data);
                var opt="<option value=0>Select</option>";
                for(var u=0;u<prodnamearray.prodname.length;u++){
                    opt +='<option value='+prodnamearray.prodname[u].id+'>'+prodnamearray.prodname[u].name+'</option>'
                }
                $('#selectPrdname').html(opt);
                $('#selectPrdname').val(slctdproductprice.product_id);
                onchangeProduct();
            }
            else
            {
                var msg = 'Error.';
                $.each(data.data, function(key, val) {
                    msg += '\n' + val[0];
                });
                alert(msg);
            }
        },
        error: function(data){ // if error occured
            alert("Error occured.please try again");
        }
    });
}
function onchangeproductname()
{
    var code={'prd_name':$('#Product_name').val(),'prd_id':$("#Product_id").val()};
    code= JSON.stringify(code)  ;
    $.ajax({
        type: 'POST',
        url: '/pos/product/CheckProductname',
        data:code,
        success:function(data) {
            if(data=='true')
            {
                checkcode=true;
                DuplicateCodedisplay_errmsg("prodname");
            }

        },
        error: function(data){ // if error occured
            alert("Error occured in checking name");
//            alert( JSON.stringify(data));
        }
    });
}
function DuplicateCodedisplay_errmsg(field)
{
    if(field=="code")
    {
        alert("Code already exists");
        $('#Subproductprice_code').val('').focus();
    }
    else if(field=="sku")
    {
        alert("SKU[Barcode] already exists");
        $('#Subproductprice_sku').val('').focus();
    }
    else
    {
        alert("Name already exists");
        $('#Product_name').val('').focus();
    }
}
$(document).on('change','.price_form',function(){
    if(($('#Productprice_invno').val()!='') && ($('#invdate').val()!=='') && ($('#selectPrdCategory').val()!=0) && ($('#selectPrdname').val()!=0))
    {
//        $('#prices_form').show();
        $('#price_form_btn').removeAttr("disabled");
    }
    else
    {
        $('#price_form_btn').attr("disabled","disabled");
    }
});
//done by raja 21/11/2014 - start
//validation for create product
function addCreateSubproductprice()
{
    if($('#selectPrdCategoryid').val()==0)
    {
        alert('Select a Category Type');
        return false;
    }
    if($('#Product_name').val()=='')
    {
        alert('Enter Product Name');
        return false;
    }
    if($('#Product_taxrate_id').val()==0)
    {
        alert('Select a Taxrate');
        return false;
    }

    if($('#Subproductprice_code').val()=='')
    {
        alert('Enter Product Code');
        return false;
    }
    if($('#Subproductprice_sku').val()=='')
    {
        alert('Enter Barcode');
        return false;
    }

    if(($('#Subproductprice_unit_sp').val()=='')|| ($('#Subproductprice_unit_sp').val()=='0.00')|| ($('#Subproductprice_unit_sp').val()=='0'))
    {
        alert('Enter Selling Price');
        return false;
    }
    if(($('#Subproductprice_code').val()=='') || ($('#Subproductprice_sku').val()=='')|| ($('#Subproductprice_unit_sp').val()=='')|| ($('#Subproductprice_unit_sp').val()=='0')|| ($('#Subproductprice_unit_sp').val()=='0.00'))
    {
        return false;
    }
    if(slctdproductpriceindex >=0 )
    {
        var val=$('#productbtn').val();
        updateProductprice(slctdproductprice, slctdproductpriceindex,val);
    }
    else
    {
        var rtnObj = getProductPriceRowForUnique();
        if(rtnObj.foundRow >= 0)
        {
            alert('duplicate Entry');
            return false;
        }
        else
        {
            addNewProductprice();
        }
    }
    curproductpricesarray = oPrdPriceTable.fnGetData();
    clearNewProductpriceentry();
}
//$(document).on('change','.radioPayment',function(){
//          $('#tenderrow').show();
//       $('#balancerow').show();
//});
$(document).on('change','.prod_form',function(){
    if(($('#selectPrdCategoryid').val()!=0) && ($('#Product_name').val()!=='') && ($('#Product_taxrate_id').val()!=0))
    {

        $('#prod_update_btn').removeAttr("disabled");
    }
    else
    {

        $('#prod_update_btn').attr("disabled","disabled");
    }
});

//done by raja 21/11/2014 - end
//done by skl 22/11/2014 - start
//validation for numbers only
$(document).on('keyup','.numberonly',function(e) {
    var val = $(this).val();
    if($.trim($.isNumeric(val))=="false")
    {
        $(this).val(val.replace(/[^0-9,]+/g,''));
    }

    if(val.substring(0,1)===',')
    {
        $(this).val(val.substring(1));
    }
});
//done by skl 22/11/2014 - end
$(document).on('click','.radioPayment',function(){
    if($('#payment_mode').find(':checked').val()=='Master/Visa' || $('#payment_mode').find(':checked').val()=='Nets')
    {
        $('#balancerow').hide();
        $('#tenderrow').hide();
    }
    else
    {
        $('#balancerow').show();
        $('#tenderrow').show();
    }
});
function StockAdjustment(url)
{
    var id=$('#Subproductprice_product_id').val();
    var remarks=$('#Subproductprice_Remarks').val();
    var refno=$('#Subproductprice_referenceno').val();
    var code=$('#Subproductprice_code').val();
    var date=$('#Subproductprice_dateofadjustment').val();
    var sku=$('#Subproductprice_sku').val();
    var stock=$('#Subproductprice_stock').val();
    var adjstock=$('#Subproductprice_stockadjustment').val();
    if($("input[name=checkboxadd]").is(":checked")==true)
    {
        var finalstock =adjstock;
    }
    if($("input[name=checkboxminus]").is(":checked")==true)
    {
        var finalstock=adjstock;
    }
    if($("input[name=checkboxadd]").is(":checked")!=true && $("input[name=checkboxminus]").is(":checked")!=true)
    {
        var finalstock=0;
    }
    if(adjstock!="" && remarks!="")
    {
        if($("input[name=checkboxadd]").is(":checked")==true || $("input[name=checkboxminus]").is(":checked")==true)
        {
            var stockadjarray={'product_id':id,'Remarks':remarks,'refno':refno,'code':code,'date':date,'sku':sku,'stock':stock,'final_stock':adjstock};

            $.ajax({
                type: 'POST',
                url: '/pos/Stockadjustment/posStockAdjustment',
                data:JSON.stringify(stockadjarray),
                success:function(data){
                    if(data.RetCode == 0){
                        if(window.location.href.match("/stockadjustment/Adjsearch"))
                        {
                            alert("Record Saved")
                        }
                        else
                        {
                            alert(data.message);
                        }
//                    $("#productprice-form").submit();
                        document.location.href=data.data;
                    }
                    else
                    {
                        var msg = 'Error.';
                        $.each(data.data, function(key, val) {
                            msg += '\n' + val[0];
                        });
                        //$('#formResult').text(msg);
                        alert(msg);
                    }
                },
                error: function(data)
                {
                    alert("Error");
                }
            });
        }
        else
        {
            alert('Select Stock Adjustment + or -');
        }
    }
    else
    {
        if(adjstock=="")
        {
            alert('Enter Stock Adjustment Quantity')
        }
        if(remarks=="")
        {
            alert('Enter The Remarks...')
        }
    }
}
function duplicaterefnocheck()
{
    var  dataarray={'refno':$('#Subproductprice_referenceno').val()};
    $.ajax({
        type: 'POST',
        url: '/pos/Stockadjustment/Refduplicatecheck',
        data:JSON.stringify(dataarray),
        success:function(data)
        {
            if(data=='true')
            {
                alert("Reference Number Already Exists");
                $('#Subproductprice_referenceno').val('').focus();
                return false;
            }
            else
                true;

        }
    });
}
