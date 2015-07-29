<?php
/* @var $this StockadjustmentController */
/* @var $model Stockadjustment */

$this->breadcrumbs=array(
	'Stockadjustments'=>array('index'),
	$model->sno,
);

$this->menu=array(
	array('label'=>'List Stockadjustment', 'url'=>array('index')),
	array('label'=>'Create Stockadjustment', 'url'=>array('create')),
	array('label'=>'Update Stockadjustment', 'url'=>array('update', 'id'=>$model->sno)),
	array('label'=>'Delete Stockadjustment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->sno),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Stockadjustment', 'url'=>array('admin')),
);
?>

<h1>View Stockadjustment #<?php echo $model->sno; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'sno',
		'referenceno',
		'dateofadjustment',
		'code',
		'sku',
		'stock',
		'stock_adjustment',
		'Remarks',
	),
)); ?>
