<?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
    });
    $('.search-form form').submit(function(){
    $.fn.yiiGridView.update('stockinventory-grid', {
    data: $(this).serialize()
    });
    return false;
    });
    ");
?>
<h3 style="color:#0000FF">Stock Inventory Report</h3>
<?php if(empty($_GET['actionid'])): ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));
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
 <div class="col-md-3">
              <label>Code</label>
        <?php 
        $htmlOptions = array('class'=>'form-control',
            'placeholder' => 'Select Code','class'=>'form-control'
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
$flds = array(
            'product_id'=> array('name' => 'product_id'                           
                            ,'value' => '$data->product->name'),
            'code'=> array('name' => 'code'
                            ,'value' => '$data->code'),
            'unit_cp' => array('name' => 'unit_cp','header'=>'Last Purchase Price'),
            'unit_sp' => array('name' => 'unit_sp'),
            'initial_stock' => array('name' => 'stock'),
//            'stockvalue' => array('name' => 'stockvalue'),
            'rol' => array('name'=>'rol','header'=>'Re-order-level'),
            'invno' => array('name' => 'invno','header'=>'Last Invoice Number'),
            'invdate' => array('name' => 'invdate','header'=>'Last Invoice Date'),
        );
$btncols = array();
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>'stockinventory-grid',
            'dataProvider'=> $model->stockinventory(),
//            'filter'=>$model,
            'columns'=> $columns,
            );
$this->widget('zii.widgets.grid.CGridView', array(
'id'=>'stockinventory-grid',
'dataProvider'=>$model->stockinventory(),
'columns'=>$flds, 
//    'filter'=>$model,
));
?>