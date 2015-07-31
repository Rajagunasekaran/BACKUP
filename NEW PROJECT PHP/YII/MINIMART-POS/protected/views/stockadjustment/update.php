<?php
/* @var $this StockadjustmentController */
/* @var $model Stockadjustment */

$this->breadcrumbs=array(
	'Stockadjustments'=>array('index'),
	$model->sno=>array('view','id'=>$model->sno),
	'Update',
);

$this->menu=array(
	array('label'=>'List Stockadjustment', 'url'=>array('index')),
	array('label'=>'Create Stockadjustment', 'url'=>array('create')),
	array('label'=>'View Stockadjustment', 'url'=>array('view', 'id'=>$model->sno)),
	array('label'=>'Manage Stockadjustment', 'url'=>array('admin')),
);
?>

<h1>Update Stockadjustment <?php echo $model->sno; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>