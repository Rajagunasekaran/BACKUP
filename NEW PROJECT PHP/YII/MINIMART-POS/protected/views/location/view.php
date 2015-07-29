<?php
$this->breadcrumbs=array(
	'Locations'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Location','url'=>array('index')),
array('label'=>'Create Location','url'=>array('create')),
array('label'=>'Update Location','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Location','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Location','url'=>array('admin')),
);
?>

<h1>View Location #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'street',
		'locality',
		'city',
		'state',
		'country',
		'pincode',
		'remarks',
		'created_at',
		'updated_at',
),
)); ?>
