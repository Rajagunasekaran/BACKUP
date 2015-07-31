<?php 
$formurl = $this->createUrl('orderproduct/' . $this->action->id );
$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'orderproduct-form',
        'action' => $formurl,
	'enableAjaxValidation'=>false,
));
?>
<?php echo $form->errorSummary($model); ?>
<?php 
$orderid = $form->textFieldGroup(
                $model,'order_id',
                array('widgetOptions'
                        =>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10))
                    )
            );
$this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  false,
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
echo $orderid;
?>
<?php
$opGridId = 'opGridId';
$onsavejs ='js: function(e, params) {
                //alert("saved value: "+params.newValue);
            }';
$onsuccessjs = 'js: function(response, newValue) {
                    if(response === "NotOK") {
                        alert("Update not done");
                    }
                    $.fn.yiiGridView.update("$opGridId");
                }';
?>
<?php 
$this->renderPartial('//orderproduct/_form_sub',array(
	'model'=>$model,
        'form'=>$form,
        'allproducts' => $allproducts,
        'opGridId' => $opGridId,
        'onsuccessjs' => $onsuccessjs,
        'onsavejs' => $onsavejs,
)); 
?>
<?php $this->renderPartial('//orderproduct/admin_sub',array(
                'model'=>$model,
                'allproducts' => $allproducts,
                'opGridId' => $opGridId,
                'onsuccessjs' => $onsuccessjs,
                'onsavejs' => $onsavejs,
        )); 
?>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>