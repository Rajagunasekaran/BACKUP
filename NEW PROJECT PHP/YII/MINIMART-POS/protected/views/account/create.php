<?php
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Account','url'=>array('index')),
array('label'=>'Manage Account','url'=>array('admin')),
);
?>
<?php echo $this->renderPartial($this->getView('form', '_form'), 
        array('model'=>$model,
            'accoutordersearch' => $accoutordersearch,)
        );
?>