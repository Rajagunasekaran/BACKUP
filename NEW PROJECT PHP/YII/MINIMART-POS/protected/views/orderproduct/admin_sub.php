<?php 
$opGridCols = array(
                        array(
                                'class'=>'booster.widgets.TbButtonColumn',
                                'template'=>'{delete}',
                                'afterDelete'=>'function(link,success,data){
                                    //if(success) alert(data.message + data.data); 
                                    afterUpdateProduct_orderentry(data);
                                    }',
                                'buttons'=>array
                                (                                
                                    'delete' => array
                                    (
                                        'url'=>function ($data, $row) { 
                                                    return $this->createUrl('orderproduct/delete', array('id'=>$data->id));
                                                },                                    
                                    )
                                ),
                            ),
                            array (
                                'name'=>'product_id',
                                'value'=>'$data->product->display',
                                'header'=>'Product',
                                'filter'=> $allproducts,
                                'class' => 'booster.widgets.TbEditableColumn',
                                'editable' => array(
                                        'type' => 'select',
                                        'url' => $this->createUrl('order/' . Helper::CONST_updateProductAjax),
                                        'source'=> $allproducts,
                                        //'onSave' => $onsavejs,
                                        'success' => $onsuccessjs,
                                ),
                            ),
                            array (
                                'name'=>'quantity',
                                'value'=>'$data->quantity',
                                'class' => 'booster.widgets.TbEditableColumn',
                                'editable' => array(
                                        'url' => $this->createUrl('order/' . Helper::CONST_updateProductAjax),
                                        //'onSave' => $onsavejs,
                                        'success' => $onsuccessjs,
                                ),
                            ),
                            array (
                                'name'=>'unit_sp',
                                'value'=>'$data->unit_sp',
                                'class' => 'booster.widgets.TbEditableColumn',
                                'editable' => array(
                                        'url' => $this->createUrl('order/' . Helper::CONST_updateProductAjax),
                                        //'onSave' => $onsavejs,
                                        'success' => $onsuccessjs,
                                ),
                            ),
                            'amount'
                    );
$opGridCols1 = array(         
                            array (
                                'name'=>'id',
                                'value'=>'$data->product->supplier->name',
                            ),
                            array (
                                'name'=>'product_id',
                                'value'=>'$data->product->name',
                            ),
                            array (
                                'name'=>'amount',
                                'value'=>'$data->amount',                                
                            ),
                    );
$opGridOptions = array(
                        'id'=> $opGridId,
                        'dataProvider'=> $model->searchSupplierProducts(),
                        'columns'=>$opGridCols1,
                        );
$this->setDefaultGVOptions($opGridOptions, Helper::CONST_grid_Height_300,
                Helper::CONST_grid_Font_10, Helper::CONST_grid_Template_I);
$isafterajaxupdate = true;
if($isafterajaxupdate)
{
    $afterAjaxUpdate = "function() {
//                    jQuery('#Attendance_date_first').datepicker({'showAnim':'fold','dateFormat':'dd/mm/yy','language':'en'});
//                    jQuery('#Attendance_date_last').datepicker({'showAnim':'fold','dateFormat':'dd/mm/yy','language':'en'});
//                    jQuery('#Attendance_date_first').datepicker({'showAnim':'fold','dateFormat':'$this->cJuiDatePickerViewFormat'});
//                    jQuery('#Attendance_date_last').datepicker({'showAnim':'fold','dateFormat':'$this->cJuiDatePickerViewFormat'});
                    }";
    $options = array_merge($opGridOptions, array('afterAjaxUpdate'=>$afterAjaxUpdate));        
}
$opGridContent = $this->widget("booster.widgets.TbGridView", $opGridOptions, true);
echo $opGridContent;
?>