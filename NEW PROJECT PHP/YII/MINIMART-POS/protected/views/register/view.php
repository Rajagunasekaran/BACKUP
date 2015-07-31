<?php
$this->breadcrumbs=array(
	'Registers'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Register','url'=>array('index')),
array('label'=>'Create Register','url'=>array('create')),
array('label'=>'Update Register','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Register','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Register','url'=>array('admin')),
);
?>

<h1>View Register #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'desc',
		'login_id',
		'role_id',
		'open_time',
		'close_time',
		'op_balance',
		'cl_balance',
		'net_collection',
		'isdefault',
		'created_at',
		'updated_at',
),
)); ?>
