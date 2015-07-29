<?php
$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Product','url'=>array('index')),
	array('label'=>'Create Product','url'=>array('create')),
	array('label'=>'View Product','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Product','url'=>array('admin')),
	);
	?>
<h1 style="color:#0000FF">Purchase Product</h1>
<?php echo $this->renderPartial('_form', 
        array('model'=>$model,
            'productprice' => $productprice,'taxrate'=>$taxrate
       
            )
   
        );     ?>