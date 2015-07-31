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
                        data:{"ErrorList":'1,2,7,8,9,10,11,30,308,400,458,463,464,466,467','flag':'UC_flag_notcreation'},
                        success: function(data) {
                            var initial_values=JSON.parse(data);
                            UC_result(initial_values);
                        }
                    });
                }
            });
            function UC_result(UC_response){
                $('.preloader').hide();
                if(UC_response.toString().match("SCRIPT ERROR:"))
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
        // FUCNTION FOR CLEAR ALL VALUES 
            function UC_resetfrm(){
                $('#UC_form_unitcreation').find('textarea').val('');
                $(':input','#UC_form_unitcreation')
                    .not(':button')
                    .val('')
                    .removeAttr('checked')
                    .removeAttr('selected');
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
                        data:{"ErrorList":'1,2,7,8,9,10,11,30,308,400,458,463,464,466,467','flag':'UC_flag_roomtype'},
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
                        <label class="col-sm-3">UNIT NUMBER <em>*</em></label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_unitno" id="UC_tb_unitno" maxlength=4 class="UC_class_numonly numonly form-control" placeholder="Unit Number"></div>
                        <div class="col-sm-4 errpadding errormsg" id="UC_div_errunitno" name="UC_div_errunitno">
                        </div>
                    </div>
                    <div class="form-group" id="UC_accesscard">
                        <label class="col-sm-3">ACCESS CARD </label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_accesscard" id="UC_tb_accesscard" class="form-control UC_class_numonly" maxlength=7 placeholder="Access Card"></div>
                        <div class="col-sm-4 errpadding errormsg" id="UC_div_errcard" name="UC_div_errcard"> </div>
                    </div>
                    <div class="form-group" id="UC_roomtype">
                        <label class="col-sm-3">ROOM TYPE </label>
                        <div class="col-sm-3"><select name="UC_lb_roomtype" id="UC_lb_roomtype" class="form-control"></select></div>
                        <div class="col-sm-2 colsmhf"><input class="btn btn-info" type="button"  name="UC_btn_addroomtype" value="ADD" id="UC_btn_addroomtype"/></div>
                        <div class="col-sm-4 errpadding errormsg" id="UC_div_errroom" name="UC_div_errroom"> </div>
                    </div>
                    <div class="form-group" id="UC_unitrent">
                        <label class="col-sm-3">UNIT RENTAL <em>*</em></label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_unitrentalamt" id="UC_tb_unitrentalamt" maxlength=4 class="UC_class_numonly form-control" placeholder="Unit Rental"></div>
                    </div>
                    <div class="form-group" id="UC_unitdepo">
                        <label class="col-sm-3">UNIT DEPOSIT </label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_unitdeposite" id="UC_tb_unitdeposite" maxlength=5 class="UC_class_numonly form-control" placeholder="Unit Deposit"></div>
                    </div>
                    <div class="form-group" id="UC_startdate">
                        <label class="col-sm-3">START PERIOD <em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input id="UC_db_startdate" name="UC_db_startdate" type="text" class="date-picker datemandtry form-control" placeholder="Start Date"/>
                                <label for="UC_db_startdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="UC_enddate">
                        <label class="col-sm-3">END PERIOD <em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input id="UC_db_enddate" name="UC_db_enddate" type="text" class="date-picker datemandtry form-control" placeholder="End Date"/>
                                <label for="UC_db_enddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="UC_accntnumber">
                        <label class=" col-sm-3">ACCOUNT NUMBER </label>
                        <div class="col-sm-3"><input type="text" name="UC_tb_accntnumber" id="UC_tb_accntnumber" placeholder="Account Number" maxlength="15" class="numonly UC_class_numonly form-control"/></div>
                    </div>
                    <div class="form-group" id="UC_accntname">
                        <label class=" col-sm-3">ACCOUNT NAME </label>
                        <div class="col-sm-3"><input type="text" name="UC_tb_accntname" id="UC_tb_accntname" placeholder="Account Name" maxlength="25" class="form-control"/></div>
                    </div>
                    <div class="form-group" id="UC_bankcode">
                        <label class="col-sm-3">BANK CODE</label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_bankcode" id="UC_tb_bankcode" maxlength=5 class="numonly UC_class_numonly form-control" placeholder="Bank Code"/></div>
                    </div>
                    <div class="form-group" id="UC_branchcode">
                        <label class="col-sm-3">BRANCH CODE</label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_branchcode" id="UC_tb_branchcode" maxlength=5 class="numonly UC_class_numonly form-control" placeholder="Branch Code"/></div>
                    </div>
                    <div class="form-group" id="UC_bankaddress">
                        <label class="col-sm-3">BANK ADDRESS</label>
                        <div class="col-sm-4"><textarea name="UC_ta_address" id="UC_ta_address" placeholder="Bank Address" rows="5" class="form-control"></textarea></div>
                    </div>
                    <div class="form-group" id="UC_doorcode">
                        <label class="col-sm-3">DOOR CODE</label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_doorcode" id="UC_tb_doorcode" class="UC_class_numonly numonly form-control" maxlength=10 placeholder="Door Code"/></div>
                        <div class="col-sm-4 errpadding" id="UC_doorcodeerr">
                            <label id="UC_lbl_doorcodeerr" name="UC_lbl_doorcodeerr" class="errormsg"></label>
                        </div>
                    </div>
                    <div class="form-group" id="UC_weblogin">
                        <label class="col-sm-3">WEB LOGIN</label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_weblogin" id="UC_tb_weblogin" class="form-control" maxlength=13 placeholder="Web Login"/></div>
                        <div class="col-sm-4 errpadding" id="UC_weblogin">
                            <label id="UC_lbl_weblogin" name="UC_lbl_weblogin" class="errormsg"></label>
                        </div>
                    </div>
                    <div class="form-group" id="UC_webpass">
                        <label class="col-sm-3">WEB PASSWORD</label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_webpass" id="UC_tb_webpass" class="UC_class_numonly numonly form-control" maxlength=6 placeholder="Web Password"/></div>
                    </div>
                    <div class="form-group" id="UC_stampdutydate">
                        <label class="col-sm-3">STAMP DUTY DATE </label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input id="UC_db_stampdutydate" name="UC_db_stampdutydate" type="text" class="date-picker datemandtry form-control" placeholder="Stamp Duty Date"/>
                                <label for="UC_db_stampdutydate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="UC_stamptype">
                        <label class="col-sm-3">STAMP DUTY TYPE </label>
                        <div class="col-sm-3"><select name="UC_lb_stamptype" id="UC_lb_stamptype" class="form-control "></select></div>
                        <div class="col-sm-2 colsmhf"><input class="btn btn-info" type="button" name="UC_btn_addstamptype" value="ADD" id="UC_btn_addstamptype"/></div>
                        <div class="col-sm-4 errpadding errormsg" id="UC_div_errstamp" name="UC_div_errstamp"></div>
                    </div>
                    <div class="form-group" id="UC_stampamount">
                        <label class="col-sm-3">STAMP DUTY AMOUNT </label>
                        <div class="col-sm-2"><input type="text" name="UC_tb_stampamount" id="UC_tb_stampamount" placeholder="Stamp Duty Amount" class="UC_class_numonly numonly form-control"></div>
                    </div>
                    <div class="form-group" id="UC_comments">
                        <label class="col-sm-3">COMMENTS</label>
                        <div class="col-sm-4"><textarea name="UC_ta_comments" id="UC_ta_comments" placeholder="Comments" maxlength="300" rows="5" class="form-control"></textarea></div>
                    </div>
                    <div class="form-group" id="UC_nonEI">
                        <label class="col-sm-3">EI/NON_EI</label>
                        <div class="radio">
                            <label><input type="checkbox" name="UC_cb_nonEI" id="UC_cb_nonEI"></label>
                        </div>
                    </div>
                    <div class="form-group" id="UC_buttons">
                        <div class="col-sm-offset-2 col-sm-3">
                            <input class="btn btn-info" type="button" id="UC_btn_submit" name="submit" value="SAVE" disabled/>
                            <input class="btn btn-info" type="button" id="UC_btn_reset" name="RESET" value="RESET"/>
                        </div>
                    </div>
                </div>
                <div id="USU_form_unitupdate">
                    
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>