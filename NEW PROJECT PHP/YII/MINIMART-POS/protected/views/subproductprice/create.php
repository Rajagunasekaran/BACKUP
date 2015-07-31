<?php
/* @var $this SubproductpriceController */
/* @var $model Subproductprice */

$this->breadcrumbs=array(
	'Subproductprices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Subproductprice', 'url'=>array('index')),
	array('label'=>'Manage Subproductprice', 'url'=>array('admin')),
);
?>

<h1>Create Subproductprice</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>