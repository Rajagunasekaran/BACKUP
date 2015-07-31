<?php
$this->breadcrumbs=array(
	'Ordertaskpeople'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Ordertaskperson','url'=>array('index')),
	array('label'=>'Create Ordertaskperson','url'=>array('create')),
	array('label'=>'View Ordertaskperson','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Ordertaskperson','url'=>array('admin')),
	);
	?>

	<h1>Update Ordertaskperson <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>