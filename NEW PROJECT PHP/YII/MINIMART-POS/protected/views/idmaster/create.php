<?php
$this->breadcrumbs=array(
	'Idmasters'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Idmaster','url'=>array('index')),
array('label'=>'Manage Idmaster','url'=>array('admin')),
);
?>

<h1>Create Idmaster</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>