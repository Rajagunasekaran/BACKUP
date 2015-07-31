<?php
$this->breadcrumbs=array(
	'Personaddresses'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Personaddress','url'=>array('index')),
array('label'=>'Create Personaddress','url'=>array('create')),
array('label'=>'Update Personaddress','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Personaddress','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Personaddress','url'=>array('admin')),
);
?>

<h1>View Personaddress #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'person_id',
		'location_id',
		'type',
),
)); ?>
