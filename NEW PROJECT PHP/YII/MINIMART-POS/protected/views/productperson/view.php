<?php
$this->breadcrumbs=array(
	'Productpeople'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Productperson','url'=>array('index')),
array('label'=>'Create Productperson','url'=>array('create')),
array('label'=>'Update Productperson','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Productperson','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Productperson','url'=>array('admin')),
);
?>

<h1>View Productperson #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'product_id',
		'person_id',
		'type',
),
)); ?>
