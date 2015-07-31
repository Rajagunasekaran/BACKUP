<?php
$this->breadcrumbs=array(
	'Persontimeslots'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Persontimeslot','url'=>array('index')),
array('label'=>'Manage Persontimeslot','url'=>array('admin')),
);
?>

<h1>Create Persontimeslot</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>