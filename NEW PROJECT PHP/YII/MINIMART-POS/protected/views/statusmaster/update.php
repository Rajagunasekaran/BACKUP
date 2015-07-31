<?php
$this->breadcrumbs=array(
	'Statusmasters'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Statusmaster','url'=>array('index')),
	array('label'=>'Create Statusmaster','url'=>array('create')),
	array('label'=>'View Statusmaster','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Statusmaster','url'=>array('admin')),
	);
	?>

	<h1>Update Statusmaster <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>