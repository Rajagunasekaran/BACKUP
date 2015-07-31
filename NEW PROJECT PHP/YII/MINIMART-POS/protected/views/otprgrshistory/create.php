<?php
$this->breadcrumbs=array(
	'Otprgrshistories'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Otprgrshistory','url'=>array('index')),
array('label'=>'Manage Otprgrshistory','url'=>array('admin')),
);
?>

<h1>Create Otprgrshistory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>