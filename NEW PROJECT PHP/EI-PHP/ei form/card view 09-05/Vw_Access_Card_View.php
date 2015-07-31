<?php
require_once "Header.php";
?>
<html>
<head>
    <script type="text/javascript">
        // document ready function
        $(document).ready(function(){
        // initial data
            $('#spacewidth').height('0%');
            var CV_errorAarray=[];
            var CV_cust_array=[];
            var CV_customername=[];
            var CV_customerflag;
            $.ajax({
                type:'POST',
                url:"<?php echo site_url('Ctrl_Access_Card_View/Initialdata'); ?>",
                data:{'ErrorList':'51,47,18,96,97,98,248,327,249,369'},
                success: function(data){
                    var value_array=JSON.parse(data);
                    CV_load_initial_values(value_array);
                    CV_customername_autocompleteresult(value_array[4]);
                }
            });
        // FUNCTION TO LOAD INITIAL VALUES
            function CV_load_initial_values(initial_values){
                CV_errorAarray=initial_values[3];
                var CV_unitarray=initial_values[0];
                var CV_cust_config=initial_values[2];
                var CV_cardno_array=initial_values[1];
                $('#CV_lbl_custautoerrmsg').text(CV_errorAarray[9].EMC_DATA);
                var CV_search_options ='<option>SELECT</option>';
                for (var i = 0; i < CV_cust_config.length; i++) {
                    var CV_configarray=CV_cust_config[i].split('_');
                    var CV_config_id=CV_configarray[0];
                    var CV_config_data=CV_configarray[1];
                    CV_search_options += '<option value="' + CV_config_id + '">' + CV_config_data + '</option>';
                }
                $('#CV_lb_searchby').html(CV_search_options);
                if(CV_unitarray.length!=0){
                    var CV_unitno_options ='<option value="SELECT">SELECT</option>';
                    for (var i = 0; i < CV_unitarray.length; i++) {
                        CV_unitno_options += '<option value="' + CV_unitarray[i] + '">' + CV_unitarray[i] + '</option>';
                    }
                    $('#CV_lb_unitno').html(CV_unitno_options);
                }
                else{
                    $('#card_view_form').replaceWith('<form id="card_view_form" class="form-horizontal content" role="form"><div class="panel-body"><fieldset><div class="form-group"><label class="errormsg"> '+CV_errorAarray[6].EMC_DATA+'</label></div></fieldset></div></form>');
                    $(".preloader").hide();
                }
                var CV_cardno_options ='<option>SELECT</option>';
                for (var i = 0; i < CV_cardno_array.length; i++) {
                    CV_cardno_options += '<option value="' + CV_cardno_array[i] + '">' + CV_cardno_array[i] + '</option>';
                }
                $('#CV_lb_cardno').html(CV_cardno_options);
                var CV_custname_options ='<option>SELECT</option>';
            }
        // FUNCTION TO HIGHLIGHT SEARCH TEXT
            function CV_highlightSearchText() {
                $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                    var re = new RegExp(this.term, "i") ;
                    var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                    return $( "<li></li>" )
                        .data( "item.autocomplete", item )
                        .append( "<a>" + t + "</a>" )
                        .appendTo( ul );
                };
            }
        // FUNCTION TO AUTOCOMPLETE SEARCH TEXT
            function CV_customername_autocompleteresult(response)
            {
                CV_customername=response;
                $("#CV_tb_custname").val('');
            }
            $("#CV_tb_custname").keypress(function(e){
                CV_customerflag=0;
                CV_highlightSearchText();
                $("#CV_tb_custname").autocomplete({
                    source: CV_customername,
                    select:CV_AutoCompleteSelectHandler
                });
            });
        // FUNCTION TO GET SELECTED VALUE
            function CV_AutoCompleteSelectHandler(event, ui) {
                CV_customerflag=1;
                $('#CV_lbl_custautoerrmsg').hide();
            }
            $(document).on('blur change','.CV_customerautovalidate',function(){
                if(CV_customerflag==1){
                    $('#CV_lbl_custautoerrmsg,#CV_div_htmltable,#CV_headermsg').hide();
                    $('#CV_tble_id > div').remove();
                    $('#CV_btn_search').removeAttr("disabled");
                }
                else
                {
                    $('#CV_lbl_custautoerrmsg').show();
                    $("#CV_btn_search").attr("disabled", "disabled");
                    $('#CV_errmsg,#CV_div_htmltable,#CV_headermsg').hide();
                    $('#CV_tble_id > div').remove();
                }
                if($('#CV_tb_custname').val()=='')
                {
                    $('#CV_lbl_custautoerrmsg,#CV_div_htmltable,#CV_headermsg,#CV_errmsg').hide();
                    $("#CV_btn_search").attr("disabled", "disabled");
                    $('#CV_tble_id > div').remove();
                }
            });
        // SEARCH BY CHANGE EVENT
            $('#CV_lb_searchby').change(function(){
//                $(".preloader").show();
                if($(this).val()==31)
                {
                    $(".preloader").hide();
                    $('#CV_cardno,#CV_custname,#CV_lbl_custautoerrmsg,#CV_div_htmltable,#CV_headermsg,#CV_errmsg').hide();
                    $('#CV_lb_cardno').val('SELECT');
                    $('#CV_lb_unitno').val('SELECT');
                    $('#CV_unitno').show();
                    $('#CV_tb_custname').val("");
                    $('#CV_tble_id > div').remove();
                    $('#CV_btn_search').attr("disabled","disabled");
                }
                else if($(this).val()==18)
                {
                    $(".preloader").hide();
                    $('#CV_unitno,#CV_custname,#CV_lbl_custautoerrmsg,#CV_div_htmltable,#CV_headermsg,#CV_errmsg').hide();
                    $('#CV_lb_cardno').val('SELECT');
                    $('#CV_lb_unitno').val('SELECT');
                    $('#CV_tb_custname').val("");
                    $('#CV_cardno').show();
                    $('#CV_tble_id > div').remove();
                    $('#CV_btn_search').attr("disabled","disabled");
                }
                else if($(this).val()==21)
                {
                    $(".preloader").hide();
                    $('#CV_unitno,#CV_cardno').hide();
                    if(CV_customername.length!=0){
                        $('#CV_errmsg').hide();
                        $('#CV_custname').show();
                    }
                    else{
                        var msg=CV_errorAarray[7].EMC_DATA;
                        $('#CV_lbl_errmsg').text(msg).show();
                        $('#CV_errmsg').show();
                        $('#CV_custname').hide();
                    }
                    $('#CV_div_htmltable,#CV_headermsg').hide();
                    $('#CV_lb_cardno').val('SELECT');
                    $('#CV_lb_unitno').val('SELECT');
                    $('#CV_tble_id > div').remove();
                }
                else if($(this).val()==40){
//                    $(".preloader").show();
                    $('#CV_unitno,#CV_cardno,#CV_custname,#CV_lbl_custautoerrmsg,#CV_div_htmltable,#CV_headermsg,#CV_errmsg').hide();
                    $('#CV_lb_cardno').val('SELECT');
                    $('#CV_lb_unitno').val('SELECT');
                    $('#CV_tb_custname').val("");
                    $('#CV_tble_id > div').remove();

//                    google.script.run.withFailureHandler(CV_error).withSuccessHandler(CV_loadcardno_details).CV_get_cardno_details('','',$(this).val())
                }
                else if($(this).val()=='SELECT')
                {
                    $(".preloader").hide();
                    $('#CV_unitno,#CV_cardno,#CV_custname,#CV_lbl_custautoerrmsg,#CV_div_htmltable,#CV_headermsg,#CV_errmsg').hide();
                    $('#CV_lb_cardno').val('SELECT');
                    $('#CV_lb_unitno').val('SELECT');
                    $('#CV_tb_custname').val("");
                    $('#CV_tble_id > div').remove();
                    $('#CV_btn_search').hide().attr("disabled","disabled");
                }
            });
            
        });
    </script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>VIEW ALL CARD</b></h4></div>
    <form id="card_view_form" name="card_view_form" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group" id="CV_searchby">
                    <label class="col-sm-2">SEARCH BY <em>*</em></label>
                    <div class="col-sm-3"> <select name="CV_lb_searchby" id="CV_lb_searchby" class="form-control CV_formvalidation"></select></div>
                </div>
                <div class="form-group" id="CV_cardno" hidden>
                    <label class="col-sm-2">CARD NUMBER <em>*</em></label>
                    <div class="col-sm-2"><select name="CV_lb_cardno" id="CV_lb_cardno" class="CV_formvalidation form-control"></select></div>
                </div>
                <div class="form-group" id="CV_custname" hidden>
                    <label class="col-sm-2" id="CV_lbl_custname">CUSTOMER NAME <em>*</em></label>
                    <div class="col-sm-4"><input type="text" name="CV_tb_custname" id="CV_tb_custname" class="auto CV_customerautovalidate form-control"/></div>
                    <input class="btn btn-info" type="button" id="CV_btn_search" name="search" value="SEARCH" disabled/>
                    <lable id="CV_lbl_custautoerrmsg" class="errormsg" hidden></lable>
                </div>
                <div class="form-group" id="CV_unitno" hidden>
                    <label class="col-sm-2">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"> <select name="CV_lb_unitno" id="CV_lb_unitno" class="form-control CV_formvalidation"></select></div>
                </div>
                <div id='CV_tble_id' name='CV_tble_id' hidden>
                </div>
                <div class="form-group" id='CV_headerdiv'>
                    <lable class="col-lg-6 srctitle" id="CV_headermsg"></lable>
                </div>
                <div class="table-responsive" id="CV_div_htmltable">
                    <section>
                    </section>
                </div>
                <div class="form-group" id="CV_errmsg" hidden>
                    <lable id="CV_lbl_errmsg" class="col-sm-4 errormsg"></lable>
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>