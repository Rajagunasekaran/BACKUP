<?php
$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Product','url'=>array('index')),
array('label'=>'Create Product','url'=>array('create')),
array('label'=>'Update Product','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Product','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Product','url'=>array('admin')),
);
?>

<h1>View Product #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'enableprdcode',
		'code',
		'name',
		'desc',
		'remarks',
		'enableprdauxname',
		'auxname',
		'taxrate_id',
		'tax',
		'manufacturer',
		'supplier_id',
		'color',
		'size',
		'unit_cp',
		'sptype',
		'unit_sp_per',
		'unit_sp',
		'sku',
		'stock',
		'stockvalue',
		'rol',
		'moq',
		'imagepath',
		'person_id',
		'created_at',
		'updated_at',
),
)); ?>
