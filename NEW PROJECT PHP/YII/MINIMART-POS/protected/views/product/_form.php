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
)); ?>
<?php
echo $form->errorSummary($model);
?>
<?php
echo $form->hiddenField($model,'id');
//echo $productprice->id;
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
    <input type="hidden" id="Productprice_id_inv" value="<?php echo $model->isNewRecord ? $productprice->id : $productprice->id?>">
<div class="row">
    <div class="col-md-4">
        <?php echo $form->textFieldGroup($productprice,'invno',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5 price_form','maxlength'=>30,'onchange'=>'js:onchangeinvoice()'))));?>
        <div style="margin-bottom: 14px;"> <?php
            echo $form->labelEx($productprice, 'invdate');?><br><?php
            $this->widget( 'booster.widgets.TbDatePicker', array(
                'name' => 'invdate',
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => $this->cJuiDatePickerViewFormat,
                ),
                'htmlOptions' => array('style'=>'width:350px',
                    'placeholder' => 'Select Invoice Date',
                    'class'=>'price_form',
                ),
            ) );
            $test=Yii::app()->controller->getCategoriesLookup();
            ?></div>
        <div style="margin-bottom: 14px;"> <label>Category<span style="color:red"> *</span></label>
            <select id="selectPrdCategory" name="Product[category_id]" class="form-control price_form" style="font-size: 108%;" tabindex="-1"  onchange="onchangecategory()">
                <?php
                echo "<option value=0>Select</option>";
                foreach($test as $x=>$x_value) {
                    if($x==$model->category_id)
                        echo "<option selected value=".$x.">" . $x_value ."</option>";
                    else
                        echo "<option value=".$x.">" . $x_value ."</option>";   }

                ?>
            </select>
        </div>
        <div style="margin-bottom: 14px;">
            <label>Product<span style="color:red"> *</span></label>
            <select id="selectPrdname" name="Product[id]" class="form-control price_form" style="font-size: 108%;" tabindex="-1"  onchange="onchangeProduct()">
            </select>
        </div>
        <?php
        echo $form->textFieldGroup($model,'taxrate_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128,'disabled'=>true,'value'=>$model->isNewRecord ? '' : $taxrate)))); ?>

        <?php
        echo $form->textFieldGroup($model,'discper',
            array('widgetOptions'=>
                array('htmlOptions'=>
                    array('class'=>'span5','maxlength'=>10,'disabled'=>true,'value'=>$model->isNewRecord ? '' : $model->discper)
                )));
        ?>
        <?php echo $form->textFieldGroup($model,'desc',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>128,'disabled'=>true,'value'=>$model->isNewRecord ? '' : $model->desc)))); ?>
        <?php echo $form->textAreaGroup($model,'remarks', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8','disabled'=>true,'value'=>$model->isNewRecord ? '' : $model->remarks)))); ?>
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
                ?>  <label>Supplier<span style="color:red"> *</span></label>
                <select id="Productprice_supplier_id" name="Productprice[supplier_id]" class="form-control" style="font-size: 108%;" tabindex="-1" >
                    <?php
                    echo "<option value=0>Select</option>";
                    foreach($companysplrs as $c=>$c_value) {
                        if($c==$productprice->supplier_id)
                            echo "<option selected value=".$c.">" . $c_value ."</option>";
                        else
                            echo "<option value=".$c.">" . $c_value ."</option>";   }

                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label>Code<span style="color:red"> *</span></label>
                <select id="Productpricecode" name="Productprice[code]" class="form-control" style="font-size: 108%;" tabindex="-1" placeholder="Select">
                    <?php echo "<option value=0>Select</option>";?></select>
            </div>
            <div class="col-md-3">
                <?php echo $form->textFieldGroup($productprice,'sku',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10,'disabled'=>true)))); ?>
            </div>
            <div class="col-md-3">
                <?php echo $form->textFieldGroup($productprice,'unit_cp',
                    array('widgetOptions'=>array(
                        'htmlOptions'=>array(
                            'class'=>'span5 numberonly','maxlength'=>10

                        )
                    )));
                ?>
            </div>
            <div class="col-md-3">
                <?php echo $form->textFieldGroup($productprice,'unit_sp',array('widgetOptions'=>array('htmlOptions'=>array('diabled'=>'disabled', 'class'=>'span5','maxlength'=>10,'disabled'=>true)))); ?>
            </div>

            <div class="col-md-3">
                <label>Last Purchase Price</label>
                <input type="text" id="Productprice_latestprice" class="form-control" placeholder="Purchase Price" disabled>
            </div>
            <div class="col-md-3">
                <label>Last Invoice Date</label>
                <input type="text" id="Productprice_latestinvdate" class="form-control" placeholder="Invoice Date" disabled>
            </div>
            <div class="col-md-3">
                <label>Last Invoice Number</label>
                <input type="text" id="Productprice_latestinvno" class="form-control" placeholder="Invoice Number" disabled>
            </div>
        </div>
        <div class="row">

            <!--        </div>

                    <div id="productcodedetails">
                        <div class="row">            -->


            <div class="col-md-3">
                <label>Stock In Hand</label>
                <input class="span5 form-control" maxlength="10" disabled="disabled" value="" placeholder="Stock In Hand" name="Productprice[stockinhand]" id="Productprice_stockinhand" type="text">
            </div>
            <!--            </div>
                        <div class="row">            -->
            <div class="col-md-3">
                <?php echo $form->textFieldGroup($productprice,'stock',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5 numberonly','maxlength'=>10,'value'=>''))));?>

            </div>
            <div class="col-md-3">
                <label>Expiry Date</label>
                <?php
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
        <div id="loader" style="color:red" hidden>Wait Process going on...</div>
        <table id="productprices" width="100%"
               class="table table-bordered table-condensed table-hover">
        </table>
        <?php $this->endWidget(); ?>
        <!--</div>-->
    </div>
    <div class="form-actions right" >
        <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'button',
            'context'=>'primary',
            'label'=>$model->isNewRecord ? 'Create' : 'Save',
            'htmlOptions' => array('onclick'=>'js:submitMultipriceproduct();','id'=>'price_form_btn')
        )); ?>
    </div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>