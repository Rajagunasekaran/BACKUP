<?php
$this->breadcrumbs=array(
	'Loginhistories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Loginhistory','url'=>array('index')),
	array('label'=>'Create Loginhistory','url'=>array('create')),
	array('label'=>'View Loginhistory','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Loginhistory','url'=>array('admin')),
	);
	?>

	<h1>Update Loginhistory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>