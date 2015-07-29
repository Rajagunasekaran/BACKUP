<?php
require_once "Header.php";
?>
<style>
    .errormsg{
        padding-top:12px;
    }
</style>
<script>
$(document).ready(function(){
    $('.preloader').show();
    $(".date-picker").datepicker({
        dateFormat:"dd-mm-yy",
        changeYear: true,
        changeMonth: true
    });
    $(".date-picker").on("change", function () {
        var id = $(this).attr("id");
        var val = $("label[for='" + id + "']").text();
        $("#msg").text(val + " changed");
    });
    var max = 250;
    $('#banktt_ta_address').keypress(function(e) {
        if (e.which < 0x20) {
            // e.which < 0x20, then it's not a printable character
            // e.which === 0 - Not a character
            return;     // Do nothing
        }
        if (this.value.length == max) {
            e.preventDefault();
        } else if (this.value.length > max) {
            // Maximum exceeded
            this.value = this.value.substring(0, max);
        }
    });
    $('textarea').autogrow({onInitialize: true});
    $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
    $(".alphanumonly").doValidation({rule:'alphanumeric'});
    $(".uppercase").doValidation({rule:'general'});
    $(".autosize").doValidation({rule:'general',prop:{whitespace:true,autosize:true}});
    $(".compautosize").doValidation({rule:'general',prop:{autosize:true}});
    $(".numonly").doValidation({rule:'numbersonly'});
    $("#banktt_tb_accno").doValidation({rule:'numbersonly',prop:{realpart:25,leadzero:true}});
    $("#banktt_tb_bankcode").doValidation({rule:'numbersonly',prop:{realpart:4,leadzero:true}});
    $("#banktt_tb_branchcode").doValidation({rule:'numbersonly',prop:{realpart:3,leadzero:true}});

    $('#banktt_customer').hide();
    $('#banktt_model').hide();
    $('#banktt_tb_bankcode').val('');
    $('#banktt_bankcode').hide().val('');
    $('#banktt_tb_branchcode').val('');
    $('#banktt_branchcode').hide().val('');
    $('#banktt_tb_swiftcode').val('');
    $('#banktt_swiftcode').hide().val('');
    $('#banktt_chargeto').hide();
    $('#banktt_errormsgcustomer').hide();
    $('#banktt_modelnameerrormsg').hide();
    $('#banktt_date').datepicker("option","minDate",new Date(new Date().getFullYear()-1,new Date().getMonth(),new Date().getDate()));
    $('#banktt_date').datepicker("option","maxDate",new Date());

    // initial data
    var type;
    var model;
    var unit;
    var charges;
    var errormsg;
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('Banktt_entry_controller/Initialdata'); ?>",
        success: function(data){
            var value=JSON.parse(data);
            $('.preloader').hide();
            type=value[0];
            model=value[1];
            unit=value[2];
            charges=value[3];
            errormsg=value[4];
            if(type!=''){
                $('#banktt_lb_transtype').append($('<option> SELECT </option>'));
                for(var i=0;i<type.length;i++)
                {
                    var data=type[i].BCN_DATA;
                    $('#banktt_lb_transtype').append($('<option>').text(data).attr('value', data));
                }
            }
            if(model!=''){
                $('#banktt_lb_model').append($('<option> SELECT </option>'));
                for(var j=0;j<model.length;j++)
                {
                    var data=model[j].BTM_DATA;
                    $('#banktt_lb_model').append($('<option>').text(data).attr('value', data));
                }
            }
            if(unit!=''){
                $('#banktt_lb_unit').append($('<option> SELECT </option>'));
                for(var k=0;k<unit.length;k++)
                {
                    var data=unit[k].UNIT_NO;
                    $('#banktt_lb_unit').append($('<option>').text(data).attr('value', data));
                }
            }
            if(charges!=''){
                $('#banktt_lb_chargeto').append($('<option> SELECT </option>'));
                for(var l=0;l<charges.length;l++)
                {
                    var data=charges[l].BCN_DATA;
                    $('#banktt_lb_chargeto').append($('<option>').text(data).attr('value', data));
                }
            }
            $('#banktt_tb_amt').prop('title',errormsg[1].EMC_DATA);
            if(unit.length==0 || unit.length=='')
            {
                if(unit.length==0)
                {
                    var uniterrormsg='<p><label class="errormsg">'+errormsg[5].EMC_DATA+'</label></p>';
                    $('#banktt_errormessagetable').append(uniterrormsg);
                    $('#banktt_entry_form').hide();
                    $('#banktt_errormessageform').show();
                }
//                if(emailname==null)
//                {
//                    var emailerrormsg='<p><label class="errormsg">'+errormsg[3].EMC_DATA+'</label></p>';
//                    $('#banktt_errormessagetable').append(emailerrormsg);
//                    $('#banktt_entry_form').hide();
//                    $('#banktt_errormessageform').show();
//                }
            }
            else
            {
                $('#banktt_entry_form').show();
            }
        }
    });
    //UNIQUE FUNCTION
    function unique(a) {
        var result = [];
        $.each(a, function(i, e) {
            if ($.inArray(e, result) == -1) result.push(e);
        });
        return result;
    }
    //unit chsange
    var customer=[];
    $(document).on('change','#banktt_lb_unit',function(){
        $('#banktt_errormsgcustomer').hide();
        var unitno=$('#banktt_lb_unit').val();
        if(unitno!='SELECT'){
            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Banktt_entry_controller/Customername'); ?>",
                data:"unitno="+ unitno,
                success: function(data){
                    $('.preloader').hide();
                    var value=JSON.parse(data);
                    customer=value;
                    var customername_array=[];
                    for(var k=0;k<customer.length;k++)
                    {
                        customername_array.push(customer[k].CUSTOMER_NAME);
                    }
                    customername_array=unique(customername_array);
                    $('#banktt_lb_customer').append($('<option> SELECT </option>'));
                    if(customer.length!=0){
                        for(var i=0;i<customername_array.length;i++)
                        {
                            var listdata=customername_array[i].replace('_',' ');
                            $('#banktt_lb_customer').append($('<option>').text(listdata).attr('value', customername_array[i]));
                        }
                        $('#banktt_errormsgcustomer').hide();
                        $('#banktt_customer').show();
                        $('#banktt_lb_customer').val('SELECT').show();
                    }
                    else{
                        var msg=errormsg[4].EMC_DATA.replace('[UNIT NO]',unitno);
                        $('#banktt_errormsgcustomer').text(msg).show();
                        $('#banktt_customer').hide();
                        $('#banktt_lb_customer').val('SELECT').hide();
                    }
                }
            });
        }
        else{
            $('#banktt_modelnameerrormsg').hide();
            $('#banktt_customer').hide();
            $('#banktt_lb_customer').val('SELECT').hide();
            $("#banktt_submitbutton").attr("disabled", "disabled");
        }
    });
    // form reset
    $('#banktt_resetbutton').click(function(){
        BANKTT_ENTRY_reset();
    });
    function BANKTT_ENTRY_reset(){
        $("#banktt_entry_form").find('input:text, textarea').val('');
        $("#banktt_entry_form").find('select').val('SELECT');
        $('#banktt_transtype').show();
        $('#banktt_dt').show();
        $('#banktt_unit').show();
        $('#banktt_model').hide();
        $('#banktt_custref').show();
        $('#banktt_swiftcode').show();
        $('#banktt_amt').show();
        $('#banktt_chargeto').hide();
        $('#banktt_customer').hide();
        $('#banktt_bankaddress').show();
        $('#banktt_invdetails').show();
        $('#banktt_comments').show();
        $('#banktt_bankcode').hide();
        $('#banktt_branchcode').hide();
        $('#banktt_accname').show();
        $('#banktt_accno').show();
        $("#banktt_submitbutton").attr("disabled", "disabled");
        $('#banktt_errormsgcustomer').hide();
        $('#banktt_modelnameerrormsg').hide();
    }
    // type change
    $(document).on('change','#banktt_lb_transtype',function(){
        $('#banktt_ta_address').val('');
        $('#banktt_tb_custref').val('');
        $('#banktt_ta_invdetails').val('');
        $('#banktt_ta_comments').val('');
        $('#banktt_errormsgcustomer').hide();
        $('#banktt_modelnameerrormsg').hide();
        $("#banktt_entry_form").find('input:text, textarea').val('');
        if($('#banktt_lb_transtype').val()=='TT')
        {
            $('#banktt_bankcode').hide();
            $('#banktt_branchcode').hide();
            $('#banktt_model').hide();
            $('#banktt_lb_model').val('SELECT').hide();
            $('#banktt_accno').show();
            $('#banktt_unit').show();
            $('#banktt_lb_unit').val('SELECT').show();
            $('#banktt_customer').hide();
            $('#banktt_lb_customer').val('SELECT').hide();
            $('#banktt_accname').show();
            $('#banktt_swiftcode').show();
            $('#banktt_amt').show();
            $('#banktt_dt').show();
            $('#banktt_chargeto').show();
            $('#banktt_lb_chargeto').val('SELECT').show();
            $('#banktt_modelnameerrormsg').hide();
            $("#banktt_submitbutton").attr("disabled", "disabled");
        }
        if($('#banktt_lb_transtype').val()=='GIRO')
        {
            $('#banktt_amt').show();
            $('#banktt_dt').show();
            $('#banktt_swiftcode').hide();
            $('#banktt_chargeto').hide();
            $('#banktt_lb_chargeto').val('SELECT').hide();
            $('#banktt_model').hide();
            $('#banktt_lb_model').val('SELECT').hide();
            $('#banktt_accno').show();
            $('#banktt_unit').show();
            $('#banktt_lb_unit').val('SELECT').show();
            $('#banktt_customer').hide();
            $('#banktt_lb_customer').val('SELECT').hide();
            $('#banktt_accname').show();
            $('#banktt_bankcode').show();
            $('#banktt_branchcode').show();
            $('#banktt_modelnameerrormsg').hide();
            $("#banktt_submitbutton").attr("disabled", "disabled");
        }
        if($('#banktt_lb_transtype').val()=='MODEL')
        {
            $('#banktt_accno').hide();
            $('#banktt_amt').show();
            $('#banktt_dt').show();
            $('#banktt_unit').hide();
            $('#banktt_lb_unit').val('SELECT').hide();
            $('#banktt_customer').hide();
            $('#banktt_lb_customer').val('SELECT').hide();
            $('#banktt_accname').hide();
            $('#banktt_swiftcode').hide();
            $('#banktt_chargeto').hide();
            $('#banktt_lb_chargeto').val('SELECT').hide();
            $('#banktt_bankcode').hide();
            $('#banktt_branchcode').hide();
            if(model.length!=0)
            {
                $('#banktt_model').show();
                $('#banktt_lb_model').val('SELECT').show();
                $('#banktt_modelnameerrormsg').hide();

            }
            else
            {
                $('#banktt_model').hide();
                $('#banktt_lb_model').val('SELECT').hide();
                $('#banktt_modelnameerrormsg').show();

            }
            $("#banktt_submitbutton").attr("disabled", "disabled");
        }
    });

    // button validation
    $(document).on('change blur','.banktt_erntryform',function(){
        if($('#banktt_lb_transtype').val()=="TT")
        {
            if($('#banktt_date').val()!='' && $('#banktt_tb_amt').val()!='' && $('#banktt_lb_unit').val()!='SELECT'
                && $('#banktt_lb_customer').val()!='SELECT' && $('#banktt_lb_customer').val()!='' && $('#banktt_lb_customer').val()!=undefined
                && $('#banktt_tb_swiftcode').val()!='' && $('#banktt_lb_chargeto').val()!="SELECT"
                && $('#banktt_tb_accno').val()!='' && $('#banktt_tb_accname').val()!='')
            {
                $("#banktt_submitbutton").removeAttr("disabled");
            }
            else
            {
                $("#banktt_submitbutton").attr("disabled", "disabled");
            }
        }
        else if($('#banktt_lb_transtype').val()=="GIRO")
        {
            if($('#banktt_date').val()!='' && $('#banktt_tb_amt').val()!='' && $('#banktt_lb_unit').val()!='SELECT'
                &&  $('#banktt_lb_customer').val()!='SELECT' && $('#banktt_lb_customer').val()!='' && $('#banktt_lb_customer').val()!=undefined
                && $('#banktt_tb_accno').val()!='' && $('#banktt_tb_accname').val()!='')
            {
                $("#banktt_submitbutton").removeAttr("disabled");
            }
            else
            {
                $("#banktt_submitbutton").attr("disabled", "disabled");
            }
        }
        else if($('#banktt_lb_transtype').val()=="MODEL")
        {
            if($('#banktt_date').val()!='' && $('#banktt_tb_amt').val()!='' && $('#banktt_lb_model').val()!="SELECT")
            {
                $("#banktt_submitbutton").removeAttr("disabled");
            }
            else
            {
                $("#banktt_submitbutton").attr("disabled", "disabled");
            }
        }
        else
        {
            $("#banktt_submitbutton").attr("disabled", "disabled");
        }
    });
    // save part

});
</script>
<!--BODY TAG START-->
<body>
<form id='banktt_errormessageform' hidden>
    <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="container">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">BANK TT ENTRY</h2>
            </div>
            <div class="panel-body">
                <fieldset>
                    <div id='banktt_errormessagetable'>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</form>
<form id="banktt_entry_form" name="banktt_entry_form" class="form-horizontal" role="form">
    <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="container">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">BANK TT ENTRY</h2>
            </div>
            <div class="panel-body">
                <fieldset>
                    <div class="form-group" id="banktt_transtype">
                        <label class=" col-sm-2">TRANSACTION TYPE<em>*</em></label>
                        <div class="col-sm-3"> <select name="banktt_lb_transtype" id="banktt_lb_transtype" class="form-control banktt_erntryform"></select></div>
                    </div>
                    <div class="form-group" id="banktt_modelnameerrormsg">
                        <label class=" col-sm-2"></label>
                        <div class="col-sm-3"> <label class="errormsg">NO DATA AVAILABLE IN MODEL DETAILS TABLE</label></div>
                    </div>
                    <div class="form-group" id="banktt_model">
                        <label class=" col-sm-2">MODEL NAME<em>*</em></label>
                        <div class="col-sm-3"> <select name="banktt_lb_model" id="banktt_lb_model" class="form-control banktt_erntryform"></select></div>
                    </div>
                    <div class="form-group" id="banktt_dt">
                        <label class="col-sm-2">DATE<em>*</em></label>
                        <div class="col-sm-3">
                            <div class="input-group addon">
                                <input id="banktt_date" name="banktt_date" type="text" class="date-picker datemandtry form-control" placeholder="Date"/>
                                <label for="banktt_date" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="banktt_accname">
                        <label class=" col-sm-2">ACCOUNT NAME<em>*</em></label>
                        <div class="col-sm-3"><input type="text" name="banktt_tb_accname" id="banktt_tb_accname" placeholder="Account Name" maxlength="40" class="autosize banktt_erntryform form-control"/></div>
                    </div>
                    <div class="form-group" id="banktt_accno">
                        <label class=" col-sm-2">ACCOUNT NO<em>*</em></label>
                        <div class="col-sm-3"><input type="text" name="banktt_tb_accno" id="banktt_tb_accno" placeholder="Account No" maxlength="25" class="banktt_erntryform form-control"/></div>
                    </div>
                    <div class="form-group" id="banktt_amt">
                        <label class=" col-sm-2">AMOUNT<em>*</em></label>
                        <div class="col-sm-2"><input type="text" name="banktt_tb_amt" id="banktt_tb_amt" placeholder="Amount" maxlength="7" class="amtonly banktt_erntryform form-control"/></div>
                    </div>
                    <div class="form-group" id="banktt_unit">
                        <label class=" col-sm-2">UNIT<em>*</em></label>
                        <div class="col-sm-2"> <select name="banktt_lb_unit" id="banktt_lb_unit" class=" form-control banktt_erntryform"></select></div>
                        <label id='banktt_errormsgcustomer' class="errormsg banktt_erntryform" hidden></label>
                    </div>
                    <div class="form-group" id="banktt_customer">
                        <label class=" col-sm-2">CUSTOMER<em>*</em></label>
                        <div class="col-sm-3"> <select name="banktt_lb_customer" id="banktt_lb_customer" class="form-control banktt_erntryform"></select></div>
                    </div>
                    <div class="form-group" id="banktt_bankcode">
                        <label class="col-sm-2">BANK CODE</label>
                        <div class="col-sm-2"><input type="text" name="banktt_tb_bankcode" id="banktt_tb_bankcode" maxlength="4" class="alphanumeric banktt_erntryform form-control" placeholder="Bank Code"/></div>
                    </div>
                    <div class="form-group" id="banktt_branchcode">
                        <label class="col-sm-2">BRANCH CODE</label>
                        <div class="col-sm-2"><input type="text" name="banktt_tb_branchcode" id="banktt_tb_branchcode" maxlength="3" class="alphanumeric banktt_erntryform form-control" placeholder="Branch Code"/></div>
                    </div>
                    <div class="form-group" id="banktt_bankaddress">
                        <label class="col-sm-2">BANK ADDRESS</label>
                        <div class="col-sm-4"> <textarea  name="banktt_ta_address" id="banktt_ta_address" placeholder="Bank Address" rows="5" class="uppercase banktt_erntryform form-control"></textarea></div>
                    </div>
                    <div class="form-group" id="banktt_swiftcode">
                        <label class="col-sm-2">SWIFT CODE<em>*</em></label>
                        <div class="col-sm-2"><input type="text" name="banktt_tb_swiftcode" id="banktt_tb_swiftcode" maxlength="12" class="alphanumeric banktt_erntryform form-control" placeholder="Swift Code"/></div>
                    </div>
                    <div class="form-group" id="banktt_chargeto">
                        <label class=" col-sm-2">CHARGES TO<em>*</em></label>
                        <div class="col-sm-2"> <select name="banktt_lb_chargeto" id="banktt_lb_chargeto" class="form-control banktt_erntryform"></select></div>
                    </div>
                    <div class="form-group" id="banktt_custref">
                        <label class="col-sm-2">CUSTOMER REF</label>
                        <div class="col-sm-3"><input type="text" name="banktt_tb_custref" id="banktt_tb_custref" maxlength="200" class="autosize banktt_erntryform form-control" placeholder="Customer Ref"/></div>
                    </div>
                    <div class="form-group" id="banktt_invdetails">
                        <label class="col-sm-2">INV DETAILS</label>
                        <div class="col-sm-4"> <textarea  name="banktt_ta_invdetails" id="banktt_ta_invdetails" placeholder="Inv Details" maxlength="300" rows="5" class="banktt_erntryform form-control"></textarea></div>
                    </div>
                    <div class="form-group" id="banktt_comments">
                        <label class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"> <textarea  name="banktt_ta_comments" id="banktt_ta_comments" placeholder="Comments" maxlength="300" rows="5" class="banktt_erntryform form-control"></textarea></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <input class="btn btn-info" type="button"  id="banktt_submitbutton" name="SAVE" value="SAVE" disabled />
                            <input class="btn btn-info" type="button"  id="banktt_resetbutton" name="Reset" value="RESET" />
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</form>
</body>
</html>
