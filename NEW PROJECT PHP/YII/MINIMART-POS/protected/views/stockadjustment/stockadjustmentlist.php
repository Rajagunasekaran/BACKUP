<?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
    });
    $('.search-form form').submit(function(){
    $.fn.yiiGridView.update('stockadjustment-grid', {
    data: $(this).serialize()
    });
    return false;
    });
    ");
?>
<!--<button class="btn btn-large btn btn-primary" onclick="js:document.location.href='/pos/stockadjustment/stockadjustmentlist?actionid=PDF'" id="yw5" name="yt1" type="button">PDF</button>-->

<?php echo $this->renderPartial('posreportslayout'
        , array(          
            )
        ); 
?>
<!--<button class="btn btn-large btn btn-primary" onclick="js:document.location.href='/pos/stockadjustment/stockadjustmentlist?actionid=PDF'" id="yw5" name="yt1" type="button">PDF</button>-->
<h3 style="color:#0000FF">Stock Adjustment Details</h3>
<?php if(empty($_GET['actionid'])): ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));
?>
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
        )); 
 Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#sample-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
        ?>
</div>
<?php $this->endWidget(); ?>
<?php endif; ?>
<?php

$flds['dateofadjustment'] = array(
                        'name' => 'dateofadjustment',
                        'value' => '$data->dateofadjustment',
                        );
$flds['referenceno'] = array (
                    'name'=>'referenceno',
                    'value'=>'$data->referenceno',                    
                );
$flds['product_id'] = array(
                        'name' => 'product_id',
                        'value' => '$data->product->name',
                        );
$flds['code'] = array(
                        'name' => 'code',
                        'value' => '$data->code',
                        );
$flds['sku'] = array(
                        'name' => 'sku',
                        'value' => '$data->sku',
                        );
$flds['stock_adjustment'] = array(
                        'name' => 'stock_adjustment',
                        'value' => '$data->stock_adjustment',
                        );
$flds['Remarks'] = array (
                    'name'=>'Remarks',
                    'value'=>'$data->Remarks',                  
                );

$viewhistoryUrl = '$this->grid->controller->createUrl("productprice/pricehistory/$data->id")';
$btncols = array();
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>'stockadjustment-grid',
            'dataProvider'=>$model->StockAdjustmentList(),
//            'filter'=>$model,
            'columns'=> $columns,
            );

?>
<h3 id="head" style="color:#0000FF"></h3>
<div class="search-form" style="display:none">

</div><!-- search-form -->
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sample-grid',
	'dataProvider'=>$model->StockAdjustmentList(),
	'columns'=>$flds, 
));
?>
