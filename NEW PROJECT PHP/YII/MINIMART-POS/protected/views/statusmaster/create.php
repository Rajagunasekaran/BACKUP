<?php
$this->breadcrumbs=array(
	'Statusmasters'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Statusmaster','url'=>array('index')),
array('label'=>'Manage Statusmaster','url'=>array('admin')),
);
?>

<h1>Create Statusmaster</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>