<?php
$this->breadcrumbs=array(
	'Purchaseproducts'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Purchaseproduct','url'=>array('index')),
array('label'=>'Manage Purchaseproduct','url'=>array('admin')),
);
?>

<h1>Create Purchaseproduct</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>