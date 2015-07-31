<?php
$this->breadcrumbs=array(
	'Persontimeslots'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Persontimeslot','url'=>array('index')),
	array('label'=>'Create Persontimeslot','url'=>array('create')),
	array('label'=>'View Persontimeslot','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Persontimeslot','url'=>array('admin')),
	);
	?>

	<h1>Update Persontimeslot <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>