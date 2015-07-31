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
$cs ->registerScriptFile($baseUrl.'/js/appscripts.js', CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/main_cr/reset.css');
$cs->registerCssFile($baseUrl.'/css/main_cr/fluid.css');
$cs->registerCssFile($baseUrl.'/css/main_cr/main.css');
//$cs->registerCssFile($baseUrl.'/css/main_cr/panel.css');
//$cs->registerCssFile($baseUrl.'/css/main_cr/buttons.css');
$cs->registerCssFile($baseUrl.'/css/main_cr/app.css');
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<!-- Viewport metatags -->
<meta name="HandheldFriendly" content="true" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>	
</head>
<body>
<div id="da-wrapper" class="fluid">
	<!-- Header -->	
        <div id="da-header">
		<div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 logo">
                        <h1><?php echo CHtml::encode(Yii::app()->name); ?></h1>
                        </div>
                        <div class="col-md-6">
                        <?php
                            if ( !Yii::app()->user->isGuest )
                            {
                                echo $this->getUserMenu();
                            }
                        ?>
                        </div>
                    </div>                                                            
		</div>
		<div id="da-header-mid">
                    <?php 
                    $menuCss = 'mainNav';
                    $submenuCss = 'dropdown-menu';
                    echo $this->getMenu($menuCss);                
                ?>
		</div>
		<div id="da-header-bottom">
			<!-- Container -->
                    <div class="da-container clearfix">
                            <!-- Breadcrumbs -->
                            <div id="da-breadcrumb">
                                <ul>
                                    <li class="active" id="curpage"><?php echo CHtml::encode($this->pageTitle); ?></li>
                                </ul>
                            </div>
                    </div>
		</div>
	</div>
	<!-- Content -->
	<div class="container-fluid">
           <div id="da-content-area">
                <?php echo $content; ?>
            </div>
	</div>
	<!-- Footer -->
	<div class="footer">
            <div class="da-container clearfix">
                <?php echo CHtml::encode(Yii::app()->name); ?>
            </div>
	</div>
</div>
</body>
</html>