<?php
$this->breadcrumbs=array(
	'Accountorders'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Accountorder','url'=>array('index')),
array('label'=>'Manage Accountorder','url'=>array('admin')),
);
?>

<h1>Create Accountorder</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>