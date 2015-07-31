<?php
$this->breadcrumbs=array(
	'Registers',
);

$this->menu=array(
array('label'=>'Create Register','url'=>array('create')),
array('label'=>'Manage Register','url'=>array('admin')),
);
?>

<h1>Registers</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
