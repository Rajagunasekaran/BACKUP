<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); 
?>
<?php
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  'Stock Adjustment Details',
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
<div class="row">
    <div class="col-md-3">
        <label class="control-label required">Reference No</label><br>
        <input type="text" name="Subproductprice[referenceno]" id="Subproductprice_referenceno" onchange="duplicaterefnocheck()" class="form-control">
         <?php // echo $form->textFieldGroup($model,'referenceno',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>
    </div>
        <div class="col-md-3">	
         <?php echo $form->textFieldGroup($model,'code',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128,'disabled'=>true)))); ?>
    </div>
    <div class="col-md-3">
        <label class="control-label required">Date Of Adjustment<span style="color:red">*</span></label><br>
        <input type="text" name="Subproductprice[dateofadjustment]" id="Subproductprice_dateofadjustment" class="form-control" style="width:175px" readonly>
         <?php // echo $form->textFieldGroup($model,'referenceno',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
		
         <?php echo $form->textFieldGroup($model,'sku',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128,'disabled'=>true)))); ?>
    </div>
    <div class="col-md-3">
		
         <?php echo $form->textFieldGroup($model,'stock',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128,'disabled'=>true)))); ?>
    </div>
    <div class="col-md-3">		
        <label class="control-label required">Remarks<span style="color:red">*</span></label><br>
        <textarea name="Subproductprice[Remarks]" id="Subproductprice_Remarks" class="form-control"></textarea>
    </div>
     
    </div>
<div class="row">
     <div class="col-md-3">		
         <label class="control-label required">Stock Adjustment Quantity<span style="color:red">*</span></label><br>
        <input type="text" name="Subproductprice[stockadjustment]" id="Subproductprice_stockadjustment" class="form-control numberonly" style="width:150px">
    </div>
    <div class="col-md-3">		
        <label class="control-label required">Stock Adjustment<span style="color:red">*</span></label><br>
        <input type="button" id="add" onclick="addstock()" value="+"> <input id="checkboxadd" name="checkboxadd" type="checkbox" hidden></input>
        <input type="button" id="delete" onclick="minusstock()" value="-"> <input id="checkboxminus" name="checkboxminus" type="checkbox" hidden ></input>
    </div>
    <div class="col-md-3">		
         <?php echo $form->hiddenField($model,'product_id'); ?>
    </div>
    </div>
<div class="form-actions">
    <div class="row">
     <div class="col-md-4"></div><div class="col-md-4"></div>
     <input type="button" onclick="StockAdjustment('/pos/stockadjustment/posStockAdjustment')" class="btn btn-primary" value="Save">
     </div>
</div>
<?php
Yii::app()->clientScript->registerScript('refresh_page',"
   window.onload = function() {  
   var date=new Date();
   var day=date.getDate();
   var month=date.getMonth()+1;
   var year=date.getFullYear();
   var currecnt=year+'-'+month+'-'+day;
   $('#Subproductprice_dateofadjustment').val(currecnt);
};
");
$this->endWidget(); 
$this->endWidget(); ?>
<script type="text/javascript">
    function addstock()
    {
     var stock=$('#Subproductprice_stockadjustment').val();
     if(stock<0)
     {
      $('#Subproductprice_stockadjustment').val(-(stock));   
     }
     $('#checkboxadd').prop('checked', true);
     $('#checkboxminus').prop('checked', false);
     $('#add').addClass('btn btn-primary');
      $('#delete').removeClass('btn btn-close');
    }
    function minusstock()
    {
     var stock=$('#Subproductprice_stockadjustment').val();
     $('#Subproductprice_stockadjustment').val(-stock);
     $('#checkboxadd').prop('checked', false);
     $('#checkboxminus').prop('checked', true);
     $('#delete').addClass('btn btn-close');
     $('#add').removeClass('btn btn-primary');
    }
</script>
