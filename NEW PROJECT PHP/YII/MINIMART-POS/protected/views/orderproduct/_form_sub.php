<div id="opdetails">
<div class="row">
    <div class="col-md-5">
        <?php 
                echo $form->select2Group($model,'product_id',array(
                'widgetOptions'=>array(
                    'data'=> $allproducts,
                    'htmlOptions'=>array('onchange'=>'js:changeproduct_orderentry()','class'=>'span5','maxlength'=>10))));
        ?>
    </div>
    <div class="col-md-1"><?php echo $form->textFieldGroup($model,'quantity',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','onchange'=>'orderamountcalc_orderentry()')))); ?></div>
    <div class="col-md-2"><?php echo $form->textFieldGroup($model,'unit_sp',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10,'onchange'=>'orderamountcalc_orderentry()')))); ?></div>
    <div class="col-md-2"><?php echo $form->textFieldGroup($model,'amount',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span10','maxlength'=>10,'disabled'=>'disabled')))); ?></div>
    <div class="col-md-2 form-actions">
        <?php 
            echo CHtml::ajaxSubmitButton(
                    "Add Product", 
                    $this->createUrl('order/' . Helper::CONST_updateProduct,
                                        array('id'=>$model->order_id)),
                    array('success'=> $onsuccessjs)
                    );
        ?>
        <?php 
//            $this->widget('booster.widgets.TbButton', array(
//                    'buttonType'=>'submit',
//                    'context'=>'primary',
//                    'label'=>$model->isNewRecord ? 'Create' : 'Save',
//            )); 
        ?>
    </div>
</div>
<div id='results' class="row">...</div>
</div>