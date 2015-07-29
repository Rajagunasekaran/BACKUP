<?php
$this->breadcrumbs=array(
	'Geolocations'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Geolocation','url'=>array('index')),
array('label'=>'Manage Geolocation','url'=>array('admin')),
);
?>

<h1>Create Geolocation</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>