<?php
$this->breadcrumbs=array(
	'Productprices'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Productprice','url'=>array('index')),
array('label'=>'Create Productprice','url'=>array('create')),
);

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
<?php /*
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
*/ ?>
<div type="text" id="resultdiv"></div>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'productprice-form',
	'enableAjaxValidation'=>false,
));
?>
<?php
$onsavejs ='js: function(e, params) {
                //alert("saved value: "+params.newValue);
            }';
$onsuccessjs = 'js: function(data, newValue) {
                    //alert(data.message);
                    $("#resultdiv").text(data.message);
                    $.fn.yiiGridView.update("productprice-grid");
                }';
    $this->widget('booster.widgets.TbButton', array(
    'buttonType' => 'ajaxSubmit',
    'context'=>'primary',
    'label'=>'Add Products',
    'url' => Yii::app()->createUrl('product/' . Helper::CONST_bulkAddProductsAjax),
    'ajaxOptions' => array(
        'dataType' => 'json',
        'success'=> $onsuccessjs,
        ),
    'htmlOptions' => array(
        'id' => 'bulkUpdateStockBtn',
        'onclick'=>'js:updateGridSubmitResult("Wait...");'
        )
));
?>
<?php 
$gridId = 'productprice-grid';
$flds = $this->appFormFields['lf']['productprice'];
unset($flds['stockvalue']);
unset($flds['rol']);
unset($flds['moq']);
unset($flds['code']);
unset($flds['sku']);
unset($flds['stock']);
$category_id = array('category_id' =>array(
                        'name' => 'category_id',
                        'type' => 'raw',
                        'header' => 'Category',
                        'value' => '$data->displayCategoryForUpdate',
                        ));
$flds['product_id'] = array(
                        'name' => 'product_id',
                        'type' => 'raw',
                        'header' => 'Product',
                        'value' => '$data->displayProductForUpdate',
                        );
$flds['supplier_id'] = array(
                        'name' => 'supplier_id',
                        'type' => 'raw',
                        'header' => 'Supplier',
                        'value' => '$data->displaySupplierForUpdate',
                        );
$flds['unit_cp'] = array('name' => 'unit_cp'
                                    ,'type' => 'raw'
                                    ,'value' => '$data->displayUnitCPForUpdate'
                                );
$flds['unit_sp'] = array('name' => 'unit_sp'
                                    ,'type' => 'raw'
                                    ,'value' => '$data->displayUnitSPForUpdate'
                                );
$stock = array('stock' => array('name' => 'stock'
                                    ,'type' => 'raw'
                                    ,'value' => '$data->displayStockForUpdate'
                                )
        );
$dontsyncwithstock =  array('dontsyncwithstock' =>
                                    array('name' => 'dontsyncwithstock',
                                    'type' => 'raw',
                                    'header' => 'Don\'t Maintain Stock',
                                    'value' => '$data->displayDontsyncwithstockForUpdate',
                                ));
$code = array('code' => array('name' => 'code'
                                    ,'type' => 'raw'
                                    ,'value' => '$data->displayCodeForUpdate'
                                )
            );
$sku = array('sku' => array('name' => 'sku'
                                    ,'type' => 'raw'
                                    ,'value' => '$data->displaySKUForUpdate'
                                )
        );
$flds = array_merge($category_id,$flds, $dontsyncwithstock, $code, $sku, $stock);
$viewhistoryUrl = '$this->grid->controller->createUrl("productstockhistory/'.Helper::CONST_viewstockhistory.'/$data->id")';
$btncols = array();
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>$gridId,
            'dataProvider'=>$model->getBulkNewRecords(),
            //'filter'=>$model,
            'columns'=> $columns,
            );
$this->setDefaultGVOptions($options,
                                Helper::CONST_grid_Height_550,
                                Helper::CONST_grid_Font_12,
                                Helper::CONST_grid_Template_SI);
$this->widget('booster.widgets.TbExtendedGridView', $options); 
?>
<?php $this->endWidget(); ?>