<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
            ),
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
                $tmpjs = 'js:newimageselect()';
                echo $form->checkBox($model, 'imagepath'
                        , array('onclick' => $tmpjs));
                echo $form->labelEx($model, 'imagepath');
                ?>
        <div id='newimageload' hidden>
        <?php echo $form->fileField($model, 'imagepath'); ?>
        </div>
        <div id='oldimageload'>
          <?php $this->widget('booster.widgets.TbLabel', array(
						'context'=>'primary',
			'label'=>$model->imagepath,
		)); ?>
        </div> 
        <?php if(empty($model->imagepath)):
        Yii::app()->clientScript->registerScript('refresh_page',"
   window.onload = function() {
  $('#newimageload').show();
  $('#oldimageload').hide();
};
");
endif; ?>
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
<script type="text/javascript">
function newimageselect(){
    var t = $("#Category_imagepath").is(':checked');
    if(t){
        $('#newimageload').show();
        $('#oldimageload').hide();
    }else{
        $('#newimageload').hide();
        $('#oldimageload').show();
    }
}
    </script>