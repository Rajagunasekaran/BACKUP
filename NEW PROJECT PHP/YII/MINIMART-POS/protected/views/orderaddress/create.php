<?php
$this->breadcrumbs=array(
	'Orderaddresses'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Orderaddress','url'=>array('index')),
array('label'=>'Manage Orderaddress','url'=>array('admin')),
);
?>

<h1>Create Orderaddress</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>