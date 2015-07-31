<?php
$this->breadcrumbs=array(
	'Paymentreceipts',
);

$this->menu=array(
array('label'=>'Create Paymentreceipt','url'=>array('create')),
array('label'=>'Manage Paymentreceipt','url'=>array('admin')),
);
?>

<h1>Paymentreceipts</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
