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

        });
    </script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>TICKLER HISTORY</b></h4></div>
    <form id="tickler_form" name="tickler_form" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group" id="tickler_customer">
                    <label class="col-sm-2">CUSTOMER NAME</label>
                    <div class="col-sm-4"><input type="text" name="tickler_tb_customer" id="tickler_tb_customer" class="tickler_erntryform custnamevalidate form-control" placeholder="Customer Name"/></div>
                </div>
                <div class="form-group" id="tickler_custerror" hidden>
                    <div class="col-sm-offset-2 col-sm-5">
                        <label id="tickler_lbl_notmatch" name="tickler_lbl_notmatch" class="errormsg"></label>
                    </div>
                </div>
                <div id="tickler_btn">
                    <input type="button" name="tickler_btn_search" id="tickler_btn_search" class="btn btn-info" value="SEARCH" disabled/>
                </div>
                <div id="tickler_div_header" class="srctitle" style="padding-top: 15px" hidden></div>
                <div id="tickler_div_nodata" class="errormsg" style="padding-top: 10px" hidden></div>
                <div id="tickler_div_htmltable" class="table-responsive">
                    <section>
                    </section>
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>