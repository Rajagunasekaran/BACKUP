<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Order','url'=>array('index')),
array('label'=>'Manage Order','url'=>array('admin')),
);
?>
<?php echo $this->renderPartial('_form'
        , array(
            'model'=>$model,
            'opmodel' => $opmodel,
            'allproducts'=>$allproducts,
            'milestonemodel'=>$milestonemodel,
            'otmodel' => $otmodel,
            'alltasks' => $alltasks,
            'allcontractors' => $allcontractors,
            )
        ); 
?>