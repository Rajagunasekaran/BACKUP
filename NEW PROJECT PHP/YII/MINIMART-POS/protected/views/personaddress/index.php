<?php
$this->breadcrumbs=array(
	'Personaddresses',
);

$this->menu=array(
array('label'=>'Create Personaddress','url'=>array('create')),
array('label'=>'Manage Personaddress','url'=>array('admin')),
);
?>

<h1>Personaddresses</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
