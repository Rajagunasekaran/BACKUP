<?php
$this->breadcrumbs=array(
	'Milestones',
);

$this->menu=array(
array('label'=>'Create Milestone','url'=>array('create')),
array('label'=>'Manage Milestone','url'=>array('admin')),
);
?>

<h1>Milestones</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
