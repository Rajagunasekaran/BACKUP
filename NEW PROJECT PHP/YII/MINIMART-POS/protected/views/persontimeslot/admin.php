<?php
$this->breadcrumbs=array(
	'Persontimeslots'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Persontimeslot','url'=>array('index')),
array('label'=>'Create Persontimeslot','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('persontimeslot-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Persontimeslots</h1>

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
'id'=>'persontimeslot-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'slotdate',
		'person_id',
		'ts1',
		'ts2',
		'ts3',
		/*
		'ts4',
		'ts5',
		'ts6',
		'ts7',
		'ts8',
		'ts9',
		'ts10',
		'ts11',
		'ts12',
		'ts13',
		'ts14',
		'ts15',
		'ts16',
		'ts17',
		'ts18',
		'ts19',
		'ts20',
		'ts21',
		'ts22',
		'ts23',
		'ts24',
		'created_at',
		'updated_at',
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
