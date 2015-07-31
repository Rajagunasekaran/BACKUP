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
$flds = array(
    'salesdate' => array('name' => 'salesdate'),
    'login_id'=> array('name' => 'login_id'
                                        ,'type' => 'raw'
                                        ,'value' => '$data->login->login'),
    'totalcollections' => array('name' => 'totalcollections'),
                );
$btncols = array( );
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>'register-grid',
            'dataProvider'=> $model->registerwisecollections(),
            'filter'=>$model,
            'columns'=> $columns,
            );
$this->setDefaultGVOptions($options);
$this->widget('booster.widgets.TbGridView', $options);
?>