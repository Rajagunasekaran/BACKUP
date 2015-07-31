<?php
$this->breadcrumbs=array(
	'Taxrates'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Taxrate','url'=>array('index')),
array('label'=>'Manage Taxrate','url'=>array('admin')),
);
?>

<h1>Create Taxrate</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>