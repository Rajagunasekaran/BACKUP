<?php
$this->breadcrumbs=array(
	'Mailqueues'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Mailqueue','url'=>array('index')),
array('label'=>'Create Mailqueue','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('mailqueue-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Mailqueues</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'mailqueue-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'event_id',
		'mailids',
		'subject',
		'mail_body',
		'status',
		/*
		'attempts',
		'last_attempt_on',
		'created_at',
		'updated_at',
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
