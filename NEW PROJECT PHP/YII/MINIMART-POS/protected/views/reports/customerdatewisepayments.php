<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('payment-grid', {
data: $(this).serialize()
});
return false;
});
");
?>
<?php 
$partyHeader = Helper::CONST_Customer;
$flds = array(
    'paymentdate' => array('name' => 'paymentdate'),
    'party_id'=> array('name' => 'party_id'
                    ,'type' => 'raw'
                    ,'header' => $partyHeader
                    ,'value' => '$data->party->name'),
    'paid' => array('name' => 'paid'),
    'pending' => array('name' => 'pending'),
                );
$btncols = array( );
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>'payment-grid',
            'dataProvider'=> $model->customerdatewisepayments(),
            'filter'=>$model,
            'columns'=> $columns,
            );
$this->setDefaultGVOptions($options);
$this->widget('booster.widgets.TbGridView', $options);
?>