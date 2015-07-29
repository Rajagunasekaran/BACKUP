<?php
$this->breadcrumbs=array(
	'Products',
);

$this->menu=array(
array('label'=>'Create Product','url'=>array('create')),
array('label'=>'Manage Product','url'=>array('admin')),
    array('label'=>'Master Product','url'=>array('_create')),
);
?>

<h1>Products</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
