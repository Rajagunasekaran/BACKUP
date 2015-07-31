<?php
$this->breadcrumbs=array(
	'Productprices'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Productprice','url'=>array('index')),
array('label'=>'Create Productprice','url'=>array('create')),
);
Yii::app()->clientScript->registerScript('refresh_page',"
window.onload = function() {
$('#expiryDate').hide();
$('#productPriceCode').hide();
$('#productName').hide();
};
");
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('productprice-grid', {
data: $(this).serialize()
});
return false;
});
");
?>
<H3 style="color:#0000FF"> Purchase Details</H3>
<div class="search-form" >
       <?php $this->renderPartial('_searchExpiry',array(
       'model'=>$model,
)); ?>
</div>

<div type="text" id="resultdiv"></div>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'productprice-form',
	'enableAjaxValidation'=>false,
));
?>
<?php
//$onsavejs ='js: function(e, params) {
//                //alert("saved value: "+params.newValue);
//            }';
//$onsuccessjs = 'js: function(data, newValue) {
//                    //alert(data.message);
//                    $("#resultdiv").text(data.message);
//                    $.fn.yiiGridView.update("productprice-grid");
//                }';
//    $this->widget('booster.widgets.TbButton', array(
//    'buttonType' => 'ajaxSubmit',
//    'context'=>'primary',
//    'label'=>'Update Stocks',
//    'url' => Yii::app()->createUrl('productprice/' . Helper::CONST_bulkupdateProductStockAjax),
//    'ajaxOptions' => array(
//        'dataType' => 'json',
//        'success'=> $onsuccessjs,
//        ),
//    'htmlOptions' => array(
//        'id' => 'bulkUpdateStockBtn',
//        'onclick'=>'js:updateGridSubmitResult("Wait...");',
//        'class'=>'right',
//        )
//));
?>
<?php 
$gridId = 'productprice-grid';

$flds = $this->appFormFields['lf']['productprice'];
unset($flds['rol']);
unset($flds['moq']);
unset($flds['stock']);
unset($flds['stockvalue']);
unset($flds['code']);
unset($flds['sku']);unset($flds['unit_cp']);unset($flds['unit_sp']);
unset($flds['supplier_id']);
unset($flds['product_id']);
//							$flds['category_id'] = array(
//                        'name' => 'category_id',
//                        'value' => '($data->category_id>0?$data->categories[0]->name:"")',
//                        );
//$flds['product_id'] = array(
//                        'name' => 'product_id',
//                        'value' => '$data->product->name',
//                        );
//							$flds['remarks'] = array(
//                        'name' => 'remarks',
//                        'value' => '$data->product->remarks',
//                        );
//						$flds['desc'] = array(
//                        'name' => 'desc',
//                        'value' => '$data->product->desc',
//                        );

$flds['invno'] = array(
                        'name' => 'invno',
                        'value' => '$data->invno',
                        );
						$flds['invdate'] = array(
                        'name' => 'invdate',
                        'value' => '$data->invdate',
                        );
                                                 $flds['created_at'] = array(
                         'name' => 'created_at',
                         'value' => '$data->created_at',
                         );
$updateUrl = $this->createUrl('productprice/' . Helper::CONST_updateProductStockAjax);
// $flds['stock'] = array (
                    // 'name'=>'stock',
                    // 'type' => 'raw',
                    // 'value'=>'$data->displayStock',
                    // 'class' => 'booster.widgets.TbEditableColumn',
                    // 'editable' => array(
                            // 'url' => $updateUrl,
                            // //'onSave' => $onsavejs,
                            // 'success' => $onsuccessjs,
                    // ),
                // );
// $flds['rol'] = array (
                    // 'name'=>'rol',
                    // 'value'=>'$data->rol',
                    // 'class' => 'booster.widgets.TbEditableColumn',
                    // 'editable' => array(
                            // 'url' => $updateUrl,
                            // //'onSave' => $onsavejs,
                            // 'success' => $onsuccessjs,
                    // ),
                // );
// $flds['moq'] = array (
                    // 'name'=>'moq',
                    // 'value'=>'$data->moq',
                    // 'class' => 'booster.widgets.TbEditableColumn',
                    // 'editable' => array(
                            // 'url' => $updateUrl,
                            // //'onSave' => $onsavejs,
                            // 'success' => $onsuccessjs,
                    // ),
                // );
// $flds['status'] = array (
                    // 'name'=>'status',
                    // 'value'=>'$data->status',
                    // 'class' => 'booster.widgets.TbToggleColumn',
                // );
// $flds['stock'] = array('name' => 'stock'
                                    // ,'type' => 'raw'
                                    // ,'value' => '$data->displayStockForUpdate'
                                // );
$viewhistoryUrl = '$this->grid->controller->createUrl("productstockhistory/'.Helper::CONST_viewstockhistory.'/$data->id")';

$viewPricesUrl = '$this->grid->controller->createUrl("productprice/'.Helper::CONST_viewProductPrices.'/$data->id")';
$btncols = array( array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("product/update/$data->id")',
                            ),
//                            'prices'=>array(
//                                'url'=>$viewPricesUrl,
//                            ),
                        ),
                    ),
                );
$columns = array_merge($btncols, $flds);

?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'productprice-grid',
	'dataProvider'=>$model->search(),
	'columns'=>$columns,
        'filter'=>$model,
)); 

?>
<?php $this->endWidget(); ?>