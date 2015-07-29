<?php
$this->breadcrumbs=array(
	'Payments'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Payment','url'=>array('index')),
array('label'=>'Create Payment','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('payment-grid', {
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
$flds = $this->appFormFields['lf']['payment'];
unset($flds['direction']);
unset($flds['account_id']);

switch($this->action->id)
{
    case Helper::CONST_customeradmin:
        $partyHeader = Helper::CONST_Customer;
        $roleName = Helper::CONST_Customer;
        break;
    case Helper::CONST_supplieradmin:
        $partyHeader = Helper::CONST_Supplier;
        $roleName = Helper::CONST_Supplier;
        break;
    case Helper::CONST_contractoradmin:
        $partyHeader = Helper::CONST_Contractor;
        $roleName = Helper::CONST_Contractor;
        break;
    default:
        $partyHeader = null;
        $roleName = null;
        break;
}
$flds['party_id'] = array('name' => 'party_id'
                                        ,'type' => 'raw'
                                        ,'header' => $partyHeader
                                        ,'value' => '$data->displayParty'
                                    );
switch($this->action->id)
{
    case Helper::CONST_customeradmin:
    case Helper::CONST_supplieradmin:
        $order_idheader = Helper::CONST_BillNumber;//Yii::app()->controller->getMenuLabels(Helper::CONST_Order);
        break;
    case Helper::CONST_contractoradmin:
        $order_idheader =  Helper::CONST_Ordertask;
        break;
    default:
        $order_idheader = Yii::app()->controller->getMenuLabels(Helper::CONST_Order) . '/' . Helper::CONST_Ordertask;
        break;
}

$flds['order_or_ot_id'] = array('name' => 'order_or_ot_id'
                                        ,'type' => 'raw'
                                        ,'header' => $order_idheader
                                        ,'value' => '$data->displayOrderOrOrderTask'
                                    );
$btncols = array( );
$columns = array_merge($btncols, $flds);
$options = array(
            'id'=>'payment-grid',
            'dataProvider'=> $model->searchByRole($roleName),
            'filter'=>$model,
            'columns'=> $columns,
            );
$this->setDefaultGVOptions($options);
if(Helper::CONST_creatPaymentEnabled)
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