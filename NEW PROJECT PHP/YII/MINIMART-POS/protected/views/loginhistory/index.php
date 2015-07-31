<?php
$this->breadcrumbs=array(
	'Loginhistories',
);

$this->menu=array(
array('label'=>'Create Loginhistory','url'=>array('create')),
array('label'=>'Manage Loginhistory','url'=>array('admin')),
);
?>

<h1>Loginhistories</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
