<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'order-form',
	'enableAjaxValidation'=>true,        
));
echo $form->errorSummary(array($model));
?>
<div class="errorMessage" id="formResult"></div>
<?php
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  $this->getMenuLabels( 'Order' ) . ' Details',
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
 $isvisible = (($this->isCustomer())?'display:none;':'display:block;');
?>
<div class="row">
<div class="col-md-4">
    <?php         
    if(!empty($type))
    {
        echo $form->hiddenField($model,'type');
    }
    else
    {
        $htmlOptions = array();
        echo $form->dropDownListGroup($model
            , 'type', array('widgetOptions' => array('data' => $this->getOrdertypesLookup() 
            , 'htmlOptions' => $htmlOptions) 
             ));
    }
    ?>
</div>
</div>
<div class="well well-sm" style="<?php echo $isvisible; ?>">
    <div class="row">
        <div class="col-md-4">            
            <?php echo $form->textFieldGroup($model,'addnlinfo',array(
                            'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>24))
                            )
                        );
            ?>
        </div>
        <div class="col-md-6">
            <?php 
                $htmlOptions = array(
                    'placeholder' => 'Surcharge',
                    'separator' => '',
                    //'template' => '{beginLabel}{input}{labelTitle}{endLabel}',
                    );
                echo $form->labelEx( $model, 'Surcharge' );
                echo $form->checkboxListGroup(
                $model
                , 'addnlinfo5'
                , array(
                    'inline' => true,
                    'widgetOptions' 
                            => array(
                                'data' => $this->getSurchargeTypesLookup(),
                                'htmlOptions' => $htmlOptions,
                                ),                
                    )

                ); 
            ?>
        </div>
        <div class="col-md-2">
            <?php echo $form->numberFieldGroup($model,'amount',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>            
        </div>
    </div>
</div>
<div class="well well-sm">
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx( $model, 'addnlinfo1' ); ?>
            <?php 
                $this->widget( 'booster.widgets.TbDateRangePicker', array(
                    'attribute' => 'addnlinfo1',
                    'model' => $model,
                    'value' => $model->addnlinfo1,
                    'options' => array(
                        'showAnim' => 'fold',
                        'format' => $this->boosterTbDateRangePickerFormat,                        
                        'timePicker'=> true,
                        'timePickerIncrement'=> 15,
                        'timePicker12Hour' => false,
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-control'
                    ),
                ) );                
            ?>
            <?php echo $form->error( $model, 'addnlinfo1' ); ?>
        </div>
    </div>
    <div class="col-md-4">
        <?php 
        $htmlOptions = array(
            'placeholder' => 'Type Of Delivery',
            );
        echo $form->select2Group(
        $model
        , 'addnlinfo3'
        , array('widgetOptions' 
                    => array(
                        'data' => $this->getDeliverytypesLookup(),                                            
                        'htmlOptions' => $htmlOptions
                        ),                
            )

        ) ; 
        ?>
    </div>
    <div class="col-md-4">
        <?php 
        $htmlOptions = array(
            'placeholder' => 'Type Of Service',
            );
        echo $form->select2Group(
        $model
        , 'addnlinfo4'
        , array('widgetOptions' 
                    => array(
                        'data' => $this->getServicetypesLookup(),                                            
                        'htmlOptions' => $htmlOptions
                        ),                
            )

        ) ; 
        ?>
    </div>
</div>
</div>
<div class="row"  style="<?php echo $isvisible; ?>">
                <div class="col-md-2">
            <?php        
                $tmpjs = 'js:togglenewcustomer_orderentry()';
                $htmlOptions = array('onChange' => $tmpjs);
                echo $form->checkboxGroup($model, 'isnewcustomer',
                            array(
                                'widgetOptions'=>array(
                                    'htmlOptions'=> $htmlOptions
                                    )
                                )
                    );
            ?>
        </div>
        <div class="col-md-4">
            <?php
            $htmlOptions = array(
            'placeholder' => 'Customer',
            'ajax' => array(
                        'type'=>'POST',
                        //'dataType' => 'json',
                        'url'=>$this->createUrl('order/' . Helper::CONST_oe_loadcustaddresses),
                        'update'=>'#addressDiv',                        
                        'data'=>array('customer_id'=>'js:this.value',
                                    'order_id'=>$model->id,
                                    'isnewcustomer'=>'js:getisnewcustomer()',
                                    'isnewfrom'=>'js:getisnewfrom()',
                                    'isnewto'=>'js:getisnewto()'
                                    ),
                      )
            );
            if($model->isnewcustomer)
            {
                $htmlOptions['disabled'] = 'disabled';
            }
            echo $form->select2Group(
                $model
                , 'customer_id'
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
                        'afterAjaxUpdate'=> "js:function(){alert('hi');}",
                    )

                ) ;
            ?>
        </div>
</div>
<div class="row">
    <div class="col-md-12">
    <?php
        $this->renderPartial( '_custaddr', array(
        'model' => $model, 'form' => $form
    ));
    ?>
    </div>
</div>    
<div class="row">
    <div class="col-md-6">        
     <?php echo $form->textAreaGroup($model,'desc',array('widgetOptions'=>array(
         'htmlOptions'=>array('class'=>'span5','maxlength'=>1024, 'rows'=>5, 'cols'=>75)))); ?>
    </div>
    <div class="col-md-6">
    <?php echo $form->textAreaGroup($model,'remarks',array(
                'widgetOptions'=>array(
                    'htmlOptions'=>array('class'=>'span5','maxlength'=>256, 'rows'=>5, 'cols'=>75)
                ))
            ); 
    ?>
    </div>
</div>
<div class="well well-sm" style="<?php echo $isvisible; ?>">
<div class="row">
    <div class="col-md-3">
        <?php echo $form->labelEx( $model, 'employee_id' ); ?>
        <?php 
        $htmlOptions = array(
            'placeholder' => Yii::app()->controller->getMenuLabels('Employee'),            
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'employee_id',
            'model' => $model,
            'data' => Yii::app()->controller->getPeopleLookup(Helper::CONST_Employee),
            'options' => array(
                'allowClear' => true,
            ),
            'htmlOptions' => $htmlOptions,
        ) );
        ?>
    </div>
    <div class="col-md-3">
        <?php echo $form->labelEx( $model, 'status' ); ?>
        <?php 
        $htmlOptions = array(
            'placeholder' => 'Status',            
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'status',
            'model' => $model,
            'data' => Yii::app()->user->orderstatuses,
            'options' => array(
                //'allowClear' => true,
            ),
            'htmlOptions' => $htmlOptions,
        ) );
        ?>        
    </div>
</div>
</div>    
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
    <div class="form-actions col-lg-offset-5 col-lg-4">
        <?php $this->widget('booster.widgets.TbButton', array(
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
        $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'ajaxSubmit',
                'context'=>'primary',
                'label'=>'Save',
                //'url' => $this->createUrl($this->route),
                'ajaxOptions' => array(
                    'dataType' => 'json',
                    'success'=>'js:function(data){afterSaveOrder(data)}',
                    'beforeSend'=>'function(){
                           $("#AjaxLoader").show();
                      }'
                    ),
                'htmlOptions' => array('id' => 'saveBtn', 'class'=>'btn btn-sm btn-success')
            ));
        ?>
        <?php if($model->id > 0) : ?>
        <?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'cancel',
			'label'=>'Delete',
                        'htmlOptions'=>array(
                            'class'=>'btn btn-sm btn-danger',
                            'onclick' => "js:document.location.href='" . $this->createUrl('delete', array('id'=>$model->id)) . "'"
                            ),
		)); 
        ?>
        <?php endif; ?>
    <div id="AjaxLoader" style="display: none">Saving......</div>
    </div>
    </div>
<?php
    $this->endWidget(); 
?>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
