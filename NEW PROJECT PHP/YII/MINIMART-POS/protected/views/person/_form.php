<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'person-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
<?php
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  $this->getMenuLabels( 'Category' ) . ' Details',
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
<?php $this->endWidget(); ?>
       
<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>