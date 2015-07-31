<?php
$this->breadcrumbs=array(
	'Ordertasks'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Ordertask','url'=>array('index')),
array('label'=>'Create Ordertask','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('ordertask-grid', {
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
<?php $this->renderPartial('//ordertask/admin_sub',array(
	'model'=>$model, 'form'=>$form
)); ?>
