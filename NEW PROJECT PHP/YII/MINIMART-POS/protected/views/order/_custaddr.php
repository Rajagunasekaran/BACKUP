<?php
$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'address-form',
	'enableAjaxValidation'=>false,
    ));
?>
<div id="addressDiv">    
<div class="row">
<div class="col-md-6 col-sm-6 col-lg-6">
    <?php
    $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  'From',
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );        
?>  
    <div id="newcustomerDiv" style="display:<?php echo ($model->isnewcustomer)?'block':'none'; ?>">
        <?php
        echo $form->textFieldGroup($model->customer,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10))));
        ?>
    </div>
    <div class="row">
        <div class="col-md-2" style="display:<?php echo ($model->isnewcustomer)?'none':'block'; ?>">
            <?php            
            $tmpjs = 'js:togglenewcustomer_orderentry()';
            $htmlOptions = array('onChange' => $tmpjs);            
            echo $form->checkboxGroup($model, 'isnewfrom',
                        array(
                            'widgetOptions'=>array(
                                'htmlOptions'=> $htmlOptions
                                )
                            )
                );
            ?>  
        </div>
        <div class="col-md-10" style="display:<?php echo ($model->isnewfrom)?'none':'block'; ?>">          
        <?php                
                $htmlOptions = array(
                'placeholder' => 'From',
                'ajax' => array(
                            'type'=>'POST',
                            //'dataType' => 'json',
                            'url'=>$this->createUrl('order/' . Helper::CONST_oe_getLocationById),                            
                            'data'=>array(
                                        'order_id'=>$model->id,
                                        'location_id'=>'js:this.value',
                                        'isto'=>'0',
                                        ),
                            'success'=>'js:function(data){ fillFromaddress(data);}'
                          )
                );
                echo $form->select2Group(
                        $model
                        ,'fromaddr_id'
                        ,array('widgetOptions' 
                                    => array(
                                        'data' => $this->getOrderFromAddresses($model)
                                        ,'htmlOptions' => $htmlOptions
                            )
                         )) ;        
            ?>
        </div>        
    </div>    
    <div id="fromaddrdtlsDiv">
        <?php
        $htmlOptions = array('name'=>'fromaddr[street]','class'=>'span5','maxlength'=>128);
        if(!$model->isnewfrom)
        {
            $htmlOptions['disabled'] = 'disabled';    
        }        
        echo $form->textFieldGroup($model->fromaddr,
                'street',array('widgetOptions'=>array(
                    'htmlOptions'=>$htmlOptions,
                    )));
        $htmlOptions = array('name'=>'fromaddr[pincode]','class'=>'span5','maxlength'=>10);
        if(!$model->isnewfrom)
        {
            $htmlOptions['disabled'] = 'disabled';    
        }
        echo $form->textFieldGroup($model->fromaddr,'pincode',array(
            'widgetOptions'=>array(
                'htmlOptions'=> $htmlOptions
                )));
        ?>
    </div>
<?php $this->endWidget(); ?>
</div>
<div class="col-md-6 col-sm-6 col-lg-6">    
    <?php
        $this->beginWidget(
            'booster.widgets.TbPanel',
            array(
            'title' =>  'To',
            'context' => 'default',
            //'headerIcon' => 'info',
            //'padContent' => false,
            'htmlOptions' => array()
            )
        );
?>
        <div class="row">
        <div class="col-md-2" style="display:<?php echo ($model->isnewcustomer)?'none':'block'; ?>">
            <?php
            $tmpjs = 'js:togglenewto_orderentry()';
            $htmlOptions = array('onChange' => $tmpjs);
            echo $form->checkboxGroup($model, 'isnewto',
                        array(
                            'widgetOptions'=>array(
                                'htmlOptions'=> $htmlOptions
                                )
                            )
                );
            ?>
        </div>
        <div class="col-md-10" style="display:<?php echo ($model->isnewto)?'none':'block'; ?>">
            <?php
                $htmlOptions = array(
                'placeholder' => 'To',
                'ajax' => array(
                            'type'=>'POST',
                            //'dataType' => 'json',
                            'url'=>$this->createUrl('order/' . Helper::CONST_oe_getLocationById),
                            'data'=>array(
                                        'order_id'=>$model->id,
                                        'location_id'=>'js:this.value',
                                        'isto'=>'1',
                                        ),
                            'success'=>'js:function(data){ fillToaddress(data);}'
                          )
                );
                echo $form->select2Group(
                        $model
                        ,'toaddr_id'
                        ,array('widgetOptions' 
                                    => array(
                                        'data' => $this->getOrderToAddresses($model),
                                        'htmlOptions' => $htmlOptions
                                        )
                         )) ;
            ?>
        </div>        
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php 
                $htmlOptions = array('class'=>'span5','maxlength'=>10);
                if(!$model->isnewto)
                {
                    $htmlOptions['disabled'] = 'disabled';    
                }
                echo $form->textFieldGroup($model,'toperson_name',array(
                    'widgetOptions'=>array(
                        'htmlOptions'=> $htmlOptions
                        )));
                ?>
            </div>
            <div class="col-md-6">
                <?php 
                $htmlOptions = array('class'=>'span5','maxlength'=>10);
                if(!$model->isnewto)
                {
                    $htmlOptions['disabled'] = 'disabled';    
                }
                echo $form->textFieldGroup($model,'toperson_mbl',array(
                    'widgetOptions'=>array(
                        'htmlOptions'=> $htmlOptions
                        )));
                ?>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
        <?php
        $htmlOptions = array('name'=>'toaddr[street]','class'=>'span5','maxlength'=>128);
        if(!$model->isnewto)
        {
            $htmlOptions['disabled'] = 'disabled';    
        }
        echo $form->textFieldGroup($model->toaddr,'street',array(
            'widgetOptions'=>array(
                'htmlOptions'=> $htmlOptions
                )));
        
        $htmlOptions = array('name'=>'toaddr[pincode]','class'=>'span5','maxlength'=>10);
        if(!$model->isnewto)
        {
            $htmlOptions['disabled'] = 'disabled';    
        }
        echo $form->textFieldGroup($model->toaddr,'pincode',array(
            'widgetOptions'=>array(
                'htmlOptions'=> $htmlOptions 
                )));
        ?>
        </div>
        </div>
<?php $this->endWidget(); ?>
</div> 
</div>
</div>
<?php $this->endWidget(); ?>