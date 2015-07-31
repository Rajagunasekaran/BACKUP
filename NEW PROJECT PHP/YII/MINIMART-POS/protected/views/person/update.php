<?php
$this->breadcrumbs=array(
	'People'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);
	?>
<?php echo $this->renderPartial($this->getView('form','_form'),array('model'=>$model)); ?>