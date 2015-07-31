<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Order','url'=>array('index')),
	array('label'=>'Create Order','url'=>array('create')),
	array('label'=>'View Order','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Order','url'=>array('admin')),
	);
	?>
<?php echo $this->renderPartial('_form'
        , array(
            'model'=>$model,
            'opmodel' => $opmodel,
            'allproducts' => $allproducts,
            'milestonemodel'=>$milestonemodel,
            'otmodel' => $otmodel,
            'alltasks' => $alltasks,
            'allcontractors' => $allcontractors,
            )
        ); ?>