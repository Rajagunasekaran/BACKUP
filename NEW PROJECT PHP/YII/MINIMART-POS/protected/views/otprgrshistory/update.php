<?php
$this->breadcrumbs=array(
	'Otprgrshistories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Otprgrshistory','url'=>array('index')),
	array('label'=>'Create Otprgrshistory','url'=>array('create')),
	array('label'=>'View Otprgrshistory','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Otprgrshistory','url'=>array('admin')),
	);
	?>

	<h1>Update Otprgrshistory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>