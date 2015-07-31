<?php
$this->breadcrumbs=array(
	'Milestones'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Milestone','url'=>array('index')),
array('label'=>'Create Milestone','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('milestone-grid', {
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
<?php $this->renderPartial('admin_sub',array(
	'model'=>$model, 'form'=>$form
)); ?>
