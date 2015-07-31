<?php
$this->breadcrumbs=array(
	'Paymentreceipts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Paymentreceipt','url'=>array('index')),
	array('label'=>'Create Paymentreceipt','url'=>array('create')),
	array('label'=>'View Paymentreceipt','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Paymentreceipt','url'=>array('admin')),
	);
	?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>