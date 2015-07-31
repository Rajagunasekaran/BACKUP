<?php
$this->breadcrumbs=array(
	'People'=>array('index'),
	$model->name,
);

?>

<h1>View Person #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'code',
		'name',
		'auxname',
		'firstname',
		'lastname',
		'mobile',
		'mail',
		'website',
		'mobile_addnls',
		'fax',
		'did',
		'cost_center',
		'devicetoken',
		'commission',
		'mhcost',
		'mhrate',
		'geo_update_frq',
		'work_hour_start',
		'work_hour_end',
		'status',
		'enablelogin',
                'enablepplcode',
		'enablecontact',
		'enablepplauxname',
		'created_at',
		'updated_at',
),
)); ?>
