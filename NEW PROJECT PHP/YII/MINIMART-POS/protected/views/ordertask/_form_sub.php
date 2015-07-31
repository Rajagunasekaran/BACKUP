<div id="otdetails">
<div class="row">
    <div class="col-md-6">
        <?php echo $form->textFieldGroup($model,'task_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>
        <?php echo $form->textFieldGroup($model,'details',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>1024)))); ?>
        <?php echo $form->datePickerGroup($model,'start_at',
                array('widgetOptions'=>array(
                            'options' => array(
                                'showAnim' => 'fold',
                                'dateFormat' => $this->cJuiDatePickerViewFormat,
                            ),
                            'htmlOptions'=>array(),                                
                        )
                    )
                ); 
        ?>         
        <?php echo $form->datePickerGroup($model,'end_at',
                array('widgetOptions'=>array(
                            'options' => array(
                                'showAnim' => 'fold',
                                'dateFormat' => $this->cJuiDatePickerViewFormat,
                            ),
                            'htmlOptions'=>array(),                                
                        )
                    )
                ); 
        ?>
    </div>
    <div class="col-md-6">
        <?php echo $form->textFieldGroup($model,'cost',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>
        <?php echo $form->textFieldGroup($model,'amount',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>        
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php echo $form->textFieldGroup($model,'completed',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>
    </div>
    <div class="col-md-6">
        <?php echo $form->textFieldGroup($model,'completed_remarks',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>1024)))); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?php echo $form->datePickerGroup($model,'completed_at',
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
</div>            
</div>