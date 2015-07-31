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
<?php echo $this->renderPartial('posreportslayout'
        , array(          
            )
        ); 
?>
<!--<button class="btn btn-large btn btn-primary" onclick="js:document.location.href='/pos/order/admin?actionid=PDF'" id="yw5" name="yt1" type="button">PDF</button>-->
<H3 style="color:#0000FF"> Sales Bill Details</H3>

<?php
$flds['qoi_id']= array( 'name'=>'qoi_id'
                    , 'header' => 'Bill Number'
                    , 'value'=>'$data->qoi_id' ,
                    );
$flds['created_at']=array('name'=>'created_at',
                           'header'=>'Bill Date');
 $flds['amount']=array('name'=>'amount',
                       'header'=>'Bill Amount' );
$flds['customer_name']=array( 'name'=>'customer_name', 'value'=>'$data->customer ? $data->customer->name: ""' );
$flds['details'] = array('name' => 'details'
                                    ,'value' => '$data->payment->details?$data->payment->details:"Sales"'
                                    );
$billnoUrl='$this->grid->controller->createUrl("orderproduct/admin/$data->id")';
$btncols = array( array(
                'class'=>'booster.widgets.TbButtonColumn',
                'template'=>'{View}',
              'buttons'=>array(
                            'View'=>array(
                                'url'=>$billnoUrl,
                            ),
                      
            )));
$columns = array_merge($btncols, $flds);
$this->setDefaultGVOptions($options);
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
$this->widget('zii.widgets.grid.CGridView', array(
'id'=>'sample-grid',
'dataProvider'=>$model->search(),
'columns'=>$columns, 
//    'filter'=>$model,
)); 

?>