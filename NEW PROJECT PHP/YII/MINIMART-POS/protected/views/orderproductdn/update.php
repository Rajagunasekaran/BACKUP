<?php
$this->breadcrumbs=array(
	'Orderproductdns'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Orderproductdn','url'=>array('index')),
	array('label'=>'Create Orderproductdn','url'=>array('create')),
	array('label'=>'View Orderproductdn','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Orderproductdn','url'=>array('admin')),
	);
	?>

	<h1>Update Orderproductdn <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>