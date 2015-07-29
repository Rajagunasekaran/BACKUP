<?php
$this->breadcrumbs=array(
	'Orderproductdns'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Orderproductdn','url'=>array('index')),
array('label'=>'Create Orderproductdn','url'=>array('create')),
array('label'=>'Update Orderproductdn','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Orderproductdn','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Orderproductdn','url'=>array('admin')),
);
?>

<h1>View Orderproductdn #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'order_id',
		'orderproduct_id',
		'quantity',
		'delivered_at',
		'created_at',
		'updated_at',
),
)); ?>
