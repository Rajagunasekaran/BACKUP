<?php
$this->breadcrumbs=array(
	'Purchasepeople'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Purchaseperson','url'=>array('index')),
array('label'=>'Create Purchaseperson','url'=>array('create')),
array('label'=>'Update Purchaseperson','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Purchaseperson','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Purchaseperson','url'=>array('admin')),
);
?>

<h1>View Purchaseperson #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'purchase_id',
		'person_id',
		'type',
),
)); ?>
