<?php 
$options = array(
'id'=> $gridId,
'dataProvider'=>$griddataprovider,
'columns'=>array(
		'name',
		'display',
		'desc',		
),
);
$this->setDefaultGVOptions($options, Helper::CONST_grid_Height_300,
                Helper::CONST_grid_Font_12, Helper::CONST_grid_Template_I);
$this->widget('booster.widgets.TbGridView', $options); 
?>