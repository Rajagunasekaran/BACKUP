<?php
$this->breadcrumbs=array(
	'Statushistories'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Statushistory','url'=>array('index')),
array('label'=>'Create Statushistory','url'=>array('create')),
array('label'=>'Update Statushistory','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Statushistory','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Statushistory','url'=>array('admin')),
);
?>

<h1>View Statushistory #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'ofwhich_id',
		'status1dt',
		'status2dt',
		'status3dt',
		'status4dt',
		'status5dt',
		'status6dt',
		'status7dt',
		'status8dt',
		'status9dt',
		'status10dt',
		'created_at',
		'updated_at',
),
)); ?>
