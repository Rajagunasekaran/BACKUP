<?php
$this->breadcrumbs=array(
	'Accountorders'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Accountorder','url'=>array('index')),
	array('label'=>'Create Accountorder','url'=>array('create')),
	array('label'=>'View Accountorder','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Accountorder','url'=>array('admin')),
	);
	?>

	<h1>Update Accountorder <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>