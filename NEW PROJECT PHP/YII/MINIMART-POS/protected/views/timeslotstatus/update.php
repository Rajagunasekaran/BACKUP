<?php
$this->breadcrumbs=array(
	'Timeslotstatuses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Timeslotstatus','url'=>array('index')),
	array('label'=>'Create Timeslotstatus','url'=>array('create')),
	array('label'=>'View Timeslotstatus','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Timeslotstatus','url'=>array('admin')),
	);
	?>

	<h1>Update Timeslotstatus <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>