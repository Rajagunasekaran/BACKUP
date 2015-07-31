<?php
/* @var $this PurchaseentryController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1 style="color:#0000FF">Create Product</h1>

<?php echo $this->renderPartial('_form', 
        array('model'=>$model,
            'subproductprice' => $subproductprice,
            )
        ); 

?>