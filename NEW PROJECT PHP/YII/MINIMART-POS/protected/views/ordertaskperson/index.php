<?php
$this->breadcrumbs=array(
	'Ordertaskpeople',
);

$this->menu=array(
array('label'=>'Create Ordertaskperson','url'=>array('create')),
array('label'=>'Manage Ordertaskperson','url'=>array('admin')),
);
?>

<h1>Ordertaskpeople</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
