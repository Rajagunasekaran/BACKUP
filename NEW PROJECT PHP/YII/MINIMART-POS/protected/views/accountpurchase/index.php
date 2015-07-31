<?php
$this->breadcrumbs=array(
	'Accountpurchases',
);

$this->menu=array(
array('label'=>'Create Accountpurchase','url'=>array('create')),
array('label'=>'Manage Accountpurchase','url'=>array('admin')),
);
?>

<h1>Accountpurchases</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
