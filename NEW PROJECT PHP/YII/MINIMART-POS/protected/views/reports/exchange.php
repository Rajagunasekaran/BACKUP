<?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
    });
    $('.search-form form').submit(function(){
    $.fn.yiiGridView.update('exchange-grid', {
    data: $(this).serialize()
    });
    return false;
    });
    ");
?>

<h3 style="color:#0000FF">Exchange Report</h3>


<?php 
$flds = array(
            'billNo'=> array('name' => 'billNo'
                            ,'header' => 'Bill No'
                            ,'value' => '$data->billNo'),
            'excOldName'=> array('name' => 'excOldName'
                                    ,'header' => 'Exchange For'
                                    ,'value' => '$data->excOldName'),
            'excOldAmount'=> array('name' => 'excOldAmount'
                                            ,'header' => 'Cost for Items Exchanged For'
                                            ,'value' => '$data->excOldAmount'),
            'excNewName'=> array('name' => 'excNewName'
                                            ,'header' => 'Items Exchanged'
                                            ,'value' => '$data->excNewName'),
            'excNewAmount'=> array('name' => 'excNewAmount'
                                            ,'header' => 'Cost for Items Exchanged'
                                            ,'value' => '$data->excNewAmount'),
            'balanceDue'=> array('name' => 'balanceDue'
                                                    ,'header' => 'Balance Due'
                                                    ,'value' => '$data->balanceDue'),
        );
$btncols = array();
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>'exchange-grid',
            'dataProvider'=> $model->exchangereports(),
            //'filter'=>$model,
            'columns'=> $columns,
            );
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sample-grid',
	'dataProvider'=>$model->exchangereports(),
	'columns'=>$flds, 
));
?>
