<?php
$this->breadcrumbs=array(
	'Personcompanyroles'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Personcompanyrole','url'=>array('index')),
array('label'=>'Create Personcompanyrole','url'=>array('create')),
array('label'=>'Update Personcompanyrole','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Personcompanyrole','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Personcompanyrole','url'=>array('admin')),
);
?>

<h1>View Personcompanyrole #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'person_id',
		'company_id',
		'role_id',
		'status',
		'created_at',
		'updated_at',
),
)); ?>
