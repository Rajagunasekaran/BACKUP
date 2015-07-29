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
	'id'=>'account-form',
	'enableAjaxValidation'=>false,
        'htmlOptions'=>array(
                       //'onsubmit'=>"return false;",/* Disable normal form submit */
                     ),
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
<input type="hidden" id="const_receivables" value="<?php echo Helper::CONST_Receivables; ?>"/>
<input type="hidden" id="const_payables" value="<?php echo Helper::CONST_Payables; ?>"/>

<div class="row">
    <div class="col-lg-4">        
    <?php
         $ajaxOptions = array(
            'ajax' => array(
                    'type'=>'POST',
                    //'dataType' => 'json',
                    'url' => $this->createUrl('account/' . Helper::CONST_ae_loadParties),
                    'update'=>'#Account_party_id',
//                    'results' => 'js: function(data,page){
//                                        return {results: data};
//                                    }',
                    'data'=>array('accounttype'=>'js:this.value',),
                    'complete'=>'function(){
                             $("#Account_party_id").change();
                        }',
                  )
            );
            $htmlOptions = array(
                'placeholder' => 'Type',
            );
            if($model->id >0){
                echo $form->hiddenField($model, 'accounttype');
                $htmlOptions = array('disabled'=>'disabled');
                echo $form->textFieldGroup(
                        $model, 
                        'accounttype', 
                        array('widgetOptions' => array('htmlOptions' => $htmlOptions))
                    );
            }
            else
            {
                $htmlOptions = array_merge($htmlOptions, $ajaxOptions);
                echo $form->select2Group(
                    $model
                    , 'accounttype'
                    , array('widgetOptions' 
                                => array(
                                    'data' => Yii::app()->controller->getAccounttypesLookup(),                                            
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
    <div class="col-lg-4" id="accnt_customerselect_div">
    <?php
        $ajaxOptions = array(
                'ajax' => array(
                        'type'=>'POST',
                        //'dataType' => 'json',
                        'url' => $this->createUrl('account/' . Helper::CONST_ae_loadPartyOrdersOrTasks),
                        'update'=>'#Account_order_or_ot_id',
                        'data'=>array('party_id'=>'js:this.value',
                                    'accounttype'=>'js:getAccounttype_accountentry()',
                        ),
                        'complete'=>'function(){
                            $("#Account_order_or_ot_id").change();
                            }',
                      )
            );
        $htmlOptions = array(
            'placeholder' => Helper::CONST_Customer,
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
            $htmlOptions = array(
                'placeholder' => Helper::CONST_Order,
            );
            if($model->id >0){
                echo $form->hiddenField($model, 'order_or_ot_id');
                $htmlOptions = array('disabled'=>'disabled');
                echo $form->textFieldGroup(
                        $model, 
                        'ordername', 
                        array('widgetOptions' => array('htmlOptions' => $htmlOptions))
                    );
            }
            else
            {
                echo $form->select2Group(
                $model
                , 'order_or_ot_id'
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
    <div class="col-md-2">
        <?php 
        $htmlOptions = array('class'=>'span5','maxlength'=>10);
        if($model->id >0){
            $htmlOptions['disabled'] = 'disabled';
        }
        echo $form->textFieldGroup($model,'acnt_no',array(
        'widgetOptions'=>array(
            'htmlOptions'=> $htmlOptions,
            )
        )
    ); ?>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx( $model, 'acnt_date' ); ?>
            <?php 
                $this->widget( 'booster.widgets.TbDatePicker', array(
                    'attribute' => 'acnt_date',
                    'model' => $model,
                    'value' => $model->acnt_date,
                    'options' => array(
                        'showAnim' => 'fold',
                        'dateFormat' => $this->cJuiDatePickerViewFormat,
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-control'
                    ),
                ) );                
            ?>
            <?php echo $form->error( $model, 'acnt_date' ); ?>
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
    <div class="col-md-2">
        <?php 
            $htmlOptions = array('class'=>'span5','maxlength'=>10);
            $htmlOptions['disabled'] = 'disabled';
            echo $form->textFieldGroup($model,'paid',array(
            'widgetOptions'=>array(
                'htmlOptions'=> $htmlOptions,
                )
            )
            ); 
        ?>
    </div>        
    </div>
<?php
    $this->endWidget(); 
?>
<div class="row">

<div class="col-md-2">
<?php if($model->id > 0) : ?>    
<?php
$pdfurl = Yii::app()->createUrl('account/' . Helper::CONST_invoicepdf);
$this->widget('booster.widgets.TbButton', array(
    'buttonType' => 'button',
    'context'=>'primary',
    'label'=>'Invoice[Pdf]',
    'htmlOptions' => array('id' => 'invoicepdfBtn', 'onclick'=>'js:submittourl("account-form","' . $pdfurl .'");')
));
?>
<?php endif; ?>    
</div>
<div class="form-actions col-lg-offset-3 col-lg-4">
<?php 
$this->widget('booster.widgets.TbButton', array(
                'buttonType'=>'cancel',
                'context'=>'default',
                'label'=>'Cancel',
                'htmlOptions'=>array(
                    'class'=>'btn btn-sm',
                    'onclick' => "js:document.location.href='" . $this->createUrl('/') . "'"
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
                    'onclick' => 'ajaxAccountFormSubmit("account-form"
                        , "formResult", "AjaxLoader", "Saving......", "'. $saveurl . '");',
                    ),
        ));
?>
<?php if($model->id > 0) : ?>
<?php     
$deleteurl = $this->createUrl('delete', array('id'=>$model->id));
$this->widget('booster.widgets.TbButton', array(
                'buttonType'=>'button',
                'context'=>'delete',
                'label'=>'Delete',
                'htmlOptions' => array(
                    'id' => 'deleteBtn',
                    'class'=>'btn btn-sm btn-danger',
                    'onclick' => 'ajaxAccountFormSubmit("account-form"
                        , "formResult", "AjaxLoader", "Deleting......", "'. $deleteurl . '");',
                    ),
        ));
?>
<?php endif; ?>
<div id="AjaxLoader" style="display: none"></div>
<div class="errorMessage" id="formResult"></div>
</div>
</div>
<div id="pdfcontent" style="background: transparent url(loading.gif) no-repeat">
</div>
<?php 
//$flds = $this->appFormFields['lf']['order'];
//unset($flds['addnlinfo1']);
//unset($flds['addnlinfo3']);
//unset($flds['customer_id']);
//unset($flds['employee_id']);
//unset($flds['fromaddr_id']);
//unset($flds['toaddr_id']);
//$flds['qoi_id'] = array('name' => 'qoi_id');
//$flds['amount'] = array('name' => 'amount'
//                                    ,'type' => 'raw'
//                                    ,'value' => '$data->displayAmountForInvoice'
//                                );
//$btncols = array( );
//$columns = array_merge($btncols, $flds);
//$afterAjaxUpdate = "function() { updateGridSubmitResult('');}";
//$options = array(
//                'id' => 'account-payment-grid',
//                'dataProvider' => $accoutpaymentsearch->search(false, false),
//                'columns'=> $columns,
//                'afterAjaxUpdate'=> $afterAjaxUpdate,
//                );
//$this->setDefaultGVOptions($options);
//$this->widget('booster.widgets.TbGridView', $options);

?>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    window.onload = function() {
        $("#Account_accounttype").change();
    };
</script>