<?php
$portlet1gridId = 'account-order-grid';

$refreshscript = "
function timedRefresh(timeoutPeriod) {
	setTimeout(function(){refreshGrid()}, timeoutPeriod);
}
 
function refreshGrid() {
        $('#$portlet1gridId').yiiGridView.update(\"$portlet1gridId\");	
        var refresh = $this->db_auto_refresh;
        if(refresh)
        {
            timedRefresh($this->db_auto_refresh_freq);
        }
}
";
if(Helper::CONST_lazy_page_load)
{
    $refreshscript = "timedRefresh($this->page_load_delay_ms);" . $refreshscript;
}
Yii::app()->clientScript->registerScript('refresh_page', $refreshscript);
?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'account-form',
	'enableAjaxValidation'=>false,
));
echo $form->errorSummary($model); 
?>
<?php
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  $this->getMenuLabels( 'Account' ) . ' Details',
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
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
?><?php echo $form->hiddenField($model, 'id'); ?>
    <div class="row">
    <div class="col-lg-2">
         <?php 
            $htmlOptions = array('class'=>'span5','maxlength'=>10);
            if($model->id > 0)
            {
                $htmlOptions['disabled'] = 'disabled';
            }
            echo $form->textFieldGroup($model,'acnt_no',array(
            'widgetOptions'=>array(
                'htmlOptions'=> $htmlOptions,
                )
            )
        ); ?>
    </div>
    <div class="col-lg-4">
    <?php
            $htmlOptions = array(
                'placeholder' => 'Customer',
            );
            if($model->id > 0)
            {
                $htmlOptions['disabled'] = 'disabled';
            }
            echo $form->select2Group(
                $model
                , 'party_id'
                , array('widgetOptions' 
                            => array(
                                'data' => Yii::app()->controller->getPeopleLookup(Helper::CONST_Customer),
                                'htmlOptions' => $htmlOptions 
                                ),
                        'groupOptions' => array(
                                        'allowClear' => true,
                                        'asDropDownList' => false,
                                        'label' => 'Customer',
                                    ),
                    )

                ) ;
?>
        </div>
    
    <div class="col-md-3">
        <?php 
            $htmlOptions = array('class'=>'span5','maxlength'=>10);
            if($this->getAccountamountfrom() != 0)
            {
                $htmlOptions['disabled'] = 'disabled';
            }
            echo $form->numberFieldGroup($model,'amount',
                array('widgetOptions'=>array(
                        'htmlOptions'=> $htmlOptions,
                    ))); 
        ?>
    </div>
    <div class="col-md-3">
        <?php
        $style = 'display:block';
        if($model->amount >= Helper::CONST_sc_limit)
        {
            $style = 'display:none';
        }
        else
        {
           $model->isapplysurcharge = true; 
        }
        ?>
        <input id="sclimit" type="hidden" value="<?php echo Helper::CONST_sc_limit;?>"/>
        <div id="scamountdiv" style="<?php echo $style; ?>">
            <?php
                $tmpjs = 'js:toggleapplysurcharge_orderentry()';
                $htmlOptions = array(
                    //'onChange' => $tmpjs
                );
                echo $form->checkboxGroup($model, 'isapplysurcharge',
                            array(
                                'widgetOptions'=>array(
                                    'htmlOptions'=> $htmlOptions
                                    )
                                )
                    );
            ?>
            <?php 
                $htmlOptions = array('class'=>'span5','maxlength'=>10);
                if($model->id > 0)
                {
                    $htmlOptions['disabled'] = 'disabled';
                }
                echo $form->numberFieldGroup($model,'scamount',
                    array('widgetOptions'=>array(
                            'htmlOptions'=> $htmlOptions,
                        ))); 
            ?>
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'ajaxSubmit',
                'context'=>'primary',
                'label'=>'Update Surcharge',
                'url' => Yii::app()->createUrl('account/' . Helper::CONST_updateaccountsurcharge),
                'ajaxOptions' => array(
                    'dataType' => 'json',
                    'success'=>'js:function(data){ updateGrid("account-order-grid", data, "gridsubmitresult"); }'
                    ),
                'htmlOptions' => array('id' => 'updatesurchargeBtn', 'onclick'=>'js:updateGridSubmitResult("Wait...");')
            ));
            ?>            
        </div>        
    </div>    
    </div>
    <div align="center">
        <div id="gridsubmitresult"></div>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'button',
            'context'=>'primary',
            'label'=>'Invoice[Pdf]',
            'htmlOptions' => array('id' => 'invoicepdfBtn', 'onclick'=>'js:submittourl("account-form","' . Yii::app()->createUrl('account/' . Helper::CONST_invoicepdf) .'");')
        ));
        ?>
    </div>
<?php
    $this->endWidget(); 
?>
<?php
    $this->widget('booster.widgets.TbButton', array(
    'buttonType' => 'ajaxSubmit',
    'context'=>'primary',
    'label'=>'Update Amounts',
    'url' => Yii::app()->createUrl('account/' . Helper::CONST_updateaccountordersamount),
    'ajaxOptions' => array(
        'dataType' => 'json',
        'success'=>'js:function(data){ updateGrid("account-order-grid", data, "gridsubmitresult"); }'
        ),
    'htmlOptions' => array('id' => 'updateamountsBtn', 'onclick'=>'js:updateGridSubmitResult("Wait...");')
));
?>
<?php 
$flds = $this->appFormFields['lf']['order'];
unset($flds['addnlinfo1']);
unset($flds['addnlinfo3']);
unset($flds['customer_id']);
unset($flds['employee_id']);
unset($flds['fromaddr_id']);
unset($flds['toaddr_id']);
$flds['qoi_id'] = array('name' => 'qoi_id');
$flds['amount'] = array('name' => 'amount'
                                    ,'type' => 'raw'
                                    ,'value' => '$data->displayAmountForInvoice'
                                );
$btncols = array( );
$columns = array_merge($btncols, $flds);
$afterAjaxUpdate = "function() { updateGridSubmitResult('');}";
$options = array(
                'id' => 'account-order-grid',
                'dataProvider' => $accoutordersearch->search(false, false),
                'columns'=> $columns,
                'afterAjaxUpdate'=> $afterAjaxUpdate,
                );
$this->setDefaultGVOptions($options);
$this->widget('booster.widgets.TbGridView', $options);

?>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>