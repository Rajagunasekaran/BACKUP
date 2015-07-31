<?php
$this->breadcrumbs=array(
	'Statushistories',
);

$this->menu=array(
array('label'=>'Create Statushistory','url'=>array('create')),
array('label'=>'Manage Statushistory','url'=>array('admin')),
);
?>

<h1>Statushistories</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
