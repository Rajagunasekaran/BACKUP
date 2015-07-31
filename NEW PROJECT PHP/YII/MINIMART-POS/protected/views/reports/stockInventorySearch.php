<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); 
//echo Yii::app()->createUrl($this->route);
?>

<div class="row">
    <div class="col-md-3">
        <label>Product</label>
        <?php 
        $htmlOptions = array(
            'placeholder' => 'Select Product', 'class'=>'form-control'           
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'product_id',
            'model' => $model,
            'data' => $this->getProductProductLookup(),
            'options' => array(
                'allowClear' => true,
            ),
            'htmlOptions' => $htmlOptions,
        ) );
        ?>
    </div>
<!--    <div class="col-md-3">
        <label>Code</label>
        <?php 
//        $htmlOptions = array(
//            'placeholder' => 'Select Code', 'class'=>'form-control'           
//            );
//        $this->widget( 'booster.widgets.TbSelect2', array(
//            'attribute' => 'code',
//            'model' => $model,
//            'data' => $this->getcodelookup(),
//            'options' => array(
//                'allowClear' => true,
//            ),
//            'htmlOptions' => $htmlOptions,
//        ) );
        ?>
    </div>-->
<div class="col-md-3">
    <label>Invoice Date</label>
                <?php
                $this->widget( 'booster.widgets.TbDatePicker', array(
                    'attribute' => 'invdate',
                    'model' => $model,
                    'value' => $model->invdate,
                    'options' => array(
                        'showAnim' => 'fold',
                        'dateFormat' => $this->cJuiDatePickerViewFormat,
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Select Invoice Date',
                    ),
                ) );
                ?>
        </div>
   <div class="col-md-3">
        <label>Invoice Number</label>
        <?php 
        $htmlOptions = array(
            'placeholder' => 'Select Invoice No', 'class'=>'form-control'           
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'invno',
            'model' => $model,
            'value' => $model->invno,
            'data' => $this->getInvoiceLookup(),
            'options' => array(
                'allowClear' => true,
            ),
            'htmlOptions' => $htmlOptions,
        ) );
        ?>
    </div> 
</div><br>
<div class="form-actions">
        <?php $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'submit',
                'context'=>'primary',
                'label'=>'Search',
        )); ?>
</div>

<?php $this->endWidget(); ?>