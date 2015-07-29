<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'person-form',
	'enableAjaxValidation'=>true,
)); ?>
<?php echo $form->errorSummary($model); ?>
<?php
       if($this->action->id !== Helper::CONST_customercreate
               && $this->action->id !== Helper::CONST_customerupdate)
       {
           $this->beginWidget(
              'booster.widgets.TbPanel',
              array(
              'title' =>  'Supplier Details',
              'context' => 'default',
              //'headerIcon' => 'info',
              //'padContent' => false,
              'htmlOptions' => array()
              )
          );
       }
       else
       {
            $this->beginWidget(
              'booster.widgets.TbPanel',
              array(
              'title' =>  'Customer Details',
              'context' => 'default',
              //'headerIcon' => 'info',
              //'padContent' => false,
              'htmlOptions' => array()
              )
          );
       }
?>
<div class="row">
    <div class="col-md-4">
        <?php      
        $htmlOptions = array();
        if($this->action->id !== 'create' 
                && $this->action->id !== 'update')
        {
            //$htmlOptions['disabled'] = 'disabled';
            echo $form->hiddenField($model,'role_id');
        }
        else
        {
             echo $form->dropDownListGroup($model
                , 'role_id', array('widgetOptions' => array('data' => Yii::app()->user->companyroles 
                , 'htmlOptions' => $htmlOptions) 
                 )) ;
        }
        ?>
    </div>
</div>
<div class="row">    
    <div class="col-md-4">
        <?php 
        if($model->enablepplcode){
            $htmlOptions = array('class'=>'span5','maxlength'=>16);
            if($this->isAutoPeopleCode($model->rolename))
            {
                //$htmlOptions['disabled'] = 'disabled';
            }
            echo $form->textFieldGroup($model,'code',array('widgetOptions'=>array('htmlOptions'=>$htmlOptions)));   
        }
        ?>
    </div>
    <div class="col-md-4">
        <?php 
        $tmpjs = 'js:abc()';
        echo $form->textFieldGroup($model,'name',
                array('widgetOptions'=>array(
                    'htmlOptions'=>array(
                        'class'=>'span5',
                        
                        'maxlength'=>128))));
        ?>
    </div>
    <?php if($model->enablecontact): ?>
    <div class="col-md-4">
        <?php echo $form->textFieldGroup($model,'firstname',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128))));?>
    </div>
    <?php endif; ?>
</div>
<div class="row">
    <div class="col-md-4">
        <?php echo $form->textFieldGroup($model,'mobile',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5 numberonly','maxlength'=>16)))); ?>        
    </div>
    <div class="col-md-4">
        <?php echo $form->textFieldGroup($model,'mail',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>
    </div>
    <?php if($model->rolename === Helper::CONST_Sales): ?>
    <div class="col-md-4">
        <?php 
        echo $form->hiddenField($model,'register_id');
        echo $form->textFieldGroup($model,'displayRegister',
            array('widgetOptions'=>array(
                'htmlOptions'=>array(
                    'class'=>'span5',
                    'maxlength'=>128,
                    'disabled' => 'disabled',
                    )
                )
                ));
        ?>
    </div>
    <?php endif; ?>
</div>
<div class="row">
    <div class="col-md-4">
        <?php 
            if($model->enablepplauxname)
            {
                echo $form->textFieldGroup($model,'auxname',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128))));    
            }
        ?>
    </div>
</div>
<div class="form-actions">
    <?php $this->widget('booster.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'context'=>'primary',
                    'label'=>$model->isNewRecord ? 'Create' : 'Save',
            )); 
    ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
   function abc($model)
   {
   alert($model);
   }
    </script>
    
    