<?php
$this->breadcrumbs=array(
	'Statusmasters',
);

$this->menu=array(
array('label'=>'Create Statusmaster','url'=>array('create')),
array('label'=>'Manage Statusmaster','url'=>array('admin')),
);
?>

<h1>Statusmasters</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
