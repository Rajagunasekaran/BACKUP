<?php
$this->breadcrumbs=array(
	'Orderaddresses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Orderaddress','url'=>array('index')),
	array('label'=>'Create Orderaddress','url'=>array('create')),
	array('label'=>'View Orderaddress','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Orderaddress','url'=>array('admin')),
	);
	?>

	<h1>Update Orderaddress <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>