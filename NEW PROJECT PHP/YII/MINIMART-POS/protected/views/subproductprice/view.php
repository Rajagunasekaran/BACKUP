<?php
/* @var $this SubproductpriceController */
/* @var $model Subproductprice */

$this->breadcrumbs=array(
	'Subproductprices'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Subproductprice', 'url'=>array('index')),
	array('label'=>'Create Subproductprice', 'url'=>array('create')),
	array('label'=>'Update Subproductprice', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Subproductprice', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Subproductprice', 'url'=>array('admin')),
);
?>

<h1>View Subproductprice #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
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
		'tax',
		'disc',
		'created_at',
		'updated_at',
	),
)); ?>
