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
$cs ->registerScriptFile($baseUrl.'/js/appscripts.js', CClientScript::POS_END);

$cs->registerCssFile($baseUrl.'/css/app-pos.css');
$cs->registerCssFile($baseUrl.'/css/app-pos-nav.css');
?>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
 <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">POS- Back Office</a>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <?php       
        $menuCss = 'nav navbar-nav';
        $submenuCss = 'dropdown-menu';
        echo $this->getMenu($menuCss);
      
        if ( !Yii::app()->user->isGuest )
        {
            echo $this->getUserMenu();
            echo $this->getCustomersMenu();            
            echo $this->getProductsMenu();
            echo $this->getSuppliersMenu();
            echo $this->getCategoriesMenu();
        }
      ?>      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container">
<?php echo $content; ?>
</div>
<input type="hidden" id="homeurl" value="<?php echo Yii::app()->homeUrl ;?>"/>
<input type="hidden" id="logouturl" value="<?php echo Yii::app()->createUrl(Helper::CONST_logouturl); ?>"/>
<form id="logoutform" action="<?php echo Yii::app()->createUrl(Helper::CONST_logouturl); ?>" method="post">
<input type="hidden" id="clbalance" name="clbalance"/>
</form>
<?php
//    if (Yii::app()->components['user']->loginRequiredAjaxResponse){
//        Yii::app()->clientScript->registerScript('ajaxLoginRequired', '
//            jQuery("body").ajaxComplete(
//                function(event, request, options) {
//                    if (request.responseText == "'.Yii::app()->components['user']->loginRequiredAjaxResponse.'") {
//                        //window.location.href = options.url;
//                        //window.location.href = "'.Yii::app()->createUrl(Helper::CONST_loginurl).'"
//                        window.location.href = "'.Yii::app()->getRequest()->getRequestUri().'"
//                    }
//                }
//            );
//        ');
//    }
?>
</body>
</html>