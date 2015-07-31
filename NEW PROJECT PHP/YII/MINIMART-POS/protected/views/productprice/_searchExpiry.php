<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<div class="row">
    <div class="col-md-3" id="expiryDate">
        <label>Expiry Date</label>
        <?php
            $this->widget( 'booster.widgets.TbDatePicker', array(
                'attribute' => 'expdate',
                'model' => $model,
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => $this->cJuiDatePickerViewFormat,
                ),
                'htmlOptions' => array('style'=>'width:265px',
                    'placeholder' => 'Select Expiry Date',
                ),
            ) );
            ?>
    </div>
    <div class="col-md-3" id="productPriceCode">
        <label>Code</label> 
        <?php 
        $htmlOptions = array(
            'placeholder' => 'Select Code','class'=>'form-control',     
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'code',
            'model' => $model,
            'data' => $this->getProductPriceCodeLookup(),
            'options' => array(
                'allowClear' => true,
            ),
            'htmlOptions' => $htmlOptions,
        ) );
        ?>
    </div>
    <div class="col-md-3">
        <label>Invoice Number</label> 
        <?php 
        $htmlOptions = array(
            'placeholder' => 'Select Invoice No', 'class'=>'form-control',           
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'invno',
            'model' => $model,
            'data' => $this->getProductPriceInvoiceLookup(),
            'options' => array(
                'allowClear' => true,
            ),
            'htmlOptions' => $htmlOptions,
        ) );
        ?>
    </div>
    <div class="col-md-3" id="productName">
        <label>Product Name</label> 
        <?php 
        $htmlOptions = array(
            'placeholder' => 'Select Product Name', 'class'=>'form-control',           
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'product_id',
            'model' => $model,
            'value' => $model->product_id,
            'data' => $this->getProductProductLookup(),
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
