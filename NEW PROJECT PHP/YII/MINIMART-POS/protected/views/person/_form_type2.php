<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'person-form',
        'type'=>'horizontal',
	'enableAjaxValidation'=>true,
        'htmlOptions'=> array('class'=>'da-form')
)); ?>
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-md-4">
        <fieldset>
            <legend>
                Login Details                
            </legend>
            <?php
                $tmpjs = 'js:changerole_personentry()';
                $htmlOptions = array('onChange' => $tmpjs);                
                echo $form->dropDownListGroup($model
                        , 'role_id', array('widgetOptions' => array('data' => Yii::app()->user->companyroles 
                        , 'htmlOptions' => $htmlOptions) 
                         )) ;
                $tmpjs = 'js:toggleenablelogin_personentry()';
                $htmlOptions = array('onChange' => $tmpjs);
                echo $form->checkboxGroup($model, 'enablelogin',
                            array(
                                'widgetOptions'=>array(
                                    'htmlOptions'=> $htmlOptions
                                    )
                                )
                    );
                ?>
                <div id="logindiv">
                <?php 
                echo $form->hiddenField($model->login,'id');
                $htmlOptions = array('class'=>'span5','maxlength'=>128);
                if($model->login->id > 0)
                {
                    $htmlOptions['disabled'] = 'disabled';
                }
                echo $form->textFieldGroup($model->login,'login',array('widgetOptions'=>array('htmlOptions'=>$htmlOptions)));
                if($model->login->id > 0)
                {
                    $tmpjs = 'js:toggleeditpwd_personentry()';
                    $htmlOptions = array('onChange' => $tmpjs);
                    echo $form->checkboxGroup($model, 'editpassword',
                                array(
                                    'widgetOptions'=>array(
                                        'htmlOptions'=> $htmlOptions
                                        )
                                    )
                        );
                }
                ?>
                <div id="pwddiv">
                <?php 
                    echo $form->textFieldGroup($model->login, 'pass', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>16))));
                ?>
                </div>
                </div>
        </fieldset>
    </div>
    <div class="col-md-4">
        <fieldset>
            <legend>
                Employee Details
            </legend>
            <?php echo $form->textFieldGroup($model,'name',array(
                            'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)),
                            //'groupOptions' => array('class'=>'da-form-row')
                            )
                    ); 
            ?>		
            <div id="cust_fld_1">
                    <?php 
                        echo $form->textFieldGroup($model,'firstname',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128))));
                        echo $form->textFieldGroup($model, 'fax', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>16))));
                        echo $form->textFieldGroup($model, 'did', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>16))));
                        echo $form->textFieldGroup($model,'cost_center',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128))));
                    ?>
            </div>
                    <?php echo $form->textFieldGroup($model,'mobile',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>16)))); ?>
                    <?php echo $form->textFieldGroup($model,'mail',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>
            <div id="emp_fld_1">
                    <?php
                        echo $form->textFieldGroup($model, 'geo_update_frq', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>16))));
                    ?>
            </div>
        </fieldset>        
    </div>
    <div class="col-md-4">
        <fieldset>            
            <legend>
                Address
            </legend>
            <?php
                $htmlOptions = array();                
                echo $form->dropDownListGroup(
                $model
                , 'addresstype', array('widgetOptions' => array('data' => $this->getAddresstypesLookup() 
                , 'htmlOptions' => $htmlOptions) 
                 ));
                echo $form->textFieldGroup($model->address,'street',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128))));
                echo $form->textFieldGroup($model->address, 'pincode', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>16))));
            ?>
        </fieldset>                
    </div>
 </div>
<div class="row form-actions">
    <?php $this->widget('booster.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'context'=>'primary',
                    'label'=>$model->isNewRecord ? 'Create' : 'Save',
                    'htmlOptions'=>array('style'=>'float:right')
            )); ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    window.onload = function() {
        changerole_personentry();
        toggleenablelogin_personentry();
        toggleeditpwd_personentry();
    };
</script>