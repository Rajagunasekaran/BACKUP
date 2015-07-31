<?php
$this->breadcrumbs=array(
    	'Person'=>array('index'),
	'Manage',
);

$this->menu=array(
    array('label'=>'List Person','url'=>array('index')),
    array('label'=>'Create Person','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('person-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<H3 style="color:#0000FF"> Customer Details</H3>
<?php
$flds = $this->appFormFields['lf']['person'];
unset($flds['role_id']);

$flds = array(
             
            'name' => array('name' => 'name'),
            'firstname' => array('name' => 'firstname'),
            'mobile' => array('name'=>'mobile'),
            'mail' => array('name' => 'mail'),
        );
switch ($this->action->id)
{
    case Helper::CONST_salesadmin:
        $updateurl = '$this->grid->controller->createUrl("person/'. Helper::CONST_salesupdate .'/$data->id")';
        $createurl = 'person/'. Helper::CONST_salescreate;
        break;
    case Helper::CONST_employeeadmin:
        $updateurl = '$this->grid->controller->createUrl("person/'. Helper::CONST_employeeupdate .'/$data->id")';
        $createurl = 'person/'. Helper::CONST_employeecreate;
        break;
    case Helper::CONST_customeradmin:
        $updateurl = '$this->grid->controller->createUrl("person/'. Helper::CONST_customerupdate .'/$data->id")';
        $createurl = 'person/'. Helper::CONST_customercreate;
        break;
    case Helper::CONST_supplieradmin:
        $updateurl = '$this->grid->controller->createUrl("person/'. Helper::CONST_supplierupdate .'/$data->id")';
        $createurl = 'person/'. Helper::CONST_suppliercreate;
        break;
    case Helper::CONST_contractoradmin:
        $updateurl = '$this->grid->controller->createUrl("person/'. Helper::CONST_contractorupdate .'/$data->id")';
        $createurl = 'person/'. Helper::CONST_contractorcreate;
        break;    
}
if($this->action->id !== 'admin')
{
    $btncols = array( array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'template'=>'{update}{delete}',
                        'buttons'=>array(
                            'update'=>array(
                                'url'=>$updateurl,
                            ),
                        ),
                    ),
                );
}
else
{
    $btncols = array( array(
                'class'=>'booster.widgets.TbButtonColumn',
                'template'=>'{update}{delete}',
            ));
    $createurl = 'person/'. Helper::CONST_createactionid;
}
$columns = array_merge($btncols, $flds);

$options = array(
'id'=>'person-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=> $columns,
);
$this->setDefaultGVOptions($options);

$this->widget('booster.widgets.TbButton', array(
                'buttonType'=>'button',
                'context'=>'primary',
                'label'=> 'Add New',
                'htmlOptions' => array('onclick' => "js:document.location.href='" . Yii::app()->createUrl($createurl) . "'")
        ));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'person-grid',
	'dataProvider'=>$model->search(),
	'columns'=>$columns,
        'filter'=>$model,
)); 

?>