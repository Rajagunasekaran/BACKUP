<?php
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Account','url'=>array('index')),
array('label'=>'Create Account','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('account-grid', {
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
*/ ?>
<?php 
$flds = $this->appFormFields['lf']['account'];
$flds['party_id'] = array('name' => 'party_id'
                                        ,'type' => 'raw'
                                        ,'value' => '$data->displayParty'
                                    );
$flds['order_or_ot_id'] = array('name' => 'order_or_ot_id'
                                        ,'type' => 'raw'
                                        ,'header' => Yii::app()->controller->getMenuLabels(Helper::CONST_Order) . ' / ' . Helper::CONST_Ordertask
                                        ,'value' => '$data->displayOrderOrOrderTask'
                                    );
$flds['acnt_no'] = array('name' => 'acnt_no'
                                        ,'type' => 'raw'
                                        ,'value' => '$data->displayAcntNo'
                                    );
$btncols = array( );
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>'account-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'columns'=> $columns,
            );
$this->setDefaultGVOptions($options);

if(!$this->getMoperinvoice())
{
$this->widget('booster.widgets.TbButton', array(
                'buttonType'=>'button',
                'context'=>'primary',
                'label'=> 'Add New',
                'htmlOptions' => array('onclick' => 'js:document.location.href="create"')
        ));    
}
$this->widget('booster.widgets.TbGridView', $options);

?>
