<?php
$this->breadcrumbs=array(
	'Mailqueues'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Mailqueue','url'=>array('index')),
array('label'=>'Create Mailqueue','url'=>array('create')),
array('label'=>'Update Mailqueue','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Mailqueue','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Mailqueue','url'=>array('admin')),
);
?>

<h1>View Mailqueue #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'event_id',
		'mailids',
		'subject',
		'mail_body',
		'status',
		'attempts',
		'last_attempt_on',
		'created_at',
		'updated_at',
),
)); ?>
