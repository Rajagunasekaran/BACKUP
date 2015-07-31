<?php
$this->breadcrumbs=array(
	'Consignmentnotes'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Consignmentnote','url'=>array('index')),
array('label'=>'Create Consignmentnote','url'=>array('create')),
array('label'=>'Update Consignmentnote','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Consignmentnote','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Consignmentnote','url'=>array('admin')),
);
?>

<h1>View Consignmentnote #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'person_id',
		'order_id',
		'notes',
		'created_at',
		'updated_at',
),
)); ?>
