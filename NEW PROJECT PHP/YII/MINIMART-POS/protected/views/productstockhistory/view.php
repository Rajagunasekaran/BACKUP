<?php
$this->breadcrumbs=array(
	'Productstockhistories'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Productstockhistory','url'=>array('index')),
array('label'=>'Create Productstockhistory','url'=>array('create')),
array('label'=>'Update Productstockhistory','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Productstockhistory','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Productstockhistory','url'=>array('admin')),
);
?>

<h1>View Productstockhistory #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'product_id',
		'productprice_id',
		'updationdate',
		'beforeupdation',
		'updatedqnty',
		'afterupdation',
),
)); ?>
