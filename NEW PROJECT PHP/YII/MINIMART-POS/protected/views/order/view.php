<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Order','url'=>array('index')),
array('label'=>'Create Order','url'=>array('create')),
array('label'=>'Update Order','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Order','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Order','url'=>array('admin')),
);
?>

<h1>View Order #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'type',
		'qoi_id',
		'quote_id',
		'order_id',
		'quote_qoi_id',
		'order_qoi_id',
		'name',
		'desc',
		'addnlinfo',
		'addnlinfo1',
		'addnlinfo2',
		'addnlinfo3',
		'addnlinfo4',
		'addnlinfo5',
		'start_at',
		'end_at',
		'budget',
		'cost',
		'amount',
		'taxper',
		'tax',
		'discper',
		'disc',
		'tasks',
		'completed',
		'status',
		'invstatus',
		'remarks',
		'paid',
		'qutcnvrtdate',
		'ordcnvrtdate',
		'started_at',
		'closed_at',
		'delivered',
		'enableordername',
		'enableordrprd',
		'enableordrtasks',
		'enableordrtaskpeople',
		'enableordrpayments',
		'enableordermilestones',
		'ordercostamountfrom',
		'ordertaskcostamountfrom',
		'enablediscount',
		'orderdiscfor',
		'created_at',
		'updated_at',
),
)); ?>
