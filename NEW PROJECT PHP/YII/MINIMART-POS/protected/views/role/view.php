<?php
$this->breadcrumbs=array(
	'Roles'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Role','url'=>array('index')),
array('label'=>'Create Role','url'=>array('create')),
array('label'=>'Update Role','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Role','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Role','url'=>array('admin')),
);
?>

<h1>View Role #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'role',
		'desc',
		'level',
		'status',
		'created_at',
		'updated_at',
),
)); ?>
