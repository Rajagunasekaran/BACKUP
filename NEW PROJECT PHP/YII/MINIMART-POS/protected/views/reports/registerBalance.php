    <h3 style="color:#0000FF">Register Balance Report</h3>
    <?php if(empty($_GET['actionid'])): ?>
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
    )); 
    ?>
    <div class="row">
        <div class="col-md-3">
            <?php echo $form->labelEx( $model, 'register' ); ?>
            <?php 
            $htmlOptions = array('class'=>'form-control',
                'placeholder' => 'Select Register',            
                );
            $this->widget( 'booster.widgets.TbSelect2', array(
                'attribute' => 'id',
                'model' => $model,
                'data' => $this->getPeopleLookup(Helper::CONST_Sales),
                'options' => array(
                    'allowClear' => true,
                ),
                'htmlOptions' => $htmlOptions,
            ) );
            ?>
        </div>
        <div class="col-md-3">
            <?php echo $form->labelEx( $model, 'date' ); ?>
            <?php
            $this->widget( 'booster.widgets.TbDatePicker', array(
                'attribute' => 'selected_date',
                'model' => $model,
                'value' => $model->selected_date,
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
    </div><br>
    <div class="form-actions">
            <?php $this->widget('booster.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'context'=>'primary',
                    'label'=>'Show',
            )); ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php endif; ?>
    <?php if(!empty($registerBalance)): 
    Yii::app()->clientScript->registerScript('refresh_page',"
       window.onload = function() {
       var date=$('#Person_selected_date').val();
       if(date!='')
       {
       var message='Register Balance Report On '+date
       $('#head').text(message).show();
       }
       else
       {
       $('#head').text('').show();
       }
    };
    ");
    ?>
    <h3 id="head" style="color:#0000FF">

    </h3>  
    <h4>
    SALVA'S MART @ ESPLANADE8,
    RAFFLES AVENUE, 
    #01-08A, 
     </h4>
    <?php if($method == 'first'): ?>
    <table>
        <tr>
            <td>Sales</td>
            <td class="right"><?php echo $registerBalance->salesinclrfndcncl; ?></td>
        </tr>
        <tr>
            <td>Cancels</td>
            <td class="right"><?php echo $registerBalance->totalcancels; ?></td>
        </tr>
        <tr>
            <td>Refunds</td>
            <td class="right"><?php echo $registerBalance->totalrefunds; ?></td>
        </tr>
        <tr>
            <td>Gross</td>
            <td class="right"><?php echo $registerBalance->salesexclrfndcncl; ?></td>
        </tr>
        <tr>
            <td>Discounts</td>
            <td class="right"><?php echo $registerBalance->totaldisc; ?></td>
        </tr>
        <tr>
            <td>After Discounts</td>
            <td class="right"><?php echo $registerBalance->salesafterdisc; ?></td>
        </tr>
        <tr>
            <td>Roundoffs</td>
            <td class="right"><?php echo $registerBalance->netroundoff; ?></td>
        </tr>
        <tr>
            <td>After Roundoffs</td>
            <td class="right"><?php echo $registerBalance->salesafterroundoff; ?></td>
        </tr>
        <tr>
            <td>Tax</td>
            <td class="right"><?php echo $registerBalance->totaltax; ?></td>
        </tr>
        <tr>
            <td>Sales Incl. Tax</td>
            <td class="right"><?php echo $registerBalance->saleswithtax; ?></td>
        </tr>
    </table>
    <?php endif; ?>
    <table>
        <tr> 
            <td><?php echo 'Open Balance :'; ?></td>
            <td class="right"><?php echo $registerBalance->op_balance; ?></td>
        </tr>
        <?php foreach($registerBalance->cashsummary as $key => $values)
        { ?>
            <tr> 
                <td><?php echo $values[0] ?></td>
                <td class="right"><?php echo $values[1] ?></td>
            </tr>
        <?php
        }
        ?>
        <tr> 
            <td><?php echo 'Expected Cash In Hand :'; ?></td>
            <td class="right"><?php echo $registerBalance->expectedCB; ?></td>
        </tr>
        <tr> 
            <td><?php echo 'Actual Cash In Hand :'; ?></td>
            <td class="right"><?php echo $registerBalance->cl_balance; ?></td>
        </tr>
    </table>
    <?php endif; ?>