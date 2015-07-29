<?php
$this->breadcrumbs=array(
	'Idmasters'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Idmaster','url'=>array('index')),
	array('label'=>'Create Idmaster','url'=>array('create')),
	array('label'=>'View Idmaster','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Idmaster','url'=>array('admin')),
	);
	?>

	<h1>Update Idmaster <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>