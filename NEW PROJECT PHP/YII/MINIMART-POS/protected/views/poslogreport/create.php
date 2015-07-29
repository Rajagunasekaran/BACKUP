<?php
/* @var $this PoslogreportController */
/* @var $model Poslogreport */

$this->breadcrumbs=array(
	'Poslogreports'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Poslogreport', 'url'=>array('index')),
	array('label'=>'Manage Poslogreport', 'url'=>array('admin')),
);
?>

<h1>Create Poslogreport</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>