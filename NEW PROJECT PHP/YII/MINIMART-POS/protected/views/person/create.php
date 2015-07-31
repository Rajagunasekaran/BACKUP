<?php
$this->breadcrumbs=array(
	'People'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Person','url'=>array('index')),
array('label'=>'Manage Person','url'=>array('admin')),
);
?>

<?php echo $this->renderPartial($this->getView('form','_form'), array('model'=>$model)); ?>