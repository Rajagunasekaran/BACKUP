<?php /* @var $this Controller */ ?>
       
        <?php //if(!empty($_GET['actionid']) && $_GET['actionid'] == Helper::CONST_PDF): ?>
            <?php        
                $this->beginWidget(
                    'booster.widgets.TbPanel',
                    array(
                    'title' => "Reports",
                    'context' => 'info',
                    //'headerIcon' => 'road',
                    //'padContent' => false,
                    'htmlOptions' => array()
                    )
                );
            ?>
                <?php 
//                    $this->widget('booster.widgets.TbButton', array(
//                                    'buttonType'=>'button',
//                                    'context'=>'primary',
//                                    'label'=>'Register Collections',
//                                    'htmlOptions'=>array(
//                                        'class'=>'btn btn-large',
//                                        'onclick' => "js:document.location.href='" . $this->createUrl('reports/registerwisecollections') . "'"
//                                        ),
//                            ));
                ?>
                <!-- Split button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-info">Sales</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href='<?php echo $this->createUrl('reports/'.Helper::CONST_dailysales) ?>'>Daily Sales</a></li>
                        <li><a href='<?php echo $this->createUrl('reports/'. Helper::CONST_periodWiseSales) ?>'>Periodwise Sales</a></li>
                        <li><a href='<?php echo $this->createUrl('reports/'. Helper::CONST_dailyItemSales) ?>'>Daily Item Sales</a></li>
                        <li><a href='<?php echo $this->createUrl('order/admin') ?>'>Billing Details</a></li>
                    </ul>
                  </div>
                <!-- Split button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-success">Stock</button>
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href='<?php echo $this->createUrl('reports/'.Helper::CONST_stockInventory) ?>'>Stock Inventory Report</a></li>
                         <li><a href='<?php echo $this->createUrl('/stockadjustment/'.Helper::CONST_stockadjustment) ?>'>Stock Adjustment Report</a></li>
                    </ul>
                </div>
                <!-- Split button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Register Balance</button>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href='<?php echo $this->createUrl('reports/'.Helper::CONST_registerBalance) ?>'>Register Balance Report</a></li>
                    </ul>
                </div>
                <!-- Split button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-warning">Refund/Cancel</button>
                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href='<?php echo $this->createUrl('reports/'.Helper::CONST_exchange) ?>'>Exchange Report</a></li>
                        <li><a href='<?php echo $this->createUrl('reports/'. Helper::CONST_refund) ?>'>Refund Report</a></li>
                        <li><a href='<?php echo $this->createUrl('reports/'. Helper::CONST_cancel) ?>'>Cancel Report</a></li>
                    </ul>
                </div>
            <?php
                $this->endWidget(); 
            ?>
        <?php //endif; ?>
                
                 
<script type="text/javascript">
    window.onload = function() {
        
    };
</script>