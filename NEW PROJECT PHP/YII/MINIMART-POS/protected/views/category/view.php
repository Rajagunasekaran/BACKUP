<?php
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->name,
);
?>

<h1>View Category #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'parent_id',
		'name',
		'desc',
),
)); ?>
