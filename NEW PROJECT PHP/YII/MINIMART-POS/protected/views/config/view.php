<?php
$this->breadcrumbs=array(
	'Configs'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Config','url'=>array('index')),
array('label'=>'Create Config','url'=>array('create')),
array('label'=>'Update Config','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Config','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Config','url'=>array('admin')),
);
?>

<h1>View Config #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'config_key',
		'config_val',
		'remarks',
),
)); ?>
