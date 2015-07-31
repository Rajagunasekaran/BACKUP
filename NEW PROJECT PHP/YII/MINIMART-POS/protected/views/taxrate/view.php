<?php
$this->breadcrumbs=array(
	'Taxrates'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Taxrate','url'=>array('index')),
array('label'=>'Create Taxrate','url'=>array('create')),
array('label'=>'Update Taxrate','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Taxrate','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Taxrate','url'=>array('admin')),
);
?>

<h1>View Taxrate #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'taxname',
		'taxrate',
		'taxtype',
		'remarks',
),
)); ?>
