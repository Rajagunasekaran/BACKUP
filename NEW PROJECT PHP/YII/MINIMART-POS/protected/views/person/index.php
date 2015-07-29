<?php
$this->breadcrumbs=array(
	'People',
);

?>

<h1>People</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
