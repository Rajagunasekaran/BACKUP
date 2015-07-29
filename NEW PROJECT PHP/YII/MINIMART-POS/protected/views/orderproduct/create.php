<?php
$this->breadcrumbs=array(
	'Orderproducts'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Orderproduct','url'=>array('index')),
array('label'=>'Manage Orderproduct','url'=>array('admin')),
);
?>

<h1>Create Orderproduct</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>