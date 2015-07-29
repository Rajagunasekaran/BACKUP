<?php
$this->breadcrumbs=array(
	'Productstockhistories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Productstockhistory','url'=>array('index')),
	array('label'=>'Create Productstockhistory','url'=>array('create')),
	array('label'=>'View Productstockhistory','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Productstockhistory','url'=>array('admin')),
	);
	?>

	<h1>Update Productstockhistory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>