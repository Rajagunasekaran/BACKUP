<?php
$this->breadcrumbs=array(
	'Orderproducts'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Orderproduct','url'=>array('index')),
array('label'=>'Create Orderproduct','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('orderproduct-grid', {
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
*/ 
?>
<?php
//unset($flds['productprice_id']);
$flds['product_id'] = array(
                        'name' => 'product_id',
                        'value' => '$data->product->name',
                        );
$flds['quantity'] = array('name' => 'quantity');
$flds['unit_sp']=array('name' => 'unit_sp');
$flds['tax'] = array('name' => 'tax');
$flds['amount'] = array('name'=>'amount');
$viewbillnoUrl = '$this->grid->controller->createUrl("/order/admin")';
$btncols = array( array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'header' => 'Back',
                        'template'=>'{Back}',
                        'buttons'=>array(
                            'Back'=>array(
                                'url'=>$viewbillnoUrl,
                            ),
                        ),
                    ),
                );
$columns = array_merge($btncols, $flds);
$opGridId = 'opGridId';
$onsavejs ='js: function(e, params) {
                //alert("saved value: "+params.newValue);
            }';
$onsuccessjs = 'js: function(response, newValue) {
                    if(response === "NotOK") {
                        alert("Update not done");
                    }
                    $.fn.yiiGridView.update("$opGridId");
                }';
?>
<?php 
// $this->renderPartial('//orderproduct/admin_sub',array(
//	'model'=>$model,
//        'allproducts'=>Yii::app()->user->products,
//        'opGridId' => $opGridId,
//        'onsuccessjs' => $onsuccessjs,
//        'onsavejs' => $onsavejs,
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sample-grid',
	'dataProvider'=>$model->search($id),
	'columns'=>$columns, 'filter'=>$model,
)); ?>
