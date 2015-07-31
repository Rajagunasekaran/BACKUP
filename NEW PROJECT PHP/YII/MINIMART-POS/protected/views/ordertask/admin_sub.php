<?php 
$otGridId = 'otGridId';
$onsavejs ='js: function(e, params) {
                //alert("saved value: "+params.newValue);
            }';
$onsuccessjs = 'js: function(response, newValue) {
                    if(response === "NotOK") {
                        alert("Update not done");
                    }
                    $.fn.yiiGridView.update("$otGridId");
                }';
$otGridCols = array(
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
                    'name'=>'task_id',
                    'value'=>'$data->task->name',
                    'header'=>'Site',
                    'filter'=> $alltasks,
                    'class' => 'booster.widgets.TbEditableColumn',
                    'editable' => array(
                                'mode'=>'inline',
                                'type' => 'select',
                                'url' => $this->createUrl('attendance/updateAttendance'),
                                'source'=> $alltasks,
                                'success' => $onsuccessjs,
                                ),
                ),
                array (
                    'name'=>'contractor.name',
                    'value'=>'$data->contractor->name',
                    'header'=>'Contractor',
                    'filter'=> $allcontractors,
                    'class' => 'booster.widgets.TbEditableColumn',
                    'editable' => array(
                                'mode'=>'inline',
                                'type' => 'select',
                                'url' => $this->createUrl('attendance/updateAttendance'),
                                'source'=> $allcontractors,
                                'success' => $onsuccessjs,
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
                    'name'=>'start_at',
                    'value'=>'$data->displayStart_at',
                    'class' => 'booster.widgets.TbEditableColumn',
                    'editable' => array(
                            'type' => 'combodate',
                            'url' => $this->createUrl('order/' . Helper::CONST_updateProductAjax),
                            'success' => $onsuccessjs,
                    ),
                ),
                array (
                    'name'=>'end_at',
                    'value'=>'$data->displayEnd_at',
                    'class' => 'booster.widgets.TbEditableColumn',
                    'editable' => array(
                            'type' => 'combodate',
                            'url' => $this->createUrl('order/' . Helper::CONST_updateProductAjax),
                            'success' => $onsuccessjs,
                    ),
                ),
);
$otGridOptions = array(
                        'id'=> $otGridId,
                        'dataProvider'=> $model->search(),
                        'columns'=>$otGridCols,
                        );
$this->setDefaultGVOptions($otGridOptions, Helper::CONST_grid_Height_300,
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
    $options = array_merge($otGridOptions, array('afterAjaxUpdate'=>$afterAjaxUpdate));        
}
$otGridContent = $this->widget("booster.widgets.TbGridView", $otGridOptions, true);
echo $otGridContent;
?>