<?php
$this->breadcrumbs=array(
	'Geolocations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Geolocation','url'=>array('index')),
	array('label'=>'Create Geolocation','url'=>array('create')),
	array('label'=>'View Geolocation','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Geolocation','url'=>array('admin')),
	);
	?>

	<h1>Update Geolocation <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>