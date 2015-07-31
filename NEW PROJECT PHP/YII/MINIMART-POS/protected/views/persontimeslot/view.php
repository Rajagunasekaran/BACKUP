<?php
$this->breadcrumbs=array(
	'Persontimeslots'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Persontimeslot','url'=>array('index')),
array('label'=>'Create Persontimeslot','url'=>array('create')),
array('label'=>'Update Persontimeslot','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Persontimeslot','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Persontimeslot','url'=>array('admin')),
);
?>

<h1>View Persontimeslot #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'slotdate',
		'person_id',
		'ts1',
		'ts2',
		'ts3',
		'ts4',
		'ts5',
		'ts6',
		'ts7',
		'ts8',
		'ts9',
		'ts10',
		'ts11',
		'ts12',
		'ts13',
		'ts14',
		'ts15',
		'ts16',
		'ts17',
		'ts18',
		'ts19',
		'ts20',
		'ts21',
		'ts22',
		'ts23',
		'ts24',
		'created_at',
		'updated_at',
),
)); ?>
