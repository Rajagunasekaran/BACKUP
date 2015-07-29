<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'order-form',
	'enableAjaxValidation'=>false,
)); 
echo $form->errorSummary($model); 
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' => 'Order Details',
        'context' => 'primary',
        //'headerIcon' => 'info',
        'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="row">
            <div class="col-md-5 col-sm-4 col-lg-4">
                <?php                    
                    $htmlOptions = array(
                        'placeholder' => 'Customer',                        
                        'ajax' => array(
                                    'type'=>'POST',
                                    //'dataType' => 'json',
                                    'url'=>$this->createUrl('order/' . Helper::CONST_oe_loadcustaddresses),
                                    'update'=>'#addressDiv',
                                    'data'=>array('customer_id'=>'js:this.value',
                                                'order_id' => $model->id),
                                  )
                        );
                    echo $form->select2Group(
                            $model
                            , 'customer_id'
                            , array('widgetOptions' 
                                        => array(
                                            'data' => Yii::app()->controller->getPeopleLookup(Helper::CONST_Customer),
                                            'htmlOptions' => $htmlOptions 
                                            ),
                                    'groupOptions' => array(
                                                    'allowClear' => true,
                                                    'asDropDownList' => false,
                                                    'label' => 'Customer',
                                                ),
                                )
                            
                            ) ;
                    ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php 
        $htmlOptions = array();
        if(!empty($type))
        {
            $htmlOptions['disabled'] = 'disabled';
            echo $form->hiddenField($model,'type');
        }
        echo $form->dropDownListGroup($model
                , 'type', array('widgetOptions' => array('data' => $this->getOrdertypesLookup() 
                , 'htmlOptions' => $htmlOptions) 
                 ));
        ?>
    </div>
    <?php if($this->getEnableordrpeople()): ?>
    <div class="col-md-4">
        <?php
        $htmlOptions = array(
            'placeholder' => 'Employee',
            'option selected' => $model->employee->id,
            );
        echo $form->select2Group(
                $model
                , 'employees'
                , array('widgetOptions' 
                            => array('data' => Yii::app()->controller->getPeopleLookup(Helper::CONST_Employee),
                                'htmlOptions' => $htmlOptions
                                )
                 )) ;
        ?>
    </div>
    <?php endif; ?>
</div>
<div class="row">
    <div class="col-md-offset-2 col-md-2">
        <?php echo $form->textFieldGroup($model,'qoi_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>16)))); ?>
    </div>
    <div class="col-md-offset-1 col-md-2">
        <?php echo $form->textFieldGroup($model,'delivered',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
    </div>
    <div class="col-md-offset-1 col-md-2">
        <?php echo $form->textFieldGroup($model,'invstatus',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>12)))); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-offset-3 col-md-3">        
        <?php 
        echo $form->textFieldGroup($model,'status',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>12)))); 
        echo $form->dropDownListGroup($model
                , 'status', array('widgetOptions' => array('data' => Yii::app()->user->orderstatuses 
                , 'htmlOptions' => array()) 
                 ));
        ?>
        <?php echo $form->textFieldGroup($model,'end_at',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>  
    </div>
    <div class="col-md-offset-1 col-md-3">
        <?php echo $form->textFieldGroup($model,'desc',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>1024)))); ?>
        <?php echo $form->textFieldGroup($model,'remarks',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>256)))); ?>        
    </div>
</div>        
<div class="row">
    <div class="col-md-offset-3 col-md-3">
        <?php echo $form->textFieldGroup($model,'cost',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>
	<?php echo $form->textFieldGroup($model,'amount',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>
	<?php echo $form->textFieldGroup($model,'disc',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>
    </div>
    <div class="col-md-offset-1 col-md-3">
        <?php echo $form->textFieldGroup($model,'paid',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>
        <?php echo $form->textFieldGroup($model,'paid',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>	
    </div>
</div>
<div class="row">
    <div class="form-actions col-lg-offset-5 col-lg-2">
        <?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Continue' : 'Save',
		)); ?>
    </div>    
</div>
<?php $this->endWidget(); ?>
<?php 
if($model->id > 0)
{
$submodel = new Orderproduct;
$submodel->order_id = $model->id;
$submodel->quantity = 1;
$this->renderPartial('//orderproduct/_form_sub', array(
    'model' => $submodel,
    'form' => $form
    ));
}
?>
<?php $this->endWidget(); ?>
