<?php
$this->breadcrumbs=array(
	'Ordertasks',
);

$this->menu=array(
array('label'=>'Create Ordertask','url'=>array('create')),
array('label'=>'Manage Ordertask','url'=>array('admin')),
);
?>

<h1>Ordertasks</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
