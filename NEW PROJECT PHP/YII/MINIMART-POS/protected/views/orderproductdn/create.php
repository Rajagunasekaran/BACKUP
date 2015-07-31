<?php
$this->breadcrumbs=array(
	'Orderproductdns'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Orderproductdn','url'=>array('index')),
array('label'=>'Manage Orderproductdn','url'=>array('admin')),
);
?>

<h1>Create Orderproductdn</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>