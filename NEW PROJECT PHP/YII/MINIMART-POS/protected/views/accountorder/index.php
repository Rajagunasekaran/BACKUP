<?php
$this->breadcrumbs=array(
	'Accountorders',
);

$this->menu=array(
array('label'=>'Create Accountorder','url'=>array('create')),
array('label'=>'Manage Accountorder','url'=>array('admin')),
);
?>

<h1>Accountorders</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
