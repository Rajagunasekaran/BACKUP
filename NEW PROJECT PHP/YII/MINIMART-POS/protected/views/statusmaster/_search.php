<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldGroup($model,'id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>

		<?php echo $form->textFieldGroup($model,'ofwhich',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>

		<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>

		<?php echo $form->textFieldGroup($model,'display',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>

		<?php echo $form->textFieldGroup($model,'desc',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
