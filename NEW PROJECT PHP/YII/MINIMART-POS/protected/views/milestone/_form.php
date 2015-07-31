<?php 
$formurl = $this->createUrl('milestone/' . $this->action->id );
$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'milestone-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>	
<?php
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  'Milestone Details',
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
<div class="row">
    <div class="col-md-4" style="display:none;">
        <?php echo $form->textFieldGroup($model,'order_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>
    </div>
    <div class="col-md-4">      
    </div>    
</div>
<?php $this->renderPartial('//milestone/_form_sub',array(
	'model'=>$model, 'form'=>$form
)); ?>		

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
