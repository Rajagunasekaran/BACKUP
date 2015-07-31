<?php
$this->breadcrumbs=array(
	'Purchaseproducts',
);

$this->menu=array(
array('label'=>'Create Purchaseproduct','url'=>array('create')),
array('label'=>'Manage Purchaseproduct','url'=>array('admin')),
);
?>

<h1>Purchaseproducts</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
