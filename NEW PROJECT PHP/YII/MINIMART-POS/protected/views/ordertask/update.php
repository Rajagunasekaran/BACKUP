<?php
$this->breadcrumbs=array(
	'Ordertasks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Ordertask','url'=>array('index')),
	array('label'=>'Create Ordertask','url'=>array('create')),
	array('label'=>'View Ordertask','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Ordertask','url'=>array('admin')),
	);
	?>

	<h1>Update Ordertask <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>