<?php
$this->breadcrumbs=array(
	'Purchases',
);

$this->menu=array(
array('label'=>'Create Purchase','url'=>array('create')),
array('label'=>'Manage Purchase','url'=>array('admin')),
);
?>

<h1>Purchases</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
