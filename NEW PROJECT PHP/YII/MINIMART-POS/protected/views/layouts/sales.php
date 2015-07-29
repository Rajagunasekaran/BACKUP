<?php /* @var $this Controller */ ?>
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
$cs->registerCoreScript('jquery.datatable');
$cs->registerCoreScript('cookie');
$cs ->registerScriptFile($baseUrl.'/js/appscripts.js', CClientScript::POS_END);
$cs ->registerScriptFile($baseUrl.'/js/moment-with-langs.js', CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/font-awesome.min.css');
$cs->registerCssFile($baseUrl.'/css/sales.css');
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
<div id="wrapper">
    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo Yii::app()->name ?></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <?php 
                $menuCss = 'nav nav-sidebar';
                $submenuCss = 'dropdown-menu';
                
                //echo $this->getMenu($menuCss);
                if ( !Yii::app()->user->isGuest )
                {
                    echo $this->getUserMenu();
                }
//                 $this->widget(
//                    'booster.widgets.TbPanel',
//                    array(
//                    'title' => 'Navigation Panel',
//                    'context' => 'primary',
//                    'headerIcon' => 'success',
//                    'content' => $this->getMenu(),
//                    'padContent' => false,
//                    'htmlOptions' => array('style' => 'min-height:100px;')
//                    )
//                );
            ?>
    </nav>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-3 sidebar">
                    <div class="collapse navbar-collapse navbar-ex1-collapse">           
            <?php
                echo $this->getMenu($menuCss);                
            ?>
        </div><!-- /.navbar-collapse -->
                </div>
                <div class="col-lg-9 col-md-9 col-md-offset-3 col-sm-offset-3 main">
                <?php echo $content; ?>
            </div>
            </div>            
        </div>
    </div>
</div>
</body>
</html>