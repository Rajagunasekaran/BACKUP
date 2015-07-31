<?php
$this->breadcrumbs=array(
	'Productprices',
);

$this->menu=array(
array('label'=>'Create Productprice','url'=>array('create')),
array('label'=>'Manage Productprice','url'=>array('admin')),
);
?>

<h1>Productprices</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
