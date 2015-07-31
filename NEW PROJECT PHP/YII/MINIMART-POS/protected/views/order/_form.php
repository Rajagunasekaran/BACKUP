<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'order-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary(array($model));
//echo $form->errorSummary(array($model, $model->customer));
?>
<?php
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  $this->getMenuLabels( 'Order' ) . ' Details',
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
<div class="row"> 
<div class="col-md-4">
        <?php 
            $htmlOptions = array(
                            'placeholder' => Helper::CONST_Customer,                            
                );
            echo $form->select2Group(
                $model->customer
                , 'id'
                , array('widgetOptions' 
                            => array(
                                'data' => Yii::app()->controller->getPeopleLookup(Helper::CONST_Customer),
                                'htmlOptions' => $htmlOptions 
                                
                                ),
                        'groupOptions' => array(
                                'allowClear' => true,
                                'asDropDownList' => true,
                            ),
                        'labelOptions' => array(
                                'label' => Helper::CONST_Customer
                            ),
                    )

                ) ;
        ?>
    </div>
</div>
<div class="row">    
    <div class="col-md-3">
        <?php echo $form->textFieldGroup($model,'qoi_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>16)))); ?>
    </div>
    <div class="col-md-3">
        <?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>
    </div>
    <div class="col-md-3">
        <?php echo $form->textFieldGroup($model,'amount',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php 
            echo $form->datePickerGroup($model,'start_at',
                    array('widgetOptions'=>array(
                                'options' => array(
                                    //'showAnim' => 'fold',
                                    'dateFormat' => $this->cJuiDatePickerViewFormat,
                                ),
                                'htmlOptions'=>array('class'=>'span5'),                                
                            )
                        )
                    ); 
       ?>
    </div>
    <div class="col-md-4">
        <?php 
            echo $form->datePickerGroup($model,'end_at',
                    array('widgetOptions'=>array(
                                'options' => array(
                                    //'showAnim' => 'fold',
                                    'dateFormat' => $this->cJuiDatePickerViewFormat,
                                ),
                                'htmlOptions'=>array('class'=>'span5'),                                
                            )
                        )
                    ); 
       ?>
    </div>    
</div>
<div class="row">
    <div class="col-md-6">        
     <?php echo $form->textAreaGroup($model,'desc',array('widgetOptions'=>array(
         'htmlOptions'=>array('class'=>'span5','maxlength'=>1024, 'rows'=>5, 'cols'=>75)))); ?>
    </div>
    <div class="col-md-6">
    <?php echo $form->textAreaGroup($model,'remarks',array(
                'widgetOptions'=>array(
                    'htmlOptions'=>array('class'=>'span5','maxlength'=>256, 'rows'=>5, 'cols'=>75)
                ))
            ); 
    ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>
<?php $this->endWidget(); ?>
<?php if($model->enableordrprd):?>
<?php
$tmpjs = 'js:toggleOPDiv("opdetails");';
$htmlOptions = array('onChange' => $tmpjs);
$opcheck = $form->checkboxGroup($model, 'isopedit',
                            array(
                                'widgetOptions'=>array(
                                    'htmlOptions'=> $htmlOptions
                                    )
                                )
                    );
echo $opcheck;
?>
<?php $this->renderPartial('//orderproduct/_form',array(
                'model'=>$opmodel,
                'allproducts'=>$allproducts,
        )); 
?>
<?php endif; ?>
<?php if($model->enableordrtasks): ?>
<?php
$tmpjs = 'js:toggleMSDiv("msdetails");';
$htmlOptions = array('onChange' => $tmpjs);
$milestonecheck = $form->checkboxGroup($model, 'ismsedit',
                            array(
                                'widgetOptions'=>array(
                                    'htmlOptions'=> $htmlOptions
                                    )
                                )
                    );
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  $milestonecheck,
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
<div class="row">
    <div class="col-md-6">
        <?php $this->renderPartial('//milestone/admin_sub',array(
                'model'=>$milestonemodel
                , 'form'=>$form
        )); ?>
    </div>
    <div class="col-md-6">
        <?php $this->renderPartial('//milestone/_form',array(
                'model'=>$milestonemodel
                //, 'form'=>$form
        )); ?>
    </div>    
</div>
<?php $this->endWidget(); ?>
<?php
$tmpjs = 'js:toggleOTDiv("otdetails");';
$htmlOptions = array('onChange' => $tmpjs);
$otcheck = $form->checkboxGroup($model, 'isotedit',
                            array(
                                'widgetOptions'=>array(
                                    'htmlOptions'=> $htmlOptions
                                    )
                                )
                    );
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  $otcheck . ' Tasks',
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
<div class="row">
    <div class="col-md-6">
        <?php $this->renderPartial('//ordertask/admin_sub',array(
                'model'=>$otmodel, 'form'=>$form, 
                'alltasks' => $alltasks,
                'allcontractors' => $allcontractors,
        )); ?>
    </div>
    <div class="col-md-6">        
        <?php $this->renderPartial('//ordertask/_form',array(
                'model'=>$otmodel, 'form'=>$form
        )); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php endif; ?>
<script type="text/javascript">
    window.onload = function() {
        toggleOPDiv("opdetails", true);
        toggleMSDiv("msdetails", true);
        toggleOTDiv("otdetails", true);
    };
</script>