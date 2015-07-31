<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->breadcrumbs=array(
	
);
$this->pageTitle = Yii::app()->name;
?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'login-form',
        'type' => 'inline',
	'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
        'htmlOptions' => array('class' => 'login-form'),
));?>
<input type="hidden" name="LoginForm[isPassencoded]" value="0" />
	<div class="header">
            <h1>Login</h1>
        </div>
         <div class="content">
                <?php 
                    echo $form->textFieldGroup($model,'username',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'input username','maxlength'=>128))));
                ?>
                <?php 
                    echo $form->passwordFieldGroup($model,'password',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'input password','maxlength'=>128))));
                ?>
        </div>
        <div class="footer">
            <?php $this->widget('booster.widgets.TbButton', 
                            array(
                                'buttonType'=>'submit',                            
                                'label'=>'Login',
                                'htmlOptions' => array('class' => 'button'),
                            )
                            ); 
                    ?>
        </div>
<?php $this->endWidget(); ?>