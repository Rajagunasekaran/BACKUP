<?php
$this->breadcrumbs=array(
	'Registers'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Register','url'=>array('index')),
array('label'=>'Create Register','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('register-grid', {
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
if($this->action->id === Helper::CONST_sectionadmin) 
{
    $btncols = array( array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'template'=>'{update}{delete}',
                        'buttons'=>array(
                            'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("category/sectionupdate/$data->id")',
                            ),
                        ),
                    ),
                );
    $columns = array(
		'name',
		'desc',
                );    
}
else
{
    $btncols = array( array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'template'=>'{update}{delete}',
                        'buttons'=>array(
                            'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("category/update/$data->id")',
                            ),
                        ),
                    ),
                );
    $columns = array(
		'login_id' => array(
                    'name' => 'login_id',
                    'value' => 'empty($data->login)?"N/A":$data->login->login'
                    ),
		'open_time',
		'close_time',
		'op_balance',
		'cl_balance',
		'net_collection',
            );
}
$columns = array_merge($columns);//$btncols
$options = array(
'id'=>'register-grid',
'dataProvider'=>$model->search(),
//'filter'=>$model,
'columns'=>$columns,
);
$this->setDefaultGVOptions($options);
$this->widget('booster.widgets.TbGridView', $options); ?>