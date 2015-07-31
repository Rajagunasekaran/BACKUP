<?php
$this->breadcrumbs=array(
	'Productprices'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Productprice','url'=>array('index')),
array('label'=>'Create Productprice','url'=>array('create')),
array('label'=>'Update Productprice','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Productprice','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Productprice','url'=>array('admin')),
);
?>

<h1>View Productprice #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'product_id',
		'code',
		'sku',
		'supplier_id',
		'unit_cp',
		'sptype',
		'unit_sp_per',
		'unit_sp',
		'stock',
		'stockvalue',
		'rol',
		'moq',
		'dontsyncwithstock',
		'status',
		'created_at',
		'updated_at',
),
)); ?>
