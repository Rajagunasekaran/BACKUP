<?php
$this->breadcrumbs=array(
	'Accountpurchases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Accountpurchase','url'=>array('index')),
	array('label'=>'Create Accountpurchase','url'=>array('create')),
	array('label'=>'View Accountpurchase','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Accountpurchase','url'=>array('admin')),
	);
	?>

	<h1>Update Accountpurchase <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>