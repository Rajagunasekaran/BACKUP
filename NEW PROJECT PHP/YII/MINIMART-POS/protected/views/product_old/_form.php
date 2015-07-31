<?php 
$prdsurl = Yii::app()->controller->createUrl('product/'.Helper::CONST_getAllProducts);
$productpricesUrl = Yii::app()->controller->createUrl('product/'.Helper::CONST_getPricesForAProduct);
$multipriceproductsaveUrl = Yii::app()->controller->createUrl('product/'.Helper::CONST_multipriceproductsave);
$productCatesaveUrl = Yii::app()->controller->createUrl('product/'.Helper::CONST_getProductlist);
$subproductCatesaveUrl = Yii::app()->controller->createUrl('product/'.Helper::CONST_getSubProductlist);
Yii::app()->clientScript->registerScript('refresh_page',"
window.onload = function() {    
    getPricesForAProduct('$productpricesUrl');
        //loadSecCatProducts('$prdsurl',5);
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
 echo $form->hiddenField($productprice,'id');
 $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
        'title' =>  'Purchase',
        'context' => 'default',
        //'headerIcon' => 'info',
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>  
<div class="row">
        <div class="col-md-4">
                        <?php echo $form->textFieldGroup($productprice,'invno',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>30,'onchange'=>'js:onchangeinvoice()'))));?>

               <?php
echo $form->labelEx($productprice, 'invdate');?><br><?php 
            $this->widget( 'booster.widgets.TbDatePicker', array(
                'name' => 'invdate',
                    'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => $this->cJuiDatePickerViewFormat,
                ),
                'htmlOptions' => array(   
                    'placeholder' => 'Select Date', 
                ),
            ) );
            ?>

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
                                    'htmlOptions' => array('onchange' => 'onchangecategory();','id'=>'selectPrdCategory','value'=>$model->isNewRecord ? '' : $model->category_id) 
                                    ),
                            'groupOptions' => array(
                                            'allowClear' => true,
                                            'asDropDownList' => false,
                                        ),
                        )

                    ) ;
        ?>
                                                            <?php
                echo $form->select2Group(
                            $model
                            , 'id',array('widgetOptions'=>array('data' =>Yii::app()->controller->getAllProducts(),'htmlOptions' => array('onchange' => 'onchangeProduct();','id'=>'selectPrdname') )
                            ) );

?>
    
        <?php echo $form->textFieldGroup($model,'taxrate_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128,'disabled'=>true,'value'=>$model->isNewRecord ? '' : $model->taxrate_id)))); ?>

        <?php 
            echo $form->textFieldGroup($model,'discper',
                    array('widgetOptions'=>
                        array('htmlOptions'=>
                            array('class'=>'span5','maxlength'=>10,'disabled'=>true,'value'=>$model->isNewRecord ? '' : $model->discper)                            
                        ))); 
        ?>
        <?php echo $form->textFieldGroup($model,'desc',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128,'disabled'=>true,'value'=>$model->isNewRecord ? '' : $model->desc)))); ?>
        <?php echo $form->textAreaGroup($model,'remarks', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8','disabled'=>true,'value'=>$model->isNewRecord ? '' : $model->remarks)))); ?>
        <?php 
//        echo $form->labelEx($model, 'imagepath');
//        echo $form->fileField($model, 'imagepath');
        ?>
    </div>
    <div class="col-md-8">
        <?php
        $addpricebtn = $this->widget('booster.widgets.TbButton', array(
                                'buttonType'=>'button',
                                'context'=>'primary',
                                'label'=>'Add/Update Price',
                                'htmlOptions' => array('onclick'=>'js:addDataForProductprice();','id'=>'productbtn','value'=>'Product')
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
                'title' =>  'Prices',
                'context' => 'default',
                //'headerIcon' => 'info',
                //'padContent' => false,
                'htmlOptions' => array()
                )
            );
        ?>
        <div class="row">            
            <div class="col-md-3">
                <?php
                    $dflt_supplier_id = -1;
                    $companysplrs = Yii::app()->controller->getPeopleLookup(Helper::CONST_Supplier);					
                    if(!empty($companysplrs))
                    {
                        foreach($companysplrs as $splrid=>$splrdisplay)
                        {
                            $dflt_supplier_id = $splrid;
                            break;
                        }
                    }
                ?>
                <input type="hidden" id="dflt_supplier_id" value="<?php echo $dflt_supplier_id;?>"/>
                <input type="hidden" id="multipriceproductsaveUrl" value="<?php echo $multipriceproductsaveUrl;?>"/>    
                <input type="hidden" id="productCatesaveUrl" value="<?php echo $productCatesaveUrl;?>"/>  
				<input type="hidden" id="subproductCatesaveUrl" value="<?php echo $subproductCatesaveUrl;?>"/> 
                <?php
                echo $form->select2Group(
                            $productprice
                            , 'supplier_id'
                            , array('widgetOptions' 
                                        => array(
                                            'data' =>  $companysplrs,
                                            'htmlOptions' => array() 
                                            ),
                                    'groupOptions' => array(
                                                    'allowClear' => true,
                                                    'asDropDownList' => false,
                                                ),
                                )

                            ) ;
                ?>
            </div>
                        <div class="col-md-3">
                <?php echo $form->textFieldGroup($productprice,'unit_sp',array('widgetOptions'=>array('htmlOptions'=>array('diabled'=>'disabled', 'class'=>'span5','maxlength'=>10,'disabled'=>true)))); ?>
            </div>  
            <div class="col-md-3">
                <?php echo $form->textFieldGroup($productprice,'unit_cp',
                        array('widgetOptions'=>array(
                            'htmlOptions'=>array(
                                'class'=>'span5','maxlength'=>10                             
                               
                                )
                            ))); 
                ?>
            </div>
   
        </div>

        <div id="productcodedetails">
            <div class="row">            
                <div class="col-md-4">
                 <?php                                                  
                echo $form->select2Group(
                            $productprice
                            , 'code',array('widgetOptions'=>array('data'=>array(),'htmlOptions' => array('id'=>'Productpricecode')  )
                            ) );
                ?>
                </div>
                <div class="col-md-4">        
                    <?php echo $form->textFieldGroup($productprice,'sku',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10,'disabled'=>true)))); ?>
                </div>  
        
                <div class="col-md-4">
                    <?php echo $form->textFieldGroup($productprice,'qnty',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10,'disabled'=>true,'value'=>''))));
?>
            </div>
        </div>
                        <div class="row">            
                <div class="col-md-4">
                                        <?php echo $form->textFieldGroup($productprice,'stock',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10,'value'=>''))));?>

                </div>
                <div class="col-md-4">        
<?php
echo $form->labelEx($productprice, 'expdate'); 
            $this->widget( 'booster.widgets.TbDatePicker', array(
                'name' => 'expdate',
                    'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => $this->cJuiDatePickerViewFormat,
                ),
                'htmlOptions' => array(   
                    'placeholder' => 'Select Date',
                ),
            ) );
            ?>
                </div>          

        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-6 right">
                <?php echo $addpricebtn ?> <?php echo $clearbtn; ?>
            </div>
        </div>
        <table id="productprices" width="100%"
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
