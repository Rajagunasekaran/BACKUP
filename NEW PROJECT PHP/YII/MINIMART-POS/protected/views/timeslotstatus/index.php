<?php
$this->breadcrumbs=array(
	'Timeslotstatuses',
);

$this->menu=array(
array('label'=>'Create Timeslotstatus','url'=>array('create')),
array('label'=>'Manage Timeslotstatus','url'=>array('admin')),
);
?>

<h1>Timeslotstatuses</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
