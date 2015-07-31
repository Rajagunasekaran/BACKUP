<?php
/* @var $this PoslogreportController */
/* @var $model Poslogreport */

$this->breadcrumbs=array(
	'Poslogreports'=>array('index'),
	$model->sno=>array('view','id'=>$model->sno),
	'Update',
);

$this->menu=array(
	array('label'=>'List Poslogreport', 'url'=>array('index')),
	array('label'=>'Create Poslogreport', 'url'=>array('create')),
	array('label'=>'View Poslogreport', 'url'=>array('view', 'id'=>$model->sno)),
	array('label'=>'Manage Poslogreport', 'url'=>array('admin')),
);
?>

<h1>Update Poslogreport <?php echo $model->sno; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>