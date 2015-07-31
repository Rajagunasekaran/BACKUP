<html lang="en">
<head>
<?php
$baseUrl = Yii::app()->request->baseUrl;
$themePath = (!is_null(Yii::app()->theme))?Yii::app()->theme->baseUrl:$baseUrl;
$cs = Yii::app()->clientScript;
$cs->scriptMap=array(
                //'bootstrap-yii.css'=>false,
            );
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('jquery.ui');
$cs->registerCssFile($baseUrl.'/css/login_custom.css');
$cs->registerCssFile($baseUrl.'/css/animate.min.css');
$cs->registerCssFile($baseUrl.'/css/animate.delay.css');
$cs->registerScript('tooltip',
    "$('#login-form').submit(function(){
            var u = jQuery('#username').val();
            var p = jQuery('#password').val();
            if(u == '' && p == '') {
                jQuery('.login-alert').fadeIn();
                return false;
            }
        });"
    ,CClientScript::POS_READY);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body class="loginpage">
<div class="loginpanel">
    <div class="loginpanelinner">
        <div class="logo animate0 bounceIn"><a><?php echo CHtml::encode($this->pageTitle); ?></a></div>
        <?php echo $content; ?>
    </div><!--loginpanelinner-->
</div><!--loginpanel-->

<div class="loginfooter">
    <p><?php echo CHtml::encode($this->pageTitle); ?></a></p>
</div>
</body>
</html>