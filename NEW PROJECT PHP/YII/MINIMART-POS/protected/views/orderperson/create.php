<?php
$this->breadcrumbs=array(
	'Orderpeople'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Orderperson','url'=>array('index')),
array('label'=>'Manage Orderperson','url'=>array('admin')),
);
?>

<h1>Create Orderperson</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>