<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'person-form',
	'enableAjaxValidation'=>true,
)); ?>
<?php echo $form->errorSummary($model); ?>

	<?php
        $htmlOptions = array(
                        
                        );
        if($isroleparam){
            $htmlOptions['disabled'] = 'disabled';
            echo $form->hiddenField($model,'role_id');
        }
        echo $form->dropDownListGroup($model
                , 'role_id', array('widgetOptions' => array('data' => Yii::app()->user->companyroles 
                , 'htmlOptions' => $htmlOptions) 
                 )) ;        
        ?>

	<?php 
        if($model->enablepplcode){
            $htmlOptions = array('class'=>'span5','maxlength'=>16);
            if($this->isAutoPeopleCode($model->rolename))
            {
                $htmlOptions['disabled'] = 'disabled';
            }
            echo $form->textFieldGroup($model,'code',array('widgetOptions'=>array('htmlOptions'=>$htmlOptions)));   
        }
        ?>

	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>
	
	<?php
        echo $form->textFieldGroup($model,'firstname',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128))));
        ?>
        <?php
        echo $form->textFieldGroup($model,'lastname',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128))));
        ?>
	<?php echo $form->textFieldGroup($model,'mobile',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>16)))); ?>       

	<?php echo $form->textFieldGroup($model,'mail',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>
        
<div class="form-actions">
    <?php $this->widget('booster.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'context'=>'primary',
                    'label'=>$model->isNewRecord ? 'Create' : 'Save',
            )); ?>
</div>

<?php $this->endWidget(); ?>