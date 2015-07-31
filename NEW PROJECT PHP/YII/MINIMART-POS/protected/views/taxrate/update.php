<?php
$this->breadcrumbs=array(
	'Taxrates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Taxrate','url'=>array('index')),
	array('label'=>'Create Taxrate','url'=>array('create')),
	array('label'=>'View Taxrate','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Taxrate','url'=>array('admin')),
	);
	?>

	<h1>Update Taxrate <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>