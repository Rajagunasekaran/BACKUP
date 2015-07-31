<?php
$this->breadcrumbs=array(
	'Personaddresses'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Personaddress','url'=>array('index')),
array('label'=>'Manage Personaddress','url'=>array('admin')),
);
?>

<h1>Create Personaddress</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>