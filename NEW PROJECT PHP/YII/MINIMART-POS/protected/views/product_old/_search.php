<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="row">
    <div class="col-md-4">
        <?php echo $form->labelEx( $model, 'category_id' ); ?>
        <?php 
        $htmlOptions = array(
            'placeholder' => 'Category',            
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'category_id',
            'model' => $model,
            'data' => $this->getCategoriesLookup(),
            'options' => array(
                'allowClear' => true,
            ),
            'htmlOptions' => $htmlOptions,
        ) );
        ?>
    </div>
    <div class="col-md-4">
        <?php echo $form->labelEx( $model, 'supplier_id' ); ?>
        <?php 
        $htmlOptions = array(
            'placeholder' => Helper::CONST_Supplier,            
            );
        $this->widget( 'booster.widgets.TbSelect2', array(
            'attribute' => 'supplier_id',
            'model' => $model,
            'data' => $this->getPeopleLookup(Helper::CONST_Supplier),
            'options' => array(
                'allowClear' => true,
            ),
            'htmlOptions' => $htmlOptions,
        ) );
        ?>
    </div>
</div>
<div class="form-actions">
        <?php $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'submit',
                'context'=>'primary',
                'label'=>'Search',
        )); ?>
</div>

<?php $this->endWidget(); ?>
