<?php
$this->breadcrumbs=array(
	'Paymentreceipts'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Paymentreceipt','url'=>array('index')),
array('label'=>'Create Paymentreceipt','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('paymentreceipt-grid', {
data: $(this).serialize()
});
return false;
});
");
?>
<?php
$btncols = array( array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'template'=>'{update}{delete}',
                        'buttons'=>array(
                            'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("paymentreceipt/update/$data->id")',
                            ),
                        ),
                    ),
                );
    $columns = array(
		'customer_id'=> array('name' => 'customer_id'
                            ,'value' => '$data->customer->name'),
		'amount',
		'details',
		'paid_date',
                );
$columns = array_merge($btncols, $columns);
$options = array(
            'id'=>'paymentreceipt-grid',
            'dataProvider'=>$model->search(),
            'columns'=>$columns,
);

 ?>
<H3 style="color:#0000FF" > Customer Payment Details</H3>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sample-grid',
	'dataProvider'=>$model->search(),
        'filter'=>$model,
	'columns'=>$columns, 
));  ?>
