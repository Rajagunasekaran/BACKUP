<?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
    });
    $('.search-form form').submit(function(){
    $.fn.yiiGridView.update('order-grid', {
    data: $(this).serialize()
    });
    return false;
    });
    ");
?>
<h3 style="color:#0000FF">Daily Sales Report</h3>
<?php if(empty($_GET['actionid'])): ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));
?>
<div class="row">
    <div class="col-md-3">
        <?php echo $form->labelEx( $model, 'day' ); ?>
        <?php 
        $htmlOptions = array('class'=>'form-control',
            'placeholder' => 'Select Day',            
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'splsearch',
            'model' => $model,
            'data' => $this->getSplseachStringsLookup(),
            'options' => array(
                'allowClear' => true,
            ),
            'htmlOptions' => $htmlOptions,
        ) );
        ?>
    </div>
    <div class="col-md-3">
        <?php echo $form->labelEx( $model, 'paidstatus' ); ?>
        <?php 
        $htmlOptions = array('class'=>'form-control',
            'placeholder' => 'Select Paid Status',            
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'paidstatus',
            'model' => $model,
            'data' => $this->getPaidStatusLookup(),
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
            'customer_id'=> array('name' => 'customer_id'
                            ,'header' => 'Customer Name'
                            ,'value' => '$data->customer->name'),
            'amount' => array('name' => 'amount'),
            'disc' => array('name' => 'disc'),
            'exchange' => array('name' => 'exchange'),
            'roundoff' => array('name' => 'roundoff'),
            'paid' => array('name' => 'paid'),
                );
$btncols = array();
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>'order-grid',
            'dataProvider'=> $model->daywisecollections(),
            //'filter'=>$model,
            'columns'=> $columns,
            );
?>
<?php if(!empty($columns)):
    Yii::app()->clientScript->registerScript('refresh_page',"
   window.onload = function() {
   var day=$('#Order_splsearch').val();
   var status=$('#Order_paidstatus').val();
   if(day!='' && status!='')
    { 
    if(day=='ALL')
    {
    day=day+' Day';
    }
     var message=day+' Sales Report And Status : '+status
     $('#head').text(message);
    }
   else
   {
    $('#head').text('All Day Sales Report(s)');
   }
  };
");

endif;


?>
<h3 id="head" style="color:#0000FF"></h3>
<div class="search-form" style="display:none">

</div><!-- search-form -->
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sample-grid',
	'dataProvider'=>$model->daywisecollections(),
	'columns'=>$flds, 
));
?>
