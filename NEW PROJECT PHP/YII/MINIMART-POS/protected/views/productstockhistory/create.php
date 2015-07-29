<?php
$this->breadcrumbs=array(
	'Productstockhistories'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Productstockhistory','url'=>array('index')),
array('label'=>'Manage Productstockhistory','url'=>array('admin')),
);
?>

<h1>Create Productstockhistory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>