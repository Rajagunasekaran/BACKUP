<!DOCTYPE html>
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
$cs->registerCssFile($baseUrl.'/css/login_cr/login.css');
$cs->registerCssFile($baseUrl.'/css/login_cr/loader.css');
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<!-- Viewport metatags -->
<meta name="HandheldFriendly" content="true" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body class="loginpage">
<div id="da-login">
	<div id="da-login-box-wrapper">
    	<div id="da-login-top-shadow">
        </div>
    	<div id="da-login-box">
            <div id="da-login-box-header">
                <h1 style="margin:0;text-align: center"><?php echo CHtml::encode($this->pageTitle); ?></h1>
            </div>
            <div id="processing" class="loader" style="display: none"></div>           
            <div id="da-login-box-content">
            	<?php echo $content; ?>
            </div>
            <div id="da-login-box-footer">
            	<!--<a href="#">forgot your password?</a>-->
                <div id="da-login-tape"></div>
            </div>
        </div>
    	<div id="da-login-bottom-shadow">
        </div>
    </div>
</div>
</body>
</html>