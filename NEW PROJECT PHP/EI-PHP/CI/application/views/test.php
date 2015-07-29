<?php
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
    <script>
        //READY FUNCTION START
        $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sample/initialdata'); ?>",
                success: function(data){
                    alert(data)
                    var value=JSON.parse(data);
                    $('#userrole').append($('<option> SELECT </option>'));
                    for(var j=0;j<value[0].length;j++)
                    {
                        var id=value[0][j].rc_id;
                        var data=value[0][j].rc_name;
                        $('#userrole').append($('<option>').text(data).attr('value', id));
                    }

                    if(value[1].length!=0)
                    {
                        var DT_table_header='<table id="DT_tbl_htmltable" border="1"  cellspacing="0" class="srcresult"><thead  bgcolor="#6495ed" style="color:white"><tr><th></th><th style="text-align: center">EMPLOYEE NAME</th><th style="text-align: center">USER NAME</th><th style="text-align: center">PASSWORD</th><th style="text-align: center">ROLE</th><th style="text-align: center">EMAIL ID</th><th style="text-align: center">TIMESTAMP</th></tr></thead><tbody>';
//
                        for(var i=0;i<value[1][i].length;i++){
                            DT_table_header+='<tr><td style="text-align: center"><input type="radio" name="DT_UPD_rd_flxtbl" class="DT_UPD_class_radio" id='+value[1][i][0]+' value='+value[1][i][0]+'></td><td nowrap>'+value[1][i][1]+'</td><td style="text-align: center"> '+value[1][i][2]+'</td><td> '+value[1][i][3]+'</td><td style="text-align: center"> '+value[1][i][4]+'</td><td >'+value[1][i][5]+'</td><td style="text-align: center" nowrap>'+value[1][i][6]+'</td></tr>';
                        }
                        $('#tablecontainer').show();
                        DT_table_header+='</tbody></table>';
//                        $('section').html(DT_table_header);
                        alert(DT_table_header)
//                    $('#DT_tbl_htmltable').DataTable({
//                        "aSorting": [],
//                        "pageLength": 10,
//                        "sPaginationType":"full_numbers"
//                    }
                    }
                    else{
                        alert('no data available');
                    }
                }
            });
            $("#username").doValidation({rule:'alphanumeric',prop:{whitespace:true,uppercase:false,autosize:true}});
            $("#employee").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
            $(document).on("keyup",'.alpha',function() {
                if (this.value.match(/[^a-zA-Z0-9\-\ \.\,\/]/g)) {
                    this.value = this.value.replace(/[^a-zA-Z0-9\-\ \.\,\/]/g, '');
                }
            });
            function UserFormClear()
            {
                $('#employee').val('');
                $('#username').val('');
                $('#password').val('');
                $('#useremail').val('');
                $('#userrole').val('SELECT');
                $('#uid').val('');
                $('#already_exist_error').removeClass('has-error');
                $('#already_exist_error_password').removeClass('has-error');
                $('#already_exist_error_email').removeClass('has-error');
            }
            $(document).on('click','#AddNewRow',function(){
                var formdata = $('#loginformdetails').serialize();
                alert(formdata)
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('sample/saveuser'); ?>",
                    data: formdata,
                    dataType: "json",
                    success: function(data){
                        UserFormClear();
                        alert('user created successfully');
                    },
                    error: function() {
                        alert("user not created");
                    }
                });

            });
            $("input.autosize").autoGrowInput();
        });
    </script>
</head>
<body>
<br><br><br>
<div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
<div class="container col-lg-12 pull-left">
    <div class="panel panel-info" >
        <div class="panel-heading">
            <h3 class="panel-title" >USER CREATION</h3>
        </div>
        <div class="panel-body">
            <form id="loginformdetails" class="form-horizontal">
                <fieldset id="user_form">
                    <div class="row form-group">
                        <div class="col-md-3" id="already_exist_errorname">
                            <label>EMPLOYEE NAME<span class="labelrequired"><em>*</em></span></label>
                            <input class="form-control autosize special validation textboxwidth alphabet" name="employee" maxlength="40" required id="employee" placeholder="Employee Name"/>
                        </div>
                        <div class="col-md-3" id="already_exist_error">
                            <label>USER NAME<span class="labelrequired"><em>*</em></span></label>
                            <input class="autosize form-control special validation textboxwidth alphanumeric usernamechk" name="username" maxlength="40" required id="username" placeholder="User Name"/>
                        </div>
                        <div class="col-md-3" id="already_exist_error_password">
                            <label>PASSWORD<span class="labelrequired"><em>*</em></span></label>
                            <input class="form-control autosize special validation textboxwidth chk_password" name="password" id="password" maxlength="20"  required type="password" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3" id="already_exist_error_email">
                            <label>EMAIL<span class="labelrequired"><em>*</em></span></label>
                            <input type="text" class="autosize form-control validation emailcheck textboxwidth" name="useremail" maxlength="50" required id="useremail" placeholder="Email">
                        </div>
<!--                        <div class="col-md-3 selectContainer">-->
<!--                            <label>ROLE<span class="labelrequired"><em>*</em></span></label>-->
<!--                            <select class="form-control autogrow validation textboxwidth" id="userrole" name="userrole">-->
<!--                                <option>dsfdsfdf</option>-->
<!--                                <option>LJSFDJLKDSJFLKDSJFDSJFDSJFDSJFLDSJFFSDFDSF</option>-->
<!--                                <option>SLKDJFLKDSF</option>-->
<!--                                <option>3HRHOWHEWOIOIEWIIOROIEW</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <input type="hidden" id="uid" name="uid">-->
                    </div>
<!--                    <div class="col-lg-7 col-lg-offset-10" style="padding-bottom: 5px;padding-left: 46px">-->
<!--                        <button type="button" id="sv_btn_addrow" class="btn btngradient" disabled>SAVE</button>-->
<!--                        <button type="button" id="update_btn_addrow" class="btn btngradient" disabled>UPDATE</button>-->
<!--                        <button type="button" id="cancel_btn_addrow" class="btn btngradient" >CANCEL</button>-->
<!--                    </div>-->
                </fieldset>
                <div class="col-lg-offset-11" style="padding-bottom: 15px; padding-left: 12px">
                    <button type="button" id="AddNewRow" class="btn btngradient addmewbtn">ADD USER</button>
                </div>
                <div id="tablecontainer" hidden>
                    <section >
                    </section>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
