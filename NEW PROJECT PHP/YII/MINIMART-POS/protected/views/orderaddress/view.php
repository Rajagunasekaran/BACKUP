<?php
$this->breadcrumbs=array(
	'Orderaddresses'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Orderaddress','url'=>array('index')),
array('label'=>'Create Orderaddress','url'=>array('create')),
array('label'=>'Update Orderaddress','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Orderaddress','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Orderaddress','url'=>array('admin')),
);
?>

<h1>View Orderaddress #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'person_id',
		'order_id',
		'location_id',
		'type',
),
)); ?>
