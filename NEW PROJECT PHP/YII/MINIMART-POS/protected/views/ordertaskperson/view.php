<?php
$this->breadcrumbs=array(
	'Ordertaskpeople'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Ordertaskperson','url'=>array('index')),
array('label'=>'Create Ordertaskperson','url'=>array('create')),
array('label'=>'Update Ordertaskperson','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Ordertaskperson','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Ordertaskperson','url'=>array('admin')),
);
?>

<h1>View Ordertaskperson #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'order_id',
		'order_type',
		'ordertask_id',
		'person_id',
		'efforts',
		'cost',
		'amount',
		'tax',
		'level',
		'type',
),
)); ?>
