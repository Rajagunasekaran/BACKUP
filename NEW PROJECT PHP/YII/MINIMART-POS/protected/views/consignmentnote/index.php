<?php
$this->breadcrumbs=array(
	'Consignmentnotes',
);

$this->menu=array(
array('label'=>'Create Consignmentnote','url'=>array('create')),
array('label'=>'Manage Consignmentnote','url'=>array('admin')),
);
?>

<h1>Consignmentnotes</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
