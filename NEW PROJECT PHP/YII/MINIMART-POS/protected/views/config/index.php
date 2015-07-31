<?php
$this->breadcrumbs=array(
	'Configs',
);

$this->menu=array(
array('label'=>'Create Config','url'=>array('create')),
array('label'=>'Manage Config','url'=>array('admin')),
);
?>

<h1>Configs</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
