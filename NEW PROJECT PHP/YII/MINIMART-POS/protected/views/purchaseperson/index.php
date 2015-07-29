<?php
$this->breadcrumbs=array(
	'Purchasepeople',
);

$this->menu=array(
array('label'=>'Create Purchaseperson','url'=>array('create')),
array('label'=>'Manage Purchaseperson','url'=>array('admin')),
);
?>

<h1>Purchasepeople</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
