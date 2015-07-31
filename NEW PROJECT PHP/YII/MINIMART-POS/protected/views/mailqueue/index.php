<?php
$this->breadcrumbs=array(
	'Mailqueues',
);

$this->menu=array(
array('label'=>'Create Mailqueue','url'=>array('create')),
array('label'=>'Manage Mailqueue','url'=>array('admin')),
);
?>

<h1>Mailqueues</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
