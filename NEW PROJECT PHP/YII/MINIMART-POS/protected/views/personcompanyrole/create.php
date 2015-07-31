<?php
$this->breadcrumbs=array(
	'Personcompanyroles'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Personcompanyrole','url'=>array('index')),
array('label'=>'Manage Personcompanyrole','url'=>array('admin')),
);
?>

<h1>Create Personcompanyrole</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>