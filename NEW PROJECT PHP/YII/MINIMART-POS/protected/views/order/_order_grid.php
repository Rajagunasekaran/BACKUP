<?php
Yii::app()->clientScript->registerScript( 'search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('order-grid', {
data: $(this).serialize()
});
$.fn.yiiGridView.update('timeslot-grid', {
data: $(this).serialize()
});
return false;
});
");
$portlet1gridId = 'order-grid';

$refreshscript = "
function timedRefresh(timeoutPeriod) {
	setTimeout(function(){refreshGrid()}, timeoutPeriod);
}
 
function refreshGrid() {
        $('#$portlet1gridId').yiiGridView.update(\"$portlet1gridId\");	
        var refresh = $this->db_auto_refresh;
        if(refresh)
        {
            timedRefresh($this->db_auto_refresh_freq);
        }
}
";
if(Helper::CONST_lazy_page_load)
{
    $refreshscript = "timedRefresh($this->page_load_delay_ms);" . $refreshscript;
}
Yii::app()->clientScript->registerScript('refresh_page', $refreshscript);
?>
<div id="gridsubmitresult"></div>
<?php
    $afterAjaxUpdate = "function() { dbAfterAjaxUpdate();}";
    $options1 = array(
                    'id' => 'order-grid',
                    'dataProvider' => $model->search($fromdb, $origin),
                    'afterAjaxUpdate'=> $afterAjaxUpdate,
                );
    $options = array_merge($options1, $options);
    $this->widget( 'booster.widgets.TbGridView', $options);
?>