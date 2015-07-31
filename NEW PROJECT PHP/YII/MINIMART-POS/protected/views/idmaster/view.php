<?php
$this->breadcrumbs=array(
	'Idmasters'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Idmaster','url'=>array('index')),
array('label'=>'Create Idmaster','url'=>array('create')),
array('label'=>'Update Idmaster','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Idmaster','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Idmaster','url'=>array('admin')),
);
?>

<h1>View Idmaster #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'forwhat',
		'foryear',
		'formonth',
		'lastid',
		'created_at',
		'updated_at',
),
)); ?>
