<?php
$this->breadcrumbs=array(
	'Productprices'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Productprice','url'=>array('index')),
array('label'=>'Manage Productprice','url'=>array('admin')),
);
?>

<h1>Create Productprice</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>