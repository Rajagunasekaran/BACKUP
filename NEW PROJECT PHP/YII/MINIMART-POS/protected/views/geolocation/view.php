<?php
$this->breadcrumbs=array(
	'Geolocations'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Geolocation','url'=>array('index')),
array('label'=>'Create Geolocation','url'=>array('create')),
array('label'=>'Update Geolocation','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Geolocation','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Geolocation','url'=>array('admin')),
);
?>

<h1>View Geolocation #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'person_id',
		'lng',
		'lat',
		'locname',
		'captured_at',
		'created_at',
		'updated_at',
),
)); ?>
