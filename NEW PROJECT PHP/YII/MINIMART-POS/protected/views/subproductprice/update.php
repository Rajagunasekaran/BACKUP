<?php
/* @var $this SubproductpriceController */
/* @var $model Subproductprice */

$this->breadcrumbs=array(
	'Subproductprices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Subproductprice', 'url'=>array('index')),
	array('label'=>'Create Subproductprice', 'url'=>array('create')),
	array('label'=>'View Subproductprice', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Subproductprice', 'url'=>array('admin')),
);
?>

<h1>Update Subproductprice <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>