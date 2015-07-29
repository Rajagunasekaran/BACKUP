<?php
$this->breadcrumbs=array(
	'Personcompanyroles'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Personcompanyrole','url'=>array('index')),
	array('label'=>'Create Personcompanyrole','url'=>array('create')),
	array('label'=>'View Personcompanyrole','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Personcompanyrole','url'=>array('admin')),
	);
	?>

	<h1>Update Personcompanyrole <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>