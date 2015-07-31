<?php
$this->breadcrumbs=array(
	'Orderproducts'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Orderproduct','url'=>array('index')),
array('label'=>'Create Orderproduct','url'=>array('create')),
array('label'=>'Update Orderproduct','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Orderproduct','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Orderproduct','url'=>array('admin')),
);
?>

<h1>View Orderproduct #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'order_id',
		'order_type',
		'product_id',
		'quantity',
		'delivered',
		'unit_sp',
		'cost',
		'amount',
		'tax',
		'discper',
		'disc',
),
)); ?>
