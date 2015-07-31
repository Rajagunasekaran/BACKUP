<?php
$this->breadcrumbs=array(
	'Taxrates',
);

$this->menu=array(
array('label'=>'Create Taxrate','url'=>array('create')),
array('label'=>'Manage Taxrate','url'=>array('admin')),
);
?>

<h1>Taxrates</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
