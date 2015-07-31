<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property string $id
 * @property string $type
 * @property string $qoi_id
 * @property string $quote_id
 * @property string $order_id
 * @property string $quote_qoi_id
 * @property string $order_qoi_id
 * @property string $name
 * @property string $desc
 * @property string $addnlinfo
 * @property string $addnlinfo1
 * @property string $addnlinfo2
 * @property string $addnlinfo3
 * @property string $addnlinfo4
 * @property string $addnlinfo5
 * @property string $start_at
 * @property string $end_at
 * @property string $budget
 * @property string $cost
 * @property string $amount
 * @property string $taxper
 * @property string $tax
 * @property string $discper
 * @property string $disc
 * @property integer $tasks
 * @property string $completed
 * @property string $status
 * @property string $invstatus
 * @property string $remarks
 * @property string $paid
 * @property string $qutcnvrtdate
 * @property string $ordcnvrtdate
 * @property string $started_at
 * @property string $closed_at
 * @property integer $delivered
 * @property integer $enableordername
 * @property integer $enableordrprd
 * @property integer $enableordrtasks
 * @property integer $enableordrtaskpeople
 * @property integer $enableordrpayments
 * @property integer $enableordermilestones
 * @property integer $ordercostamountfrom
 * @property integer $ordertaskcostamountfrom
 * @property integer $enablediscount
 * @property integer $orderdiscfor
 * @property integet $customer_id
 * @property integet $created_id
 * @property integet $modified_id
 * @property integet $createdmp_id
 * @property integet $modifiedemp_id
 * @property string $created_at
 * @property string $updated_at
 */
class Order extends CActiveRecord
{
        public $customer_name;
        public $salesinclrfndcncl;
        public $totaldisc;
        public $totaltax;
        public $netroundoff;
        public $totalcancels;
        public $totalrefunds;
        public $tmptotal;
        public $details;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('qoi_id, name', 'required'),
			array('tasks, delivered, enableordername, enableordrprd, enableordrtasks, enableordrtaskpeople, enableordrpayments, enableordermilestones, ordercostamountfrom, ordertaskcostamountfrom, enablediscount, orderdiscfor', 'numerical', 'integerOnly'=>true),
			array('type, status, invstatus', 'length', 'max'=>12),
			array('qoi_id, quote_qoi_id, order_qoi_id', 'length', 'max'=>16),
			array('quote_id, order_id, budget, cost, amount, taxper, tax, 
                            discper, disc, completed, paid', 'length', 'max'=>10),
			array('name, addnlinfo', 'length', 'max'=>128),
			array('desc', 'length', 'max'=>1024),
			array('addnlinfo3, addnlinfo4', 'length', 'max'=>32),
			array('addnlinfo5', 'length', 'max'=>512),
			array('remarks', 'length', 'max'=>256),
			array('addnlinfo1, addnlinfo2, start_at, end_at, qutcnvrtdate, 
                            ordcnvrtdate, started_at, closed_at, 
                            created_at, updated_at, isopedit, ismsedit, isotedit
                            customer_id, created_id, createdemp_id, modified_id, modifiedemp_id,details', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, qoi_id, quote_id, order_id, quote_qoi_id, order_qoi_id, 
                            name, desc, addnlinfo, addnlinfo1, addnlinfo2, addnlinfo3, addnlinfo4, 
                            addnlinfo5, start_at, end_at, budget, cost, amount, taxper, tax, discper, disc,
                            tasks, completed, status, invstatus, remarks, paid, qutcnvrtdate, ordcnvrtdate,
                            started_at, closed_at, delivered, enableordername, enableordrprd, enableordrtasks,
                            enableordrtaskpeople, enableordrpayments, enableordermilestones, ordercostamountfrom, 
                            ordertaskcostamountfrom,  enablediscount, orderdiscfor, created_at, updated_at
                            customer_name, acnt_no, splsearch, paidstatus,  
                            customer_id, created_id, createdemp_id, modified_id, modifiedemp_id',
                            'safe', 'on'=>'search'),
		);
	}
        public function getMetaData()
        {
            $data = parent::getMetaData();
            $this->addAdditionalColumns($data);
            return $data;
        }
        public function beforeSave()
        {
            if ( parent::beforeSave() )
            {
                //$this->id > 0;                
                if(!$this->isNewRecord)
                {
                    $this->updated_at = new CDbExpression('NULL');
                }
                else
                {
                    $this->created_at = new CDbExpression('NULL'); 
                    $this->updated_at = new CDbExpression('NULL');                    
                }
                $this->start_at = Yii::app()->controller->getMysqlFormattedDatetime($this->start_at);
                $this->end_at = Yii::app()->controller->getMysqlFormattedDatetime($this->end_at);
            }
            else
            {
                return false;
            }
            return true;
        }
        public function afterFind()
        {
            $this->start_at = Yii::app()->controller->getMysqlFormattedDatetime($this->start_at, null, false);
            $this->end_at = Yii::app()->controller->getMysqlFormattedDatetime($this->end_at, null, false);
            parent::afterFind();
        }
        private function addAdditionalColumns(&$data)
        {           
            $data->columns['acnt_no'] = array('name' => 'acnt_no');
            $data->columns['isopedit'] = array('name' => 'isopedit');
            $data->columns['ismsedit'] = array('name' => 'ismsedit');
            $data->columns['isotedit'] = array('name' => 'isotedit');  
            $data->columns['splsearch'] = array('name' => 'splsearch');
            $data->columns['paidstatus'] = array('name' => 'paidstatus');
        }
        public function customerValidation($attribute, $params)
        {
            $rtn = empty($this->customer) || empty($this->customer->id);
            if(!$rtn)
            {
                $this->addError('customer.id', " Customer cannot be blank" ); 
            }
            return $rtn;
        }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'orderaddresses' => array(self::HAS_MANY, 'Orderaddress', 'order_id'),
                    'orderpeople' => array(self::HAS_MANY, 'Orderperson', 'order_id'),
                    'orderproducts' => array(self::HAS_MANY, 'Orderproduct', 'order_id'),
                    'ordertasks' => array(self::HAS_MANY, 'Ordertask', 'order_id'),
                    'ordermilestones' => array(self::HAS_MANY, 'Milestone', 'order_id'),
                    'orderpayments' => array(self::HAS_MANY, 'Payment', 'order_id'),                    
                    'accountorders' => array(self::HAS_MANY, 'Accountorder', 'order_id'),
                     'payment' => array(self::HAS_ONE, 'Payment', 'order_id'),    
                    'accounts' => array(self::HAS_MANY, 'Account', 'account_id'
                        , 'through'=>'accountorders'
                        ),
                    'araccount' => array(self::HAS_ONE, 'Account', 'account_id'
                        , 'through'=>'accountorders'
                        ,'condition' => 'LCASE(accounttype)="'.strtolower(Helper::CONST_Receivables).'"'
                        ),
                    'apaccount' => array(self::HAS_ONE, 'Account', 'account_id'
                        , 'through'=>'accountorders'
                        ,'condition' => 'LCASE(accounttype)="'.strtolower(Helper::CONST_Payables).'"'
                        ),
//                    'customer' => array(self::HAS_ONE, 'Person', 'person_id'
//                        , 'through'=>'orderpeople'
//                        ,'condition' => 'LCASE(orderpeople.type)="'.strtolower(Helper::CONST_Customer).'"'
//                        ),
                    'customer' => array(self::BELONGS_TO, 'Person', 'customer_id'),
                    'statusmaster' => array(self::BELONGS_TO, 'Statusmaster', 'status',),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'qoi_id' => Yii::app()->controller->getMenuLabels(Helper::CONST_Order) . '-ID',
			'quote_id' => 'Quote',
			'order_id' => 'Order',
			'quote_qoi_id' => 'Quote Qoi',
			'order_qoi_id' => 'Order Qoi',
			'name' => 'Name',
			'desc' => 'Description',
			'addnlinfo' => 'Addnlinfo',
			'addnlinfo1' => 'Addnlinfo1',
			'addnlinfo2' => 'Addnlinfo2',
			'addnlinfo3' => 'Addnlinfo3',
			'addnlinfo4' => 'Addnlinfo4',
			'addnlinfo5' => '',
			'start_at' => 'Start On',
			'end_at' => 'End On',
			'budget' => 'Budget',
			'cost' => 'Cost',
			'amount' => 'Amount',
			'taxper' => 'Taxper',
			'tax' => 'Tax',
			'discper' => 'Discout %',
			'disc' => 'Discount',
			'tasks' => 'Tasks',
			'completed' => 'Completed',
			'status' => 'Status',
			'invstatus' => 'Invoice-Status',
			'remarks' => 'Remarks',
			'paid' => 'Paid',
			'qutcnvrtdate' => 'Qutcnvrtdate',
			'ordcnvrtdate' => 'Ordcnvrtdate',
			'started_at' => 'Started At',
			'closed_at' => 'Closed At',
			'delivered' => 'Delivered',
			'enableordername' => 'Enableordername',
			'enableordrprd' => 'Enableordrprd',
			'enableordrtasks' => 'Enableordrtasks',
			'enableordrtaskpeople' => 'Enableordrtaskpeople',
			'enableordrpayments' => 'Enableordrpayments',
			'enableordermilestones' => 'Enableordermilestones',
			'ordercostamountfrom' => 'Ordercostamountfrom',
			'ordertaskcostamountfrom' => 'Ordertaskcostamountfrom',
			'enablediscount' => 'Enablediscount',
			'orderdiscfor' => 'Orderdiscfor',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
                        'customer_name' => 'Customer',
                        'customer.id' => 'Customer',
                        'customer_id' => 'Customer',
                        'created_id' => 'Created Login',
                        'createdemp_id' => 'Created BY',
                        'modified_id' => 'Modified Login', 
                        'modifiedemp_id' => 'Modified By',
                        'acnt_no' => 'Invoice Number',
                        'isopedit'=> 'Add/Modify Products',
                        'ismsedit'=> 'Add/Modify Milestones',
                        'isotedit'=> 'Add/Modify Tasks',
                        'splsearch' => 'Select Day',
                        'paidstatus' => 'Paid Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
                $criteria = new CDbCriteria();
                $criteria->order = 't.id desc';
                $criteria->with = array('customer','payment');
                $status=null;
                if(!empty($this->details))
                $status= strtolower($this->details);
                if(!empty($this->details)&& $status!='sales')
                  $status=':'.ucfirst(strtolower($this->details)).':';
                elseif(!empty($this->details)&& $status=='sales')
                   $status=' ';
                $criteria->compare('payment.details',$status,false);
                $criteria->compare('t.created_at',$this->created_at,true);
                $criteria->compare('t.amount',$this->amount);
//                Yii::app()->controller->alwaysApplyOrderCriteria($criteria);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('qoi_id',$this->qoi_id,true);
		$criteria->compare('quote_id',$this->quote_id,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('quote_qoi_id',$this->quote_qoi_id,true);
		$criteria->compare('order_qoi_id',$this->order_qoi_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('addnlinfo',$this->addnlinfo,true);
		$criteria->compare('addnlinfo1',$this->addnlinfo1,true);
		$criteria->compare('addnlinfo2',$this->addnlinfo2,true);
		$criteria->compare('addnlinfo3',$this->addnlinfo3,true);
		$criteria->compare('addnlinfo4',$this->addnlinfo4,true);
		$criteria->compare('addnlinfo5',$this->addnlinfo5,true);
		$criteria->compare('start_at',$this->start_at,true);
		$criteria->compare('end_at',$this->end_at,true);
		$criteria->compare('budget',$this->budget,true);
		$criteria->compare('cost',$this->cost,true);
                $criteria->compare('taxper',$this->taxper,true);
		$criteria->compare('tax',$this->tax,true);
		$criteria->compare('discper',$this->discper,true);
		$criteria->compare('disc',$this->disc,true);
		$criteria->compare('tasks',$this->tasks);
		$criteria->compare('t.completed',$this->completed,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('invstatus',$this->invstatus,true);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('paid',$this->paid,true);
		$criteria->compare('qutcnvrtdate',$this->qutcnvrtdate,true);
		$criteria->compare('ordcnvrtdate',$this->ordcnvrtdate,true);
		$criteria->compare('started_at',$this->started_at,true);
		$criteria->compare('closed_at',$this->closed_at,true);
		$criteria->compare('delivered',$this->delivered);
		$criteria->compare('enableordername',$this->enableordername);
		$criteria->compare('enableordrprd',$this->enableordrprd);
		$criteria->compare('enableordrtasks',$this->enableordrtasks);
		$criteria->compare('enableordrtaskpeople',$this->enableordrtaskpeople);
		$criteria->compare('enableordrpayments',$this->enableordrpayments);
		$criteria->compare('enableordermilestones',$this->enableordermilestones);
		$criteria->compare('ordercostamountfrom',$this->ordercostamountfrom);
		$criteria->compare('ordertaskcostamountfrom',$this->ordertaskcostamountfrom);
		$criteria->compare('enablediscount',$this->enablediscount);
		$criteria->compare('orderdiscfor',$this->orderdiscfor);
                $criteria->compare('updated_at',$this->updated_at,true);
                $criteria->compare( 'customer.name', $this->customer_name, true );
                $criteria->compare('created_id',$this->created_id);
                $criteria->compare('createdemp_id',$this->createdemp_id);
                $criteria->compare('modified_id',$this->modified_id);
                $criteria->compare('modifiedemp_id',$this->modifiedemp_id);
//                $criteria->compare('LCASE(accounts.acnt_no)',strtolower($this->acnt_no),true);
                
                $sort = array(
                            'attributes'=>array(
                                'customer_name'=>array(
                                    'asc'=>'customer.name',
                                    'desc'=>'customer.name DESC',
                                ),
                                '*',
                            ),
                        );
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=> $sort,
		));
	}
        
        public function getbillstatus(){
           $id=$this->id;
           $rowsql = "select details from payments where order_id='".$id."'"; 
         $billstatus = Yii::app()->db->createCommand( $rowsql )->queryScalar();
         if($billstatus)
         {
             $billstatus = str_replace(':', '', $billstatus);
          return $billstatus;
         }
         else if($id==null)
         {
             return '';
         }
         else
         {
             return 'Sales';
         }

       }
        public function dayWiseCollections()
	{
            $splSearch = $this->splsearch;
            $paidStatus = $this->paidstatus;
            
            
            $criteria=new CDbCriteria;
            Yii::app()->controller->exculdeDefaultOrderRecord($criteria);
            if(!empty($splSearch))
            {
                Yii::app()->controller->addOrderDateSearch($criteria,$splSearch);   
            }
            if(!empty($paidStatus) && (strtoupper($paidStatus) != strtoupper(Helper::CONST_ALL)))
            {
                if(strtoupper($paidStatus) == strtoupper(Helper::CONST_Paid))
                {
                    $criteria->addCondition(' paid = amount ');
                }
                else if (strtoupper($paidStatus) == strtoupper(Helper::CONST_OnAccount))
                {
                    $criteria->addCondition(' paid < amount ');
                }
            }
            $options = array('criteria'=>$criteria,);
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
        public function getRefundsData()
	{
            $criteria = new CDbCriteria;
            Yii::app()->controller->exculdeDefaultOrderRecord($criteria);
            $condition = "LCASE(statusmaster.name) = '" . strtolower(Helper::CONST_REFUNDNEW) . "'";
            $criteria->addCondition($condition);            
            $refundNewRecord = Order::model()->with('statusmaster')->findAll($criteria);
            $rawData = array();
            
            foreach($refundNewRecord as $modelObject)
            {
                $obj= new stdClass;
                
                $obj->id = $modelObject->id;
                $billno = $modelObject->qoi_id;
                $refAmount = $modelObject->amount;
                $refTax = $modelObject->tax;
                $refDisc = $modelObject->disc;
                $refDate = $modelObject->created_at;
                
                $obj->billNo = $billno;
                $obj->refAmount = abs($refAmount);
                $obj->refTax = abs($refTax);
                $obj->refDisc = abs($refDisc);
                
                $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
                $refDate = Yii::app()->controller->getMysqlFormattedDatetime($refDate, $dateformat, false);
                $obj->refDate = $refDate;
                $rawData[] = $obj;
            }
            $arrayDataProvider=new CArrayDataProvider($rawData, 
                                    array(
                                        'id'=>'id',
                                    )
                    );
            return $arrayDataProvider;
        }
        public function getCancelledData()
	{
            $criteria = new CDbCriteria;
            Yii::app()->controller->exculdeDefaultOrderRecord($criteria);
            $condition = "LCASE(statusmaster.name) = '" . strtolower(Helper::CONST_CANCELNEW) . "'";
            $criteria->addCondition($condition);            
            $refundNewRecord = Order::model()->with('statusmaster')->findAll($criteria);
            $rawData = array();
            
            foreach($refundNewRecord as $modelObject)
            {
                $obj= new stdClass;
                
                $obj->id = $modelObject->id;
                $billno = $modelObject->qoi_id;
                $refAmount = $modelObject->amount;
                $refTax = $modelObject->tax;
                $refDisc = $modelObject->disc;
                $refDate = $modelObject->created_at;
                
                $obj->billNo = $billno;
                $obj->refAmount = abs($refAmount);
                $obj->refTax = abs($refTax);
                $obj->refDisc = abs($refDisc);
                
                $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
                $refDate = Yii::app()->controller->getMysqlFormattedDatetime($refDate, $dateformat, false);
                $obj->refDate = $refDate;
                $rawData[] = $obj;
            }
            $arrayDataProvider=new CArrayDataProvider($rawData, 
                                    array(
                                        'id'=>'id',
                                    )
                    );
            return $arrayDataProvider;

        }
        public function exchangeReports()
	{
            $criteria = new CDbCriteria;
            Yii::app()->controller->exculdeDefaultOrderRecord($criteria);
            $condition = "LCASE(statusmaster.name) = '" . strtolower(Helper::CONST_EXCHANGENEW) . "'";
            $criteria->addCondition($condition);            
            $excNewRecord = Order::model()->with('statusmaster')->findAll($criteria);
            $rawData = array();
            
            foreach($excNewRecord as $modelObject)
            {
                $obj= new stdClass;
                $billno = $modelObject->qoi_id;
                $excNewName = '';
                $excOldName = '';
                $excNewAmount = '';
                $excOldAmount = '';
                $balanceDue = 0;
                $quantity = 0;
                foreach($modelObject->orderproducts as $objOrdPrd)
                {
                    $quantity = $objOrdPrd->quantity;
                    if($quantity > 0)
                    {
                        $excNewName .= $objOrdPrd->productprice->name . ',';
                        $excNewAmount += $objOrdPrd->amount;
                    }
                    else
                    {
                        $excOldName .= $objOrdPrd->productprice->name  . ',';
                        $excOldAmount += $objOrdPrd->amount;
                    }
                }           
                $obj->id = $modelObject->id;
                $obj->billNo = $billno;
                $obj->excOldName = $excOldName;
                $obj->excOldAmount = abs($excOldAmount);
                $obj->excNewName = $excNewName;
                $obj->excNewAmount = abs($excNewAmount);
                $obj->balanceDue = $obj->excNewAmount - $obj->excOldAmount;
                $rawData[] = $obj;
            }
            $arrayDataProvider=new CArrayDataProvider($rawData, 
                                    array(
                                        'id'=>'id',
                                    )
                    );
            return $arrayDataProvider;
        }        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}