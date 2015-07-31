<?php
$this->breadcrumbs=array(
	'Productpeople',
);

$this->menu=array(
array('label'=>'Create Productperson','url'=>array('create')),
array('label'=>'Manage Productperson','url'=>array('admin')),
);
?>

<h1>Productpeople</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
