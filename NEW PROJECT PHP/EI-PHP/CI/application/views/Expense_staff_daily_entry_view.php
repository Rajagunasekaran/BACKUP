<?php
require_once "Header.php";
?>
<html>
<head>
<style type="text/css">
    td, th {
        padding: 8px;
    }
</style>
<script type="text/javascript">
// document ready function
$(document).ready(function(){
    $('textarea').autogrow({onInitialize: true});
    $(".numonly").doValidation({rule:'numbersonly',prop:{realpart:5}});
    $("#staffdly_tb_comisnamt").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
    $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
    $(".amtonlysalary").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
    $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
// DATE PICKER FOR THE AGENT COMMISION
    $("#staffdly_invdate").datepicker({
        dateFormat:'dd-mm-yy',
        changeYear: true,
        changeMonth: true
    });
// DATE PICKER FOR THE STAFF
    $("#staffdly_db_invdate1").datepicker({
        dateFormat:'dd-mm-yy',
        changeYear: true,
        changeMonth: true
    });
    $('#staffdly_tb_cursalary').hide();
    $('#staffdly_tb_newsalary').hide();
    $('#staffdly_tb_curcpfamt').hide();
    $('#staffdly_tb_newcpfamt').hide();
    $('#staffdly_tb_curlevyamt').hide();
    $('#staffdly_tb_newlevyamt').hide();
// initial data
    $('#spacewidth').height('0%');
    $('#agent_comisndiv,#salary_entrydiv,#staffdiv,#buttons,#staff_errordiv').hide();
    var staffdly_currentsal='';
    var staffdly_currentcpf='';
    var staffdly_currentlevy='';
    var staffdly_employeeRadio=[];
    var checktable=[];
    var employeename=[];
    var category=[];
    var expencetype=[];
    var errormsg;
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('Expense_staff_daily_entry_controller/Initialdata'); ?>",
        data:{'ErrorList':'337,169,105,400'},
        success: function(data){
            $('.preloader').hide();
            var value_array=JSON.parse(data);
            expencetype=value_array[0];
            checktable=value_array[1];
            employeename=value_array[2];
            errormsg=value_array[3];
            if(expencetype!=''){
                $('#staffdly_lb_type').append($('<option> SELECT </option>'));
                for(var i=0;i<expencetype.length;i++)
                {
                    if( i>=5 && i<=7)
                    {
                        var expid=expencetype[i].ECN_ID;
                        var expdata=expencetype[i].ECN_DATA;
                        $('#staffdly_lb_type').append($('<option>').text(expdata).attr('value', expid));
                    }
                    if( i>=0 && i<=4)
                    {
                        var catid=expencetype[i].ECN_ID;
                        var catdata=expencetype[i].ECN_DATA;
                        $('#staffdly_lb_category1').append($('<option>').text(catdata).attr('value', catid));
                    }
                }
            }
            if(checktable!=''){
                $('#staffdly_lb_employee').append($('<option> SELECT </option>'));
                var staffdly_employeename=[];
                for(var i=0;i<checktable.length;i++)
                {
                    staffdly_employeename.push(checktable[i].EMPLOYEE_NAME);
                }
                var staffdly_unique_employee=staffdly_unique(staffdly_employeename);
                staffdly_unique_employee=staffdly_unique_employee.sort();
                if(checktable.length!=0){
                    for(var j=0;j<staffdly_unique_employee.length;j++)
                    {
                        var listdata=staffdly_unique_employee[j];
                        $('#staffdly_lb_employee').append($('<option>').text(listdata).attr('value', listdata));
                    }
                }
            }
        }
    });
    function staffdly_unique(a) {
        var result = [];
        $.each(a, function(i, e) {
            if ($.inArray(e, result) == -1) result.push(e);
        });
        return result;
    }
// change event for expense
    $(document).on('change','#staffdly_lb_type',function(){
//        $("html, body").animate({ scrollTop: '100' }, "slow");
        $('#staffdlyentry_form').find('input:text, textarea').val('');
        $('#staffdlyentry_form').find('input:radio').removeAttr('checked');
        $('#salary_entrydiv,#staffdiv').find('select').val('SELECT');
        var expensetype =$(this).val();
        if(expensetype=='SELECT'){
            $('#agent_comisndiv,#salary_entrydiv,#staffdiv,#buttons').hide();
            $("#staffdlyentry_form").find('input:text, textarea').val('');
            $("#staffdlyentry_form").find('select').val('SELECT');
            $('#staffdlyentry_form').find('input:radio').removeAttr('checked');
        }
        if(expensetype==39){
            $('#agent_comisndiv,#buttons').show();
            $('#salary_entrydiv,#staffdiv,#staff_errordiv').hide();
        }
        if(expensetype==40){
            if((checktable.length==0)||(employeename.length==0))
            {
                $('#staff_errordiv').show();
                if((checktable.length==0)&&(employeename.length==0))
                {
                    $('#staffdly_lbl_erromsg').text(errormsg[1].EMC_DATA).show();
                    $('#staffdly_lbl_edtlerromsg').text(errormsg[2].EMC_DATA).show();
                }
                if((checktable.length==0)&&(employeename.length!=0))
                {
                    $('#staffdly_lbl_erromsg').text(errormsg[1].EMC_DATA).show();
                    $('#staffdly_lbl_edtlerromsg').text(errormsg[2].EMC_DATA).hide();
                }
                if((checktable.length!=0)&&(employeename.length==0))
                {
                    $('#staffdly_lbl_erromsg').text(errormsg[1].EMC_DATA).hide();
                    $('#staffdly_lbl_edtlerromsg').text(errormsg[2].EMC_DATA).show();
                }
            }
            else{
                $('#salary_entrydiv,#buttons').show();
                $('#agent_comisndiv,#staffdiv,#staff_errordiv').hide();
            }
        }
        if(expensetype==41){
            $('#staffdiv').show();
            $('#agent_comisndiv,#salary_entrydiv,#buttons,#staff_errordiv').hide();
            STAFF_clear_staff();
            STAFF_categorytyperesult();
        }
    });
// botton reset
    $(document).on('click','#staffdly_resetbutton',function(){
        $('#staffdlyentry_form').find('input:text, textarea').val('');
        $('#staffdlyentry_form').find('input:radio').removeAttr('checked');
        $('#salary_entrydiv,#staffdiv').find('select').val('SELECT');
        $('#staffdly_submitbutton').attr("disabled", "disabled");
        $('#staffdly_multipleemployee').empty();
        $('#staffdly_fromdate') .datepicker( "option", "maxDate", new Date());
        $('#staffdly_todate') .datepicker( "option", "maxDate", new Date());
        $('#staffdly_todate') .datepicker( "option", "minDate",null );
    });
// CHANGE THE EMPLOYEE NAME
    function STAFFDLY_func_salaryentryclear(){
        $('#staffdly_tb_cursalary').val('').hide();
        $('#staffdly_tb_newsalary').val('').hide();
        $('#staffdly_tb_curcpfamt').val('').hide();
        $('#staffdly_tb_newcpfamt').val('').hide();
        $('#staffdly_tb_curlevyamt').val('').hide();
        $('#staffdly_tb_newlevyamt').val('').hide();
        $('#staffdly_todate').val('');
        $('#staffdly_fromdate').val('');
        $('#staffdly_paiddate').val('');
        $('#staffdly_ta_salarycomments').val('');
        $('#staffdly_salaryamt').find('input:radio').removeAttr('checked');
        $('#staffdly_rd_cursalary').removeAttr("disabled");
        $('#staffdly_rd_curcpfamt').removeAttr("disabled");
        $('#staffdly_rd_curlevyamt').removeAttr("disabled");
        $('#staffdly_rd_newsalary').removeAttr("disabled");
        $('#staffdly_rd_newcpfamt').removeAttr("disabled");
        $('#staffdly_rd_newlevyamt').removeAttr("disabled");
        $('#staffdly_submitbutton').show();
        $('#staffdly_resetbutton').show();
        staffdly_currentsal='';
        staffdly_currentcpf='';
        staffdly_currentlevy='';
    }
// CHANGE FUNCTION FOR SALARY ENTRY
    $(document).on('change','#staffdly_lb_employee',function(){
        $('#staffdly_hidden_edssid').val('');
        STAFFDLY_func_salaryentryclear();
        var staffdly_listvalue=$('#staffdly_lb_employee').find('option:selected').text();
        if(staffdly_listvalue=="SELECT")
        {
            STAFFDLY_func_salaryentryclear();
            $('#staffdly_submitbutton').attr("disabled", "disabled");
            $('#staffdly_tb_cpf').val('');
            $('#staffdly_multipleemployee').empty();
        }
        else
        {
            staffdly_employeeRadio=[];
            $('#staffdly_multipleemployee').empty();
            for(var k=0;k<checktable.length;k++)
            {
                if(checktable[k].EMPLOYEE_NAME==staffdly_listvalue)
                {
                    staffdly_employeeRadio.push(checktable[k])
                }
            }
            if(staffdly_employeeRadio.length!=1)
            {
                STAFFDLY_func_salaryentryclear();
                $('#staffdly_tb_cpf').val('');
                for (var i=0;i<staffdly_employeeRadio.length;i++)
                {
                    var staffdly_val_emplyidname=staffdly_employeeRadio[i].EMPLOYEE_NAME+'-'+staffdly_employeeRadio[i].EMP_ID;
                    var staffdly_tr_radio ='<div class="col-sm-offset-3" style="padding-left:15px"><div class="radio"><label><input type="radio" value='+staffdly_employeeRadio[i].EMPLOYEE_NAME+' id='+staffdly_val_emplyidname+' name="staffdly_rd_employee" class="staffdly_sameemployee"/>'+ staffdly_val_emplyidname +'</label></div></div>';
                    $('#staffdly_multipleemployee').append(staffdly_tr_radio);
                    $('#staffdly_multipleemployee').show();
                }
            }
            else
            {
                $('#staffdly_multipleemployee').empty();
                staffdly_currentsal=staffdly_employeeRadio[0].EDSS_SALARY_AMOUNT;
                staffdly_currentcpf=staffdly_employeeRadio[0].EDSS_CPF_AMOUNT;
                staffdly_currentlevy=staffdly_employeeRadio[0].EDSS_LEVY_AMOUNT;
                $('#staffdly_hidden_edssid').val(staffdly_employeeRadio[0].EDSS_ID);
                var staffdly_arr_loadamt=[];
                staffdly_arr_loadamt.push(staffdly_employeeRadio[0].EDSS_CPF_NUMBER);
                staffdly_arr_loadamt.push(staffdly_employeeRadio[0].EDSS_LEVY_AMOUNT);
                STAFFDLY_loadamt(staffdly_arr_loadamt);
            }
        }
    });
// LOAD THE AMOUNT FOR THE LEVY ,SALARY AND CPF
    function STAFFDLY_loadamt(cpfamt)
    {
        var staffdly_getamtno=[];
        staffdly_getamtno=cpfamt;
        var staffdly_no=staffdly_getamtno[0];
        var staffdly_levy_amount=staffdly_getamtno[1];
        $('#staffdly_tb_cpf').val(staffdly_no);
        var staffdly_empname=$("#staffdly_lb_employee").val();
        if(staffdly_empname=='SELECT')
        {
            $('#staffdly_submitbutton').attr("disabled", "disabled");
        }
        else
        {
            if(staffdly_no==null)
            {
                $('#staffdly_tb_cpf').text("");
                $('#staffdly_rd_curcpfamt').attr("disabled", "disabled");
                $('#staffdly_rd_newcpfamt').attr("disabled", "disabled");
            }
            else
            {
                $('#staffdly_rd_curcpfamt').removeAttr("disabled");
                $('#staffdly_rd_newcpfamt').removeAttr("disabled");
            }
            if(staffdly_levy_amount==null)
            {
                $('#staffdly_rd_curlevyamt').attr("disabled", "disabled");
            }
            else
            {
                $('#staffdly_rd_curlevyamt').removeAttr("disabled");
            }
        }
    }
// CLICK FUNCTION FOR SAME EMPLOYEE NAME
    $(document).on('click','.staffdly_sameemployee',function(){
        $('#staffdly_submitbutton').attr("disabled", "disabled");
        STAFFDLY_func_salaryentryclear();
        for (var i=0;i<staffdly_employeeRadio.length;i++) {
            if(staffdly_employeeRadio[i].EDSS_ID==$(this).val()){
                staffdly_currentsal=staffdly_employeeRadio[i].EDSS_SALARY_AMOUNT;
                staffdly_currentcpf=staffdly_employeeRadio[i].EDSS_CPF_AMOUNT;
                staffdly_currentlevy=staffdly_employeeRadio[i].EDSS_LEVY_AMOUNT;
                var  staffdly_arr_loadamt=[];
                staffdly_arr_loadamt.push(staffdly_employeeRadio[i].EDSS_CPF_NUMBER);
                staffdly_arr_loadamt.push(staffdly_employeeRadio[i].EDSS_LEVY_AMOUNT);
                STAFFDLY_loadamt(staffdly_arr_loadamt);
            }
        }
    });
// RADIO BUTTON FUNCTIONS FOR GET SALARY AMOUNT IN THE SALARY ENTRY
    $('#staffdly_rd_cursalary').click(function(){
        $('#staffdly_tb_newsalary').val('').hide();
        $('#staffdly_tb_cursalary').val(staffdly_currentsal).show();
        var staffdly_listvalue=$('#staffdly_lb_employee').val();
    });
// SHOW THE TEXTBOX FOR CURRENT SALARY ENTRY
    $('#staffdly_rd_newsalary').click(function(){
        $('#staffdly_tb_cursalary').hide();
        $('#staffdly_tb_newsalary').val('').show();
    });
// RADIO BUTTON FUNCTIONS FOR GET CPF AMOUNT IN THE SALARY ENTRY
    $('#staffdly_rd_curcpfamt').click(function(){
        $('#staffdly_tb_newcpfamt').val('').hide();
        $('#staffdly_tb_curcpfamt').val(staffdly_currentcpf).show();
        var staffdly_listvalue=$('#staffdly_lb_employee').val();
    });
// SHOW THE TEXTBOX FOR CPF AMOUNT ENTRY
    $('#staffdly_rd_newcpfamt').click(function(){
        $('#staffdly_tb_curcpfamt').hide();
        $('#staffdly_tb_newcpfamt').val('').show();
    });
// RADIO BUTTON FUNCTIONS FOR GET LEVY AMOUNT IN THE SALARY ENTRY
    $('#staffdly_rd_curlevyamt').click(function(){
        $('#staffdly_tb_newlevyamt').val('').hide();
        $('#staffdly_tb_curlevyamt').val(staffdly_currentlevy).show();
        var staffdly_listvalue=$('#staffdly_lb_employee').val();
    });
// SHOW THE TEXTBOX FOR LEVY AMOUNT ENTRY
    $('#staffdly_rd_newlevyamt').click(function(){
        $('#staffdly_tb_curlevyamt').hide();
        $('#staffdly_tb_newlevyamt').val('').show();
    });
// DATE PICKER FOR THE SALARY ENTRY
    $("#staffdly_paiddate").datepicker({
        dateFormat:"dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        onSelect: function(date){
            var staffdly_datepaid = $('#staffdly_paiddate').datepicker('getDate');
            var date = new Date(Date.parse(staffdly_datepaid));
            date.setDate( date.getDate() - 1 );
            var newDate = date.toDateString();
            newDate = new Date( Date.parse( newDate ) );
            $('#staffdly_fromdate').datepicker("option","maxDate",newDate);
            $('#staffdly_todate').datepicker("option","maxDate",newDate);
            if( $('#staffdly_rd_cursalary').is(":checked")==true)
            {
                var staffdly_radio_radiovalue="data";
            }
            else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
            {
                var staffdly_radio_radiovalue="data";
            }
            if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data"))
            {
                $('#staffdly_submitbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#staffdly_submitbutton').removeAttr("disabled");
            }
        }
    });
// DATE PICKER FUNCTION FOR  FOR DATEBOX IN SALARY ENTRY...............
    $("#staffdly_fromdate").datepicker({
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        onSelect: function(date){
            var staffdly_fromdate = $('#staffdly_fromdate').datepicker('getDate');
            var date = new Date( Date.parse( staffdly_fromdate ) );
            date.setDate( date.getDate()  ); //+ 1
            var newDate = date.toDateString();
            newDate = new Date( Date.parse( newDate ) );
            $('#staffdly_todate').datepicker("option","minDate",newDate);
            var paiddate = $('#staffdly_paiddate').datepicker('getDate');
            var date = new Date( Date.parse( paiddate ) );
            date.setDate( date.getDate() - 1 );
            var paidnewDate = date.toDateString();
            paidnewDate = new Date( Date.parse( paidnewDate ) );
            $('#staffdly_todate').datepicker("option","maxDate",paidnewDate);
            if( $('#staffdly_rd_cursalary').is(":checked")==true)
            {
                var staffdly_radio_radiovalue="data";
            }
            else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
            {
                var staffdly_radio_radiovalue="data";
            }
            if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data"))
            {
                $('#staffdly_submitbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#staffdly_submitbutton').removeAttr("disabled");
            }
        }
    });
// DATE PICKER FOR TO DATE IN THE  SALARY ENTRY.....................
    $("#staffdly_todate").datepicker({
        dateFormat:"dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        onSelect: function(date){
            var staffdly_fromdate = $('#staffdly_fromdate').datepicker('getDate');
            var date = new Date( Date.parse( staffdly_fromdate ) );
            date.setDate( date.getDate()  ); //+ 1
            var newDate = date.toDateString();
            newDate = new Date( Date.parse( newDate ) );
            $('#staffdly_todate').datepicker("option","minDate",newDate);
            var paiddate = $('#staffdly_paiddate').datepicker('getDate');
            var date = new Date( Date.parse( paiddate ) );
            date.setDate( date.getDate() - 1 );
            var paidnewDate = date.toDateString();
            paidnewDate = new Date( Date.parse( paidnewDate ) );
            $('#staffdly_todate').datepicker("option","maxDate",paidnewDate);
            if( $('#staffdly_rd_cursalary').is(":checked")==true)
            {
                var staffdly_radio_radiovalue="data";
            }
            else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
            {
                var staffdly_radio_radiovalue="data";
            }
            if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data"))
            {
                $('#staffdly_submitbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#staffdly_submitbutton').removeAttr("disabled");
            }
        }
    });
// CHANGE THE PAID DATE  BOX ....................
    $("#staffdly_paiddate").change(function(){
        var staffdly_datep = $('#staffdly_paiddate').datepicker('getDate');
        var date = new Date( Date.parse( staffdly_datep ) );
        date.setDate( date.getDate() - 1 );
        var newDate = date.toDateString();
        newDate = new Date( Date.parse( newDate ) );
        $('#staffdly_fromdate').datepicker("option","maxDate",newDate);
        $('#staffdly_todate').datepicker("option","maxDate",newDate);
        if($("#staffdly_paiddate").val()!='' && $("#staffdly_todate").val()!='' && $("#staffdly_fromdate").val()!='')
        {
            $('#staffdly_submitbutton').removeAttr('disabled');
        }
        else
        {
            $('#staffdly_submitbutton').attr('disabled','disabled');
        }
        if( $('#staffdly_rd_cursalary').is(":checked")==true)
        {
            var staffdly_radio_radiovalue="data";
        }
        else if(($('#staffdly_rd_newsalary').is(":checked")==true) && ($("#staffdly_tb_newsalary").val()!=""))
        {
            var staffdly_radio_radiovalue="data";
        }
        if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data"))
        {
            $('#staffdly_submitbutton').attr("disabled", "disabled");
        }
        else
        {
            $('#staffdly_submitbutton').removeAttr("disabled");
        }
    });
// DATEPICKER FOR USING DATE IN THE SALARY ENTRY...............
    $(".datebox").datepicker({
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        onSelect: function(date){
            var staffdly_fromdate = $('#staffdly_fromdate').datepicker('getDate');
            var date = new Date( Date.parse( staffdly_fromdate ) );
            date.setDate( date.getDate() + 1 );
            var newDate = date.toDateString();
            newDate = new Date( Date.parse( newDate ) );
            $('#staffdly_todate').datepicker("option","minDate",newDate);
            var paiddate = $('#staffdly_paiddate').datepicker('getDate');
            var date = new Date( Date.parse( paiddate ) );
            date.setDate( date.getDate() - 1 );
            var paidnewDate = date.toDateString();
            paidnewDate = new Date( Date.parse( paidnewDate ) );
            $('#staffdly_todate').datepicker("option","maxDate",paidnewDate);
        }
    });
    //CHANGE THE FROM AND TO DATE BOX................
    $("#staffdly_fromdate").change(function(){
        var staffdly_fromdate = $('#staffdly_fromdate').datepicker('getDate');
        var date = new Date( Date.parse( staffdly_fromdate ) );
        date.setDate( date.getDate()); // + 1
        var newDate = date.toDateString();
        newDate = new Date( Date.parse( newDate ) );
        $('#staffdly_todate').datepicker("option","minDate",newDate);
        var paiddate = $('#staffdly_paiddate').datepicker('getDate');
        var date = new Date( Date.parse( paiddate ) );
        date.setDate( date.getDate() - 1 );
        var paidnewDate = date.toDateString();
        paidnewDate = new Date( Date.parse( paidnewDate ) );
        $('#staffdly_todate').datepicker("option","maxDate",paidnewDate);
        if( $('#staffdly_rd_cursalary').is(":checked")==true)
        {
            var staffdly_radio_radiovalue="data";
        }
        else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
        {
            var staffdly_radio_radiovalue="data";
        }
        if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data"))
        {
            $('#staffdly_submitbutton').attr("disabled", "disabled");
        }
        else
        {
            $('#staffdly_submitbutton').removeAttr("disabled");
        }
    });
// CHANGE TO DATE BOX..................
    $('#staffdly_todate').change(function(){
        if($('#staffdly_rd_cursalary').is(":checked")==true)
        {
            var staffdly_radio_radiovalue="data";
        }
        else if(($('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
        {
            var staffdly_radio_radiovalue="data";
        }
        if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data"))
        {
            $('#staffdly_submitbutton').attr("disabled", "disabled");
        }
        else
        {
            $('#staffdly_submitbutton').removeAttr("disabled");
        }
    });
// SUBMIT BUTTON VALIDATION FOR THE AGENT COMISSION
    $(".submitvalamt").blur(function(){
        var staffdly_typrval=$("#staffdly_lb_type").val();
        if(staffdly_typrval==39)
        {
            if(($("#staffdly_invdate").val()=="")||($("#staffdly_tb_comisnamt").val()==""))
            {
                $('#staffdly_submitbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#staffdly_submitbutton').removeAttr("disabled");
            }
        }
    });
// SUBMIT VALIDATION
    $(document).on('blur','.submitval',function() {
        var staffdly_typrval=$("#staffdly_lb_typelist").val();
        if(staffdly_typrval==39)
        {
            if(($("#staffdly_invdate").val()=="")||($("#staffdly_tb_comisnamt").val()==""))
            {
                $('#staffdly_submitbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#staffdly_submitbutton').removeAttr("disabled");
            }
        }
        if(staffdly_typrval==40)
        {
            var flag=0;
            if( $('#staffdly_rd_cursalary').is(":checked")==true)
            {
                var staffdly_radio_radiovalue="data";
            }
            else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
            {
                var staffdly_radio_radiovalue="data";
            }
            if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data") ||
                (( $('#staffdly_rd_newcpfamt').is(":checked")==true)&&($("#staffdly_tb_newcpfamt").val()==""))||(( $('#staffdly_rd_newlevyamt').is(":checked")==true)&&($("#staffdly_tb_newlevyamt").val()=="")))
            {
                flag=1;
            }
            if(flag=="1")
            {
                $('#staffdly_submitbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#staffdly_submitbutton').removeAttr("disabled");
            }
        }
    });
// RADIO TO SHOW SUBMIT BUTTON VALIDATION......................
    $(".radiosubmitval").click(function(){
        var flag=0;
        if( $('#staffdly_rd_cursalary').is(":checked")==true)
        {
            var staffdly_radio_radiovalue="data";
        }
        else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
        {
            var staffdly_radio_radiovalue="data";
        }
        if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data") ||
            (( $('#staffdly_rd_newcpfamt').is(":checked")==true)&&($("#staffdly_tb_newcpfamt").val()==""))||(( $('#staffdly_rd_newlevyamt').is(":checked")==true)&&($("#staffdly_tb_newlevyamt").val()=="")))
        {
            flag=1;
        }
        if(flag=="1")
        {
            $('#staffdly_submitbutton').attr("disabled", "disabled");
        }
        else
        {
            $('#staffdly_submitbutton').removeAttr("disabled");
        }
    });
// CURRENT SALARY  SUBMIT VALIDATION..............
    $(".radiotextboxsubmitval").change(function(){
        var flag=0;
        if( $('#staffdly_rd_cursalary').is(":checked")==true)
        {
            var staffdly_radio_radiovalue="data";
        }
        else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
        {
            var staffdly_radio_radiovalue="data";
        }
        if(($("#staffdly_lb_employee").val()=="SELECT")||(($('#staffdly_rd_cursalary').attr('id')!=undefined)&&($('input:radio[name=staffdly_rd_employee]:checked').val()==''))($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data") ||
            (( $('#staffdly_rd_newcpfamt').is(":checked")==true)&&($("#staffdly_tb_newcpfamt").val()==""))||(( $('#staffdly_rd_newlevyamt').is(":checked")==true)&&($("#staffdly_tb_newlevyamt").val()=="")))
        {
            flag=1;
        }
        if(flag=="1")
        {
            $('#staffdly_submitbutton').attr("disabled", "disabled");
        }
        else
        {
            $('#staffdly_submitbutton').removeAttr("disabled");
        }
    });
    //<!-- SUBMIT BUTTON VALIDATION FOR THE STAFF SECTION  -->
    $(document).on('blur','.submultivalid',function() {
        var e=$(this).attr('id');
        var staffdly_table = document.getElementById('staffdly_tble_multi');
        var staffdly_table_rowlength=staffdly_table.rows.length;
        var count=0;
        for(var i=1;i<staffdly_table_rowlength;i++)
        {
            var unit=$('#staffdly_lb_category'+i).val();
            var invoicedate=$('#staffdly_db_invdate'+i).val();
            var fromdate=$('#staffdly_tb_incamtrp'+i).val();
            var todate=$('#staffdly_ta_invitem'+i).val();
            var payment=$('#staffdly_tb_invfrom'+i).val();
            if((unit!=undefined)&&(unit!="SELECT")&&(unit!='')&&(payment!='')&&(fromdate!="")&&(todate!="")&&(fromdate!=undefined)&&(todate!=undefined)&&(invoicedate!=''))
            {
                count=count+1;
            }
        }
        if(count==staffdly_table_rowlength-1)
        {
            $('#staffdly_staffsubmitbutton').removeAttr("disabled");
            $('#staffdly_btn_addbtn'+(staffdly_table_rowlength-1)).removeAttr("disabled");
        }
        else
        {
            $('#staffdly_staffsubmitbutton').attr("disabled", "disabled");
            $('#staffdly_btn_addbtn'+(staffdly_table_rowlength-1)).attr("disabled", "disabled");
        }
    });
    function STAFF_clear_staff(){
        $('#staffdly_submitbutton').hide();
        $('#staffdly_resetbutton').hide();
        $('#staffdly_lb_category1').val('SELECT');
        $('#staffdly_db_invdate1').val('');
        $('#staffdly_tb_incamtrp1').val('');
        $('#staffdly_ta_invitem1').val('');
        $('#staffdly_tb_invfrom1').val('');
        $('#staffdly_tb_comments1').val('');
        $('#staffdly_btn_addbtn1').attr("disabled", "disabled").show();
        $('#staffdly_btn_delbtn1').attr("disabled", "disabled").show();
        $('#staffdly_staffsubmitbutton').attr('disabled','disabled');
        var elmtTable = document.getElementById('staffdly_tble_multi');
        var tableRows = elmtTable.getElementsByTagName('tr');
        var rowCount = tableRows.length;
        for(var x=0;x<rowCount;x++)
        {
            if((x==0)||(x==1))continue;
            if(x==3)
            {
                STAFF_clear_staff();
            }
            $('#staffdly_lb_category'+x).remove();
            $('#staffdly_db_invdate'+x).remove();
            $('#staffdly_tb_incamtrp'+x).remove();
            $('#staffdly_ta_invitem'+x).remove();
            $('#staffdly_tb_invfrom'+x).remove();
            $('#staffdly_tb_comments'+x).remove();
            $('#staffdly_btn_addbtn'+x).remove();
            $('#staffdly_btn_delbtn'+x).remove();
            document.getElementById('staffdly_tble_multi').deleteRow(x);
        }
        $('#staffdly_lb_category1').val('SELECT');
        $('#staffdly_db_invdate1').val('');
        $('#staffdly_tb_incamtrp1').val('');
        $('#staffdly_ta_invitem1').val('');
        $('#staffdly_tb_invfrom1').val('');
        $('#staffdly_tb_comments1').val('');
        $('#staffdly_btn_addbtn1').attr("disabled", "disabled").show();
        $('#staffdly_btn_delbtn1').attr("disabled", "disabled").show();
        $('#staffdly_tble_multi').hide();
        STAFF_categorytyperesult();
    }
    function STAFF_Sortit(lbid)
    {
        var $r = $("#"+lbid+" "+"option");
        $r.sort(function(a, b) {
            if (a.text < b.text) return -1;
            if (a.text == b.text) return 0;
            return 1;
        });
        $($r).remove();
        $("#"+lbid).append($($r));
        $("#"+lbid+" "+"option").eq(0).before('<option value="SELECT">SELECT</option>');
        $("select#"+lbid)[0].selectedIndex = 0;
    }
// LOAD THE CATEGORY TYPE IN THE LISTBOX...................
    function STAFF_categorytyperesult()
    {
        $(".preloader").hide();
        $('#staffdly_tble_multi').show();
//        STAFF_Sortit('staffdly_lb_category1');
        $('#staffdly_lb_category1').show();
        $('#staffdly_staffsubmitbutton').attr("disabled", "disabled").show();
        $('#staffdly_db_invdate1').datepicker("option","maxDate",new Date());
        $('#staffdly_db_invdate1').show();
        $('#staffdly_tb_incamtrp1').show();
        $('#staffdly_ta_invitem1').show();
        $('#staffdly_tb_invfrom1').show();
        $('#staffdly_tb_comments1').show();
        $('#staffdly_btn_addbtn1').attr("disabled", "disabled").show();
        $('#staffdly_btn_delbtn1').attr("disabled", "disabled").show();
    }
// LOAD THE CATEGORY TYPE FOR INCREAMENT MULTIROW LISTBOX...............
    function STAFF_loadcategorymultirow()
    {
        $(".preloader").hide();
        var staffdly_options ='';
        var staffdly_val=$('#staffdly_hidetablerowid').val();
        for (var i = 0; i < expencetype.length; i++)
        {
            if( i>=0 && i<=4)
            {
                var catid=expencetype[i].ECN_ID;
                var catdata=expencetype[i].ECN_DATA;
                $('#staffdly_lb_category'+staffdly_val).append($('<option>').text(catdata).attr('value', catid));
            }
        }
//        STAFF_Sortit('staffdly_lb_category'+staffdly_val);
    }
});
</script>
</head>
<body>
<div class="container">
    <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>STAFF EXPENSE DAILY ENTRY</b></h4></div>
    <form id="staffdlyentry_form" name="staffdlyentry_form" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group" id="staffdly_type">
                    <label class="col-sm-3">TYPE OF EXPENSE</label>
                    <div class="col-sm-3"> <select name="staffdly_lb_type" id="staffdly_lb_type" class="form-control staffdly_entryform"></select></div>
                </div>

                <div id="agent_comisndiv">
                    <div class="form-group" id="staffdly_invdt">
                        <label class="col-sm-3">INVOICE DATE <em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input id="staffdly_invdate" name="staffdly_invdate" type="text" class="date-picker datemandtry submitval form-control" placeholder="Invoice Date"/>
                                <label for="staffdly_invdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="staffdly_comisnamt">
                        <label class="col-sm-3">COMMISSION AMOUNT <em>*</em></label>
                        <div class="col-sm-2"><input type="text" name="staffdly_tb_comisnamt" style="width:75px" id="staffdly_tb_comisnamt" placeholder="Amount" class="staffdly_erntryform submitvalamt form-control"/></div>
                    </div>
                    <div class="form-group" id="staffdly_agentcomments">
                        <label class="col-sm-3">COMMENTS</label>
                        <div class="col-sm-4"> <textarea  name="staffdly_ta_agentcomments" id="staffdly_ta_agentcomments" placeholder="Comments" maxlength="300" rows="5" class="staffdly_erntryform form-control"></textarea></div>
                    </div>
                </div>

                <div id="salary_entrydiv">
                    <div class="form-group" id="staffdly_employee">
                        <label class=" col-sm-3">EMPLOYEE NAME <em>*</em></label>
                        <div class="col-sm-3"> <select name="staffdly_lb_employee" id="staffdly_lb_employee" class="form-control submitval staffdly_erntryform"></select></div>
                    </div>
                    <div class="form-group" id="staffdly_multipleemployee" hidden>
                    </div>
                    <div class="form-group" id="staffdly_cpf">
                        <label class="col-sm-3">CPF NUMBER</label>
                        <div class="col-sm-2"><input type="text" name="staffdly_tb_cpf" id="staffdly_tb_cpf" class="staffdly_erntryform form-control" placeholder="CPF Number" readonly/></div>
                    </div>
                    <div class="form-group" id="staffdly_paiddt">
                        <label class="col-sm-3">PAID DATE <em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input id="staffdly_paiddate" name="staffdly_paiddate" type="text" class="date-picker datemandtry submitval form-control" placeholder="Paid Date"/>
                                <label for="staffdly_paiddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="staffdly_fromdt">
                        <label class="col-sm-3">FROM PERIOD <em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input id="staffdly_fromdate" name="staffdly_fromdate" type="text" class="date-picker datemandtry submitval form-control" placeholder="From Period"/>
                                <label for="staffdly_fromdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="staffdly_todt">
                        <label class="col-sm-3">TO PERIOD <em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input id="staffdly_todate" name="staffdly_todate" type="text" class="date-picker datemandtry submitval form-control" placeholder="To Period"/>
                                <label for="staffdly_todate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="staffdly_salaryamt">
                        <label class="col-sm-3">SALARY AMOUNT <em>*</em></label>
                        <div class="col-sm-7">
                            <div class="row form-group">
                                <div class="col-md-5">
                                    <div class="radio">
                                        <label><input type="radio" class="radiosubmitval" name="salarysalaryopt" id="staffdly_rd_cursalary">CURRENT SALARY</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control staffdly_erntryform" name="staffdly_tb_cursalary" id="staffdly_tb_cursalary" readonly/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-5">
                                    <div class="radio">
                                        <label><input type="radio" class="radiosubmitval" name="salarysalaryopt" id="staffdly_rd_newsalary">NEW SALARY</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control staffdly_erntryform submitval radiotextboxsubmitval amtonlysalary" name="staffdly_tb_newsalary" id="staffdly_tb_newsalary"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-5">
                                    <div class="radio">
                                        <label><input type="radio" class="submitval" name="salarycpfamtopt" id="staffdly_rd_curcpfamt">CURRENT CPF AMOUNT</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control staffdly_erntryform" name="staffdly_tb_curcpfamt" id="staffdly_tb_curcpfamt" readonly/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-5">
                                    <div class="radio">
                                        <label><input type="radio" class="radiosubmitval" name="salarycpfamtopt" id="staffdly_rd_newcpfamt">NEW CPF AMOUNT</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control staffdly_erntryform submitval amtonlysalary" name="staffdly_tb_newcpfamt" id="staffdly_tb_newcpfamt"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-5">
                                    <div class="radio">
                                        <label><input type="radio" class="submitval" name="salarylevyamtopt" id="staffdly_rd_curlevyamt">CURRENT LEVY AMOUNT</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control staffdly_erntryform" name="staffdly_tb_curlevyamt" id="staffdly_tb_curlevyamt" readonly/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-5">
                                    <div class="radio">
                                        <label><input type="radio" class="radiosubmitval" name="salarylevyamtopt" id="staffdly_rd_newlevyamt">NEW LEVY AMOUNT</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control staffdly_erntryform submitval amtonlysalary" name="staffdly_tb_newlevyamt" id="staffdly_tb_newlevyamt"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="staffdly_salarycomments">
                        <label class="col-sm-3">COMMENTS</label>
                        <div class="col-sm-4"> <textarea name="staffdly_ta_salarycomments" id="staffdly_ta_salarycomments" placeholder="Comments" maxlength="300" rows="5" class="staffdly_erntryform form-control"></textarea></div>
                        <input type="hidden" id="staffdly_hidden_edssid" name="staffdly_hidden_edssid">
                    </div>
                </div>
                <div class="form-group" id="buttons">
                    <div class="col-sm-offset-1 col-sm-3">
                        <input class="btn btn-info" type="button" id="staffdly_submitbutton" name="SAVE" value="SAVE" disabled/>
                        <input class="btn btn-info" type="button" id="staffdly_resetbutton" name="RESET" value="RESET"/>
                    </div>
                </div>
                <div id="staffdiv">
                    <div class="table-responsive">
                        <table id="staffdly_tble_multi">
                            <tr>
                                <td nowrap><label id="staffdly_lbl_expense">CATEGORY OF EXPENSE<em>*</em></label> </td>
                                <td style="max-width: 150px" nowrap><label  id="staffdly_lbl_invdate">INVOICE DATE<em>*</em></label></td>
                                <td style="max-width: 200px" nowrap><label id="staffdly_lbl_invamt">INVOICE AMOUNT<em>*</em></label> </td>
                                <td ><label id="staffdly_lbl_invitm">INVOICE ITEMS<em>*</em></label> </td>
                                <td ><label id="staffdly_lbl_invfrom">INVOICE FROM<em>*</em></label> </td>
                                <td ><label id="staffdly_lbl_invcmt">COMMENTS</label></td>
                            </tr>
                            <tr>
                                <td><select class="form-control submultivalid" name="staffdly_lb_category[]" id="staffdly_lb_category1"><option >SELECT</option> </select> </td>
                                <td><input class="form-control submultivalid date-picker datemandtry" type="text" name ="staffdly_db_invdate[]" id="staffdly_db_invdate1" style="max-width:100px;" /> </td>
                                <td><input type="text" name ="staffdly_tb_incamtrp[]" id="staffdly_tb_incamtrp1" class="submultivalid form-control amtonly" style="max-width:80px;"   /></td>
                                <td><textarea class="submultivalid form-control" name="staffdly_ta_invitem[]" id="staffdly_ta_invitem1"></textarea></td>
                                <td><input class="submultivalid form-control autosize autocompinc" type="text" name ="staffdly_tb_invfrom[]" id="staffdly_tb_invfrom1" /></td>
                                <td><textarea class="submultivalid form-control" name ="staffdly_tb_comments[]" id="staffdly_tb_comments1"></textarea></td>
                                <td><input enabled type='button'disabled value='+' class='addbttn' alt='Add Row' style="max-height: 30px; max-width:30px;" name ='staffdly_btn_addbtn' id='staffdly_btn_addbtn1' disabled/></td>
                                <td><input type='button' value='-' class='deletebttn' alt='delete Row' style="max-height: 30px; max-width:30px;" name ='staffdly_btn_delbtn' id='staffdly_btn_delbtn1'/></td>
                            </tr>
                        </table>
                        <table>
                            <tr><td><input type="button" id="staffdly_staffsubmitbutton" value="SAVE" class="btn btn-info" disabled hidden /></td></tr>
                            <tr><td><input type="text" name ="staffdly_hideaddid" id="staffdly_hideaddid" hidden /> </td></tr>
                            <tr><td><input type="text" name ="staffdly_hideremoveid" id="staffdly_hideremoveid" hidden /> </td></tr>
                            <tr><td><input type="text" name ="staffdly_hidetablerowid" id="staffdly_hidetablerowid" hidden /> </td></tr>
                        </table>
                    </div>
                </div>
                <div id="staff_errordiv">
                    <div class="col-md-8">
                        <label id='staffdly_lbl_erromsg' class="errormsg" hidden></label>
                    </div>
                    <div class="col-md-8">
                        <label id='staffdly_lbl_edtlerromsg' class="errormsg" hidden></label>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>
                