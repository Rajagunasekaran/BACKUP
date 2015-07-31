<?php
/* @var $this SampleController */
/* @var $model Sample */

$this->breadcrumbs=array(
	'Samples'=>array('index'),
	$model->name=>array('view','id'=>$model->sno),
	'Update',
);

$this->menu=array(
	array('label'=>'List Sample', 'url'=>array('index')),
	array('label'=>'Create Sample', 'url'=>array('create')),
	array('label'=>'View Sample', 'url'=>array('view', 'id'=>$model->sno)),
	array('label'=>'Manage Sample', 'url'=>array('admin')),
);
?>

<h1>Update Sample <?php echo $model->sno; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>