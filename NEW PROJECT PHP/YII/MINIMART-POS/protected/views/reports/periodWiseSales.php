<?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
    });
    $('.search-form form').submit(function(){
    $.fn.yiiGridView.update('periodwisesales-grid', {
    data: $(this).serialize()
    });
    return false;
    });
    ");
?>
<h3 style="color:#0000FF">Periodwise Sales Report</h3>
<?php if(empty($_GET['actionid'])): ?>

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); 
?>
<div class="row">
    <div class="col-md-3">
        <?php echo $form->labelEx( $model, 'groupby' ); ?>
        <?php 
        $htmlOptions = array('class'=>'form-control',
            'placeholder' => 'Select Group by',          
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'groupby',
            'model' => $model,
            'data' => $this->getReportsGroupbyStrings(),
            'options' => array(
                'allowClear' => true,
            ),
            'htmlOptions' => $htmlOptions,
        ) );
        ?>
    </div>
    <div class="col-md-3">
            <?php echo $form->labelEx($model, 'daterange'); ?>
            <?php
                $this->widget('booster.widgets.TbDateRangePicker', array(
                    'attribute' => 'daterange',
                    'model' => $model,
                    'value' => $model->daterange,
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
</div><br>
<div class="form-actions">
       
        <?php
        $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'submit',
                'context'=>'primary',
                'label'=>'Search',
                          
        )); ?>
</div>

<?php $this->endWidget(); ?>

<?php endif; ?>
<?php 
$flds = array(
            'rptprdwse_namecol2'=> array('name' => 'rptprdwse_namecol2'),
            'totalAmount' => array('name' => 'totalAmount'),
        );
if($model->groupby !== Helper::CONST_Product)
{
    $flds = array_merge(
                array(
                    'rptprdwse_namecol1'=> array('name' => 'rptprdwse_namecol1'),
                ),
                $flds
            );
}


$btncols = array();
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>'periodwisesales-grid',
            'dataProvider'=> $model->periodWiseSales(),
            'columns'=> $columns,
            );
?>
<?php if(!empty($columns)): 
   Yii::app()->clientScript->registerScript('refresh_page',"
   window.onload = function() {
   var date=$('#Orderproduct_daterange').val();
   if(date!='')
      { 
  var datesplit=date.split('-');
  var sdate=datesplit[0].split(' ');
  var edate=datesplit[1].split(' ');
  var message='Sales Report Between '+sdate[0]+' To '+edate[1] 
  $('#head').text(message);
  }
  else
  {
   $('#head').text('');
  }
};
");
?>
<h3 id="head"></h3>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sample-grid',
	'dataProvider'=>$model->periodWiseSales(),
	'columns'=>$flds, 
));
 endif; 
?>
