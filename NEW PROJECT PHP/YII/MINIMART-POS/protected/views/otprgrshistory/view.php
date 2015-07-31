<?php
$this->breadcrumbs=array(
	'Otprgrshistories'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Otprgrshistory','url'=>array('index')),
array('label'=>'Create Otprgrshistory','url'=>array('create')),
array('label'=>'Update Otprgrshistory','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Otprgrshistory','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Otprgrshistory','url'=>array('admin')),
);
?>

<h1>View Otprgrshistory #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'order_id',
		'order_type',
		'ordertask_id',
		'completed',
		'completed_at',
		'remarks',
		'created_at',
		'updated_at',
),
)); ?>
