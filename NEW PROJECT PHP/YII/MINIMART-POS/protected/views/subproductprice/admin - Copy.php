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
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
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
    'label'=>'Update Stocks',
    'url' => Yii::app()->createUrl('productprice/' . Helper::CONST_bulkupdateProductStockAjax),
    'ajaxOptions' => array(
        'dataType' => 'json',
        'success'=> $onsuccessjs,
        ),
        'visible'=>'false',
    'htmlOptions' => array(
        'id' => 'bulkUpdateStockBtn',
        'onclick'=>'js:updateGridSubmitResult("Wait...");',
        'class'=>'right hidden',
        )
));
?>
<?php 
$gridId = 'productprice-grid';
$flds = $this->appFormFields['lf']['productprice'];
unset($flds['rol']);
unset($flds['moq']);
unset($flds['stock']);
unset($flds['supplier_id']);
unset($flds['stockvalue']);
$flds['product_id'] = array(
                        'name' => 'product_id',
                        'value' => '$data->product->name',
                        );
$updateUrl = $this->createUrl('productprice/' . Helper::CONST_updateProductStockAjax);
$flds['stock'] = array (
                    'name'=>'stock',
                    //'type' => 'raw',
                    'value'=>'$data->stock',
                    //'class' => 'booster.widgets.TbEditableColumn',
                   // 'editable' => array(
                        //    'url' => $updateUrl,
                            //'onSave' => $onsavejs,
                         //   'success' => $onsuccessjs,
                    //),
                );
/*
 * 
 * $flds['rol'] = array (
                    'name'=>'rol',
                    'value'=>'$data->rol',
                  //  'class' => 'booster.widgets.TbEditableColumn',
                  //  'editable' => array(
                   //         'url' => $updateUrl,
                            //'onSave' => $onsavejs,
                    //        'success' => $onsuccessjs,
                    //),
                );
 * 
 *  */
//$flds['stock'] = array('name' => 'stock'
//
//                                    ,'type' => 'raw'
//                                    ,'value' => '$data->Stockcount'
//                                );
$viewhistoryUrl = '$this->grid->controller->createUrl("productprice/pricehistory/$data->id")';
$viewstocklogUrl='$this->grid->controller->createUrl("poslogreport/admin/$data->id")';
$btncols = array( array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'header' => 'Stock',
                        'template'=>'{history} {stock}',
                        'buttons'=>array(
                            'history'=>array(
                                'url'=>$viewhistoryUrl,
                            ),
                             'stock'=>array(
                                'url'=>$viewstocklogUrl,
                            ),
                        ),
                    ),
                );

$flds['unit_cp'] = array (
                    'name'=>'unit_cp',
                    'type'=>'raw',
                    'value'=>'$data->unit_cp', 
                    
                );
 
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>$gridId,
            'dataProvider'=>$model->search(),
            //'filter'=>$model,
            'columns'=> $columns,
            );

?>
<?php $this->endWidget(); ?>

<H3 style="color:#0000FF"> Manage Stock</H3>
<?php
$this->setDefaultGVOptions($options);
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sample-grid',
	'dataProvider'=>$model->search(),
	'columns'=>$columns, 'filter'=>$model,
)); 

?>
