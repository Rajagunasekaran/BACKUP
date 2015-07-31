<?php 
echo 'type3 - DB';
$portlet1gridId = 'portlet1gridId';
$portlet2gridId = 'portlet2gridId';
$portlet3gridId = 'portlet3gridId';

$portlet1gridColumns = array(
		'name',
		'display',
		'desc',		
);
$portlet2gridColumns = array(
		'code',
		'name',
		'desc',		
);
$portlet3gridColumns = array(
		'code',
		'name',
		'firstname',		
);
$portlet1gridOptions = array(
                        'id'=> $portlet1gridId,
                        'dataProvider'=>$portlet1griddataProvider,
                        'ajaxUpdate'=>$portlet1gridId,
                        'columns'=>$portlet1gridColumns,
                        );
$this->setDefaultGVOptions($portlet1gridOptions, Helper::CONST_grid_Height_300,
                Helper::CONST_grid_Font_12, Helper::CONST_grid_Template_I);
$portlet1content = $this->widget("booster.widgets.TbGridView", $portlet1gridOptions, true);
$portlet2gridOptions = array(
                        'id'=> $portlet2gridId,
                        'dataProvider'=>$portlet2griddataProvider,
                        'ajaxUpdate'=>$portlet2gridId,
                        'columns'=>$portlet2gridColumns,
                        );
$this->setDefaultGVOptions($portlet1gridOptions, Helper::CONST_grid_Height_300,
                Helper::CONST_grid_Font_12, Helper::CONST_grid_Template_I);
$portlet2content = $this->widget("booster.widgets.TbGridView", $portlet2gridOptions, true);
$portlet3gridOptions = array(
                        'id'=> $portlet3gridId,
                        'dataProvider'=>$portlet3griddataProvider,
                        'ajaxUpdate'=>$portlet3gridId,
                        'columns'=>$portlet3gridColumns,
                        );
$this->setDefaultGVOptions($portlet3gridOptions, Helper::CONST_grid_Height_300,
                Helper::CONST_grid_Font_12, Helper::CONST_grid_Template_I);
$portlet3content = $this->widget("booster.widgets.TbGridView", $portlet3gridOptions, true);

Yii::app()->clientScript->registerScript('refresh_page',"
timedRefresh($this->page_load_delay_ms);

function timedRefresh(timeoutPeriod) {
	setTimeout(function(){refreshGrid()}, timeoutPeriod);
}
 
function refreshGrid() {
        $('#$portlet1gridId').yiiGridView.update(\"$portlet1gridId\");
        $('#$portlet2gridId').yiiGridView.update(\"$portlet2gridId\");
        $('#$portlet3gridId').yiiGridView.update(\"$portlet3gridId\");
	//$.fn.yiiGridView.update(\"$portlet1gridId\");
        var refresh = $this->db_auto_refresh;
        if(refresh)
        {
            timedRefresh($this->db_auto_refresh_freq);
        }
}
");
?>

<div class="col-sm-12 col-md-12 main">
    <div class="row placeholders">
        <div class="col-xs-24 col-sm-12 placeholder">
            <?php 
                $this->widget(
                    'booster.widgets.TbPanel',
                    array(
                    'title' => 'Orders Overall status',
                    'context' => 'primary',
                    'headerIcon' => 'road',
                    'content' => "test",
                    'padContent' => false,
                    'htmlOptions' => array('style' => 'min-height:100px;'),
                    )
                );
            ?>
        </div>
    </div>
    <div class="row placeholders">
    <div class="col-xs-12 col-sm-6 placeholder">
        <?php 
            $panel = $this->widget(
                'booster.widgets.TbPanel',
                array(
                'title' => 'Invoice Summary',
                'context' => 'primary',
                'headerIcon' => 'list-alt',
                'padContent' => false,
                'content' => $portlet1content,
                'htmlOptions' => array('class' => 'dashboardgrid',),
                )
            );
        ?>
    </div>
    <div class="col-xs-12 col-sm-6 placeholder">
      <?php 
    $this->widget(
        'booster.widgets.TbPanel',
        array(
        'title' => 'Orders Due in Next 3 Days',
        'context' => 'primary',
        'headerIcon' => 'bullhorn',
        'padContent' => false,
        'content' => $portlet2content,
        'htmlOptions' => array('class' => 'dashboardgrid',),
        )
    );
?>
    </div>
    </div>
    <div class="row placeholders">
        <div class="col-xs-12 col-sm-6 placeholder">
          <?php 
            $wdgt = $this->beginWidget(
                'booster.widgets.TbPanel',
                array(
                'title' => 'Orders Summary',
                'context' => 'primary',
                'headerIcon' => 'list-alt',
                'padContent' => false,
                'content' => $portlet3content,
                'htmlOptions' => array('class' => 'dashboardgrid',),
                )
            );
        ?>
<?php $this->endWidget(); ?>
        </div>
    </div>
</div>