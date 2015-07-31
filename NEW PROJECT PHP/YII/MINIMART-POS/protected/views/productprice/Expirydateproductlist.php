<?php
   Yii::app()->clientScript->registerScript('search', "
   $('.search-button').click(function(){
   $('.search-form').toggle();
   return false;
   });
   $('.search-form form').submit(function(){
   $.fn.yiiGridView.update('Expirydateproductlist-grid', {
   data: $(this).serialize()
   });
   return false;
   });
   ");
?>
<h3 style="color:#0000FF">Expiry Product List</h3>
<div class="search-form" >
       <?php $this->renderPartial('_searchExpiry',array(
       'model'=>$model,
)); ?>
</div>
<?php 
$flds = $this->appFormFields['lf']['productprice'];
unset($flds['unit_sp']);
unset($flds['unit_cp']);
unset($flds['stock']);
unset($flds['stockvalue']);
unset($flds['rol']);
unset($flds['moq']);
unset($flds['supplier_id']);
$flds['product_id'] = array(
                        'name' => 'product_id',
                        'value' => '$data->product->name',
                        );
//$flds['supplier_id'] = array(
//                        'name' => 'supplier_id',
//                        'value' => '$data->supplier->display',
//                        );
$updateUrl = $this->createUrl('productprice/' . Helper::CONST_updateProductStockAjax);

//$flds['stock'] = array (
//                    'name'=>'stock',
//                    'value'=>'$data->displayStock',                    
//                );
$flds['expdate'] = array(
                        'name' => 'expdate',
                        'value' => '$data->expdate',
                        );
$flds['invno'] = array(
                        'name' => 'invno',
                        'value' => '$data->invno',
                        );
$flds['invdate'] = array(
                        'name' => 'invdate',
                        'value' => '$data->invdate',
                        );
//$flds['created_at'] = array (
//                    'name'=>'created_at',
//                    'value'=>'$data->created_at',                  
//                );
$flds['status'] = array (
                    'name'=>'status',
                    'value'=>'$data->status',
                    'class' => 'booster.widgets.TbToggleColumn',
    'filter'=>'',
                );
//$flds['stock'] = array('name' => 'stock'
//                                    ,'type' => 'raw'
//                                    ,'value' => '$data->displayStock'
//                                );
$btncols = array();
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>'Expirydateproductlist-grid',
            'dataProvider'=> $model->ExpirydateProductList(),
            'filter'=>$model,
            'columns'=> $columns,
            );
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'Expirydateproductlist-grid',
	'dataProvider'=>$model->ExpirydateProductList(),
    'filter'=>$model,
	'columns'=>$flds, 
));
?>