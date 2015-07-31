<?php
$this->breadcrumbs=array(
	'Loginhistories'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Loginhistory','url'=>array('index')),
array('label'=>'Create Loginhistory','url'=>array('create')),
array('label'=>'Update Loginhistory','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Loginhistory','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Loginhistory','url'=>array('admin')),
);
?>

<h1>View Loginhistory #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'login_id',
		'role_id',
		'login_time',
		'logout_time',
		'created_at',
		'updated_at',
),
)); ?>
