<?php
$this->breadcrumbs=array(
	'Timeslotstatuses'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Timeslotstatus','url'=>array('index')),
array('label'=>'Manage Timeslotstatus','url'=>array('admin')),
);
?>

<h1>Create Timeslotstatus</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>