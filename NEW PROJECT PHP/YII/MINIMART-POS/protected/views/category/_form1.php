<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
            ),
)); ?>
<?php echo $form->errorSummary($model); ?>
<?php
       if($this->action->id !== Helper::CONST_sectioncreate
               && $this->action->id !== Helper::CONST_sectionupdate)
       {
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
       }
else
{
$this->beginWidget(
       'booster.widgets.TbPanel',
       array(
       'title' =>  $this->getMenuLabels( 'Section' ) . ' Details',
       'context' => 'default',
       //'headerIcon' => 'info',
       //'padContent' => false,
       'htmlOptions' => array()
       )
   );
       }
?>
<div class="row">
    <div class="col-md-offset-4 col-md-4">
        <?php
        if($this->action->id !== Helper::CONST_sectioncreate
                && $this->action->id !== Helper::CONST_sectionupdate)
        {
            echo $form->select2Group(
                        $model
                        , 'parent_id'
                        , array('widgetOptions' 
                                    => array(
                                        'data' => Yii::app()->user->rootcategories,
                                        'htmlOptions' => array() 
                                        ),
                                'groupOptions' => array(
                                                'allowClear' => true,
                                                'asDropDownList' => false,
                                            ),
                            )

                        ) ;
        }
        ?>
    </div>
    <div class="col-md-offset-4 col-md-4">
        <?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>
    </div>    
</div>
<div class="row">
    <div class="col-md-offset-4 col-md-4">
        <?php echo $form->textFieldGroup($model,'desc',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>
    </div>
<div class="col-md-4">
        <?php 
        echo $form->labelEx($model, 'imagepath');
        echo $form->fileField($model, 'imagepath');       
        ?>
    </div>
    </div>

    
<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
