<?php
$this->breadcrumbs=array(
	'Otprgrshistories',
);

$this->menu=array(
array('label'=>'Create Otprgrshistory','url'=>array('create')),
array('label'=>'Manage Otprgrshistory','url'=>array('admin')),
);
?>

<h1>Otprgrshistories</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
