<div id="msdetails">
<div class="row">
    <div class="col-md-12">
        <?php echo $form->textFieldGroup($model,'details',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>1024)))); ?>  
    </div>        
</div>	 
<div class="row">
    <div class="col-md-9">
        <?php 
        echo $form->datePickerGroup($model,'start_at',
                    array('widgetOptions'=>array(
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'dateFormat' => $this->cJuiDatePickerViewFormat,
                                ),
                                'htmlOptions'=>array('class'=>'span5'),                                
                            )
                        )
                    ); 
        ?>
    </div>
    <div class="col-md-3">
        <?php echo $form->textFieldGroup($model,'alertbefore',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
    </div>    
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $form->textFieldGroup($model,'remarks',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>256)))); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $form->textAreaGroup($model,'mailids', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>2, 'cols'=>50, 'class'=>'span8')))); ?>
    </div>    
</div>
</div>