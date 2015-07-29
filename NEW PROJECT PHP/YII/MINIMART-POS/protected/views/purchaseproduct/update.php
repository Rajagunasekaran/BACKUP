<?php
$this->breadcrumbs=array(
	'Purchaseproducts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Purchaseproduct','url'=>array('index')),
	array('label'=>'Create Purchaseproduct','url'=>array('create')),
	array('label'=>'View Purchaseproduct','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Purchaseproduct','url'=>array('admin')),
	);
	?>

	<h1>Update Purchaseproduct <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>