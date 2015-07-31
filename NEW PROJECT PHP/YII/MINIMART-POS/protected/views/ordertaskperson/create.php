<?php
$this->breadcrumbs=array(
	'Ordertaskpeople'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Ordertaskperson','url'=>array('index')),
array('label'=>'Manage Ordertaskperson','url'=>array('admin')),
);
?>

<h1>Create Ordertaskperson</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>