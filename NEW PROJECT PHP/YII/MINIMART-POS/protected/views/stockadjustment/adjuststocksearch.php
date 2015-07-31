<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<div class="row">
    <div class="col-md-3">
            <label>Date Range</label> 
            <?php
                $this->widget('booster.widgets.TbDateRangePicker', array(
                    'attribute' => 'dateofadjustment',
                    'model' => $model,
                    'value' => $model->dateofadjustment,
                    'options' => array(
                        'showAnim' => 'fold',
                        'format' => $this->boosterTbDateRangePickerFormat,
                            'timePicker'=> false,
    //                        'timePickerIncrement'=> 5,
    //                        'timePicker12Hour' => false,
                    ),
                    'htmlOptions' => array('placeholder' => 'Select Period',
                       'class'=>'form-control',
                    ),
                ));
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
            'data' => $this->getAllProducts(),
            'options' => array(
                'allowClear' => true,
            ),
            'htmlOptions' => $htmlOptions,
        ) );
        ?>
    </div>
    <div class="col-md-3" id="productName">
        <label>SKU[Barcode]</label> 
        <?php 
        $htmlOptions = array(
            'placeholder' => 'Select Barcode', 'class'=>'form-control',           
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'sku',
            'model' => $model,
            'value' => $model->sku,
            'data' => $this->getProductBarcode(),
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
