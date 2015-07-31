<?php
$this->breadcrumbs=array(
	'Mailqueues'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Mailqueue','url'=>array('index')),
	array('label'=>'Create Mailqueue','url'=>array('create')),
	array('label'=>'View Mailqueue','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Mailqueue','url'=>array('admin')),
	);
	?>

	<h1>Update Mailqueue <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>