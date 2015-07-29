<?php
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Category','url'=>array('index')),
array('label'=>'Manage Category','url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form1', array('model'=>$model)); ?>