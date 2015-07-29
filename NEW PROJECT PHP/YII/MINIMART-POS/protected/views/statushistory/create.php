<?php
$this->breadcrumbs=array(
	'Statushistories'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Statushistory','url'=>array('index')),
array('label'=>'Manage Statushistory','url'=>array('admin')),
);
?>

<h1>Create Statushistory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>