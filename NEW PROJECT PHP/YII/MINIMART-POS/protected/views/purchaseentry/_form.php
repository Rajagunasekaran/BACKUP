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
       <div style="margin-bottom: 14px;">
            <label>Category<span style="color:red"> *</span></label>  
              <select id="selectPrdCategoryid" name="Product[category_id]" class="form-control prod_form" style="font-size: 108%;">
             <?php 
             $testid=Yii::app()->controller->getCategoriesLookup();
             echo "<option value=0>Select</option>";
                foreach($testid as $x=>$x_value) {
                    if($x==$model->category_id)
                         echo "<option selected value=".$x.">" . $x_value ."</option>"; 
                    else
                echo "<option value=".$x.">" . $x_value ."</option>";   }             
                 
                 ?>
              </select>
        </div>
            <input type="hidden" id="multipriceproductsaveUrl" value="<?php echo $multipriceproductsaveUrl;?>"/>    
        <?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('placeholder' => 'Name','class'=>'span5 prod_form','maxlength'=>30,'onchange'=>'js:onchangeproductname();')))); ?>        
        
        <div style="margin-bottom: 14px;">
            <label>Sales Tax %<span style="color:red"> *</span></label>  
              <select id="Product_taxrate_id" name="Product[taxrate_id]"class="form-control prod_form" style="font-size: 108%;" >
             <?php 
             $taxid=Yii::app()->user->taxrates;
             echo "<option value=0>Select</option>";
                foreach($taxid as $y=>$y_value) {
                    if($y==$model->taxrate_id)
                         echo "<option selected value=".$y.">" . $y_value ."</option>"; 
                    else
                echo "<option value=".$y.">" . $y_value ."</option>";   }             
                 
                 ?>
              </select>
         </div>
        <?php 
            echo $form->textFieldGroup($model,'discper',
                    array('widgetOptions'=>
                        array('htmlOptions'=>
                            array('class'=>'span5','maxlength'=>10)                            
                        ))); 
        ?>
        <?php echo $form->textFieldGroup($model,'desc',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128)))); ?>
        <?php echo $form->textAreaGroup($model,'remarks', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>
        <?php 
        echo $form->labelEx($model, 'imagepath');
        echo $form->fileField($model, 'imagepath');
        ?>
                        <?php if($model->isNewRecord!='1'){
                            //    echo $model->imagepath;
                           if($model->imagepath!=""||$model->imagepath!=null)
                           {
    echo CHtml::image(Yii::app()->request->baseUrl.'/protected/assets/images/'.$model->imagepath,"image",array('style' => 'max-width:150px; min-width:100px; max-height:150px; min-height:100px;',));
                           }                           
                           }?>                      
    <input type="hidden" id="img" name="img"/>
    </div>
    <div class="col-md-8">
        <?php
        $addpricebtn = $this->widget('booster.widgets.TbButton', array(
                                'buttonType'=>'button',
                                'context'=>'primary',
                                'label'=>'Add/Update Price',            
                                'htmlOptions' => array('onclick'=>'js:addCreateSubproductprice();','id'=>'productbtn','value'=>'Subproduct')
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
                <?php echo $form->textFieldGroup($subproductprice,'unit_sp',array('widgetOptions'=>array('htmlOptions'=>array('diabled'=>'disabled', 'class'=>'span5 numberonly','maxlength'=>10)))); ?>
            </div>   
                <div class="col-md-3">        
                    <?php echo $form->textFieldGroup($subproductprice,'rol',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5 numberonly','maxlength'=>10)))); ?>
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
                    <?php echo $form->textFieldGroup($subproductprice,'sku',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>39,'onchange'=>'js:onchangesku();',)))); ?>
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
                        'htmlOptions' => array('onclick'=>'js:submitMultipriceproduct();','id'=>'prod_update_btn',)
		)); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>