<?php
$this->breadcrumbs=array(
	'Productstockhistories',
);

$this->menu=array(
array('label'=>'Create Productstockhistory','url'=>array('create')),
array('label'=>'Manage Productstockhistory','url'=>array('admin')),
);
?>

<h1>Productstockhistories</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
