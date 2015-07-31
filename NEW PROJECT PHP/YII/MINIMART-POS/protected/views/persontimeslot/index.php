<?php
$this->breadcrumbs=array(
	'Persontimeslots',
);

$this->menu=array(
array('label'=>'Create Persontimeslot','url'=>array('create')),
array('label'=>'Manage Persontimeslot','url'=>array('admin')),
);
?>

<h1>Persontimeslots</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
