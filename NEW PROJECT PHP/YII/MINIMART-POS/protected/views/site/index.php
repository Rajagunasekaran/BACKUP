<?php 
$customerduegridid = 'customerduegridid';
$rolgridid = 'rolgridid';
$topproductgridid = 'topproductgridid';
Yii::app()->clientScript->registerScript('refresh_page',"
timedRefresh($this->page_load_delay_ms);

function timedRefresh(timeoutPeriod) {
	setTimeout(function(){refreshGrid()}, timeoutPeriod);
}

function refreshGrid() {
        $('#$customerduegridid').yiiGridView.update(\"$customerduegridid\");
        $('#$rolgridid').yiiGridView.update(\"$rolgridid\");
        $('#$topproductgridid').yiiGridView.update(\"$topproductgridid\");
        var refresh = $this->db_auto_refresh;
        if(refresh)
        {
            timedRefresh($this->db_auto_refresh_freq);
        }
}
");
?>
<div class="row">
    <div class="col-md-4">
        <?php
        $this->beginWidget(
            'booster.widgets.TbPanel',
            array(
            'title' => 'Customer Dues',
            'context' => 'primary',
            //'headerIcon' => 'road',
            'padContent' => false,
            'htmlOptions' => array()
            )
        );                
        ?>
        <?php 
            $partyHeader = Helper::CONST_Customer;
            $flds = array(
               'product_id'=> array('name' => 'Customer Name'
                               ,'value' => '$data->name'),
               'stock' => array('name' => 'Purchase Amount','value' =>'$data->purchaseamount'),
               'rol' => array('name' => 'Paid Amount','value' =>'$data->paidamount'),
               'moq' => array('name' => 'Balance Due','value' =>'$data->paidamount'),
                           );
            $btncols = array( );
            $columns = array_merge($btncols, $flds);
            $options = array(
                        'id'=>$customerduegridid,
                        'dataProvider'=> $customerduemodel->customerDueDetails(),
                        'columns'=> $columns,
                        );
            $this->setDefaultGVOptions($options);
            $customerduegrid = $this->widget('booster.widgets.TbGridView', $options, true);
            echo $customerduegrid;
        ?>
        <?php $this->endWidget(); ?>
    </div>
    <div class="col-md-4">
        <?php
        $this->beginWidget(
            'booster.widgets.TbPanel',
            array(
            'title' => 'ROL-Products',
            'context' => 'primary',
            //'headerIcon' => 'road',
            'padContent' => false,
            'htmlOptions' => array()
            )
        );
        ?>
        <?php 
            $flds = array(
                'product_id'=> array('name' => 'Product Name'
                                ,'value' => '$data->name'),
                'stock' => array('name' => 'Stock in Hand','value' =>'$data->stock'),
                'rol' => array('name' => 'Re-order level','value' =>'$data->rol'),
                //'moq' => array('name' => 'moq'),
                            );
            $btncols = array( );
            $columns = array_merge($btncols, $flds);
            $options = array(
                        'id'=>$rolgridid,
                        'dataProvider'=> $productpricemodel->listROLProducts(),
                        'columns'=> $columns,
                        );
            $this->setDefaultGVOptions($options);
            $rolgrid = $this->widget('booster.widgets.TbGridView', $options, true);
            echo $rolgrid;
        ?>
        <?php $this->endWidget(); ?>
    </div>   
    <div class="col-md-4">
        <?php
        $this->beginWidget(
            'booster.widgets.TbPanel',
            array(
            'title' => 'Top Products[Sales on Last '. Helper::CONST_TopProducts_days .' Days]',
            'context' => 'primary',
            //'headerIcon' => 'road',
            'padContent' => false,
            'htmlOptions' => array()
            )
        );                
        ?>
        <?php 
            $flds = array(
                'product_id'=> array('name' => 'Product Name'
                                ,'value' => '$data->product->name'),
                'totalAmount' => array('name' => 'totalAmount'),
                            );
            $btncols = array( );
            $columns = array_merge($btncols, $flds);
            $options = array(
                        'id'=>$topproductgridid,
                        'dataProvider'=> $orderproductmodel->listTopProducts(),
                        'columns'=> $columns,
                        );
            $this->setDefaultGVOptions($options);
            $topproductgrid = $this->widget('booster.widgets.TbGridView', $options, true);
            echo $topproductgrid;
        ?>
        <?php $this->endWidget(); ?>
    </div>
</div>