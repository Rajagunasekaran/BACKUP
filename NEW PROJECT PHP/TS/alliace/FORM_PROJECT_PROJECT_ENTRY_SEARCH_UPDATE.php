<!--//*******************************************FILE DESCRIPTION*********************************************//
//*********************************PROJECT ENTRY/SEARCH/UPDATE**************************************//
//DONE BY:RAJA
//VER 0.05-SD:03/01/2015 ED:06/01/2015, TRACKER NO:166,179,DESC:IMPLEMENTED PDF BUTTON AND VALIDATED AND GAVE INPUT TO DB, SETTING PRELOADER POSITON, MSGBOX POSITION
//DONE BY:LALTHA
//VER 0.04 SD:03/12/2014 ED:03/12/2014,TRACKER NO:74,DESC:Updated preloader funct,Removed confirmation err msg,Added no data err msg,Fixed Width
//DONE BY:safi
//ver 0.03 SD:06/011/2014 ED:07/11/2014,tracker no:74,updated autocomplte function,set date for datepicker,changed validation part
//DONE BY:SASIKALA
//VER 0.02 SD:14/10/2014 ED:16/10/2014,TRACKER NO:86,DESC:VALIDATION'S DONE
//VER 0.01-INITIAL VERSION, SD:20/09/2014 ED:13/10/2014,TRACKER NO:74 DONE BY:SHALINI
//*********************************************************************************************************//-->
<?php
include "HEADER.php";
?>
<script>
//CHECK PRELOADER STATUS N HIDE START
var SubPage=1;
var upload=0;
var projectflag=0;
// READY FUNCTION STARTS
$(document).ready(function(){

    $(document).on("click",'#attachprompt', function (){
        var tablerowCount = $('#filetableuploads tr').length;
        var uploadfileid="upload_filename"+tablerowCount;
        var appendfile='<tr><td><input type="file" class="fileextensionchk" id='+uploadfileid+' name='+uploadfileid+'></td><td><button type="button" class="removebutton" title="Remove this row" style="background:red;color:white;width: 20px;height: 23px;border-radius:10%;">-</button><label id="attach_error" hidden></label></td></tr></br>';
        $('#filetableuploads').append(appendfile);
        upload++;
        var rowCount = $('#filetableuploads tr').length;
        if(rowCount!=0)
        {
            $('#attachafile').text('Attach another file');
        }
        else
        {
            $('#attachafile').text('Attach a file');
        }
    });

    $(document).on('click', 'button.removebutton', function () {

        $(this).closest('tr').remove();
        var rowCount = $('#filetableuploads tr').length;
        if(rowCount!=0)
        {
            $('#attachafile').text('Attach another file');
        }
        else
        {
            $('#attachafile').text('Attach a file');
        }
        return false;
    });
    //file extension validation
    $(document).on("change",'.fileextensionchk', function (){
        for(var i=0;i<25;i++)
        {
            var data= $('#upload_filename'+i).val();
            var datasplit=data.split('.');
            var ext=datasplit[1].toUpperCase();
            if(ext=='PDF'|| ext=='JPG'|| ext=='PNG' || ext=='JPEG' || data==undefined || data=="")
            {
            }
            else
            {
                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"PROJECT ENTRY/SEARCH/UPDATE",msgcontent:error_message[7],position:{top:150,left:500}}});
                reset_field($('#upload_filename'+i));
            }
        }
    });
    //file upload reset
    //file upload reset
    function reset_field(e) {
        e.wrap('<form>').parent('form').trigger('reset');
        e.unwrap();
    }
    //add file upload row
//    $('.preloader', window.parent.document).show();
    get_Values();
    $('#PE_btn_pdf').hide();
    var  CACS_VIEW_customername;
    $('textarea').autogrow({onInitialize: true});
    $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
    //DATE PICKER FUNCTION
    $('.PE_tb_sdatedatepicker').datepicker({
        dateFormat:"dd-mm-yy",
        maxDate: Date(),
        changeYear: true,
        changeMonth: true
    });
    //DATE PICKER FUNCTION
    $('.PE_tb_edatedatepicker').datepicker({
        dateFormat:"dd-mm-yy",
        maxDate: Date(),
        changeYear: true,
        changeMonth: true
    });
    //CHANGE EVENT FOR STARTDATE
    $(document).on('change','#PE_tb_sdate',function(){

        var PE_startdate = $('#PE_tb_sdate').datepicker('getDate');
        var date = new Date( Date.parse( PE_startdate ));
        date.setDate( date.getDate()  );
        var PE_enddate = date.toDateString();
        PE_enddate = new Date( Date.parse( PE_enddate ));
        $('#PE_tb_edate').datepicker("option","minDate",PE_enddate);
        var max_date=new Date(PE_startdate);
        var month=max_date.getMonth();
        var year=max_date.getFullYear()+2;
        var date=max_date.getDate();
        var max_date = new Date(year,month,date);
        $('#PE_tb_edate').datepicker("option","maxDate",max_date);
    });
    //AUTOCOMPLETE TEXT
    var error_message=[];
    var comp_start_date;
    function get_Values(){
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                $('.preloader', window.parent.document).hide();
                var values=JSON.parse(xmlhttp.responseText);
                var proj_auto=values[0];
                error_message=values[1];
                comp_start_date=values[2];
                CACS_VIEW_customername=proj_auto;
            }
        }
        var option='AUTO';
        xmlhttp.open("GET","DB_PROJECT_PROJECT_ENTRY_SEARCH_UPDATE.php?&option="+option,true);
        xmlhttp.send();

    }
    showTable();
    //BLUR FUNCTION FOR PROJECT NAME
    $(document).on("change blur",'#projectname',function(){
        var checkproject_name=$(this).val();
        if(checkproject_name!=''){
            $('.preloader', window.parent.document).show();
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    $('.preloader', window.parent.document).hide();
                    var check_array=JSON.parse(xmlhttp.responseText);
                    if(check_array[0]==1){
                        $("#PE_btn_update").attr("disabled", "disabled");
                    }
                    else{
                        $("#PE_btn_update").removeAttr("disabled");
                    }
                }
            }
            var option='CHECK';
            xmlhttp.open("GET","DB_PROJECT_PROJECT_ENTRY_SEARCH_UPDATE.php?checkproject_name="+checkproject_name+"&option="+option,true);
            xmlhttp.send();
        }
    });
    //BLUR FUNCTION FOR PROJECT DESCRIPTION
    $(document).on("change blur",'#PE_ta_prjdescrptn',function(){
        $('#PE_ta_prjdescrptn').val($('#PE_ta_prjdescrptn').val().toUpperCase())
        var trimfunc=($('#PE_ta_prjdescrptn').val()).trim()
        $('#PE_ta_prjdescrptn').val(trimfunc)
    });
    $(document).on("change blur",'#projectdes',function(){
        $('#projectdes').val($('#projectdes').val().toUpperCase())
        var trimfunc=($('#projectdes').val()).trim()
        $('#projectdes').val(trimfunc)
    });

    //CHANGE EVENT FOR PROJECT TEXT BOX
    $(document).on("change blur",'#PE_tb_prjectname', function (){

//        $('#PE_ta_prjdescrptn').val("");
//        $('#PE_tb_edate').val('');
//        $('#PE_tb_sdate').val('');
        var PE_startdate=(comp_start_date).split('-');
        var day=PE_startdate[0];
        var month=PE_startdate[1];
        var year=PE_startdate[2];
        PE_startdate=new Date(year,month-1,day);
        $('#PE_tb_sdate').datepicker("option","minDate",PE_startdate);
        var max_date=new Date();
        var month=max_date.getMonth();
        var year=max_date.getFullYear()+2;
        var date=max_date.getDate();
        var max_date = new Date(year,month,date);
        $('#PE_tb_sdate').datepicker("option","maxDate",max_date);

        var checkproject_name=($(this).val()).trim();
        if(checkproject_name!=''){
            $('#PE_tb_prjectname').val(checkproject_name.toUpperCase())
            $('.preloader', window.parent.document).show();
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    $('.preloader', window.parent.document).hide();
                    var check_array=JSON.parse(xmlhttp.responseText);
//                    var desc=check_array[1];
                    var min_enddate=check_array[1];
                    var max_date=new Date(min_enddate);
                    var month=max_date.getMonth();
                    var year=max_date.getFullYear();
                    var date=max_date.getDate()+1;
                    var mindate = new Date(year,month,date);
                    var count=0;
                    for(var i=0;i<CACS_VIEW_customername.length;i++){
                        if(CACS_VIEW_customername[i]==checkproject_name){
                            $('#PE_tb_sdate').datepicker("option","minDate",new Date(mindate));
                            var max_date=new Date();
                            var month=max_date.getMonth();
                            var year=max_date.getFullYear()+2;
                            var date=max_date.getDate();
                            var max_date = new Date(year,month,date);
                            $('#PE_tb_sdate').datepicker("option","maxDate",max_date);
//                            $('#PE_ta_prjdescrptn').val(desc);
                            alert('enter');
                            $('#PE_tb_status').val('REOPEN');
                            $('#PE_lbl_erromsg').hide();
                            $('#PE_ta_prjdescrptn').val(check_array[2]);
                            count=1;
                            break;
                            //reopen
                        }
                    }
                    if(count!=1){
                        if(check_array[0]==1){
                            $('#PE_lbl_erromsg').text(error_message[0]).show();
                            $('#PE_tb_status').val('');
                            $("#PE_btn_save").attr("disabled", "disabled");
                            $("#PE_btn_update").attr("disabled", "disabled");
                        }
                        else
                        {
                            $('#PE_lbl_erromsg').hide();
                            $('#PE_tb_status').val('STARTED').show();
                            validation();
                        }
                    }

                }
            }
            var option='CHECK';
            xmlhttp.open("GET","DB_PROJECT_PROJECT_ENTRY_SEARCH_UPDATE.php?checkproject_name="+checkproject_name+"&option="+option,true);
            xmlhttp.send();
        }
        else{
            $('#PE_lbl_erromsg').hide();
        }
    });
    //FUNCTION TO HIGHLIGHT SEARCH TEXT
    function CACS_VIEW_highlightSearchText() {
        $.ui.autocomplete.prototype._renderItem = function( ul, item) {
            var re = new RegExp(this.term, "i") ;
            var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + t + "</a>" )
                .appendTo( ul );
        }
    };
//FUNCTION TO AUTOCOMPLETE SEARCH TEXT
    var CACS_VIEW_customername=[];
    var CACS_VIEW_customerflag;
    $("#PE_tb_prjectname").keypress(function(){
        CACS_VIEW_customerflag=0;
        CACS_VIEW_highlightSearchText();
        $("#PE_tb_prjectname").autocomplete({
            source: CACS_VIEW_customername,
            select:CACS_VIEW_AutoCompleteSelectHandler
        });
    });
//FUNCTION TO GET SELECTED VALUE
    function CACS_VIEW_AutoCompleteSelectHandler(event, ui) {
        CACS_VIEW_customerflag=1;
        $('#CACS_VIEW_lbl_custautoerrmsg').hide();
    }
// CLICK EVENT FOR SAVE BUTTON
    $(document).on('click','.PE_btn_save',function(){
        $('.preloader', window.parent.document).show();
        var formElement = document.getElementById("PE_form_projectentry");

        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                $('.preloader', window.parent.document).hide();
                var msg_alert=xmlhttp.responseText;
                if(msg_alert==1 || msg_alert==2)
                {
                    if(msg_alert==1)
                    {
                        $(document).doValidation({rule:'messagebox',prop:{msgtitle:"PROJECT ENTRY/SEARCH/UPDATE",msgcontent:error_message[1],position:{top:150,left:500}}});
                    }
                    else
                    {
                        $(document).doValidation({rule:'messagebox',prop:{msgtitle:"PROJECT ENTRY/SEARCH/UPDATE",msgcontent:error_message[3],position:{top:150,left:500}}});
                    }

                }
                else if(msg_alert==0)
                {
                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"PROJECT ENTRY/SEARCH/UPDATE",msgcontent:error_message[2],position:{top:150,left:500}}});
                }
                else
                {
                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"PROJECT ENTRY/SEARCH/UPDATE",msgcontent:msg_alert,position:{top:150,left:500}}});
                }
                $("#PE_tb_prjectname").val('').show();
                $("#PE_ta_prjdescrptn").val('').show();
                $("#PE_tb_sdate").val('').show();
                $("#PE_tb_edate").val('').show();
                $("#PE_tb_status").val('').show();
                $('#PE_tb_id').val('');
                $("#PE_btn_save").attr("disabled", "disabled");
                $("#PE_btn_update").attr("disabled", "disabled");
                $("#filetableuploads tr").remove();
                $("#exsistingfiletable tr").remove();
                $('#attachafile').text('Attach a file');
                $('#PE_entryformtable').hide();
                $("#PE_btn_Removeform").attr("disabled", "disabled");
                $('#PE_updatestatus').hide();
                formclear();
                showTable();
                get_Values();
            }
        }
        var option='SAVE';
        xmlhttp.open("POST","DB_PROJECT_PROJECT_ENTRY_SEARCH_UPDATE.php?option="+option+"&upload="+upload,true);
        xmlhttp.send(new FormData(formElement));
    });
    //FUNCTION FOR VALIDATION
    function validation(){

        var projectname= $('#PE_tb_prjectname').val();
        var projectsdate= $("#PE_tb_sdate").val();
        var projectstatus=$("#PE_tb_status").val();
        var projectstatusupdate=$("#PE_tb_statusupdate").val();
        var projectdes=$("#PE_ta_prjdescrptn").val().trim();
        var projectedate=$("#PE_tb_edate").val();
        if((projectname!="") && (projectsdate!="") && (projectdes !="")&&(projectedate!=""))
        {
            $("#PE_btn_save").removeAttr("disabled");
            $("#PE_btn_update").removeAttr("disabled");
        }
        else
        {
            $("#PE_btn_save").attr("disabled", "disabled");
            $("#PE_btn_update").attr("disabled", "disabled");
        }
    }
// SAVE BUTTON VALIDATION
    $(document).on('change blur','.valid',function(){
        validation();
    });
// CREATING UPDATE AND CANCEL BUTTON
    var data='';
    var action = '';
    var updatebutton = "<input type='button' id='PE_btn_update' class='ajaxupdate btn' disabled value='Update'>";
    var cancel = "<input type='button' class='ajaxcancel btn' value='Cancel'>";
    var pre_tds;
    var field_arr = new Array('text','text');
    var field_name = new Array('projectname','projectdes');
    // FUNCTION FOR DATETABLE
    function showTable(){
        $.ajax({
            url:"DB_PROJECT_PROJECT_ENTRY_SEARCH_UPDATE.php",
            type:"POST",
            data:"option=showData",
            cache: false,
            success: function(response){
                if(response!=0){
                    $('#PE_nodataerrormsg').text(error_message[5]).hide();
                    $('#PE_lbl_title').text('DETAILS FOR ALL PROJECT(S)').show();
                    $('#PE_btn_pdf').show();

                    var header='<table id="demoajax" border="1" cellspacing="0" class="srcresult" width="1700">';//<thead  bgcolor="#6495ed" style="color:white"><tr ><th  width=200>PROJECT NAME</th><th width=500 >PROJECT DESCRIPTION</th><th width=10>REC VER</th><th width=30>STATUS</th><th width=50 class="uk-date-column">START DATE</th><th width=50 class="uk-date-column">END DATE</th><th style="min-width:70px;">USERSTAMP</th><th style="min-width:100px;" nowrap class="uk-timestp-column">TIMESTAMP</th><th width=110>EDIT</th></tr></thead><tbody>';

                    header+=response;
//                    header+='</tbody></table>';
                    $('section').html(header);
                    $('#demoajax').DataTable({
                        "aaSorting": [],
                        "pageLength": 10,
                        "sPaginationType":"full_numbers",
                        "aoColumnDefs" : [
                            { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ]
                    });
                    $('#tablecontainer').show();
                    sorting();
                }
                else
                {
                    $('#PE_nodataerrormsg').text(error_message[5]).show();
                    $('#PE_lbl_title').text(error_message[6]).hide();
                    $('#PE_btn_pdf').hide();
                    $('#tablecontainer').hide();
                }

            }

        });

    }

    function sorting(){
        jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
            var x = new Date( Date.parse(FormTableDateFormat(a)));
            var y = new Date( Date.parse(FormTableDateFormat(b)) );
            return ((x < y) ? -1 : ((x > y) ?  1 : 0));
        };
        jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
            var x = new Date( Date.parse(FormTableDateFormat(a)));
            var y = new Date( Date.parse(FormTableDateFormat(b)) );
            return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
        }
        jQuery.fn.dataTableExt.oSort['uk_timestp-asc']  = function(a,b) {
            var x = new Date( Date.parse(FormTableDateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
            var y = new Date( Date.parse(FormTableDateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
            return ((x < y) ? -1 : ((x > y) ?  1 : 0));
        };
        jQuery.fn.dataTableExt.oSort['uk_timestp-desc'] = function(a,b) {
            var x = new Date( Date.parse(FormTableDateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
            var y = new Date( Date.parse(FormTableDateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
            return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
        };
    }

    //FUNCTION FOR FORMTABLEDATEFORMAT
    function FormTableDateFormat(inputdate){
        var string = inputdate.split("-");
        return string[2]+'-'+ string[1]+'-'+string[0];
    }
// CLICK EVENT FOR EDIT BUTTON
    $(document).on('click','.ajaxedit',function(){
//        $('.ajaxedit').attr("disabled","disabled");
        $('#PE_entryformtable').show();
        $("#exsistingfiletable tr").remove();
        var combineid = $(this).parent().parent().attr('id');
        $("#PE_btn_update").attr("disabled", "disabled");
        var combineid_split=combineid.split('_');
        var edittrid=combineid_split[0];
        $('#PE_tb_id').val(combineid);
        var tds = $('#'+combineid).children('td');
        var tdstr = '';
        var td = '';
        pre_tds = tds;
        $('#PE_tb_prjectname').val($(tds[1]).html().trim());
        $('#PE_ta_prjdescrptn').val($(tds[2]).html());
        $('#PE_tb_sdate').val($(tds[5]).html());
        $('#PE_tb_edate').val($(tds[6]).html());
        $('#PE_btn_update').show();
        $('#PE_btn_Cancel').show();
        $('#PE_btn_save').hide();
        $('#PE_tb_statusupdate').val($(tds[4]).html()).show();
        $('#PE_entrystatus').hide();
        $('#PE_updatestatus').show();
        var filenames=$(tds[7]).html();
        var filenameinarray=filenames.split("/");
        for(var i=0;i<filenameinarray.length;i++)
        {
            var appendfile='<tr><td width="91%" align="left" valign="middle"><a href="download.php?filename='+filenameinarray[i]+'" class="links">'+filenameinarray[i]+'</a></tr></br>';
            $('#exsistingfiletable').append(appendfile);
        }
        if(filenames=="")
        {
            $('#attachafile').text('Attach a file');
        }
        else
        {
            $('#attachafile').text('Attach another file');
        }
        tdstr += "<td><input type='text' id='projectname' name='projectname'  class='autosize enable' style='font-weight:bold;' value='"+($(tds[0]).html()).trim()+"'></td>";
        tdstr += "<td><textarea id='projectdes' name='projectdes'  class='enable' value='"+$(tds[1]).html()+"'></textarea></td>";
        tdstr += "<td><input type='text' id='recver' name='recver' style='width:25px';  value='"+$(tds[2]).html()+"' readonly></td>";
        if($(tds[3]).html()=='STARTED'||$(tds[3]).html()=='REOPEN'){
            tdstr+="<td><select id='status' name='status' class='enable'><option value="+$(tds[3]).html()+">"+$(tds[3]).html()+"</option><option value='CLOSED'>CLOSED</option></select></td>";
        }
        else if($(tds[3]).html()=='CLOSED'){
            tdstr+="<td><select id='status' name='status' class='enable'><option value="+$(tds[3]).html()+">"+$(tds[3]).html()+"</option><option value='STARTED'>STARTED</option></select></td>";
        }
        tdstr+="<td nowrap><input type='text' id='std' name='start_date' style='width:75px'; class='PE_tb_edatedatepicker  enable datemandtry ' value='"+$(tds[4]).html()+"'></td>";
        tdstr+="<td nowrap><input type='text' name='end_date' id='PE_tb_enddate' style='width:75px'; class='PE_tb_edatedatepicker enable datemandtry' value='"+$(tds[5]).html()+"' ></td>";
        tdstr+="<td>"+$(tds[6]).html()+"</td>";
        tdstr+="<td nowrap>"+$(tds[7]).html()+"</td>";
        tdstr+="<td>"+updatebutton +" " + cancel+"</td>";
//        $('#'+combineid).html(tdstr);
        $('#projectdes').val($(tds[1]).html())
        $('.PE_tb_edatedatepicker').datepicker({
            dateFormat:"dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
        var PE_startdate=($('#PE_tb_sdate').val()).split('-');
        var day=PE_startdate[0];
        var month=PE_startdate[1];
        var year=PE_startdate[2];
        PE_startdate=new Date(year,month-1,day);

        var date = new Date( Date.parse( PE_startdate ));
        date.setDate( date.getDate()  );
        var PE_enddate = date.toDateString();
        PE_enddate = new Date( Date.parse( PE_enddate ));
        $('#PE_tb_edate').datepicker("option","minDate",PE_enddate);
        var max_date=new Date();
        var month=max_date.getMonth();
        var year=max_date.getFullYear()+2;
        var date=max_date.getDate();
        var max_date = new Date(year,month,date);
        $('#PE_tb_edate').datepicker("option","maxDate",max_date);

        $(".autosize").doValidation({rule:'general',prop:{autosize:true}});

        var PE_sdate=(comp_start_date).split('-');
        var day=PE_sdate[0];
        var month=PE_sdate[1];
        var year=PE_sdate[2];
        PE_sdate=new Date(year,month-1,day);
        $('#PE_tb_sdate').datepicker("option","minDate",PE_sdate);
        var max_date=new Date();
        var month=max_date.getMonth();
        var year=max_date.getFullYear()+2;
        var date=max_date.getDate();
        var max_date = new Date(year,month,date);
        $('#PE_tb_sdate').datepicker("option","maxDate",max_date);
    });
// UPDATE BUTTON VALIDATION
    $(document).on('change blur','.enable',function(){
        var projectname= $('#projectname').val();
        var projectsdate= $("#std").val();
        var projectstatus=$("#status").val();
        var projectdes=$("#projectdes").val().trim();
        var projectedate=$("#PE_tb_enddate").val();
        if((projectname!="") && (projectstatus!='') && (projectsdate!="") && (projectdes !="") && (projectedate!=""))
        {
            $("#PE_btn_update").removeAttr("disabled");
        }
        else
        {
            $("#PE_btn_update").attr("disabled", "disabled");
        }
    });
//CLICK EVENT FOR CANCEL BUTTON
    $(document).on("click",'.ajaxcancel', function (){
        $('.ajaxedit').removeAttr("disabled");
    });
//CLICK EVENT FOR UPDATE BUTTON
    $(document).on("click",'.ajaxedit', function (){
        var checkproject_name=$('#projectname').val();
        var rec_ver=$('#recver').val();
        if(checkproject_name!=''){
            $('.preloader', window.parent.document).show();
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    $('.preloader', window.parent.document).hide();
                    var check_array=(xmlhttp.responseText);
                    if(check_array==1){
                        $('#std').prop('disabled','disabled');
                    }
                    else
                    {
                        $('#std').removeAttr('disabled');
                    }
                }
            }
            var option='RANDOM';
            xmlhttp.open("GET","DB_PROJECT_PROJECT_ENTRY_SEARCH_UPDATE.php?checkproject_name="+checkproject_name+"&option="+option+"&recver="+rec_ver,true);
            xmlhttp.send();
        }
    });
// CLICK EVENT FOR UPDATE BUTTON
    $('section').on('click','.ajaxupdate',function(){
        $('.preloader', window.parent.document).show();
        var edittrid = $(this).parent().parent().attr('id');
        var combineid = $(this).parent().parent().attr('id');
        var combineid_split=combineid.split('_');
        var edittrid=combineid_split[0];
        var pdid=combineid_split[1];
        var projectname =  $("input[name='"+field_name[0]+"']");
        var projectdes = $("textarea[name='"+field_name[1]+"']");
        var prostatus =  $('#status').val();
        var projectsdate = $("input[name='start_date']");
        var projectedate =  $("input[name='end_date']");
        data = "&name="+projectname.val()+"&des="+projectdes.val()+"&sta="+prostatus+"&ssd="+projectsdate.val()+"&eed="+projectedate.val()+"&editid="+edittrid+"&pdid="+pdid+"&option=updateData";
        $.ajax({
            url:"DB_PROJECT_PROJECT_ENTRY_SEARCH_UPDATE.php",
            type:"POST",
            data:data,
            cache: false,
            success: function(response){
                $('.preloader', window.parent.document).hide();
                if(response==1){
                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"PROJECT ENTRY/SEARCH/UPDATE",msgcontent:error_message[3],position:{top:150,left:520}}});
                    showTable()
                    get_Values();
                }
                else if(response==0)
                {
                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"PROJECT ENTRY/SEARCH/UPDATE",msgcontent:error_message[4],position:{top:150,left:520}}});
                    showTable()
                    get_Values();
                }
                else
                {
                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"PROJECT ENTRY/SEARCH/UPDATE",msgcontent:response,position:{top:150,left:520}}});
                    showTable()
                    get_Values();
                }
            }
        });
    });
// CLICK EVENT FOR CANCEL BUTTON
    $('section').on('click','.ajaxcancel',function(){
        var edittrid = $(this).parent().parent().attr('id');
        $('#'+edittrid).html(pre_tds);
    });
    $(document).on('click','#PE_btn_pdf',function(){
        var url=document.location.href='COMMON_PDF.php?flag=17&title='+error_message[6];
    });
});
// READY FUNCTION ENDS
function formclear()
{
    $("#PE_btn_save").attr("disabled", "disabled");
    $("#PE_btn_update").attr("disabled", "disabled");
    $('#PE_tb_prjectname').val('');
    $('#PE_ta_prjdescrptn').val('');
    $('#PE_tb_status').val('');
    $('#PE_tb_sdate').val('');
    $('#PE_tb_edate').val('');
    $('#PE_tb_id').val('');
    $('#PE_lbl_erromsg').hide();
    PE_lbl_erromsg=0;
    $('#PE_tb_statusupdate').show().prop('selectedIndex',0);
    if($('#PE_tb_sdate').val())
    {
        var PE_startdate = $('#PE_tb_sdate').datepicker('getDate');
        var date = new Date( Date.parse( PE_startdate ));
        date.setDate( date.getDate()  );
        var PE_enddate = date.toDateString();
        PE_enddate = new Date( Date.parse( PE_enddate ));
        $('#PE_tb_edate').datepicker("option","minDate",PE_enddate);
        var max_date=new Date(PE_startdate);
        var month=max_date.getMonth();
        var year=max_date.getFullYear()+2;
        var date=max_date.getDate();
        var max_date = new Date(year,month,date);
        $('#PE_tb_edate').datepicker("option","maxDate",max_date);
    }
    else
    {
        $('.PE_tb_edatedatepicker').datepicker({
            dateFormat:"dd-mm-yy",
            maxDate: Date(),
            changeYear: true,
            changeMonth: true
        });
        var max_date=new Date();
        var month=max_date.getMonth();
        var maxyear=max_date.getFullYear()+2;
        var minyear=max_date.getFullYear()-2;
        var date=max_date.getDate();
        var max_date = new Date(maxyear,month,date);
        var min_date = new Date(minyear,month,date);
        $('#PE_tb_edate').datepicker("option","minDate",min_date);
        $('#PE_tb_edate').datepicker("option","maxDate",max_date);
        $('#PE_tb_sdate').datepicker("option","minDate",min_date);
        $('#PE_tb_sdate').datepicker("option","maxDate",max_date);
    }
}
//FORM SHOW BUTTONS
$(document).on('click','#PE_btn_addnew',function(){
    $('#PE_btn_save').show();
    $('#PE_entryformtable').show();
    $('#PE_btn_Removeform').removeAttr('disabled');
    $('#PE_btn_update').hide();
    $("#filetableuploads tr").remove();
    $("#exsistingfiletable tr").remove();
    $('#attachafile').text('Attach a file');
    $('#PE_updatestatus').hide();
    $('#PE_entrystatus').show();
    formclear();
});

$(document).on('click','.PE_formhide',function(){
    $('#PE_entryformtable').hide();
    $("#PE_btn_Removeform").attr("disabled", "disabled");
    formclear();
    showTable();
    get_Values();
    $("#filetableuploads tr").remove();
    $("#exsistingfiletable tr").remove();
    $('#attachafile').text('Attach a file');
    $('#PE_updatestatus').hide();
    $('#PE_entrystatus').show();

});
</script>
</head>
<!--HEAD TAG END-->
<!--BODY TAG START-->
<body>
<div class="wrapper">
    <div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="image/Loading.gif"  /></div></div></div>
    <div class="newtitle" id="fhead" ><div style="padding-left:500px; text-align:left;"><p><h3>PROJECT ENTRY/SEARCH/UPDATE</h3><p></div></div>

    <form  name="PE_form_projectentry" id="PE_form_projectentry" method="post" class="newcontent">
        <div id="PE_entryformtable" hidden>
            <table id="PE_tble_projectentry">
                <tr>
                    <td><label name="PE_lbl_prjectname" id="PE_lbl_prjectname">PROJECT NAME<em>*</em></label></td>
                    <td><input type="text" name="PE_tb_prjectname" id="PE_tb_prjectname" class="valid autosize" maxlength='50'>  <label id="PE_lbl_erromsg" class="errormsg"></label></td>
                    <td><input type="text" id="PE_tb_id" name="PE_tb_id" style="width:50px;" class="valid" hidden></td>
                </tr>
                <tr>
                    <td><label name="PE_lbl_prjdescrptn" id="PE_lbl_prjdescrptn">PROJECT DESCRIPTION<em>*</em></label></td>
                    <td><textarea  name="PE_ta_prjdescrptn" id="PE_ta_prjdescrptn" class="maxlength valid"></textarea></td>
                </tr>
                <tr id="PE_entrystatus">
                    <td><label name="PE_lbl_status" id="PE_lbl_status" >STATUS<em>*</em></label></td>
                    <td><input type="text" id="PE_tb_status" name="PE_tb_status" style="width:100px;" class="valid" readonly></td>
                </tr>
                <tr id="PE_updatestatus" hidden>
                    <td><label name="PE_lbl_status" id="PE_lbl_status" >STATUS<em>*</em></label></td>
                    <td><select name="PE_tb_statusupdate" id="PE_tb_statusupdate" class="valid" readonly hidden>
                            <option>STARTED</option>
                            <option>CLOSED</option>
                        </select></td>
                </tr>
                <tr>
                    <td><label name="PE_lbl_sdate" id="PE_lbl_sdate" >START DATE<em>*</em></label></td>
                    <td><input type="text" name="PE_tb_sdate" id="PE_tb_sdate" style="width:75px;" class="PE_tb_sdatedatepicker valid datemandtry "></td>
                </tr>
                <tr>
                    <td><label name="PE_lbl_edate" id="PE_lbl_edate" >END DATE<em>*</em></label></td>
                    <td><input type="text" name="PE_tb_edate" id="PE_tb_edate" style="width:75px;" class="PE_tb_edatedatepicker valid datemandtry"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td>
                        <table ID="exsistingfiletable">

                        </table>
                        <table ID="filetableuploads">

                        </table>
                    </td>
                </tr>
                <tr>
                    <td><label></label></td>
                    <td>
                        <span id="attachprompt"><img width="15" height="15" src="https://ssl.gstatic.com/codesite/ph/images/paperclip.gif" border="0">
                        <a href="javascript:_addAttachmentFields('attachmentarea')" class="valid" id="attachafile">Attach a file</a>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td><table><tr><td><input type="button" class="btn PE_btn_save" name="PE_btn_save" id="PE_btn_save"  value="Save" disabled ></td>
                    <td><input type="button" class="btn PE_btn_save" name="PE_btn_Update" id="PE_btn_update"  value="Update" disabled></td>
                    <td><input type="button" class="btn PE_formhide" name="PE_btn_Cancel" id="PE_btn_Cancel"  value="Cancel"></td></tr></table></td>
                </tr>
            </table>
        </div>
        <div>
            <label class="errormsg" id="PE_nodataerrormsg" hidden></label>
        </div>
        <div>
            <label class="srctitle" id="PE_lbl_title" hidden></label>
        </div>
        <div>
            <input type="button" id="PE_btn_addnew" class="btnpdf" style="background-color:#006400;width:100px;" value="Add New" title="Add New Project">
            <input type="button" id="PE_btn_pdf" class="btnpdf" value="PDF">
        </div>
        <div class="container" id="tablecontainer" hidden>
            <section>
            </section>
        </div>
    </form>

</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->