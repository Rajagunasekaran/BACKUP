<?php
$this->breadcrumbs=array(
	'Productprices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Productprice','url'=>array('index')),
	array('label'=>'Create Productprice','url'=>array('create')),
	array('label'=>'View Productprice','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Productprice','url'=>array('admin')),
	);
	?>

	<h1>Update Productprice <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>