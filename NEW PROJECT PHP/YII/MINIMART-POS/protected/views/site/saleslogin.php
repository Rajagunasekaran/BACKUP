<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->breadcrumbs=array(
	
);
$this->pageTitle = Yii::app()->name;
?>
<div class="form">
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'login-form',
        'type' => 'inline',
	'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));?>        
	<div class="row" style="margin-bottom: 10px;">
            <input type="hidden" name="LoginForm[isPassencoded]" value="0" />
            <div class="inputwrapper animate1 bounceIn">
		<?php 
                    echo $form->textFieldGroup($model,'username',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'da-login-username','maxlength'=>128))));
                ?>
            </div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
            <div class="inputwrapper animate2 bounceIn">
		<?php 
                    echo $form->passwordFieldGroup($model,'password',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'da-login-password','maxlength'=>128))));
                ?>
            </div>
	</div>
	<div class="row buttons">
            <div class="inputwrapper">
                <?php $this->widget('booster.widgets.TbButton', 
                        array(
                            'buttonType'=>'submit',                            
                            'label'=>'Login',
                            'htmlOptions' => array('class' => 'btn btn-default'),
                        )
                        ); 
                ?>
            </div>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
