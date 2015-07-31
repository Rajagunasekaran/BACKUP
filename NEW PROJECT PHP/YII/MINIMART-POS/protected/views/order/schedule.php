<style type="text/css">
.labels {
   color: blue;
   background-color: yellow;
   font-family: "Lucida Grande", "Arial", sans-serif;
   font-size: 10px;
   font-weight: bold;
   text-align: center;
   opacity:0.75;
   white-space: nowrap;
   width:100px;
   border:20px solid black;
}
</style>
<?php
$portlet1gridId = 'schedule-order-open-grid';
$portlet2gridId = 'schedule-order-rejected-grid';
$portlet3gridId = 'schedule-order-undelivered-grid';
$portlet4gridId = 'schedule-employee-grid';
Yii::app()->clientScript->registerScript('refresh_page',"
timedRefresh($this->page_load_delay_ms);

function timedRefresh(timeoutPeriod) {
	setTimeout(function(){refreshGrid()}, timeoutPeriod);
}
 
function refreshGrid() {
        $('#$portlet1gridId').yiiGridView.update(\"$portlet1gridId\");
        $('#$portlet2gridId').yiiGridView.update(\"$portlet2gridId\");
        $('#$portlet3gridId').yiiGridView.update(\"$portlet3gridId\");
        $('#$portlet4gridId').yiiGridView.update(\"$portlet4gridId\");
	//$.fn.yiiGridView.update(\"$portlet1gridId\");
        var refresh = $this->db_auto_refresh;
        if(refresh)
        {
            timedRefresh($this->db_auto_refresh_freq);
            EGMapContainer1_init();
        }
}
");
?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'order-schedule-form',
	'enableAjaxValidation'=>false,
));
echo $form->errorSummary($model); 
?>
<?php
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  false,
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
<div class="row">
    <input type="hidden" id="hdn_orderid" /> <input type="hidden" id="hdn_empid" />
    <div class="col-lg-4">
        <strong>Job Details</strong>
        <div id="jobdetails"></div>
    </div>
    <div class="col-lg-4">
        <strong>Assign To</strong>
        <div id="empdetails"></div>
    </div>
    <div class="col-md-4">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'ajaxSubmit',
            'context'=>'primary',
            'label'=>'Assign',
            'url' => Yii::app()->createUrl('order/' . Helper::CONST_schedule),
            'ajaxOptions' => array(
                'dataType' => 'json',
                'success'=>'js:function(data){ afterSchedule(data); refreshGrid(); }'
                ),
            'htmlOptions' => array('id' => 'assignBtn', 'onclick'=>'js:beforeSchedule("Wait...");')
        ));
        ?>
        <div id="gridsubmitresult"></div>
    </div>
    </div>
<?php $this->endWidget(); ?>
<?php
$flds = $this->appFormFields['lf']['order'];
unset($flds['addnlinfo']);
unset($flds['addnlinfo3']);
unset($flds['employee_id']);
unset($flds['toaddr_id']);
$radiocell = array();
$radiocell['amount'] = array('name' => 'amount',
                                'header' => '',
                                    'type' => 'raw',
                                    'class'=>'DataColumn',
                                    'evaluateHtmlOptions'=>true,
                                    'htmlOptions'=>array(
                                        'id'=>'"order_{$data->id}"',
                                        'onclick' => '"js:fillorderdetails(
                                            \"{$data->addnlinfo}\"
                                            ,\"{$data->displayFrom}\"
                                            ,\"{$data->addnlinfo1}\"
                                            ,\"{$data->id}\"
                                            );"'
                                        ),
                                    'value' => '$data->radioCell'
                                );
$flds = array_merge($radiocell, $flds);
$flds['addnlinfo1'] = array('name' => 'addnlinfo1','header'=>'Time');
$flds['fromaddr_id'] = array('name' => 'fromaddr_id','header'=>'From','type' => 'raw','value' => '$data->displayFrom');
$btncols = array( );
$columns = array_merge($btncols, $flds);
$options = array(
                'columns'=> $columns,
                );
$this->setDefaultGVOptions($options, Helper::CONST_grid_Height_300,
                Helper::CONST_grid_Font_10, Helper::CONST_grid_Template_SI);
?>
<div class="row" id="schedulepage">
<div class="col-md-3 cols">
<?php
    $options['id'] = 'schedule-order-open-grid';
    $options['dataProvider'] = $ordersearch->searchByStatus(Helper::CONST_OPEN);            
    $panel1= $this->widget('booster.widgets.TbGridView', $options, true);
?>    
<?php
    $options['id'] = 'schedule-order-rejected-grid';
    $options['dataProvider'] = $ordersearch->searchByStatus(Helper::CONST_REJECTED);
    $panel2 = $this->widget('booster.widgets.TbGridView', $options, true);
?>
<?php
    $options['id'] = 'schedule-order-undelivered-grid';
    $options['dataProvider'] = $ordersearch->searchByStatus(Helper::CONST_UNDELIVERED);
    $panel3 = $this->widget('booster.widgets.TbGridView', $options, true);
?>    
<?php
	$this->widget('zii.widgets.jui.CJuiAccordion',array(
	    'panels'=>array(
	       "<span class='color1'>".ucwords(strtolower(Helper::CONST_OPEN))."</span>" =>$panel1,
	        "<span class='color2'>".ucwords(strtolower(Helper::CONST_REJECTED))."</span>"=>$panel2,
	        "<span class='color3'>".ucwords(strtolower(Helper::CONST_UNDELIVERED))."</span>"=>$panel3,
	    ),
	    // additional javascript options for the accordion plugin
	    'options'=>array(
	        'collapsible'=> true,
	        'animated'=>'bounceslide',
	        'autoHeight'=>true,
	        'active'=>0,
	    ),
	));
?>
</div>
<div class="col-md-6 cols">
<?php
if(!empty($gMap))
{
    $gMap->renderMap();
}
?>
</div>
<div class="col-md-3 cols">
<?php
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  $this->getMenuLabels(Helper::CONST_Employee),
        'context' => 'default',
        //'headerIcon' => 'info',
        'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>    
<?php 
    $flds = $this->appFormFields['lf']['person'];
    unset($flds['mail']);
    $flds['contact'] = array('name' => 'contact' , 'header' => 'Location'
                                        ,'value' => '$data->displayLocation'
                                    );
    $flds['mobile'] = array('name' => 'mobile', 'header' => 'Time',
                                        'value' => '$data->displayTime'
                                    );
//    $flds['role_id'] = array('name' => 'role_id' , 'header' => false,
//                                        'type' => 'raw'
//                                        ,'value' => '$data->radioCell'
//                                    );    
    $flds['role_id'] = array('name' => 'role_id',
                                    'header' => '',
                                        'type' => 'raw',
                                        'class'=>'DataColumn',
                                        'evaluateHtmlOptions'=>true,
                                        'htmlOptions'=>array(
                                            'id'=>'"order_{$data->id}"',
                                            'onclick' => '"js:fillassigndetails(                                                
                                                \"{$data->name}\"
                                                ,\"{$data->id}\"
                                                );"'
                                            ),
                                        'value' => '$data->radioCell'
                                    );
    $btncols = array( );
    $columns = array_merge($btncols, $flds);
    $afterAjaxUpdate = "function() {}";
    $options = array(
                    'id' => 'schedule-employee-grid',
                    'dataProvider' => $employeesearch->searchByRole(Helper::CONST_Employee),
                    'columns'=> $columns,
                    'afterAjaxUpdate'=> $afterAjaxUpdate,
                    );
    $this->setDefaultGVOptions($options, Helper::CONST_grid_Height_300,
                Helper::CONST_grid_Font_10, Helper::CONST_grid_Template_SI);
    $this->widget('booster.widgets.TbGridView', $options);
    ?>
<?php $this->endWidget(); ?>    
</div>
<?php $this->endWidget(); ?>