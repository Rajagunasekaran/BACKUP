<?php
$this->breadcrumbs=array(
	'Accountpurchases'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Accountpurchase','url'=>array('index')),
array('label'=>'Create Accountpurchase','url'=>array('create')),
array('label'=>'Update Accountpurchase','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Accountpurchase','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Accountpurchase','url'=>array('admin')),
);
?>

<h1>View Accountpurchase #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'account_id',
		'purchase_id',
		'created_at',
		'updated_at',
),
)); ?>
