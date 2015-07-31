<?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
    });
    $('.search-form form').submit(function(){
    $.fn.yiiGridView.update('cancel-grid', {
    data: $(this).serialize()
    });
    return false;
    });
    ");
?>
<h3 style="color:#0000FF">Cancelled Report</h3>
<?php 
$flds = array(
            'refDate'=> array('name' => 'refDate'
                                    ,'header' => 'Date'
                                    ,'value' => '$data->refDate'),
            'billNo'=> array('name' => 'billNo'
                                    ,'header' => 'Bill No'
                            ,'value' => '$data->billNo'),
            'refAmount'=> array('name' => 'refAmount'
                                    ,'header' => 'Amount'
                                ,'value' => ('$data->refAmount')),
            'refTax'=> array('name' => 'refTax'
                                    ,'header' => 'Tax'
                                    ,'value' => '$data->refTax'),
            'refDisc'=> array('name' => 'refDisc'
                                    ,'header' => 'Discount'
                            ,'value' => '$data->refDisc'),
                );
$btncols = array();
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>'cancel-grid',
            'dataProvider'=> $model->getCancelledData(),
            //'filter'=>$model,
            'columns'=> $columns,
            );
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sample-grid',
	'dataProvider'=>$model->getCancelledData(),
	'columns'=>$flds, 
));
?>