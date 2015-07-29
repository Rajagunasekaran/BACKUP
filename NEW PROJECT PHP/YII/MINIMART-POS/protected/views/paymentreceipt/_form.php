<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'paymentreceipt-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  $this->getMenuLabels( 'Paymentreceipt' ) . ' Details',
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
<?php echo $form->errorSummary($model); ?>
<div class="row">
  <div class="col-md-offset-2 col-md-4">
        <div class="form-group">
            <?php
            echo $form->labelEx( $model, 'customer_id' );
                $this->widget(
                        'booster.widgets.TbSelect2',
                        array(
                            'attribute' => 'customer_id',
                            'model' => $model,
                            'name' => 'customer_id',
                            //'value' => Yii::app()->controller->getPersonByName(Helper::CONST_Walk_in_Customer),
                            'data' => Yii::app()->controller->getAllPeopleNoRestriction(Helper::CONST_Customer),                                      
                            'htmlOptions' => array('id' => 'customer_id',
                              'style' => 'width:100%'
                              ),
                            )
                        );    
            ?>
        </div>
    </div>
    <div class="row">
    <div class="col-md-4">
        <?php echo $form->textFieldGroup($model,'amount',
                array('widgetOptions'=>array('htmlOptions'=>
                    array('class'=>'numberonly')))); ?>
    </div>
        </div>
<div class="col-md-offset-2 col-md-4">
        <?php echo $form->textFieldGroup($model,'details',
                array('widgetOptions'=>array('htmlOptions'=>
                    array()))); ?>
    </div>
    <div class="col-md-4">
        <div class="form-group">
                <?php echo $form->labelEx( $model, 'paid_date' ); ?>
                <?php 
                    $this->widget( 'booster.widgets.TbDatePicker', array(
                        'attribute' => 'paid_date',
                        'model' => $model,
                        'value' => $model->paid_date,
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
</div>
	
<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>