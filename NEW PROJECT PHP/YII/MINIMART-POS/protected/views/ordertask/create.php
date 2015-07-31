<?php
$this->breadcrumbs=array(
	'Ordertasks'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Ordertask','url'=>array('index')),
array('label'=>'Manage Ordertask','url'=>array('admin')),
);
?>

<h1>Create Ordertask</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>