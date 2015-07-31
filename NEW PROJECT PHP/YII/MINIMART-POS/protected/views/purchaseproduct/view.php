<?php
$this->breadcrumbs=array(
	'Purchaseproducts'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Purchaseproduct','url'=>array('index')),
array('label'=>'Create Purchaseproduct','url'=>array('create')),
array('label'=>'Update Purchaseproduct','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Purchaseproduct','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Purchaseproduct','url'=>array('admin')),
);
?>

<h1>View Purchaseproduct #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'purchase_id',
		'product_id',
		'quantity',
		'unit_cp',
		'amount',
		'taxrate_id',
		'tax',
),
)); ?>
