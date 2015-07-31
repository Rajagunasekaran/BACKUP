<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
    });
    $('.search-form form').submit(function(){
    $.fn.yiiGridView.update('stockreport-grid', {
    data: $(this).serialize()
    });
    return false;
    });
    ");
?>
<h3 style="color:#0000FF">Stock Enquiry Details</h3>
<?php if (empty($_GET['actionid'])): ?>
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <div class="row">
        <div class="col-md-3">
            <label>Code</label>
            <?php
            $htmlOptions = array(
                'placeholder' => 'Select Code', 'class' => 'form-control'
            );
            $this->widget('booster.widgets.TbSelect2', array(
                'attribute' => 'code',
                'model' => $model,
                'data' => $this->getCodeLookup(),
                'options' => array(
                    'allowClear' => true,
                ),
                'htmlOptions' => $htmlOptions,
            ));
            ?>
        </div>
        <div class="col-md-3">
            <?php echo $form->textFieldGroup($model, 'sku', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 128)))); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => 'Search',
        ));
        ?>
    </div>
    <?php $this->endWidget(); ?>
<?php endif; ?>
<?php
$model = new ProductPrice();
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->StockReport(),
    'id' => 'stockreport-grid',
    'columns' => array(
        array(
            'header' => 'CODE',
            'value' => 'strip_tags($data[\'CODE\'])',
            'type' => 'raw',
            'name' => 'CODE',
            'htmlOptions'=>array('width'=>'200'),
        ),
        array(
            'header' => 'SKU',
            'value' => 'strip_tags($data[\'SKU\'])',
            'type' => 'raw',
            'name' => 'SKU',
            'htmlOptions'=>array('width'=>'200'),
        ),
        array(
            'header' => 'DATE',
            'value' => 'strip_tags($data[\'INVOICE_DATE\'])',
            'type' => 'raw',
            'name' => 'INVOICE_DATE',
            'htmlOptions'=>array('width'=>'200'),
        ),
        array(
            'header' => 'TYPE',
            'value' => 'strip_tags($data[\'INVOICE_NUMBER\'])?"INVOICE":"RECORD"',
            'type' => 'raw',
            'name' => 'TYPE',
            'htmlOptions'=>array('width'=>'200'),
        ),
        array(
            'header' => 'INVOICE NUMBER',
            'value' => 'strip_tags($data[\'INVOICE_NUMBER\'])',
            'type' => 'raw',
            'name' => 'INVOICE_NUMBER',
            'htmlOptions'=>array('width'=>'200'),
        ),
        array(
            'header' => 'QUANTITY PURCHASED',
            'value' => 'strip_tags($data[\'QUANTITY\'])',
            'type' => 'raw', 'name' => 'QUANTITY',
            'htmlOptions'=>array('width'=>'200'),
        ),
        array(
            'header' => 'STOCK AT HAND',
            'value' => 'strip_tags($data[\'STOCKINHAND\'])',
            'type' => 'raw', 'name' => 'STOCKINHAND',
            'htmlOptions'=>array('width'=>'200'),
        ),
    )
));
?>
