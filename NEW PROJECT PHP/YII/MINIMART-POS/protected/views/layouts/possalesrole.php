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
$cs->registerCoreScript('jquery.datatable');
$cs->registerCoreScript('cookie');
$cs ->registerScriptFile($baseUrl.'/js/typeahead.bundle_0_10_5.js', CClientScript::POS_END);
$cs ->registerScriptFile($baseUrl.'/js/jquery.mobile-1.2.0.min.js', CClientScript::POS_END);
$cs ->registerScriptFile($baseUrl.'/js/appscripts.js', CClientScript::POS_END);

$cs->registerCssFile($baseUrl.'/css/typeahead.css');
$cs->registerCssFile($baseUrl.'/css/imagelist_style.css');
$cs->registerCssFile($baseUrl.'/css/jquery.mobile-1.2.0.min.css');
$cs->registerCssFile($baseUrl.'/css/pos.css');
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
<?php 
$prdsurl = Yii::app()->controller->createUrl('order/'.Helper::CONST_getAllProducts);
$posSaveBillUrl = Yii::app()->controller->createUrl('order/'.Helper::CONST_posSaveBill);
$dashboardUrl = Yii::app()->controller->createUrl('site/'.Helper::CONST_indexactionid);
$titletext = '<div style="float:left">Bill Details</div>';
$modedisplay = '<label id="txtcurrentmode"></label>';
$titleItemsbtn = '<div style="float: right">
                <button type="button" class="btn btn-primary" onclick="loadTopCategories();">Items</button></div>';
$refundconfirmbtn = '<button 
                id="refundconfirmbtn" 
                type="button" 
                style="display:none"
                class="btn btn-primary" 
                onClick="confirmRefund(\'' . $posSaveBillUrl . '\');"' . '>Confirm Refund</button>';
$cancelconfirmbtn = '<button 
                id="cancelconfirmbtn" 
                type="button" 
                style="display:none"
                class="btn btn-primary" 
                onClick="confirmCancel(\'' . $posSaveBillUrl . '\');"' . '>Confirm Cancel</button>';        
$titlehtml = $modedisplay;//. $refundconfirmbtn . $cancelconfirmbtn;//
?>
<div id="posclient-main">
	<div class="container-fluid" id="posclient-nav">
            <a href="#">Point Of Sale</a>
            <?php if($this->isSUorAdmin()): ?>
            <button type="button" class="btn btn-default navbar-right" onclick="js:document.location.href='<?php echo $dashboardUrl; ?>'">Dashboard</button>
            <?php endif; ?>            
            <?php if($this->isSales()): ?>
            <button type="button" class="btn btn-default navbar-right" onclick="logout(event);">Exit</button>
            <?php endif; ?>
	</div>

	<?php echo $content; ?>

	<?php
	/*$this->beginWidget(
			'booster.widgets.TbPanel', array(
		'title' => false,
		'context' => 'success',
		'headerIcon' => 'info',
		'padContent' => false,
		'htmlOptions' => array(
			'id'=>'posclient-actions',
			'class'=>'panel-without-margin'
			)
		)
	);*/
	?>
	<div class="container-fluid" id="posclient-actions">
		<div class="row row-without-margin">     
			<div class="col-md-12 col-onlyleft-padding center">
				<button type="button" class="btn btn-hold" id="holdBtn" onclick="holdBillBtnClick();">Hold</button>
				<button type="button" class="btn btn-held"  id="heldBillsBtn" onclick="heldBillsBtnClick();">Held Bills</button>
				<button type="button" class="btn btn-close" id="clsRgstrBtn" onclick="updateRegisterbalance(2);">Close Register</button>
                                <button type="button" class="btn btn-primary" id="syncPrdMstrBtn" onclick="syncProductMasters('<?php echo $prdsurl;?>',2);">Sync Products</button>				
                                <button type="button" class="btn btn-exchange" id="exchangeBtn" onclick="exchangeBtnClick();">Exchange</button>
				<button type="button" class="btn btn-refund" id="refundBtn" onclick="refundBtnClick();">Refund</button>
				<button type="button" class="btn btn-danger" id="cancelBtn" onclick="cancelBtnClick();">Bill Cancel</button>
				<button type="button" class="btn btn-primary" onclick="resetALL();">RESET</button>
				<?php echo $refundconfirmbtn; ?>
				<?php echo $cancelconfirmbtn; ?>
			</div>
		</div>
	</div>
	<?php //$this->endWidget(); ?>
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