<?php
$this->breadcrumbs=array(
	'Logins'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Login','url'=>array('index')),
array('label'=>'Create Login','url'=>array('create')),
array('label'=>'Update Login','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Login','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Login','url'=>array('admin')),
);
?>

<h1>View Login #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'person_id',
		'login',
		'pass',
		'hash_id',
		'status',
		'created_at',
		'updated_at',
),
)); ?>
