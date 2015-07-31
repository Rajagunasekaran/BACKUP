<?php
$this->breadcrumbs=array(
	'Paymentreceipts'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Paymentreceipt','url'=>array('index')),
array('label'=>'Manage Paymentreceipt','url'=>array('admin')),
);
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>