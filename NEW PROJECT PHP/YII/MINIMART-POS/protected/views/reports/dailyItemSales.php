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
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'dailyitemsales-form',
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'htmlOptions' => array('role'=>'form')
));
$formgroup ='form-group';
$formcontrol= 'form-control';
$labels = $model->attributeLabels();
?>
<h3 style="color:#0000FF">Daily Item Sales Report</h3>


<?php 
$flds = array(
            'rptprdwse_namecol2'=> array('name' => 'rptprdwse_namecol2'),
            'totalQuantity' => array('name' => 'totalQuantity'),
            'totalAmount' => array('name' => 'totalAmount'),
        );
$btncols = array();
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>'order-grid',
            'dataProvider'=> $model->daywiseitemsales(),
            //'filter'=>$model,
            'columns'=> $columns,
            );
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sample-grid',
	'dataProvider'=>$model->daywiseitemsales(),
	'columns'=>$flds, 
));
?>
<?php $this->endWidget(); ?>