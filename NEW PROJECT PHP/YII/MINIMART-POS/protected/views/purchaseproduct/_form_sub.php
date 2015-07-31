<?php
$this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' => 'Products',
        'context' => 'primary',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
<div class="row">
    <div class="col-md-4">

<?php 
    echo $form->select2Group($model,'product_id',array('widgetOptions'=>array('data'=> Yii::app()->user->products,'htmlOptions'=>array('class'=>'span5','maxlength'=>10))));
?>
    </div>
    <div class="col-md-2"><?php echo $form->textFieldGroup($model,'quantity',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','onchange'=>'purchaseamountcalc_purchaseentry()')))); ?></div>
    <div class="col-md-2"><?php echo $form->textFieldGroup($model,'unit_cp',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10,'onchange'=>'purchaseamountcalc_purchaseentry()')))); ?></div>
    <div class="col-md-2"><?php echo $form->textFieldGroup($model,'amount',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span10','maxlength'=>10,'disabled'=>'disabled')))); ?></div>
    <div class="col-md-2"><?php echo CHtml::ajaxSubmitButton("Add Product", $this->createUrl('purchase/' . Helper::CONST_updateProduct,array('id'=>$model->purchase_id)), array('success'=>'afterUpdateProduct_purchaseentry'));?>
    <div id='results'>...</div></div>
</div>
<div class="row">
<div class="col-md-12">
<?php 
$onsavejs ='js: function(e, params) {
                //alert("saved value: "+params.newValue);
            }';
$onsuccessjs = 'js: function(response, newValue) {
                    afterUpdateProduct_purchaseentry(response);
                }';
$isafterajaxupdate = true;
$afterAjaxUpdate = "function() {
//                    jQuery('#Attendance_date_first').datepicker({'showAnim':'fold','dateFormat':'dd/mm/yy','language':'en'});
//                    jQuery('#Attendance_date_last').datepicker({'showAnim':'fold','dateFormat':'dd/mm/yy','language':'en'});
//                    jQuery('#Attendance_date_first').datepicker({'showAnim':'fold','dateFormat':'$this->cJuiDatePickerViewFormat'});
//                    jQuery('#Attendance_date_last').datepicker({'showAnim':'fold','dateFormat':'$this->cJuiDatePickerViewFormat'});
                    }";
$productsColumns = array(
                            array (
                                'name'=>'product_id',
                                'value'=>'$data->product->display',
                                'header'=>'Product',
                                'filter'=> Yii::app()->user->products,
                                'class' => 'booster.widgets.TbEditableColumn',
                                'editable' => array(
                                        'type' => 'select',
                                        'url' => $this->createUrl('purchase/' . Helper::CONST_updateProductAjax),
                                        'source'=> Yii::app()->user->products,
                                        //'onSave' => $onsavejs,
                                        'success' => $onsuccessjs,
                                ),
                            ),
                            array (
                                'name'=>'quantity',
                                'value'=>'$data->quantity',
                                'class' => 'booster.widgets.TbEditableColumn',
                                'editable' => array(
                                        'url' => $this->createUrl('purchase/' . Helper::CONST_updateProductAjax),
                                        //'onSave' => $onsavejs,
                                        'success' => $onsuccessjs,
                                ),
                            ),
                            array (
                                'name'=>'unit_cp',
                                'value'=>'$data->unit_cp',
                                'class' => 'booster.widgets.TbEditableColumn',
                                'editable' => array(
                                        'url' => $this->createUrl('purchase/' . Helper::CONST_updateProductAjax),
                                        //'onSave' => $onsavejs,
                                        'success' => $onsuccessjs,
                                ),
                            ),
                            'amount');
    $btncols = array( array(
                            'class'=>'booster.widgets.TbButtonColumn',
                            'template'=>'{delete}',
                            'afterDelete'=>'function(link,success,data){
                                //if(success) alert(data.message + data.data); 
                                afterUpdateProduct_purchaseentry(data);
                                }',
                            'buttons'=>array
                            (                                
                                'delete' => array
                                (
                                    'url'=>function ($data, $row) { 
                                                return $this->createUrl('purchaseproduct/delete', array('id'=>$data->id));
                                            },                                    
                                )
                            ),
                        ),
                    );
    $columns = array_merge( $btncols, $productsColumns );
    $options = array(
                'id'=>'purchaseproduct-grid',
                 'dataProvider'=>$model->search(),
                 'columns'=> $columns,
                 'template' => "{items}\n{summary}");
    if($isafterajaxupdate)
    {
        $options = array_merge($options, array('afterAjaxUpdate'=>$afterAjaxUpdate));        
    }
    $this->widget('booster.widgets.TbGridView', $options);
    
?>
</div>
</div>
<?php $this->endWidget(); ?>