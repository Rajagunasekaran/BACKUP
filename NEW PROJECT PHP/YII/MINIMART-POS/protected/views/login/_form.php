<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'login-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'person_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>

	<?php echo $form->textFieldGroup($model,'login',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>24)))); ?>

	<?php echo $form->passwordFieldGroup($model,'pass',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>88)))); ?>

	<?php echo $form->textFieldGroup($model,'hash_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>88)))); ?>

	<?php echo $form->textFieldGroup($model,'status',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

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
