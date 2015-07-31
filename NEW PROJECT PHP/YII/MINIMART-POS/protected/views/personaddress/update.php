<?php
$this->breadcrumbs=array(
	'Personaddresses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Personaddress','url'=>array('index')),
	array('label'=>'Create Personaddress','url'=>array('create')),
	array('label'=>'View Personaddress','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Personaddress','url'=>array('admin')),
	);
	?>

	<h1>Update Personaddress <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>