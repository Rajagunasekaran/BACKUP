<?php
/* @var $this PoslogreportController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Poslogreports',
);

$this->menu=array(
	array('label'=>'Create Poslogreport', 'url'=>array('create')),
	array('label'=>'Manage Poslogreport', 'url'=>array('admin')),
);
?>

<h1>Poslogreports</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
