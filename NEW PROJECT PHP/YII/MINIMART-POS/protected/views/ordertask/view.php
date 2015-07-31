<?php
$this->breadcrumbs=array(
	'Ordertasks'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Ordertask','url'=>array('index')),
array('label'=>'Create Ordertask','url'=>array('create')),
array('label'=>'Update Ordertask','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Ordertask','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Ordertask','url'=>array('admin')),
);
?>

<h1>View Ordertask #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'order_id',
		'order_type',
		'task_id',
		'details',
		'start_at',
		'end_at',
		'started_at',
		'closed_at',
		'completed',
		'completed_at',
		'completed_remarks',
		'status',
		'invstatus',
		'cost',
		'amount',
		'taxper',
		'tax',
		'alertbefore',
),
)); ?>
