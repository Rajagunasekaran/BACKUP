<?php
$this->breadcrumbs=array(
	'Subproductprices'=>array('index'),
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

<H3 style="color:#0000FF">Product Details</H3>
<div class="search-form" >
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<?php

$gridId = 'productprice-grid';

$flds['product_id'] = array(
                       'name' => 'product_id',
                       'value' => '$data->product->name',
                       );
$flds['sku'] = array(
                       'name' => 'sku',
                       'value' => '$data->sku',
                       );
$flds['unit_cp'] = array (
                   'name'=>'unit_cp',
                   'type'=>'raw',
                   'value'=>'$data->unit_cp', 
                   
               );
$flds['unit_sp'] = array(
                       'name' => 'unit_sp',
                       'value' => '$data->unit_sp',
                       );

$updateUrl = $this->createUrl('productprice/' . Helper::CONST_updateProductStockAjax);




$viewPricesUrl = '$this->grid->controller->createUrl("purchaseentry/viewProductPrices/$data->id")';
$btncols = array( array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("purchaseentry/update/$data->id")',
                            ),
//                            'prices'=>array( ********to enable this need give template
//                                'url'=>$viewPricesUrl,
//                            ),
                        ),
                    ),
                );
		




 
$columns = array_merge($btncols, $flds);
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'productprice-grid',
	'dataProvider'=>$model->search(),
	'columns'=>$columns, 
        'filter'=>$model,
)); 

?>