<?php
$this->breadcrumbs=array(
	'Loginhistories'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Loginhistory','url'=>array('index')),
array('label'=>'Manage Loginhistory','url'=>array('admin')),
);
?>

<h1>Create Loginhistory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>