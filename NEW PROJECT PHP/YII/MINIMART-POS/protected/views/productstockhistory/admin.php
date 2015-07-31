<?php
$this->breadcrumbs=array(
	'Productstockhistories'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Productstockhistory','url'=>array('index')),
array('label'=>'Create Productstockhistory','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('productstockhistory-grid', {
data: $(this).serialize()
});
return false;
});
");
?>
<?php /*
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
*/ ?>

<?php 
$gridId = 'productstockhistory-grid';
$flds = array();
$flds['productprice_id'] = array(
                        'name' => 'productprice_id',
                        'value' => '$data->productprice->name',
                        );
$flds['updationdate'] = array(
                        'name' => 'updationdate',
                        );
$flds['beforeupdation'] = array(
                        'name' => 'beforeupdation',
                        );
$flds['afterupdation'] = array(
                        'name' => 'afterupdation',
                        );
$btncols = array();
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>$gridId,
            'dataProvider'=>$model->search(),
            'columns'=> $columns,
            );
$this->setDefaultGVOptions($options);
$this->widget('booster.widgets.TbExtendedGridView', $options); 
?>