<?php
$this->breadcrumbs=array(
	'Mailqueues'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Mailqueue','url'=>array('index')),
array('label'=>'Manage Mailqueue','url'=>array('admin')),
);
?>

<h1>Create Mailqueue</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>