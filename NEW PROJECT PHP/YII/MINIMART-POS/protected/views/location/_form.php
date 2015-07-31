<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'location-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'street',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>

	<?php echo $form->textFieldGroup($model,'locality',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>

	<?php echo $form->textFieldGroup($model,'city',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>32)))); ?>

	<?php echo $form->textFieldGroup($model,'state',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>32)))); ?>

	<?php echo $form->textFieldGroup($model,'country',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>32)))); ?>

	<?php echo $form->textFieldGroup($model,'pincode',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>12)))); ?>

	<?php echo $form->textFieldGroup($model,'remarks',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>64)))); ?>

	<?php echo $form->textFieldGroup($model,'created_at',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php echo $form->textFieldGroup($model,'updated_at',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
