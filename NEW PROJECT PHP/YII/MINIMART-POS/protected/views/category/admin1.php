<?php
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Category','url'=>array('index')),
array('label'=>'Create Category','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('category-grid', {
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
*/ 
?>
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
		'name',
		'desc',
		array('name' => 'desc', 'value'=>'(empty($data->section)?"":$data->section->name)'),                
            );    
}
$columns = array_merge($btncols, $columns);
$options = array(
'id'=>'category-grid',
'dataProvider'=>$model->search(),
//'filter'=>$model,
'columns'=>$columns,
);
$this->setDefaultGVOptions($options);
?>
<H3 style="color:#0000FF"> Section Details</H3>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'columns'=>$columns, 
//        'filter'=>$model,
));
?>
