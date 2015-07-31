<?php
/* @var $this PoslogreportController */
/* @var $model Poslogreport */

$this->breadcrumbs=array(
	'Poslogreports'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Poslogreport', 'url'=>array('index')),
	array('label'=>'Create Poslogreport', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#poslogreport-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<H3 style="color:#0000FF"> Stock Log History</H3>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div>

</div><!-- search-form -->
<?php $viewhistoryUrl = '$this->grid->controller->createUrl("subproductprice/admin")';?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'poslogreport-grid',
	'dataProvider'=>$model->displayStockHistory($id),
	'filter'=>$model,
	'columns'=>array(
             array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'header' => 'Back',
                        'template'=>'{Back}',
                        'buttons'=>array(
                            'Back'=>array(
                                'url'=>$viewhistoryUrl,
                            ),
                        ),
                    ),
	
		'date',
		'barcode',
		'previous_stock',
		'sold_out',
		'today_purchase',
                'rtn_product_quantity',
                'stock_adjustment',
		'current_aval_stock',
		'updated_at',
		
	),
)); ?>
