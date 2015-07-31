<?php
$this->breadcrumbs=array(
	'Consignmentnotes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Consignmentnote','url'=>array('index')),
	array('label'=>'Create Consignmentnote','url'=>array('create')),
	array('label'=>'View Consignmentnote','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Consignmentnote','url'=>array('admin')),
	);
	?>

	<h1>Update Consignmentnote <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>