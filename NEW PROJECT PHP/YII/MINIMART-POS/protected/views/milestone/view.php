<?php
$this->breadcrumbs=array(
	'Milestones'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Milestone','url'=>array('index')),
array('label'=>'Create Milestone','url'=>array('create')),
array('label'=>'Update Milestone','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Milestone','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Milestone','url'=>array('admin')),
);
?>

<h1>View Milestone #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'person_id',
		'order_id',
		'details',
		'remarks',
		'start_at',
		'end_at',
		'alertbefore',
		'completed',
		'completed_at',
		'completed_remarks',
		'mailids',
		'mailcount',
		'lastmailsent_at',
		'started_at',
		'closed_at',
		'status',
		'created_at',
		'updated_at',
),
)); ?>
