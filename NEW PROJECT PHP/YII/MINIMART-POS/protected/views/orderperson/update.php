<?php
$this->breadcrumbs=array(
	'Orderpeople'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Orderperson','url'=>array('index')),
	array('label'=>'Create Orderperson','url'=>array('create')),
	array('label'=>'View Orderperson','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Orderperson','url'=>array('admin')),
	);
	?>

	<h1>Update Orderperson <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>