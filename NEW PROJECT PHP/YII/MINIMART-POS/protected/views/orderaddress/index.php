<?php
$this->breadcrumbs=array(
	'Orderaddresses',
);

$this->menu=array(
array('label'=>'Create Orderaddress','url'=>array('create')),
array('label'=>'Manage Orderaddress','url'=>array('admin')),
);
?>

<h1>Orderaddresses</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
