<?php
$prdsurl = Yii::app()->controller->createUrl('order/'.Helper::CONST_getAllProducts);
$subprodLatestprice = Yii::app()->controller->createUrl('order/'.Helper::CONST_getSubproductLatestprice);
$updateRegisterbalanceUrl = Yii::app()->controller->createUrl('order/'.Helper::CONST_updateRegisterbalanceUrl);
$posSaveBillUrl = Yii::app()->controller->createUrl('order/'.Helper::CONST_posSaveBill);
$orderProductsForABillUrl = Yii::app()->controller->createUrl('order/'.Helper::CONST_getOrderProductsForABill);
$askopbalance = $this->checkIfAskBalance(1);
$askclbalance = $this->checkIfAskBalance(2);
$rgstrBlRprtPDFUrl = Yii::app()->createUrl('reports/'. Helper::CONST_registerBalanceII, array('actionid'=> Helper::CONST_PDF));
$islazyload = Helper::CONST_lazy_page_load;
Yii::app()->clientScript->registerScript('refresh_page',"
if($islazyload)
{
    timedRefresh($this->page_load_delay_ms, 1);//1- firsttime 2 - every refresh
}
else
{
    window.onload = function() {
        loadSecCatProducts('$prdsurl', 1);
    };
}
window.onload = function() {
    promptOPBalance($askopbalance, $askclbalance, '$updateRegisterbalanceUrl');
    //document.onkeypress = KeyPressHappened;
    registerNumberPadEvents();
    setupPOSScreen(1);
};
function timedRefresh(timeoutPeriod, throautorefresh) {
	setTimeout(function(){refreshPage(throautorefresh)}, timeoutPeriod);
}
function refreshPage(throautorefresh) {
        syncProductMasters('$prdsurl',throautorefresh);
        var refresh = $this->pos_auto_refresh;
        if(refresh)
        {
            timedRefresh($this->pos_prdsupdate_freq, 2);
        }
}
");
?>
<div id="posclient-content">
<div class="row row-without-margin">
<div class="col-md-7 col-sm-8 col-xs-12  col-onlyleft-padding">
    <div class="row row-without-margin">
        <div class="col-md-6 col-without-padding">
            <?php
            $this->beginWidget(
                'booster.widgets.TbPanel', array(
                    'title' => 'Categories',
                    'context' => 'success',
                    'headerIcon' => 'info',
                    'padContent' => false,
                    'htmlOptions' => array(
                        'id'=>'nontopcatpanel',
                        'style'=>"height:284px;min-height:284px;overflow-y:auto;",
                        'class'=>'panel-without-margin'
                    )
                )
            );
            ?>
            <div id="nontopcatDiv">
                loading...
            </div>
            <?php $this->endWidget(); ?>
        </div>
        <div class="col-md-6 col-without-padding">
            <?php
            $this->beginWidget(
                'booster.widgets.TbPanel', array(
                    'title' => '<span id="productspaneltitle"></span>&nbsp;Products&nbsp;&nbsp;<span id="prdmstrupdatemsg"></span>',
                    'context' => 'info',
                    'headerIcon' => 'info',
                    'padContent' => false,
                    'htmlOptions' => array(
                        'id'=>'productspanel',
                        'style'=>"height:284px;min-height:284px;overflow-y:auto;",
                        'class'=>'panel-without-margin'
                    )
                )
            );
            ?>
            <div id="productsDiv">
                loading...
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <div class="row row-without-margin">
        <div class="col-md-6 col-without-padding">
            <?php
            $this->beginWidget(
                'booster.widgets.TbPanel', array(
                    'title' => 'Divisions',
                    'context' => 'danger',
                    'headerIcon' => 'info',
                    'padContent' => false,
                    'htmlOptions' => array(
                        'id'=>'topcatpanel',
                        'style'=>"height:298px;min-height:298px;overflow-y:auto;",
                        'class'=>'panel-without-margin'
                    )
                )
            );
            ?>
            <div id="topcatDiv">
                loading...
            </div>
            <?php $this->endWidget(); ?>
        </div>
        <div class="col-md-6 col-without-padding">
            <div class="row row-without-margin">
                <div class="col-md-12 col-without-padding numberpad">
                    <div class="row row-without-margin">
                        <table class="table table-condensed" style="margin-top:-2px;">
                            <tr>
                                <td>
                                    <input type="text" class="form-control" readonly="readonly" id="numPadInput" style="height:38px;font-size:16px;margin-bottom:0px"/>
                                </td>
                                <td>
                                    <div align="right"><button type="button" class="btn btn-block btn-exchange done" onclick="closeNumberPadModal();" style="margin-bottom: 0px; height: 38px;">OK</button></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="n_keypad" style="-khtml-user-select: none;height: 250px">
                        <div class="row row-without-margin">
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-close del">Del</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-refund clear">C</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-hold percent">%</button></div>
                            <div class="col-xs-3 col-without-padding"><button type="button" class="btn btn-sm btn-block btn-held numeric_overwrite">10</button></div>
                        </div>
                        <div class="row row-without-margin">
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-info numero">7</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-info numero">8</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-info numero">9</button></div>
                            <div class="col-xs-3 col-without-padding"><button type="button" class="btn btn-sm btn-block btn-held numeric_overwrite">20</button></div>
                        </div>
                        <div class="row row-without-margin">
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-info numero">4</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-info numero">5</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-info numero">6</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-held numeric_overwrite">30</button></div>
                        </div>
                        <div class="row row-without-margin">
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-info numero">1</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-info numero">2</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-info numero">3</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-held numeric_overwrite">50</button></div>
                        </div>
                        <div class="row row-without-margin">
                            <div class="col-xs-3 col-without-padding"><button type="button" class="btn btn-sm btn-block btn-info zero">00</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-info zero">0</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-hold decimalpoint">.</button></div>
                            <div class="col-xs-3"><button type="button" class="btn btn-sm btn-block btn-held numeric_overwrite">100</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-5 col-sm-4 col-xs-12 col-onlyright-padding">
    <?php
    $this->beginWidget(
        'booster.widgets.TbPanel', array(
            'title' => false,
            'context' => 'success',
            'headerIcon' => 'info',
            'padContent' => false,
            'htmlOptions' => array(
                'id'=>'tablpanel',
                'style'=>"height:284px;min-height:284px;",
                'class'=>'panel-without-margin'
            )
        )
    );
    ?>
    <div>
        <table class="table table-condensed">
            <tr>
                <td>
                    <input type="text" style="margin-bottom: 2px;margin-top: 2px" id="prd_skus" class="form-control" name="prd_skus" placeholder="Product Code"/>
                </td>
                <td>
                    <input type="text" style="margin-bottom: 2px;margin-top: 2px" id="prd_skus_over" class="form-control" placeholder="Bar Code" />
                </td>
            </tr>
        </table>
    </div>
    <table id="orderproducts"  width="100%" class="table table-bordered table-condensed table-hover">
    </table>
    <?php $this->endWidget(); ?>
    <div class="row row-without-margin" style="background:#fff;
             height:299px;min-height:294px;">
        <div id="paymentType" class="col-md-5 col-without-padding">
            <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
                'id'=>'paymenttype-form',
                'enableAjaxValidation'=>false,
            )); ?>
            <div class="form-group">
                <label>Customer</label>
                <?php
                $this->widget(
                    'booster.widgets.TbSelect2',
                    array('name' => 'customer_id',
                        'value' => Yii::app()->controller->getPersonByName(Helper::CONST_Walk_in_Customer),
                        'data' => Yii::app()->controller->getAllPeopleNoRestriction(Helper::CONST_Customer),
                        'htmlOptions' => array('id' => 'customer_id',
                            'onchange' => 'oncustomerChange_Payment();',
                            'style' => 'width:50%;margin-bottom:18px'
                        ),
                    )
                );
                ?>
            </div>
            <?php
            $htmlOptions = array(
                'placeholder' => 'Payment Type',
                'separator' => '',
                'name' => 'payment_mode',
                'id' => 'payment_mode',
                'class'=>'radioPayment',
                'style'=>'margin-bottom:15px'
            );
            echo $form->radioButtonListGroup(
                $model,
                'addnlinfo5',
                array(
                    'inline' => false,
                    'widgetOptions'
                    => array(
                        'data' => Yii::app()->controller->getPaymenttypesList(),
                        'htmlOptions' => $htmlOptions,
                    ),
                )

            );
            ?>
            <span style="display:block">
                        <?php echo Helper::CONST_OnAccount ?>
                <input type="checkbox" id="payment_modecheck" style="margin-bottom:12px"
                       name="payment_modecheck" onclick="onONAccountClick();"/>
                    </span>

            <div class="form-group">
                <label>Details</label>
                <input type="text" class="form-control" id="paymentdetails"
                       placeholder="Card Number etc.,"/>
            </div>

            <?php $this->endWidget(); ?>
        </div>
        <div id="summary" class="col-md-7 col-without-padding">
            <table class="table table-bordered table-condensed">
                <tr>
                    <th class="right" style="width:50%">
                        Total
                    </th>
                    <td class="right" style="width:50%" id="billtotalamount">

                    </td>
                </tr>
                <tr>
                    <th class="right">
                        <span class="glyphicon glyphicon-pencil"></span>
                        <a href="#" id="billdiscounthref" onclick="editBillDiscountBtnClick();">Discount</a>
                    </th>
                    <td class="right" id="billdiscount">

                    </td>
                </tr>
                <tr>
                    <th class="right">
                        Sub-Total
                    </th>
                    <td class="right" id="billsubtotal">

                    </td>
                </tr>
                <tr>
                    <th class="right">
                        Tax
                    </th>
                    <td class="right" id="billtax">

                    </td>
                </tr>
                <tr>
                    <th class="right">
                        <input type="hidden" value="" id="roundoff"/>
                        Round-Off<input type="checkbox" id="roundoffcheck" onclick="applyRoundOff();"/>
                        To Pay:
                    </th>
                    <td class="right" id="billnetamount">

                    </td>
                </tr>
                <tr id="tenderrow">

                    <th class="right">
                        Tendered
                    </th>
                    <td class="right" id="billnetamount">
                        <input type="Amount" class="form-control right"
                               readonly="readonly"
                               id="tenderedamount"
                               onclick="openNumberPadModal(7);" />
                    </td>
                </tr>
                <tr id="balancerow">
                    <th class="right">
                        Balance
                    </th>
                    <td class="right" id="billnetamount">
                        <input type="Amount" class="form-control right"
                               id="balancereturned"
                               readonly="readonly"
                               placeholder=""/>
                    </td>
                </tr>
            </table>
            <div align="left">
                <button type="button" style="width:158px; margin-top: 3px" class="btn btn-primary btn-block" id="normalsubmit" onClick="posSaveBillNormal('<?php echo $posSaveBillUrl; ?>');">PRINT</button>
                <button type="button"
                        class="btn btn-primary btn-block"
                        id="exchangesubmit"
                        style="display:none;width:158px; margin-top: 3px"
                        onClick="posSaveBillExchange('<?php echo $posSaveBillUrl; ?>');">PRINT</button>
            </div>
        </div>
    </div>
</div>
</div>


</div>
<input type="hidden" id="latestPriceSubprd" value="<?php echo $subprodLatestprice; ?>"/>
<input type='hidden' id="openblconst" value="<?php echo Helper::CONST_OpenBalance; ?>"/>
<input type='hidden' id="closeblconst" value="<?php echo Helper::CONST_CloseBalance; ?>"/>
<input type="hidden" id="heldbillref" />
<input type="hidden" id="prdsckieid" value="<?php echo Helper::CONST_sec_cat_products ;?>"/>
<input type="hidden" id="ordprdsckieid" value="<?php echo Helper::CONST_orderProducts ;?>"/>
<input type="hidden" id="imagepath" value="<?php echo $this->imagePath; ?>"/>
<input type="hidden" id="dfltcustomerid" value="<?php echo Yii::app()->controller->getPersonByName(Helper::CONST_Walk_in_Customer);?>"/>
<input type="hidden" id="cashconst" value="<?php echo Helper::CONST_Cash; ?>"/>
<!-- Modal -->
<div class="modal fade" id="heldBillsModal" tabindex="-1" role="dialog"
     aria-labelledby="heldBills" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="heldBillsModalTitle">Bills in HOLD.</h4>
            </div>
            <div class="modal-body">
                <table id="heldBillsDataTable" width="100%">
                    <thead>
                    <tr>
                        <th width="10%" style="text-align: center"></th>
                        <th width="10%" style="text-align: center"></th>
                        <th width="40%" style="text-align: center">Bill. Ref.</th>
                        <th width="50%" style="text-align: center">Amount</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="getBillModal" tabindex="-1" role="dialog"
     aria-labelledby="getBill" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="getBillModalTitle">Bill Number</h4>
            </div>
            <div class="modal-body">
                <label>Enter Bill Number.</label>
                <?php
                $input = array_slice($orderid,0);
                //autocomplete
                $form->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute'=>'qoi_id',
                    'name'=>'order_qoi_id',
                    'source'=>$input,
                    'htmlOptions'=>array(
                        'id'=>'qoi_id',
                        'size'=>'25',
                        'placeholder' => 'Bill No.',
                    ),
                ));
                echo '    ';
                $this->widget('booster.widgets.TbButton',array(
                    'buttonType'=>'button',
                    'context'=>'primary',
                    'label'=>'OK',
                    'htmlOptions'=>array('onclick'=>'getOrderProductsForABill(event,"/pos/order/getOrderProductsForABill");')
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="rgstrBlRprtModal" tabindex="-1" role="dialog"
     aria-labelledby="rgstrBlRprt" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="rgstrBlRprtModalTitle">Register Balance Report</h4>
            </div>
            <form action="<?php echo $rgstrBlRprtPDFUrl;?>" method="post">
                <button type="submit" class="btn btn-primary" onclick="confirmAskclbalance();">Print</button>
            </form>
            <div class="modal-body" id="rgstrBlRprtModalBody">

            </div>
        </div>
    </div>
</div>
