<?php
$this->breadcrumbs=array(
	'Statushistories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Statushistory','url'=>array('index')),
	array('label'=>'Create Statushistory','url'=>array('create')),
	array('label'=>'View Statushistory','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Statushistory','url'=>array('admin')),
	);
	?>

	<h1>Update Statushistory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>