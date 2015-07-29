<?php
$this->breadcrumbs=array(
	'Accountorders'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Accountorder','url'=>array('index')),
array('label'=>'Create Accountorder','url'=>array('create')),
array('label'=>'Update Accountorder','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Accountorder','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Accountorder','url'=>array('admin')),
);
?>

<h1>View Accountorder #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'account_id',
		'order_id',
		'ordertask_id',
		'addnlinfo',
		'created_at',
		'updated_at',
),
)); ?>
