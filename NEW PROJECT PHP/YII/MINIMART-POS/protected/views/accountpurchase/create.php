<?php
$this->breadcrumbs=array(
	'Accountpurchases'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Accountpurchase','url'=>array('index')),
array('label'=>'Manage Accountpurchase','url'=>array('admin')),
);
?>

<h1>Create Accountpurchase</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>