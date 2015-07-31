<?php 
//NEED TO CREATE PURCHASE VIEW AND APPEND THIS ONE
$productpricesUrl = Yii::app()->controller->createUrl('purchaseentry/'.Helper::CONST_getPricesForAProduct);
$multipriceproductsaveUrl = Yii::app()->controller->createUrl('purchaseentry/'.Helper::CONST_multipriceproductsave);
Yii::app()->clientScript->registerScript('refresh_page',"
window.onload = function() { 
    getPricesForAProductmaster('$productpricesUrl');
};
");
?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=>'product-form',
        'enableAjaxValidation' => false,
        'focus'=>array($model,'name'),
        'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
            ),
        //'enableClientValidation' => true,
//        'clientOptions' => array(
//                            'validateOnSubmit' => true,
//            //'validateOnChange'=>true,
//                           ),
)); ?>
<?php 
echo $form->errorSummary($model); 
?>
<?php
 echo $form->hiddenField($model,'id');
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  $this->getMenuLabels( 'Product' ) . ' Details',
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
<div class="row">
    <div class="col-md-4">
        <?php
            $htmlOptions = array(
                                //'disabled'=>'disabled'
                            );            
            //echo $form->hiddenField($model,'category_id');
            echo $form->select2Group(
                    $model
                    , 'category_id'
                    , array('widgetOptions' 
                                => array(
                                    'data' => Yii::app()->user->categories,
                                    'htmlOptions' => array('id'=>'selectPrdCategoryid',) 
                                    ),
                            'groupOptions' => array(
                                            'allowClear' => true,
                                            'asDropDownList' => false,
                                        ),
                        )

                    ) ;
        ?>
                        <input type="hidden" id="multipriceproductsaveUrl" value="<?php echo $multipriceproductsaveUrl;?>"/>    
        <?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>30,'onchange'=>'js:onchangeproductname();')))); ?>        
        <?php         
        echo $form->select2Group(
                    $model
                    , 'taxrate_id'
                    , array('widgetOptions' 
                                => array(
                                    'data' => Yii::app()->user->taxrates,
                                    'htmlOptions' => array() 
                                    ),
                            'groupOptions' => array(
                                            'allowClear' => true,
                                            'asDropDownList' => false,
                                        ),
                        )

                    ) ;
        ?>
        <?php 
            echo $form->textFieldGroup($model,'discper',
                    array('widgetOptions'=>
                        array('htmlOptions'=>
                            array('class'=>'span5','maxlength'=>10)                            
                        ))); 
        ?>
        <?php echo $form->textFieldGroup($model,'desc',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>
        <?php echo $form->textAreaGroup($model,'remarks', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>
         <label><input type="checkbox" id="checkbox" name="checkbox" onclick ="newimageselect()">Image</label>
        <div id='newimageload' hidden>
        <?php echo $form->fileField($model, 'imagepath'); ?>
        </div>
        <div id='oldimageload'>
          <?php $this->widget('booster.widgets.TbLabel', array(
                        'context'=>'primary',
            'label'=>$model->imagepath,
        )); ?>
        </div> 
        <?php if(empty($model->imagepath)):
        Yii::app()->clientScript->registerScript('refresh_page',"
   window.onload = function() {
  $('#newimageload').show();
  $('#oldimageload').hide();
};
");
endif; ?>
        
    </div>
    <div class="col-md-8">
        <?php
        $addpricebtn = $this->widget('booster.widgets.TbButton', array(
                                'buttonType'=>'button',
                                'context'=>'primary',
                                'label'=>'Add/Update Price',            
                                'htmlOptions' => array('onclick'=>'js:addDataForProductprice();','id'=>'productbtn','value'=>'Subproduct')
                        ), true); 
        $clearbtn = $this->widget('booster.widgets.TbButton', array(
                                'buttonType'=>'button',
                                'context'=>'primary',
                                'label'=>'Clear',
                                'htmlOptions' => array('onclick'=>'js:clearNewProductpriceentry();')
                        ), true);
         $this->beginWidget(
                'booster.widgets.TbPanel',
                array(
                'title' =>  'Enter Sub Product, Barcode ',
                'context' => 'default',
                //'headerIcon' => 'info',
                //'padContent' => false,
                'htmlOptions' => array()
                )
            );
        ?>

        <div id="productcodedetails"><div class="row">   
                        <div class="col-md-3">
                <?php echo $form->textFieldGroup($subproductprice,'unit_cp',
                        array('widgetOptions'=>array(
                            'htmlOptions'=>array(
                                'class'=>'span5','maxlength'=>10,
                                'onkeyup' => 'onchangeprdmargin_prdentry();','disabled'=>true,'value'=>$model->isNewRecord ? 0 : 0,
                                )
                            ))); 
                ?>
            </div>
            <div class="col-md-3">
                <?php echo $form->textFieldGroup($subproductprice,'unit_sp_per',
                        array('widgetOptions'=>array(
                            'htmlOptions'=>array(
                                'class'=>'span5', 'maxlength'=>10,
                                'onkeyup' => 'onchangeprdmargin_prdentry();'
                                )
                            ))
                        ); ?>
            </div>    
            <div class="col-md-3">
                <?php echo $form->textFieldGroup($subproductprice,'unit_sp',array('widgetOptions'=>array('htmlOptions'=>array('diabled'=>'disabled', 'class'=>'span5','maxlength'=>10)))); ?>
            </div>    
                 <div class="col-md-3">        
                    <?php echo $form->textFieldGroup($subproductprice,'rol',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>
                </div> 
            </div>
            <div class="row">            
                <div class="col-md-4">
                    <?php 
                    echo $form->hiddenField($subproductprice,'id');
                    if($model->enableprdcode){
                        $htmlOptions = array('class'=>'span5','maxlength'=>16);            
                        if($this->getEnableautoprdcode())
                        {
                            //$htmlOptions['disabled'] = 'disabled';
                        }
                        echo $form->textFieldGroup($subproductprice,'code',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>16,'onchange'=>'js:onchangecode();'))));
                    }
                    ?>
                </div>
                <div class="col-md-4">        
                    <?php echo $form->textFieldGroup($subproductprice,'sku',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>39,'onchange'=>'js:onchangesku();','style'=>'width:350px')))); ?>
                </div>            
            </div>

        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-6 right">
                <?php echo $addpricebtn ?> <?php echo $clearbtn; ?>
            </div>
        </div>
        <table id="subproductprices" width="100%"
               class="table table-bordered table-condensed table-hover">
        </table>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div class="form-actions right">
    <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'button',
            'context'=>'primary',
            'label'=>$model->isNewRecord ? 'Create' : 'Save',
                        'htmlOptions' => array('onclick'=>'js:submitMultipriceproduct();')
        )); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
function newimageselect(){
    var t = $("#checkbox").is(':checked');
    if(t){
        $('#newimageload').show();
        $('#oldimageload').hide();
    }else{
        $('#newimageload').hide();
        $('#oldimageload').show();
      $("#Product_imagepath").val('');
        
    }
}
    </script>