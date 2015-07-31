<?php
$this->breadcrumbs=array(
	'Statusmasters'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Statusmaster','url'=>array('index')),
array('label'=>'Create Statusmaster','url'=>array('create')),
array('label'=>'Update Statusmaster','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Statusmaster','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Statusmaster','url'=>array('admin')),
);
?>

<h1>View Statusmaster #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'ofwhich',
		'name',
		'display',
		'desc',
),
)); ?>
