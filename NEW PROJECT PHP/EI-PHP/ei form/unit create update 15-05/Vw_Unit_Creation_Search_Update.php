<?php
require_once "Header.php";
?>
<html>
<head>
    <style>
        .errpadding{
            padding-top: 10px;
        }
        .colsmhf {
            width: 11.666%;
            padding-top: 2px;
            padding-left: 15px;
            padding-right: 0px;
        }
    </style>
    <script type="text/javascript">
    // document ready function
    var ErrorControl ={AmountCompare:'InValid'};
    $(document).ready(function(){
        // initial data
            $('.preloader').hide();
            $('#spacewidth').height('0%');
            var UC_room=[];
            var UC_errorMsg_array=[];
            var UC_stamp=[];
            var UC_flaglen=0;
            var UC_flag='true';
            var UC_flag_unit='true';
            var UC_flag_room='true';
            var UC_flag_stamp='true';
            var UC_flg_Login=1;
            var UC_flg_Doorcode=1;
        //---------------------UPDATE-----------------------//
            var USU_flag_updbtn=0;
            var USU_flag_stamptype=0;
            var USU_flag_roomtype=0;
            var USU_flag_access=0;
            var USU_flag_enddate=0;
            var USU_flag_unitno=0;
            var USU_flag_searchbtn=0;
            var USU_accesscard_no='';
            var USU_obj_rowvalue='';
            var USU_unit_optionvalues_roomtype=[];
            var USU_errormsg_arr =[];
            var USU_unitoption_arr =[];
            var USU_unitoptions_id_arr=[];
            var USU_glb_unitno_arr=[];
            var USU_obsolete_upd='';
            var USU_accesscard_transaction=false;
            var USU_select_options_card ='<option>SELECT</option>';
        //------------------------END UPDATE----------------------//
            $('textarea').autogrow({onInitialize: true});
            $("#UC_tb_accesscard,#UC_tb_unitdeposite,#UC_tb_unitrentalamt").doValidation({rule:'numbersonly',prop:{leadzero:false}});
            $("#UC_tb_stampamount").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
            $("#UC_db_stampdutydate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true});
            $(".numonly").doValidation({rule:'numbersonly',prop:{leadzero:true}});
            $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
            $("#UC_db_startdate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true,maxDate: '+2Y',minDate:'-1M',
                onSelect:function(date){
                    $('#UC_db_enddate').datepicker("option","minDate",date);
                }
            });
            $("#UC_db_enddate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true,maxDate: '+2Y'});
        
        //RADIO BUTTON CLICK FUNCTION
            $('.UC_selectform').click(function(){
                var radiooption=$(this).val();
                if(radiooption=='unitcreate')
                {
                    $('#USU_form_unitupdate').hide();
                    $('.preloader').show();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/Initialdata'); ?>",
                        data:{'flag':'UC_flag_notcreation'},
                        success: function(data) {
                            var initial_values=JSON.parse(data);
                            UC_result(initial_values);
                        }
                    });
                }
                else{
                    $('#UC_form_unitcreation').hide();
                    $('.preloader').show();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/USU_Initialdata'); ?>",
                        success: function(usudata) {
                            var usuinitial_values=JSON.parse(usudata);
                            USU_success(usuinitial_values);
                        }
                    });
                }
            });
            function UC_result(UC_response){
                $('.preloader').hide();
                if(UC_response.toString().match("error:"))
                {
                    show_msgbox("UNIT CREATION",UC_response,'error',false);
                }
                else
                {
                    $('#UC_form_unitcreation').show();
                    var UC_flag=UC_response[3];
                    if((UC_flag!=true)&&(UC_flag!=0)){
                        UC_room=UC_response[0];
                        UC_stamp=UC_response[1];
                        UC_errorMsg_array=UC_response[2];
                        $(".UC_class_numonly").prop("title",UC_errorMsg_array[1].EMC_DATA);
                        if((UC_flag=='UC_flag_roomtype')||(UC_flag=='UC_flag_notcreation')||(UC_flag=='UC_flag_created')){
                            if(UC_room.length==0){
                                $('#UC_lb_roomtype').replaceWith('<input type="text" name="UC_tb_newroomtype" id="UC_tb_newroomtype" maxlength="30" class="form-control autosize" placeholder="Room Type"/>');
                                $('#UC_btn_addroomtype').hide();
                                $('#UC_btn_removeroomtype').hide();
                                $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
                            }
                            else{
                                var UC_roomoptions ='<option>SELECT</option>';
                                for (var i = 0; i < UC_room.length; i++) {
                                    UC_roomoptions += '<option value="' + UC_room[i]  + '">' + UC_room[i] + '</option>';
                                }
                                $('#UC_tb_newroomtype').replaceWith('<select name="UC_lb_roomtype" id="UC_lb_roomtype" class="form-control"><option>SELECT</option></select>');
                                $('#UC_btn_removeroomtype').replaceWith('<input class="btn btn-info" type="button"  name="UC_btn_addroomtype" value="ADD" id="UC_btn_addroomtype"/>');
                                $('#UC_lb_roomtype').html(UC_roomoptions).show();
                                $('#UC_btn_addroomtype').show();
                            }
                        }
                        if((UC_flag=='UC_flag_stamptype')||(UC_flag=='UC_flag_notcreation')||(UC_flag=='UC_flag_created')){
                            if(UC_stamp.length==0){
                                $('#UC_lb_stamptype').replaceWith('<input type="text" name="UC_tb_newstamptype" id="UC_tb_newstamptype" maxlength="12" class="form-control autosize" placeholder="Stamp Duty Type"/>');
                                $('#UC_btn_addstamptype').hide();
                                $('#UC_btn_removestamptype').hide();
                                $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
                            }
                            else{
                                var UC_stampoptions ='<option>SELECT</option>';
                                for (var i = 0; i < UC_stamp.length; i++) {
                                    UC_stampoptions += '<option value="' + UC_stamp[i]  + '">' + UC_stamp[i] + '</option>';
                                }
                                $('#UC_tb_newstamptype').replaceWith('<select id="UC_lb_stamptype" name="UC_lb_stamptype" class="form-control"><option>SELECT</option></select>');
                                $('#UC_btn_removestamptype').replaceWith('<input class="btn btn-info" type="button" name="UC_btn_addstamptype" value="ADD" id="UC_btn_addstamptype"/>');
                                $('#UC_lb_stamptype').html(UC_stampoptions).show();
                                $('#UC_btn_addstamptype').show();
                            }
                        }
                        if(UC_flag=='UC_flag_created'){
                            var UC_unitnumber= $("#UC_tb_unitno").val();
                            var UC_errmsg =UC_errorMsg_array[6].EMC_DATA.replace('[UNITNO]',UC_unitnumber);
                            show_msgbox("UNIT CREATION",UC_errmsg,'success',false);
                            UC_resetfrm();
                        }
                    }
                    else if(UC_response[3]==0)
                    {
                        show_msgbox("UNIT CREATION",UC_errorMsg_array[9].EMC_DATA,'error',false);
                    }
                }
            }
            var UC_max = 250;
        // KEYPRESS EVENT OF BANK ADDRESSS
            $('#UC_ta_address').keypress(function(e) {
                if (e.which < 0x20) {
                    return;
                }
                if (this.value.length == UC_max) {
                    e.preventDefault();
                }
                else if (this.value.length > UC_max) {
                    this.value = this.value.substring(0, UC_max);
                }
            });
        // CHECK UNIT NUMBER LENGTH
            $(document).on("change",'#UC_tb_unitno',function(){
                if(($('#UC_tb_unitno').val().length>0)&&($('#UC_tb_unitno').val().length<4)){
                    UC_flag='false';
                    $('#UC_div_errunitno').text(UC_errorMsg_array[2].EMC_DATA);
                    $("#UC_tb_unitno").addClass('invalid');
                }
                if(($('#UC_tb_unitno').val().length==4)&&(parseInt($('#UC_tb_unitno').val())!=0)){
                    $(".preloader").show();
                    UC_flag='true';
                    var UC_source='UC_tb_unitno';
                    var unitno=$('#UC_tb_unitno').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/Check_existinginput'); ?>",
                        data:{'source':UC_source,'chkinput':unitno},
                        success: function(unitdata) {
                            var unit_values=JSON.parse(unitdata);
                            UC_unitresult(unit_values);
                        }
                    });
                }
                if(($('#UC_tb_unitno').val()==0)||(parseInt($('#UC_tb_unitno').val())==0)){
                    $('#UC_div_errunitno').text('');
                    $("#UC_tb_unitno").removeClass('invalid');
                }
            });
        // SUCCESS FUNCTION FOR UNIT ALREADY EXISTS
            function UC_unitresult(response){
                $(".preloader").hide();
                if(response==true){
                    UC_flag_unit='false';
                    $('#UC_div_errunitno').text(UC_errorMsg_array[4].EMC_DATA);
                    $("#UC_btn_submit").attr("disabled", "disabled");
                    $("#UC_tb_unitno").addClass('invalid');
                }
                else if(response==false){
                    UC_flag_unit='true';
                    $('#UC_div_errunitno').text('');
                    $("#UC_tb_unitno").removeClass('invalid');
                    if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                        $("#UC_btn_submit").removeAttr("disabled");
                    }
                }
            }
        // CHECKING ACCESS CARD LENGTH
            $(document).on("change",'#UC_tb_accesscard',function(){
                var access_card=parseInt($('#UC_tb_accesscard').val());
                if((parseInt($('#UC_tb_accesscard').val()).toString().length>0)&&(parseInt($('#UC_tb_accesscard').val()).toString().length<4)){
                    UC_flaglen=0;
                    $('#UC_div_errcard').text(UC_errorMsg_array[3].EMC_DATA);
                    $("#UC_tb_accesscard").addClass('invalid');
                }
                if((parseInt($('#UC_tb_accesscard').val())==0)||($('#UC_tb_accesscard').val().length==0)){
                    UC_flag='true';
                    $('#UC_div_errcard').text('');
                    $("#UC_tb_accesscard").removeClass('invalid');
                }
                if(parseInt($('#UC_tb_accesscard').val()).toString().length>=4){
                    $(".preloader").show();
                    var UC_source='UC_tb_accesscard';
                    var accesscardno=$('#UC_tb_accesscard').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/Check_existinginput'); ?>",
                        data:{'source':UC_source,'chkinput':accesscardno},
                        success: function(carddata){
                            var card_values=JSON.parse(carddata);
                            UC_accessresult(card_values);
                        }
                    });
                }
            });
        // SUCCESS FUNCTION FOR UNIT NUMBER AND ACCESS CARD
            function UC_accessresult(cardresponse){
                $(".preloader").hide();
                if(cardresponse=='true'){
                    UC_flag='false';
                    $('#UC_div_errcard').text(UC_errorMsg_array[5].EMC_DATA);
                    $("#UC_btn_submit").attr("disabled", "disabled");
                    $("#UC_tb_accesscard").addClass('invalid');
                }
                else if(cardresponse=='false'){
                    UC_flag='true';
                    $('#UC_div_errcard').text('');
                    $("#UC_tb_accesscard").removeClass('invalid');
                    if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                        $("#UC_btn_submit").removeAttr("disabled");
                    }
                }
            }
        // CHANGE EVENT FOR ENABLING SUBMIT BUTTON UNTIL MANDATORY VALUES ARE GIVEN
            $(document).on("change blur",'#UC_form_unitcreation',function(){
                var UC_unitno=$("#UC_tb_unitno").val();
                var UC_access=$("#UC_tb_accesscard").val();
                if((parseInt($('#UC_tb_unitno').val())==0)||($("#UC_tb_unitno").val()=='')||($("#UC_tb_unitrentalamt").val()=='')||(parseInt($("#UC_tb_unitrentalamt").val())=='')||($("#UC_db_startdate").val()=='')||($("#UC_db_enddate").val()=='')||((UC_unitno.length>0)&&(UC_unitno.length<4))||((parseInt($('#UC_tb_accesscard').val()).toString().length>0)&&(parseInt($('#UC_tb_accesscard').val()).toString().length<4)&&(parseInt(UC_access)!=0)&&(UC_access!=''))||(UC_flg_Doorcode==0)||(UC_flg_Login==0)){
                    $("#UC_btn_submit").attr("disabled", "disabled");
                    UC_flaglen=0;
                }
                else
                    UC_flaglen=1;
                if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flag=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                    $("#UC_btn_submit").removeAttr("disabled");
                }
                else{
                    $("#UC_btn_submit").attr("disabled", "disabled");
                }
            });
        // CLICK FUNCTION FOR ADD AND REMOVE ROOM TYPE BUTTON
            $(document).on('click','#UC_btn_addroomtype,#UC_btn_removeroomtype',function(){
                $('#UC_div_errroom').text('');
                $("#UC_tb_newroomtype").removeClass('invalid');
                if($(this).attr('id')=="UC_btn_addroomtype"){
                    UC_flag_room='false';
                    // REPLACE NEW ROOM TYPE
                    $('#UC_lb_roomtype').replaceWith('<input type="text" name="UC_tb_newroomtype" id="UC_tb_newroomtype" maxlength="30" class="form-control autosize" placeholder="Room Type"/>');
                    $(this).replaceWith('<input class="btn btn-info" type="button" name="UC_btn_removeroomtype" value="CLEAR" id="UC_btn_removeroomtype"/>');
                    $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
                }
                if($(this).attr('id')=='UC_btn_removeroomtype'){
                    $(".preloader").show();
                    UC_flag_room='true';
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/Initialdata'); ?>",
                        data:{'flag':'UC_flag_roomtype'},
                        success: function(data) {
                            var initial_values=JSON.parse(data);
                            UC_result(initial_values);
                        }
                    });
                    $('#UC_tb_newroomtype').replaceWith('<select name="UC_lb_roomtype" id="UC_lb_roomtype" class="form-control"><option>SELECT</option></select>');
                    $(this).replaceWith('<input class="btn btn-info" type="button" name="UC_btn_addroomtype" value="ADD" id="UC_btn_addroomtype"/>');
                }
                if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flag=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                    $("#UC_btn_submit").removeAttr("disabled");
                }
                else{
                    $("#UC_btn_submit").attr("disabled", "disabled");
                }
            });
        // CLICK FUNCTION FOR ADD AND REMOVE ROOM TYPE BUTTON
            $(document).on('click','#UC_btn_addstamptype,#UC_btn_removestamptype',function(){
                $('#UC_div_errstamp').text('');
                $("#UC_tb_newstamptype").removeClass('invalid');
                // REPLACE NEW STAMP TYPE
                if($(this).attr('id')=="UC_btn_addstamptype"){
                    UC_flag_stamp='false';
                    $('#UC_lb_stamptype').replaceWith('<input type="text" name="UC_tb_newstamptype" id="UC_tb_newstamptype" maxlength="12" class="form-control autosize" placeholder="Stamp Duty Type"/>');
                    $(this).replaceWith('<input type="button" name="UC_btn_removestamptype" value="CLEAR" id="UC_btn_removestamptype" class="btn btn-info"/>');
                    $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
                }
                if($(this).attr('id')=='UC_btn_removestamptype'){
                    $(".preloader").show();
                    UC_flag_stamp='true';
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/Initialdata'); ?>",
                        data:{'flag':'UC_flag_stamptype'},
                        success: function(data) {
                            var initial_values=JSON.parse(data);
                            UC_result(initial_values);
                        }
                    });
                    $('#UC_div_errstamp').text('');
                    $('#UC_tb_newstamptype').replaceWith('<select id="UC_lb_stamptype" name="UC_lb_stamptype" class="form-control"><option>SELECT</option></select>');
                    $(this).replaceWith('<input type="button" name="UC_btn_addstamptype" value="ADD" id="UC_btn_addstamptype" class="btn btn-info"/>');
                }
                if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flag=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                    $("#UC_btn_submit").removeAttr("disabled");
                }
                else{
                    $("#UC_btn_submit").attr("disabled", "disabled");
                }
            });
        // CHANGE EVENT FUNCTION FOR ROOM TYPE
            $(document).on("blur",'#UC_tb_newroomtype',function(){
                var UC_newroom=$(this).val();
                var UC_source=$(this).attr('id');
                if(UC_newroom.length==0){
                    UC_flag_room='false';
                    if((UC_newroom.length==0)&&(UC_room.length==0)){
                        UC_flag_room='true';
                    }
                    $('#UC_div_errroom').text('');
                    $("#UC_tb_newroomtype").removeClass('invalid');
                }
                else{
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/Check_existinginput'); ?>",
                        data:{'source':UC_source,'chkinput':UC_newroom},
                        success: function(roomdata){
                            var room_values=JSON.parse(roomdata);
                            UC_roomresult(room_values);
                        }
                    });
                }
            });
        // SUCCESS FUNCTION FOR STAMP TYPE ALREADY EXISTS
            function UC_roomresult(UC_msgroom) {
                $(".preloader").hide();
                if(UC_msgroom=='true'){
                    $('#UC_div_errroom').text(UC_errorMsg_array[7].EMC_DATA);
                    $("#UC_tb_newroomtype").addClass('invalid');
                    $("#UC_btn_submit").attr("disabled", "disabled");
                    UC_flag_room='false';
                }
                else if(UC_msgroom=='false')
                {
                    UC_flag_room='true';
                    $('#UC_div_errroom').text('');
                    $("#UC_tb_newroomtype").removeClass('invalid');
                    if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_room=='true')&&(UC_flag_stamp=='true')&&(UC_flag_unit=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                        $("#UC_btn_submit").removeAttr("disabled");
                    }
                }
            }
        // CHANGE EVENT FUNCTION FOR STAMP TYPE
            $(document).on("blur",'#UC_tb_newstamptype',function(){
                var UC_newstamp=$(this).val();
                var UC_source=$(this).attr('id');
                if(UC_newstamp.length==0){
                    UC_flag_stamp='false';
                    if((UC_newstamp.length==0)&&(UC_stamp.length==0)){
                        UC_flag_stamp='true';
                    }
                    $('#UC_div_errstamp').text('');
                    $("#UC_tb_newstamptype").removeClass('invalid');
                }
                else{
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/Check_existinginput'); ?>",
                        data:{'source':UC_source,'chkinput':UC_newstamp},
                        success: function(stampdata){
                            var stamp_values=JSON.parse(stampdata);
                            UC_stampresult(stamp_values);
                        }
                    });
                }
            });
        // SUCCESS FUNCTION FOR STAMP TYPE ALREADY EXISTS
            function UC_stampresult(UC_msgstamp) {
                $(".preloader").hide();
                if(UC_msgstamp=='true')
                {
                    UC_flag_stamp='false';
                    $('#UC_div_errstamp').text(UC_errorMsg_array[8].EMC_DATA);
                    $("#UC_tb_newstamptype").addClass('invalid');
                    $("#UC_btn_submit").attr("disabled", "disabled");
                }
                else if(UC_msgstamp=='false')
                {
                    UC_flag_stamp='true';
                    $('#UC_div_errstamp').text('');
                    $("#UC_tb_newstamptype").removeClass('invalid');
                    if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                        $("#UC_btn_submit").removeAttr("disabled");
                    }
                }
            }
        // CHECK DOORCODE
            $(document).on("change blur",'#UNIT_tb_doorcode',function(){
                $('#UC_lbl_doorcode').text('');
                $(this).removeClass('invalid');
                UC_flg_Doorcode=1;
                if(($(this).val()!='')&&(parseInt($(this).val())!=0)&&($(this).val().length<6)){
                    $(this).addClass('invalid');
                    UC_flg_Doorcode=0;
                    $('#UC_lbl_doorcode').text(UC_errorMsg_array[14].EMC_DATA);
                }
                else if(($(this).val()!='')&&(parseInt($(this).val())!=0)&&($(this).val().length>=6)){
                    $(".preloader").show();
                    UC_func_doorcode_weblogin($(this).val(),$(this).attr('id'));
                }
            });
        // CHECK WEBLOGIN
            $(document).on("change blur",'#UNIT_tb_weblogin',function(){
                $('#UC_lbl_weblogin').text('');
                $(this).removeClass('invalid');
                UC_flg_Login=1;
                if(($(this).val()!='')&&($(this).val().length<5)){
                    $(this).addClass('invalid');
                    UC_flg_Login=0;
                    $('#UC_lbl_weblogin').text(UC_errorMsg_array[13].EMC_DATA);
                }
                else if(($(this).val()!='')&&($(this).val().length>=5)){
                    $(".preloader").show();
                    UC_func_doorcode_weblogin($(this).val(),$(this).attr('id'));
                }
            });
            function UC_func_doorcode_weblogin(UC_value,UC_attrid){
                $("#UC_btn_submit").attr("disabled", "disabled");
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/Check_existinginput'); ?>",
                    data:{'source':UC_attrid,'chkinput':UC_value},
                    success: function(doorlogindata){
                        var door_logindata=JSON.parse(doorlogindata);
                        UC_SuccessLoginDoor(door_logindata);
                    }
                });
            }
        // SUCCESS FUNCTION FOR DOORCODE AND WEBLOGIN
            function UC_SuccessLoginDoor(UC_response_Login){
                $(".preloader").hide();
                if(UC_response_Login[0]==0){
                    if(UC_response_Login[1]=='UNIT_tb_doorcode'){
                        UC_flg_Doorcode=0;
                        $('#UC_lbl_doorcode').text(UC_errorMsg_array[12].EMC_DATA);
                    }
                    else if(UC_response_Login[1]=='UNIT_tb_weblogin'){
                        UC_flg_Login=0;
                        $('#UC_lbl_weblogin').text(UC_errorMsg_array[11].EMC_DATA);
                    }
                    $("#"+UC_response_Login[1]).addClass('invalid');
                    if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1))
                        $("#UC_btn_submit").removeAttr("disabled");
                }
                else{
                    if(UC_response_Login[1]=='UNIT_tb_doorcode'){
                        UC_flg_Doorcode=1;
                        $('#UC_lbl_doorcode').text('');
                    }
                    else if(UC_response_Login[1]=='UNIT_tb_weblogin'){
                        $('#UC_lbl_weblogin').text('');
                        UC_flg_Login=1;
                    }
                    $("#"+UC_response_Login[1]).removeClass('invalid');
                }
            }
        // FUCNTION FOR CLEAR ALL VALUES
            function UC_resetfrm(){
                $('#UC_form_unitcreation').find('textarea').val('');
                $(':input','#UC_form_unitcreation')
                    .not(':button')
                    .val('')
                    .removeAttr('checked')
                    .removeAttr('selected');
                $('#UC_form_unitcreation').find('select').val('SELECT');
                $("#UC_db_enddate").datepicker('option', {minDate: '-1M', maxDate: '+2Y'});
                $('input').removeClass('invalid');
                $("#UC_btn_submit").attr("disabled", "disabled");
                $('#UC_div_errunitno').text("");
                $('#UC_div_errcard').text("");
                $('#UC_div_errroom').text('');
                $('#UC_div_errstamp').text('');
                $('.errormsg').text('');
                $('#UC_ta_comments,#UC_ta_address').height(116);//set default size for textarea , we can give id also
            }
        //CLICK FUNCTION FOR RESET
            $("#UC_btn_reset").click(function(){
                if((($('#UC_lb_roomtype').val()==undefined)&&($('#UC_btn_removeroomtype').val()=='CLEAR'))||(($('#UC_lb_stamptype').val()==undefined)&&($('#UC_btn_removestamptype').val()=='CLEAR'))){
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/Initialdata'); ?>",
                        data:{'flag':'UC_flag_notcreation'},
                        success: function(data) {
                            var initial_values=JSON.parse(data);
                            UC_result(initial_values);
                        }
                    });
                }
                UC_resetfrm();
            });
        // CLICK FUNCTION FOR SAVE BUTTON
            $("#UC_btn_submit").click(function(){
                var UC_checked_nonEI=$('#UC_cb_nonEI').is(":checked");
                if (UC_checked_nonEI==true){
                    $('#UC_cb_nonEI').val('X')}
                else{
                    $('#UC_cb_nonEI').val('')
                }
                $(".preloader").show();
                var formelement=$('#unit_createupdate_form').serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/Unitsaveprocess'); ?>",
                    data: formelement,
                    success: function(savedata) {
                        var initial_values=JSON.parse(savedata);
                        UC_result(initial_values);
                    }
                });
            });
    /*-------------------------------------------------UNIT SEARCH AND UPDATE FUNCTIONALITY------------------------------------------------*/
        // FUNCTION FOR CHANGE DATE FORMAT
            function USU_FormTableDateFormat(USU_inputdate){
                var USU_string  = USU_inputdate.split("-");
                return USU_string[2]+'-'+ USU_string[1]+'-'+USU_string[0];
            }
        // loade initial data in updateform
            function USU_success(USU_response){
                USU_errormsg_arr=USU_response[2];
                USU_unitoption_arr=USU_response[1];
                USU_glb_unitno_arr=USU_response[0];
                if(USU_unitoption_arr.length==0)
                    $('#USU_form_unitupdate').replaceWith('<div class="form-group"><label class="errormsg"> '+USU_errormsg_arr[35].EMC_DATA+'</label></div>');
                else{
                    var USU_select_options ='<option>SELECT</option>';
                    for (var i = 0; i < USU_unitoption_arr.length; i++)
                    {
                        if((USU_unitoption_arr[i].unitid==10)||(USU_unitoption_arr[i].unitid==11)||(USU_unitoption_arr[i].unitid==12))
                            USU_select_options_card += '<option value="' + USU_unitoption_arr[i].unitid + '">'+ USU_unitoption_arr[i].unitdata+' </option>';
                        else
                            USU_select_options += '<option value="' + USU_unitoption_arr[i].unitid + '">'+ USU_unitoption_arr[i].unitdata+' </option>';
                    }
                    $('#USU_lb_searchby').html(USU_select_options);
                    $('#USU_form_unitupdate').show();
                    $('.preloader').hide();
                }
            }
            var USU_unitno_flag = 'unittrue';
            var USU_cardnumber_flag = 'accesstrue';
        // CHANGE FUNCTION SEARCH BY ALL TYPES
            $('#USU_lb_searchby').change(function(){
                var USU_unit_optionfetch =$(this).val();
                $('#USU_subheaderdiv,#USU_carddiv,#USU_roomdiv,#USU_datediv,#USU_stampamtdiv,#USU_paymentamtdiv,#USU_searchbtn,#USU_headerdiv,#USU_div_htmltable,#USU_errmsg_roominventory').hide();
                $('#USU_form_unitupdate').find('input:text').val('');
                $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                if(USU_unit_optionfetch!='SELECT')
                {
                    $(".preloader").show();
                    if((USU_unit_optionfetch==5)||(USU_unit_optionfetch==8))//ROOM TYPE,STAMP TYPE
                    {
//                        google.script.run.withSuccessHandler(USU_success_flex).withFailureHandler(USU_onFailure).USU_func_flex(document.getElementById('USU_form_unit_searchnupdate'))
                    }
                    else
                    {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/USU_Searchbyoption'); ?>",
                            data: {'option':USU_unit_optionfetch,'USU_parentfunc_load':'USU_parentfunc_load','USU_not_load_lb':'USU_not_load_lb'},
                            success: function(data) {
                                var valuesarray=JSON.parse(data);
                                USU_success_load_searchby_lb(valuesarray);
                            }
                        });
                    }
                }
            });
        // SUCCESS FUNCTION FOR ALL SEARCH BY SEARCH
            function USU_success_load_searchby_lb(USU_response_load_searchby){
                $(".preloader").hide();
                var USU_unit_optionfetch =USU_response_load_searchby[0].USU_flag;
                var USU_unit_optionvalues=USU_response_load_searchby[0].USU_loaddata_searchby;
                if(USU_unit_optionfetch==9)
                    USU_unit_optionvalues_roomtype=USU_unit_optionvalues;
                var USU_td='';
                $('#USU_subheadermsg').text($('#USU_lb_searchby').find('option:selected').text());
                if((USU_unit_optionfetch==2)||(USU_unit_optionfetch==4)||(USU_unit_optionfetch==3)||(USU_unit_optionfetch==6))
                {
                    if(USU_unit_optionfetch==2)//END DATE
                    {
                        $('#USU_carddiv,#USU_roomdiv,#USU_datediv,#USU_paymentamtdiv,#USU_div_htmltable,#USU_headerdiv,#USU_errmsg_roominventory').hide();
                        $('#USU_stampamtdiv,#USU_searchbtn,#USU_subheaderdiv').show();
                        $('#USU_form_unitupdate').find('input:text').val('');
                        $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                        $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                    }
                    else if(USU_unit_optionfetch==4)//PAYMENT
                    {
                        $('#USU_carddiv,#USU_roomdiv,#USU_datediv,#USU_stampamtdiv,#USU_div_htmltable,#USU_headerdiv,#USU_errmsg_roominventory').hide();
                        $('#USU_paymentamtdiv,#USU_searchbtn,#USU_subheaderdiv').show();
                        $('#USU_form_unitupdate').find('input:text').val('');
                        $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                        $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                    }
                    else if((USU_unit_optionfetch==3)||(USU_unit_optionfetch==6))//END DATE,START DATE
                    {
                        $('#USU_carddiv,#USU_roomdiv,#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_htmltable,#USU_headerdiv,#USU_errmsg_roominventory').hide();
                        $('#USU_datediv,#USU_searchbtn,#USU_subheaderdiv').show();
                        $('#USU_form_unitupdate').find('input:text').val('');
                        $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                        $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                    }
                }
                else if((USU_unit_optionfetch==1)||(USU_unit_optionfetch==5)||(USU_unit_optionfetch==9)||(USU_unit_optionfetch==8)||(USU_unit_optionfetch==7))
                {
                    if(USU_unit_optionvalues.length==0){
                        if((USU_unit_optionfetch==1)||(USU_unit_optionfetch==7)){//INVENTROY CARD
                            var USU_errmsg_roominventory=USU_errormsg_arr[43].EMC_DATA;
                        }
                        else if(USU_unit_optionfetch==9)//ROOM TYPE WITH UNIT
                        {
                            var USU_errmsg_roominventory=USU_errormsg_arr[46].EMC_DATA;
                        }
                        $('#USU_errmsg_roominventory').show();
                        $('#USU_subheadermsg').text(USU_errmsg_roominventory);
                    }
                    else
                    {
                        var USU_unit_options='<option>SELECT</option>';
                        if(USU_unit_optionfetch==1){
                            for(var i = 0; i < USU_unit_optionvalues.length; i++)
                            {
                                USU_unit_options += '<option value="' + USU_unit_optionvalues[i].UNIT_NO + '">' + USU_unit_optionvalues[i].UNIT_NO + '</option>';
                            }
                        }
                        else{
                            for(var i = 0; i < USU_unit_optionvalues.length; i++)
                            {
                                USU_unit_options += '<option value="' + USU_unit_optionvalues[i] + '">' + USU_unit_optionvalues[i] + '</option>';
                            }
                        }
                        if((USU_unit_optionfetch==1)||(USU_unit_optionfetch==7))//INVENTORY CARD, UNIT
                        {
                            $('#USU_lb_unitno').html(USU_unit_options);
                            $('#USU_carddiv,#USU_unitno').show();
                            $('#USU_roomdiv,#USU_cardtype,#USU_cardno,#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_htmltable,#USU_headerdiv,#USU_errmsg_roominventory').hide();
                            $('#USU_form_unitupdate').find('input:text').val('');
                            $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                            $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                        }
                        else if(USU_unit_optionfetch==9)//ROOM TYPE WITH UNIT
                        {
                            $('#USU_lb_roomtype').html(USU_unit_options);
                            $('#USU_roomdiv').show();
                            $('#USU_carddiv,#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_htmltable,#USU_headerdiv,#USU_errmsg_roominventory').hide();
                            $('#USU_form_unitupdate').find('input:text').val('');
                            $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                            $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                        }
                    }
                }
                $(document).doValidation({rule:'fromto',prop:{elem1:'USU_db_fromdate',elem2:'USU_db_todate'}});
                $("#USU_tb_dutyamt_fromamt").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
                $("#USU_tb_dutyamt_toamt").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
                $("#USU_tb_payment_fromamt").doValidation({rule:'numbersonly',prop:{realpart:4}});
                $("#USU_tb_payment_toamt").doValidation({rule:'numbersonly',prop:{realpart:4}});
                $(".USU_class_title_nums").prop("title",USU_errormsg_arr[1].EMC_DATA);
                $("#USU_db_fromdate,#USU_db_todate").datepicker("option", { maxDate: '+2Y'});
            }
        // VALIDATION FOR STAMP DUTY AMOUNT
            $(document).on('change blur','.USU_class_amtvalidstamp',function(){
                var USU_tb_dutyamt_fromamt=$('#USU_tb_dutyamt_fromamt').val();
                var USU_tb_dutyamt_toamt=$('#USU_tb_dutyamt_toamt').val();
                if((parseInt(USU_tb_dutyamt_fromamt) <= parseInt(USU_tb_dutyamt_toamt) )&& (USU_tb_dutyamt_fromamt!=''))
                    ErrorControl.AmountCompare="Valid";
                else
                    ErrorControl.AmountCompare="InValid";
                if((ErrorControl.AmountCompare=="InValid")||(USU_tb_dutyamt_fromamt==0)||(USU_tb_dutyamt_toamt==0))
                    $('#USU_btn_search').attr("disabled", "disabled");
                else
                    $('#USU_btn_search').removeAttr("disabled");
                if(USU_tb_dutyamt_fromamt!='' && USU_tb_dutyamt_toamt!='' && ErrorControl.AmountCompare=="InValid")
                    $("#USU_lbl_errmsg_date").text(USU_errormsg_arr[31].EMC_DATA);
                else
                    $("#USU_lbl_errmsg_date").text('');
            });
        // VALIDATION FOR PAYMENT AMOUNT
            $(document).on('change blur','.USU_class_amtvalidpayment',function(){
                var USU_tb_payment_fromamt=$('#USU_tb_payment_fromamt').val();
                var USU_tb_payment_toamt=$('#USU_tb_payment_toamt').val();
                if(USU_tb_payment_fromamt <= USU_tb_payment_toamt && USU_tb_payment_fromamt!='')
                    ErrorControl.AmountCompare="Valid";
                else
                    ErrorControl.AmountCompare="InValid";
                if((ErrorControl.AmountCompare=="InValid")||(USU_tb_payment_fromamt==0)||(USU_tb_payment_toamt==0))
                    $('#USU_btn_search').attr("disabled", "disabled");
                else
                    $('#USU_btn_search').removeAttr("disabled");
                if(USU_tb_payment_fromamt!='' && USU_tb_payment_toamt!='' && ErrorControl.AmountCompare=="InValid")
                    $("#USU_lbl_errmsg_paymentdate").text(USU_errormsg_arr[31]);
                else
                    $("#USU_lbl_errmsg_paymentdate").text('');
            });
        // CHANGE EVENT FOR SEARCH BY LISTBOX
            $(document).on('change','.USU_all_searchby',function(){
                $('#USU_cardtype,#USU_cardno,#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_htmltable,#USU_headerdiv,#USU_errmsg_roominventory').hide();
                $('#USU_form_unitupdate').find('input:text').val('');
                $('#USU_cardtype,#USU_cardno').find('select').val('SELECT');
                $('#USU_headermsg,#USU_errmsg_roominventory').text('');                
                var USU_unit_optionfetch =$('#USU_lb_searchby').val();
                var formelement=$('#unit_createupdate_form').serialize();
                if($('#USU_lb_unitno').val()!='SELECT' || $('#USU_lb_roomtype').val()!='SELECT'){
                    if(USU_unit_optionfetch==1)//INVENTORY CARD
                    {
                        $('#USU_lb_typeofcard').html(USU_select_options_card);
                        $('#USU_cardtype').show();
                    }
                    else
                    {
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/USU_flexttable'); ?>",
                            data: formelement,
                            success: function(flexdata) {
//                                alert(flexdata)
                                var flxsarray=JSON.parse(flexdata);
//                                USU_success_flex(flxsarray);
                            }
                        });
                    }
                }
            });
        // CHANGE EVENT FOR SEARCH BY CARD
            $(document).on('change','#USU_lb_typeofcard',function(){
                $('#USU_cardno,#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_htmltable,#USU_headerdiv,#USU_errmsg_roominventory').hide();
                $('#USU_form_unitupdate').find('input:text').val('');
                $('#USU_cardno').find('select').val('SELECT');
                $('#USU_headermsg,#USU_errmsg_roominventory,#USU_lbl_errmsg_cardno').text('');
                if($('#USU_lb_typeofcard').val()!='SELECT'){
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/USU_AlreadyExists'); ?>",
                        data: {'inventory_unitno':$('#USU_lb_unitno').val(),'typeofcard':$('#USU_lb_typeofcard').val(),'flag_card_unitno':'USU_flag_check_cardunitno','USU_parent_func':''},
                        success: function(existdata) {
                            var exist_data=JSON.parse(existdata);
                            USU_success_alreadyexists(exist_data);
                        }
                    });
                }
            });
        // SUCCESS FUNCTION FOR INVENTORY CARDS,ACCESS CARD,UNIT NO,ALREADY EXISTS FOR ROOMTYPE STAMP TYPE
            function USU_success_alreadyexists(USU_response_Cardnumbers){
                $(".preloader").hide();
                var USU_cardarray_fetch=[] ;
                var USU_card_unitno_roomstamp=USU_response_Cardnumbers[0].USU_flag_check;
                var USU_flag_roomstamp=USU_response_Cardnumbers[0].USU_truefalse_flag;
                USU_cardarray_fetch = USU_response_Cardnumbers[0].USU_loaddata_searchby;
                if(USU_card_unitno_roomstamp=='USU_flag_check_cardunitno')
                {
                    if(USU_cardarray_fetch.length == 0){
                        $('#USU_lbl_errmsg_cardno').text(USU_errormsg_arr[34].EMC_DATA);
                        $('#USU_stamperrdiv').show();
                        $('#USU_cardno').hide();
                    }
                    else{
                        $('#USU_stamperrdiv').hide();
                        $('#USU_lbl_errmsg_cardno').text('');
                        var USU_inventory_options ='<option>SELECT</option>';
                        for (var i = 0; i < USU_cardarray_fetch.length; i++)
                        {
                            USU_inventory_options += '<option value="' + USU_cardarray_fetch[i].UASD_ACCESS_CARD + '">' + USU_cardarray_fetch[i].UASD_ACCESS_CARD + '</option>';
                        }
                        $('#USU_lb_cardno').html(USU_inventory_options);
                        $('#USU_cardno').show();
                    }
                }
            }
        // CHANGE EVENT FOR SEARCH BY LISTBOX
            $(document).on('change','#USU_lb_cardno',function(){
                if($('#USU_lb_cardno').val()!='SELECT'){
                    $(".preloader").show();
                    var formelement=$('#unit_createupdate_form').serialize();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/USU_flexttable'); ?>",
                        data: formelement,
                        success: function(flexdata) {
//                            alert(flexdata)
                            var flxsarray=JSON.parse(flexdata);
//                                USU_success_flex(flxsarray);
                        }
                    });
                }
            });
        // CHANGE FUNCTION FOR FORM VALIDATION FOR SEARCH BUTTON
            $(document).on('change blur','.USU_class_datesearch',function(){
                if(($('#USU_db_fromdate').val()=='')||($('#USU_db_todate').val()==''))
                {
                    $('#USU_btn_search').attr("disabled", "disabled")
                }
                else{
                    $('#USU_btn_search').removeAttr("disabled");
                }
            });
        // CLICK FUNCTION FOR DATE,AMOUNT SEARCH BUTTON
            $(document).on('click','#USU_btn_search',function(){
                $(".preloader").show();
                var formelement=$('#unit_createupdate_form').serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('Ctrl_Unit_Creation_Search_Update/USU_flexttable'); ?>",
                    data: formelement,
                    success: function(flexdata) {
//                        alert(flexdata)
                        var flxsarray=JSON.parse(flexdata);
//                                USU_success_flex(flxsarray);
                    }
                });
            });

        
        
        });
    </script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>UNIT CREATION / SEARCH AND UPDATE</b></h4></div>
    <form id="unit_createupdate_form" name="unit_createupdate_form" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group">
                    <div class="col-md-10">
                        <div class="radio">
                            <label><input type="radio" class="UC_selectform" value="unitcreate" name="UC_form_select" id="UC_form_unitcreate">UNIT CREATION</label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="radio">
                            <label><input type="radio" class="UC_selectform" value="unitsearchupdate" name="UC_form_select" id="UC_form_unitupdate">UNIT SEARCH AND UPDATE</label>
                        </div>
                    </div>
                </div>
                <div id="UC_form_unitcreation" hidden>
                    <div class="form-group" id="UC_unitno">
                        <label class="col-sm-2">UNIT NUMBER <em>*</em></label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_unitno" id="UC_tb_unitno" maxlength=4 class="UC_class_numonly numonly form-control" placeholder="Unit Number"></div>
                        <div class="col-sm-4 errpadding errormsg" id="UC_div_errunitno" name="UC_div_errunitno">
                        </div>
                    </div>
                    <div class="form-group" id="UC_accesscard">
                        <label class="col-sm-2">ACCESS CARD </label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_accesscard" id="UC_tb_accesscard" class="form-control UC_class_numonly" maxlength=7 placeholder="Access Card"></div>
                        <div class="col-sm-4 errpadding errormsg" id="UC_div_errcard" name="UC_div_errcard"> </div>
                    </div>
                    <div class="form-group" id="UC_roomtype">
                        <label class="col-sm-2">ROOM TYPE </label>
                        <div class="col-sm-3"><select name="UC_lb_roomtype" id="UC_lb_roomtype" class="form-control"></select></div>
                        <div class="col-sm-2 colsmhf"><input class="btn btn-info" type="button"  name="UC_btn_addroomtype" value="ADD" id="UC_btn_addroomtype"/></div>
                        <div class="col-sm-4 errpadding errormsg" id="UC_div_errroom" name="UC_div_errroom"> </div>
                    </div>
                    <div class="form-group" id="UC_unitrent">
                        <label class="col-sm-2">UNIT RENTAL <em>*</em></label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_unitrentalamt" id="UC_tb_unitrentalamt" maxlength=4 class="UC_class_numonly form-control" placeholder="Unit Rental"></div>
                    </div>
                    <div class="form-group" id="UC_unitdepo">
                        <label class="col-sm-2">UNIT DEPOSIT </label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_unitdeposite" id="UC_tb_unitdeposite" maxlength=5 class="UC_class_numonly form-control" placeholder="Unit Deposit"></div>
                    </div>
                    <div class="form-group" id="UC_startdate">
                        <label class="col-sm-2">START PERIOD <em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input id="UC_db_startdate" name="UC_db_startdate" type="text" class="date-picker datemandtry form-control" placeholder="Start Date"/>
                                <label for="UC_db_startdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="UC_enddate">
                        <label class="col-sm-2">END PERIOD <em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input id="UC_db_enddate" name="UC_db_enddate" type="text" class="date-picker datemandtry form-control" placeholder="End Date"/>
                                <label for="UC_db_enddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="UC_accntnumber">
                        <label class="col-sm-2">ACCOUNT NUMBER </label>
                        <div class="col-sm-3"><input type="text" name="UC_tb_accntnumber" id="UC_tb_accntnumber" placeholder="Account Number" maxlength="15" class="numonly UC_class_numonly form-control"/></div>
                    </div>
                    <div class="form-group" id="UC_accntname">
                        <label class="col-sm-2">ACCOUNT NAME </label>
                        <div class="col-sm-3"><input type="text" name="UC_tb_accntname" id="UC_tb_accntname" placeholder="Account Name" maxlength="25" class="form-control"/></div>
                    </div>
                    <div class="form-group" id="UC_bankcode">
                        <label class="col-sm-2">BANK CODE</label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_bankcode" id="UC_tb_bankcode" maxlength=5 class="numonly UC_class_numonly form-control" placeholder="Bank Code"/></div>
                    </div>
                    <div class="form-group" id="UC_branchcode">
                        <label class="col-sm-2">BRANCH CODE</label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_branchcode" id="UC_tb_branchcode" maxlength=5 class="numonly UC_class_numonly form-control" placeholder="Branch Code"/></div>
                    </div>
                    <div class="form-group" id="UC_bankaddress">
                        <label class="col-sm-2">BANK ADDRESS</label>
                        <div class="col-sm-4"><textarea name="UC_ta_address" id="UC_ta_address" placeholder="Bank Address" rows="5" class="form-control"></textarea></div>
                    </div>
                    <div class="form-group" id="UC_doorcode">
                        <label class="col-sm-2">DOOR CODE</label>
                        <div class="col-sm-2"><input type="text" name="UNIT_tb_doorcode" id="UNIT_tb_doorcode" class="UC_class_numonly numonly form-control" maxlength=10 placeholder="Door Code"/></div>
                        <div class="col-sm-4 errpadding" id="UC_doorcodeerr">
                            <label id="UC_lbl_doorcode" name="UC_lbl_doorcode" class="errormsg"></label>
                        </div>
                    </div>
                    <div class="form-group" id="UC_weblogin">
                        <label class="col-sm-2">WEB LOGIN</label>
                        <div class="col-sm-2"><input type="text" name="UNIT_tb_weblogin" id="UNIT_tb_weblogin" class="form-control" maxlength=13 placeholder="Web Login"/></div>
                        <div class="col-sm-4 errpadding" id="UC_weblogin">
                            <label id="UC_lbl_weblogin" name="UC_lbl_weblogin" class="errormsg"></label>
                        </div>
                    </div>
                    <div class="form-group" id="UC_webpass">
                        <label class="col-sm-2">WEB PASSWORD</label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_webpass" id="UC_tb_webpass" class="UC_class_numonly numonly form-control" maxlength=6 placeholder="Web Password"/></div>
                    </div>
                    <div class="form-group" id="UC_stampdutydate">
                        <label class="col-sm-2">STAMP DUTY DATE </label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input id="UC_db_stampdutydate" name="UC_db_stampdutydate" type="text" class="date-picker datemandtry form-control" placeholder="Stamp Duty Date"/>
                                <label for="UC_db_stampdutydate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="UC_stamptype">
                        <label class="col-sm-2">STAMP DUTY TYPE </label>
                        <div class="col-sm-3"><select name="UC_lb_stamptype" id="UC_lb_stamptype" class="form-control "></select></div>
                        <div class="col-sm-2 colsmhf"><input class="btn btn-info" type="button" name="UC_btn_addstamptype" value="ADD" id="UC_btn_addstamptype"/></div>
                        <div class="col-sm-4 errpadding errormsg" id="UC_div_errstamp" name="UC_div_errstamp"></div>
                    </div>
                    <div class="form-group" id="UC_stampamount">
                        <label class="col-sm-2">STAMP DUTY AMOUNT </label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_stampamount" id="UC_tb_stampamount" placeholder="Stamp Duty Amount" class="UC_class_numonly numonly form-control"></div>
                    </div>
                    <div class="form-group" id="UC_comments">
                        <label class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea name="UC_ta_comments" id="UC_ta_comments" placeholder="Comments" maxlength="300" rows="5" class="form-control"></textarea></div>
                    </div>
                    <div class="form-group" id="UC_nonEI">
                        <label class="col-sm-2">EI/NON_EI</label>
                        <div class="radio">
                            <label><input type="checkbox" name="UC_cb_nonEI" id="UC_cb_nonEI"></label>
                        </div>
                    </div>
                    <div class="form-group" id="UC_buttons">
                        <div class="col-sm-offset-1 col-sm-3">
                            <input class="btn btn-info" type="button" id="UC_btn_submit" name="submit" value="SAVE" disabled/>
                            <input class="btn btn-info" type="button" id="UC_btn_reset" name="RESET" value="RESET"/>
                        </div>
                    </div>
                </div>
                <div id="USU_form_unitupdate" hidden>
                    <div class="form-group" id="USU_searchby">
                        <label class="col-sm-2">SEARCH BY <em>*</em></label>
                        <div class="col-sm-3"> <select name="USU_lb_searchby" id="USU_lb_searchby" class="form-control USU_formvalidation"></select></div>
                    </div>
                    <div class="form-group" id='USU_errmsg_roominventory' hidden>
                        <lable class="col-lg-12 errormsg" id="USU_lbl_errmsg_roominventory"></lable>
                    </div>
                    <div class="form-group" id='USU_subheaderdiv' hidden>
                        <lable class="col-lg-12 srctitle" id="USU_subheadermsg"></lable>
                    </div>
                    <div id="USU_carddiv" hidden>
                        <div class="form-group" id="USU_unitno">
                            <label class="col-sm-2">UNIT NUMBER </label>
                            <div class="col-sm-2"> <select name="USU_lb_unitno" id="USU_lb_unitno" class="USU_all_searchby form-control USU_formvalidation"></select></div>
                        </div>
                        <div class="form-group" id="USU_cardtype">
                            <label class="col-sm-2">TYPE OF CARD </label>
                            <div class="col-sm-2"> <select name="USU_lb_typeofcard" id="USU_lb_typeofcard" class="form-control USU_formvalidation"></select></div>
                            <div class="form-group errpadding" id='USU_stamperrdiv' hidden>
                                <lable class="col-lg-4 errormsg" id="USU_lbl_errmsg_cardno"></lable>
                            </div>
                        </div>
                        <div class="form-group" id="USU_cardno">
                            <label class="col-sm-2">CARD NUMBER </label>
                            <div class="col-sm-2"> <select name="USU_lb_cardno" id="USU_lb_cardno" class="form-control USU_formvalidation"></select></div>
                        </div>
                    </div>
                    <div id="USU_roomdiv" hidden>
                        <div class="form-group" id="USU_roomtype">
                            <label class="col-sm-2">ROOM TYPE </label>
                            <div class="col-sm-3"><select name="USU_lb_roomtype" id="USU_lb_roomtype" class="USU_all_searchby form-control"></select></div>
                        </div>
                    </div>
                    <div id="USU_datediv" hidden>
                        <div class="form-group" id="USU_fromdate">
                            <label class="col-sm-2">FROM DATE </label>
                            <div class="col-sm-2">
                                <div class="input-group addon">
                                    <input id="USU_db_fromdate" name="USU_db_fromdate" type="text" class="USU_class_datesearch date-picker datemandtry form-control" placeholder="From Date"/>
                                    <label for="USU_db_fromdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="USU_todate">
                            <label class="col-sm-2">TO DATE </label>
                            <div class="col-sm-2">
                                <div class="input-group addon">
                                    <input id="USU_db_todate" name="USU_db_todate" type="text" class="USU_class_datesearch date-picker datemandtry form-control" placeholder="To Date"/>
                                    <label for="USU_db_todate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="USU_stampamtdiv" hidden>
                        <div class="form-group" id="USU_stampfromamt">
                            <label class="col-sm-2">FROM AMOUNT </label>
                            <div class="col-sm-2"><input type="text" name="USU_tb_dutyamt_fromamt" id="USU_tb_dutyamt_fromamt" placeholder="From Amount" class="USU_class_amtvalidstamp form-control"></div>
                        </div>
                        <div class="form-group" id="USU_stamptoamt">
                            <label class="col-sm-2">TO AMOUNT </label>
                            <div class="col-sm-2"><input type="text" name="USU_tb_dutyamt_toamt" id="USU_tb_dutyamt_toamt" placeholder="To Amount" class="USU_class_amtvalidstamp form-control"></div>
                        </div>
                        <div class="form-group" id='USU_stamperrdiv' hidden>
                            <lable class="col-sm-offset-2 col-lg-12 errormsg" id="USU_lbl_errmsg_date"></lable>
                        </div>
                    </div>
                    <div id="USU_paymentamtdiv" hidden>
                        <div class="form-group" id="USU_paymentfromamt">
                            <label class="col-sm-2">FROM AMOUNT </label>
                            <div class="col-sm-2"><input type="text" name="USU_tb_payment_fromamt" id="USU_tb_payment_fromamt" maxlength="4" placeholder="From Amount" class="USU_class_title_nums USU_class_amtvalidpayment form-control"></div>
                        </div>
                        <div class="form-group" id="USU_paymenttoamt">
                            <label class="col-sm-2">TO AMOUNT </label>
                            <div class="col-sm-2"><input type="text" name="USU_tb_payment_toamt" id="USU_tb_payment_toamt" maxlength="4" placeholder="To Amount" class="USU_class_title_nums USU_class_amtvalidpayment form-control"></div>
                        </div>
                        <div class="form-group" id='USU_paymenterrdiv' hidden>
                            <lable class="col-sm-offset-2 col-lg-12 errormsg" id="USU_lbl_errmsg_paymentdate"></lable>
                        </div>
                    </div>
                    <div class="form-group" id="USU_searchbtn" hidden>
                        <div class="col-sm-offset-1 col-sm-3">
                            <input class="btn btn-info" type="button" id="USU_btn_search" name="USU_btn_search" value="SEARCH" disabled/>
                        </div>
                    </div>
                    <div class="form-group" id='USU_headerdiv' hidden>
                        <lable class="col-lg-12 srctitle" id="USU_headermsg"></lable>
                        <div style="padding-left: 15px;">
                            <input type="button" id="USU_btn_pdf" class="btnpdf" value="PDF">
                        </div>
                    </div>
                    <div class="table-responsive" id="USU_div_htmltable" hidden>
                        <section>
                        </section>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>