<?php
$this->breadcrumbs=array(
	'Consignmentnotes'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Consignmentnote','url'=>array('index')),
array('label'=>'Manage Consignmentnote','url'=>array('admin')),
);
?>

<h1>Create Consignmentnote</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>