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
unset($flds['status']);
$flds['product_id'] = array(
                        'name' => 'product_id',
                        'value' => '$data->product->name',
                        );
$flds['supplier_id'] = array(
                        'name' => 'supplier_id',
                        'value' => '$data->supplier->display',
                        );
$updateUrl = $this->createUrl('productprice/' . Helper::CONST_updateProductStockAjax);

$flds['stock'] = array (
                    'name'=>'stock',
                    //'type' => 'raw',
                    'value'=>'$data->displayStock',
                    //'class' => 'booster.widgets.TbEditableColumn',
                   // 'editable' => array(
                        //    'url' => $updateUrl,
                            //'onSave' => $onsavejs,
                         //   'success' => $onsuccessjs,
                    //),
                );
$flds['expdate'] = array(
                        'name' => 'expdate',
                        'value' => '$data->expdate',
                        );
$flds['invno'] = array(
                        'name' => 'invno',
                        'value' => '$data->invno',
                        );
$flds['invdate'] = array(
                        'name' => 'invdate',
                        'value' => '$data->invdate',
                        );
/*
$flds['rol'] = array (
                    'name'=>'rol',
                    'value'=>'$data->rol',
                  //  'class' => 'booster.widgets.TbEditableColumn',
                  //  'editable' => array(
                   //         'url' => $updateUrl,
                            //'onSave' => $onsavejs,
                    //        'success' => $onsuccessjs,
                    //),
                );
 
 */

$flds['created_at'] = array (
                    'name'=>'created_at',
                    'value'=>'$data->created_at',
                   
                );
//$flds['status'] = array (
//                    'name'=>'status',
//                    'value'=>'$data->status',
//                    'class' => 'booster.widgets.TbToggleColumn',
//                );
$flds['stock'] = array('name' => 'stock'
                                    ,'type' => 'raw'
                                    ,'value' => '$data->displayStock'
                                );
$viewhistoryUrl = '$this->grid->controller->createUrl("subproductprice/admin")';
$btncols = array( array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'header' => 'Back',
                        'template'=>'{Back}',
                        'buttons'=>array(
                            'Back'=>array(
                                'url'=>$viewhistoryUrl,
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
//$columns =  $flds;
$options = array(
            'id'=>$gridId,
            'dataProvider'=>$model->displayProductHistory($id),
            //'filter'=>$model,
            'columns'=> $columns,
            );
$this->setDefaultGVOptions($options);
//$this->widget('booster.widgets.TbExtendedGridView', $options);
?>


<H3 style="color:#0000FF"> Product History</H3>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sample-grid',
	'dataProvider'=>$model->displayProductHistory($id),
	'columns'=>$columns, 
        'filter'=>$model,
)); 

?>
<?php $this->endWidget(); ?>