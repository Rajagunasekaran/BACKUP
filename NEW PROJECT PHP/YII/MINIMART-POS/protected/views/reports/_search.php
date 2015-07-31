<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); 
//echo Yii::app()->createUrl($this->route);
?>

<div class="row">
    <div class="col-md-3">
        <label>Code</label>
        <?php 
        $htmlOptions = array(
            'placeholder' => 'Select Code', 'class'=>'form-control'           
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'code',
            'model' => $model,
            'data' => $this->getCodeLookup(),
            'options' => array(
                'allowClear' => true,
            ),
            'htmlOptions' => $htmlOptions,
        ) );
        ?>
    </div>
 <div class="col-md-3">
              <?php echo $form->textFieldGroup($model,'sku',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>  
 </div>
   <div class="col-md-3">

       <label>Invoice Date</label>
        <?php
            $this->widget( 'booster.widgets.TbDatePicker', array(
                'attribute' => 'invdate',
                'model' => $model,
                    'options' => array(
                    'showAnim' => 'fold',
                  'dateFormat' =>$this->cJuiDatePickerViewFormat,
                ),
                'htmlOptions' => array(   
                    'placeholder' => 'Select Date',
                ),
            ) );
            ?>
    </div>
</div>
<div class="form-actions">
        <?php $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'submit',
                'context'=>'primary',
                'label'=>'Search',
        )); ?>
</div>

<?php $this->endWidget(); ?>