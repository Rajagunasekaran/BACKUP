<?php 
$flds = array(
		array('name'=>'product_id','value'=>'$data->product->name','header'=>'Product'),
		'quantity',
		'unit_cp',
		'amount',
		);
$btncols = array( array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'template'=>'{update}{delete}',
                        'buttons'=>array
                        (
                            'update' => array
                            (
                                'url'=>function ($data, $row) { 
                                            return $this->createUrl('purchaseproduct/update',array('id'=>$data->id));
                                        },
                                'success'=>'afterUpdateProduct_purchaseentry'
                            ),
                            'delete' => array
                            (
                                'url'=>function ($data, $row) { 
                                            return $this->createUrl('purchaseproduct/delete',array('id'=>$data->id));
                                        },
                                'success'=>'afterUpdateProduct_purchaseentry'
                            )
                        ),
                    ),
                );
$columns = array_merge( $btncols, $flds );
$options = array(
    'id' => 'purchaseproduct-grid',
    'dataProvider'=>$model->search(),
    'columns' => $columns,
);
$this->setDefaultGVOptions($options);
$options['template'] = "{items}";
$this->widget('booster.widgets.TbGridView', $options);
?>