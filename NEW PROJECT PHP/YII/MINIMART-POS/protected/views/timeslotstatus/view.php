<?php
$this->breadcrumbs=array(
	'Timeslotstatuses'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Timeslotstatus','url'=>array('index')),
array('label'=>'Create Timeslotstatus','url'=>array('create')),
array('label'=>'Update Timeslotstatus','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Timeslotstatus','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Timeslotstatus','url'=>array('admin')),
);
?>

<h1>View Timeslotstatus #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'slotdate',
		'slot',
		'status',
		'created_at',
		'updated_at',
),
)); ?>
