<?php
$this->breadcrumbs=array(
	'Orderproducts',
);

$this->menu=array(
array('label'=>'Create Orderproduct','url'=>array('create')),
array('label'=>'Manage Orderproduct','url'=>array('admin')),
);
?>

<h1>Orderproducts</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
