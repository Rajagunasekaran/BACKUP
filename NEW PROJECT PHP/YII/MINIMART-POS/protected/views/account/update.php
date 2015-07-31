<?php
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Account','url'=>array('index')),
	array('label'=>'Create Account','url'=>array('create')),
	array('label'=>'View Account','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Account','url'=>array('admin')),
	);
	?>
<?php echo $this->renderPartial($this->getView('form','_form'),
        array('model'=>$model,
            'accoutordersearch' => $accoutordersearch,)
        ); 
?>