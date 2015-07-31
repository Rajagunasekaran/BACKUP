<?php
$this->breadcrumbs=array(
	'Geolocations',
);

$this->menu=array(
array('label'=>'Create Geolocation','url'=>array('create')),
array('label'=>'Manage Geolocation','url'=>array('admin')),
);
?>

<h1>Geolocations</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
