<?php
/* @var $this StockadjustmentController */
/* @var $model Stockadjustment */

$this->breadcrumbs=array(
	'Stockadjustments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Stockadjustment', 'url'=>array('index')),
	array('label'=>'Manage Stockadjustment', 'url'=>array('admin')),
);
?>

<h1>Create Stockadjustment</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>