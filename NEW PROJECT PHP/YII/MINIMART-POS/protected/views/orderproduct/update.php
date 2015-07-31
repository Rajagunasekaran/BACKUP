<?php
$this->breadcrumbs=array(
	'Orderproducts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Orderproduct','url'=>array('index')),
	array('label'=>'Create Orderproduct','url'=>array('create')),
	array('label'=>'View Orderproduct','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Orderproduct','url'=>array('admin')),
	);
	?>

	<h1>Update Orderproduct <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>