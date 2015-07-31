<?php
$this->breadcrumbs=array(
	'Orderproductdns',
);

$this->menu=array(
array('label'=>'Create Orderproductdn','url'=>array('create')),
array('label'=>'Manage Orderproductdn','url'=>array('admin')),
);
?>

<h1>Orderproductdns</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
