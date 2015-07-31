<?php
$this->breadcrumbs=array(
	'Purchasepeople'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Purchaseperson','url'=>array('index')),
	array('label'=>'Create Purchaseperson','url'=>array('create')),
	array('label'=>'View Purchaseperson','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Purchaseperson','url'=>array('admin')),
	);
	?>

	<h1>Update Purchaseperson <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>