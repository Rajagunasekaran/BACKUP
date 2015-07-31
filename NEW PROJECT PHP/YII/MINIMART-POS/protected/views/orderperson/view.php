<?php
$this->breadcrumbs=array(
	'Orderpeople'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Orderperson','url'=>array('index')),
array('label'=>'Create Orderperson','url'=>array('create')),
array('label'=>'Update Orderperson','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Orderperson','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Orderperson','url'=>array('admin')),
);
?>

<h1>View Orderperson #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'order_id',
		'person_id',
		'type',
),
)); ?>
