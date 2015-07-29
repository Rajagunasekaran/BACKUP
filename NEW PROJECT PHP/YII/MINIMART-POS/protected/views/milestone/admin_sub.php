<?php 
$msGridId = 'msGridId';
$onsavejs ='js: function(e, params) {
                //alert("saved value: "+params.newValue);
            }';
$onsuccessjs = 'js: function(response, newValue) {
                    if(response === "NotOK") {
                        alert("Update not done");
                    }
                    $.fn.yiiGridView.update("$msGridId");
                }';
$msGridCols = array(
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
                    'name'=>'details',
                    'value'=>'$data->details',
                    'class' => 'booster.widgets.TbEditableColumn',
                    'editable' => array(
                            'mode'=>'inline',
                            'url' => $this->createUrl('order/' . Helper::CONST_updateProductAjax),
                            'success' => $onsuccessjs,
                    ),
                ),
                array (
                    'name'=>'remarks',
                    'value'=>'$data->remarks',
                    'class' => 'booster.widgets.TbEditableColumn',
                    'editable' => array(
                            'mode'=>'inline',
                            'url' => $this->createUrl('order/' . Helper::CONST_updateProductAjax),
                            'success' => $onsuccessjs,
                    ),
                ),
                array (
                    'name'=>'start_at',
                    'value'=>'$data->displayStart_at',
                    'class' => 'booster.widgets.TbEditableColumn',
                    'editable' => array(
                            'type' => 'combodate',
                            'options' => array(
                                'mode'=>'popup',
//                                            'datepicker' => array(
////                                                'altFormat' => Yii::app()->controller->datetimemysqlformatYMDHIS,
////                                                'dateFormat' => Yii::app()->controller->boosterTbDateRangePickerFormat, //format for display
////                                                //'language' => 'ru',
//                                                'format' => Yii::app()->controller->datetimemysqlformatYMDHIS, //database datetime format
//                                                'viewformat' => Yii::app()->controller->boosterTbDateRangePickerFormat, //format for display
//                                                ),
//                                            'datetimepicker' => array(
////                                                'altFormat' => Yii::app()->controller->datetimemysqlformatYMDHIS,
////                                                'dateFormat' => Yii::app()->controller->boosterTbDateRangePickerFormat, //format for display
////                                                //'language' => 'ru',
////                                                'format' => Yii::app()->controller->datetimemysqlformatYMDHIS, //database datetime format
////                                                'viewformat' => Yii::app()->controller->boosterTbDateRangePickerFormat, //format for display
//                                                ),
                                        ),
                            'url' => $this->createUrl('order/' . Helper::CONST_updateProductAjax),
                            'success' => $onsuccessjs,
                    ),
                ),                
);
$msGridOptions = array(
                        'id'=> $msGridId,
                        'dataProvider'=> $model->search(),
                        'columns'=>$msGridCols,
                        );
$this->setDefaultGVOptions($msGridOptions, Helper::CONST_grid_Height_300,
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
    $options = array_merge($msGridOptions, array('afterAjaxUpdate'=>$afterAjaxUpdate));        
}
$msGridContent = $this->widget("booster.widgets.TbGridView", $msGridOptions, true);
echo $msGridContent;
?>