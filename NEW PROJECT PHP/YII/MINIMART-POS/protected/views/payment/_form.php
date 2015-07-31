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
//Yii::app()->clientScript->registerScript('refresh_page', $refreshscript);
?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'payment-form',
	'enableAjaxValidation'=>false,
        'htmlOptions'=>array(
                     ),
));
echo $form->errorSummary($model); 
?>
<?php
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  $this->getMenuLabels( 'Payment' ) . ' Details',
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
<input type="hidden" id="const_receivables" value="<?php echo Helper::CONST_Receivables; ?>"/>
<input type="hidden" id="const_payables" value="<?php echo Helper::CONST_Payables; ?>"/>
<div class="row">
    <div class="col-lg-4">        
    <?php
         $ajaxOptions = array(
            'ajax' => array(
                    'type'=>'POST',
                    'url' => $this->createUrl('payment/' . Helper::CONST_ae_loadParties),
                    'update'=>'#Payment_party_id',
                    'data'=>array('direction'=>'js:this.value',),
                    'complete'=>'function(){
                             $("#Payment_party_id").change();
                        }',
                  )
            );
            $htmlOptions = array(
                'placeholder' => Helper::CONST_Inwards . ' / ' . Helper::CONST_Outwards,
            );
            if($model->id >0){
                echo $form->hiddenField($model, 'direction');
                $htmlOptions = array('disabled'=>'disabled');
                echo $form->textFieldGroup(
                        $model, 
                        'direction', 
                        array('widgetOptions' => array('htmlOptions' => $htmlOptions))
                    );
            }
            else
            {
                $htmlOptions = array_merge($htmlOptions, $ajaxOptions);
                echo $form->select2Group(
                    $model
                    , 'direction'
                    , array('widgetOptions' 
                                => array(
                                    'data' => Yii::app()->controller->getPaymentdirectionsLookup(),                                            
                                    'htmlOptions' => $htmlOptions 
                                    ),
                            'groupOptions' => array(
                                            'allowClear' => true,
                                            'asDropDownList' => false,
                                        ),
                        )

                    ) ;
            }            
    ?>
    </div>
</div>
<div class="row">    
    <div class="col-lg-4">
    <?php
        $ajaxOptions = array(
                'ajax' => array(
                        'type'=>'POST',
                        'url' => $this->createUrl('payment/' . Helper::CONST_ae_loadPartyAccounts),
                        'update'=>'#Payment_account_id',
                        'data'=>array('party_id'=>'js:this.value',
                                    'direction'=>'js:getPaymentdirection_accountentry()',
                        ),
                        'complete'=>'function(){
                            $("#Payment_account_id").change();
                            }',
                      )
            );
        $htmlOptions = array(
            'placeholder' => $model->getAttributeLabel( 'partyname' ),
        );
        if($model->id >0){
            echo $form->hiddenField($model, 'party_id');
            $htmlOptions = array('disabled'=>'disabled');
            echo $form->textFieldGroup(
                        $model, 
                        'partyname', 
                        array('widgetOptions' => array('htmlOptions' => $htmlOptions))
                    );
        }
        else
        {
            $htmlOptions = array_merge($htmlOptions, $ajaxOptions);
            echo $form->select2Group(
                $model
                , 'party_id'
                , array('widgetOptions' 
                            => array(
                                'data' => array(),
                                'htmlOptions' => $htmlOptions 
                                ),
                        'groupOptions' => array(
                                        'allowClear' => true,
                                        'asDropDownList' => true,
                                    ),
                    )

                ) ;
        }        
    ?>
    </div>
    <div class="col-lg-4">
    <?php
            $ajaxOptions = array(
                'ajax' => array(
                        'type'=>'POST',
                        'url' => $this->createUrl('payment/' . Helper::CONST_ae_loadAccountDetails),
                        'data'=>array('account_id'=>'js:this.value',
                                ),
                        'success'=>'function(data){
                                        $("#Payment_order_or_ot_id").val(data.order_or_ot_id);
                                        $("#Payment_ordername").val(data.ordername);
                                        $("#Payment_accountamount").val(data.amount);
                                        $("#Payment_accountpaid").val(data.paid);                                        
                                    }',
                      )
            );
            $htmlOptions = array(
                'placeholder' => $model->getAttributeLabel( 'account_id' ),
            );
            if($model->id >0){
                echo $form->hiddenField($model, 'account_id');
                $htmlOptions = array('disabled'=>'disabled');
                echo $form->textFieldGroup(
                        $model, 
                        'account_id',
                        array('widgetOptions' => array('htmlOptions' => $htmlOptions))
                    );
            }
            else
            {
                $htmlOptions = array_merge($htmlOptions, $ajaxOptions);
                echo $form->select2Group(
                $model
                , 'account_id'
                , array('widgetOptions' 
                            => array(
                                'data' => array(),
                                'htmlOptions' => $htmlOptions 
                                ),
                        'groupOptions' => array(
                                        'allowClear' => true,
                                        'asDropDownList' => false,
                                    ),
                    )
                ) ;
            }            
    ?>
    </div>    
</div>
<div class="row">
    <div class="col-md-4">
        <?php 
            echo $form->hiddenField($model, 'order_or_ot_id');
            $htmlOptions = array('class'=>'span5','maxlength'=>10);
            $htmlOptions['disabled'] = 'disabled';
            echo $form->textFieldGroup($model,'ordername',array(
            'widgetOptions'=>array(
                'htmlOptions'=> $htmlOptions,
                )
            )
            ); 
        ?>
    </div>
    <div class="col-md-2">
        <?php 
            $htmlOptions = array('class'=>'span5','maxlength'=>10);
            $htmlOptions['disabled'] = 'disabled';
            echo $form->textFieldGroup($model,'accountamount',array(
            'widgetOptions'=>array(
                'htmlOptions'=> $htmlOptions,
                )
            )
            ); 
        ?>
    </div>
    <div class="col-md-2">
        <?php 
            $htmlOptions = array('class'=>'span5','maxlength'=>10);
            $htmlOptions['disabled'] = 'disabled';
            echo $form->textFieldGroup($model,'accountpaid',array(
            'widgetOptions'=>array(
                'htmlOptions'=> $htmlOptions,
                )
            )
            ); 
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx( $model, 'payment_at' ); ?>
            <?php 
                $this->widget( 'booster.widgets.TbDatePicker', array(
                    'attribute' => 'payment_at',
                    'model' => $model,
                    'value' => $model->payment_at,
                    'options' => array(
                        'showAnim' => 'fold',
                        'dateFormat' => $this->cJuiDatePickerViewFormat,
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-control'
                    ),
                ) );                
            ?>
            <?php echo $form->error( $model, 'payment_at' ); ?>
        </div>
    </div>        
    <div class="col-md-2">
        <?php 
            $htmlOptions = array('class'=>'span5','maxlength'=>10);            
            echo $form->numberFieldGroup($model,'amount',
                array('widgetOptions'=>array(
                        'htmlOptions'=> $htmlOptions,
                    ))); 
        ?>
    </div>
    </div>
<?php
    $this->endWidget(); 
?>
<div class="row">
<div class="col-md-offset-4 col-md-4" align="center">
<?php 
$this->widget('booster.widgets.TbButton', array(
                'buttonType'=>'cancel',
                'context'=>'default',
                'label'=>'Cancel',
                'htmlOptions'=>array(
                    'class'=>'btn btn-sm',
                    'onclick' => "js:document.location.href='" . $this->createUrl('admin') . "'"
                    ),
        ));
?>
<?php 
$saveurl = $this->createUrl('create');
if($model->id > 0)
{
    $saveurl = $this->createUrl('update', array('id'=>$model->id));   
}
$this->widget('booster.widgets.TbButton', array(
                'buttonType'=>'button',
                'context'=>'primary',
                'label'=>'Save',
                'htmlOptions' => array(
                    'id' => 'saveBtn',
                    'class'=>'btn btn-sm btn-success',
                    'onclick' => 'ajaxAccountFormSubmit("payment-form"
                        , "formResult", "AjaxLoader", "Saving......", "'. $saveurl . '");',
                    ),
        ));
?>    
<?php
if($model->id > 0)
{
    $deleteurl = $this->createUrl('delete', array('id'=>$model->id));
    $this->widget('booster.widgets.TbButton', array(
                    'buttonType'=>'button',
                    'context'=>'delete',
                    'label'=>'Delete',
                    'htmlOptions' => array(
                        'id' => 'deleteBtn',
                        'class'=>'btn btn-sm btn-danger',
                        'onclick' => 'ajaxAccountFormSubmit("payment-form"
                            , "formResult", "AjaxLoader", "Deleting......", "'. $deleteurl . '");',
                        ),
            ));
}
?>    
</div>
</div>
<div class="row">
<div id="AjaxLoader" style="display: none"></div>
<div class="errorMessage" id="formResult"></div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    window.onload = function() {
        $("#Payment_direction").change();
    };
</script>