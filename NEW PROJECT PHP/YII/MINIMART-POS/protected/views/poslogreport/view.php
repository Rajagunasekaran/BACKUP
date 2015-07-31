<?php
/* @var $this PoslogreportController */
/* @var $model Poslogreport */

$this->breadcrumbs=array(
	'Poslogreports'=>array('index'),
	$model->sno,
);

$this->menu=array(
	array('label'=>'List Poslogreport', 'url'=>array('index')),
	array('label'=>'Create Poslogreport', 'url'=>array('create')),
	array('label'=>'Update Poslogreport', 'url'=>array('update', 'id'=>$model->sno)),
	array('label'=>'Delete Poslogreport', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->sno),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Poslogreport', 'url'=>array('admin')),
);
?>

<h1>View Poslogreport #<?php echo $model->sno; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'sno',
		'date',
		'barcode',
		'previous_stock',
		'current_stock',
		'sold_out',
		'today_purchase',
		'current_aval_stock',
		'log_status',
		'updated_at',
	),
)); ?>
