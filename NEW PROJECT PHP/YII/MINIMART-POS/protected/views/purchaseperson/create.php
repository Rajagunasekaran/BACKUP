<?php
$this->breadcrumbs=array(
	'Purchasepeople'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Purchaseperson','url'=>array('index')),
array('label'=>'Manage Purchaseperson','url'=>array('admin')),
);
?>

<h1>Create Purchaseperson</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>