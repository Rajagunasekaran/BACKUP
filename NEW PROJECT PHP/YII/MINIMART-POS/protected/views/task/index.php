<?php
$this->breadcrumbs=array(
	'Tasks',
);

$this->menu=array(
array('label'=>'Create Task','url'=>array('create')),
array('label'=>'Manage Task','url'=>array('admin')),
);
?>

<h1>Tasks</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
