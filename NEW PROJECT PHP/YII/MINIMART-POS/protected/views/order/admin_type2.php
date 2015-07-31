<?php
$this->breadcrumbs = array(
    'Order' => array( 'index' ),
    'Manage',
);

$this->menu = array(
    array( 'label' => 'List Order', 'url' => array( 'index' ) ),
    array( 'label' => 'Create Order', 'url' => array( 'create' ) ),
);
?>
<div class="flash-success">
<?php 
if(Yii::app()->user->getFlash('message'))
{
echo Yii::app()->user->getFlash('message'); 
}
?>
</div>
<div class="search-form">
<?php $this->renderPartial('//order/_search',array(
'model'=>$model, 'fromdb' => $fromdb
)); ?>
</div><!-- search-form -->
<?php 
$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>'',
	'method'=>'post',
        'id' => 'order-grid-form'
));
?>
<?php
    $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'id' => 'p1',
        'title' =>  false,
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
$isvisible = (($this->isCustomer())?'display:none;':'display:block;');
?>
<div class="well well-sm" align="right" style="<?php echo $isvisible; ?>">
  <?php  
    if($fromdb)
    {
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'ajaxSubmit',
            'context'=>'primary',
            'label'=>'Submit Schedule',
            'url' => Yii::app()->createUrl('order/'.Helper::CONST_dba_submitschedule),
            'ajaxOptions' => array(
                'success'=>'js:function(data){ submitDBOrderGridCallback(data,".search-form form"); }'
                ),
            'htmlOptions' => array('id' => 'submitScheduleBtn', 'onclick'=>'js:updateGridSubmitResult("Wait...");')
        ));
    }
    else //;
    {
        ?>
        <div style="float:left">
        <?php
        $this->widget( 'booster.widgets.TbButton', array(
            'buttonType' => 'button',
            'context' => 'primary',
            'label' => 'Add New',
            'htmlOptions' => array('onclick' => "js:document.location.href='" . $this->getEditUrl(false) . "'")
        ) );
        ?>
        </div>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'ajaxSubmit',
            'context'=>'primary',
            'label'=>'Invoice',
            'url' => Yii::app()->createUrl('account/create'),
            'ajaxOptions' => array(
                'success'=>'js:function(data){ afterCreateInvoiceFromOrder(data,".search-form form"); }'
                ),
            'htmlOptions' => array('id' => 'submitScheduleBtn', 'onclick'=>'js:updateGridSubmitResult("Wait...");')
        ));
    }
?>
</div>
<div class="row">
<div class="col-md-12" id="order-grid-div">   
<?php 
$this->renderPartial('//order/_order_grid',array(
    'model'=>$model,
    'origin' => $origin,
    'options' => $options,
    'fromdb' => $fromdb,
)); 
?>
</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>

<input type="hidden" id="const_all" value="<?php echo Helper::CONST_ALL; ?>"/>
<input type="hidden" id="const_admin" value="<?php echo Helper::CONST_adminactionid; ?>"/>
<input type="hidden" id="const_index" value="<?php echo Helper::CONST_indexactionid; ?>"/>
<input type="hidden" id="iscustomer" value="<?php echo ($this->isCustomer()?'1':'0'); ?>"/>
<input type="hidden" id="enable_timeslot" value="<?php echo (($this->isCRTypeAPP())?1:0); ?>"/>
<?php if($this->isCRTypeAPP()): ?>
<div id="timeslotgriddiv" style="display:none;">
<?php
    $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'id' => 'p1',
        'title' =>  'Riders Vs. Timeslots',
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
    <?php
        $flds = $this->appFormFields['lf']['timeslot'];
        $i = 0;
        foreach($flds as $key => &$fld)
        {
            $i++;
            $fld['type'] = 'raw';
            $fld['value'] = '$data->display' . ucfirst($key);
        }
        $flds['person']['header'] = Yii::app()->controller->getMenuLabels(Helper::CONST_Employee);
        $btncols = array( );
        $columns1 = array_merge($btncols, $flds);
        $options1 = array(
                    'id'=>'timeslot-grid',
                    'dataProvider'=>$timeslotmodel->search(),
                    //'filter'=>$timeslotmodel,
                    'columns'=> $columns1,
                    );
        $this->setDefaultGVOptions($options1, Helper::CONST_grid_Height_200);
        $this->widget('booster.widgets.TbGridView', $options1);
    ?>
<?php $this->endWidget(); ?>    
</div>
<?php endif; ?>
<script type="text/javascript">
    window.onload = function() {
        toggletimeslotgrid();
    };
</script>