<?php
$this->breadcrumbs=array(
	'Personcompanyroles',
);

$this->menu=array(
array('label'=>'Create Personcompanyrole','url'=>array('create')),
array('label'=>'Manage Personcompanyrole','url'=>array('admin')),
);
?>

<h1>Personcompanyroles</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
