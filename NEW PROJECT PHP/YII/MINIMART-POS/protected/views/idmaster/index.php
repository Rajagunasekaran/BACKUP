<?php
$this->breadcrumbs=array(
	'Idmasters',
);

$this->menu=array(
array('label'=>'Create Idmaster','url'=>array('create')),
array('label'=>'Manage Idmaster','url'=>array('admin')),
);
?>

<h1>Idmasters</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
