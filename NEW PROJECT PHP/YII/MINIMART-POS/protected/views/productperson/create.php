<?php
$this->breadcrumbs=array(
	'Productpeople'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Productperson','url'=>array('index')),
array('label'=>'Manage Productperson','url'=>array('admin')),
);
?>

<h1>Create Productperson</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>