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
$cs->registerCssFile($baseUrl.'/css/poslogin.css');
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    <div id="wrapper">
        <?php echo $content; ?>
    </div>
    <div class="gradient"></div>
</body>
</html>