<?php
$this->breadcrumbs=array(
	'Orderpeople',
);

$this->menu=array(
array('label'=>'Create Orderperson','url'=>array('create')),
array('label'=>'Manage Orderperson','url'=>array('admin')),
);
?>

<h1>Orderpeople</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
