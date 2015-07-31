<?php
$this->breadcrumbs=array(
	'Productpeople'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Productperson','url'=>array('index')),
	array('label'=>'Create Productperson','url'=>array('create')),
	array('label'=>'View Productperson','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Productperson','url'=>array('admin')),
	);
	?>

	<h1>Update Productperson <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>