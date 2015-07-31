<?php

/**
 * This is the model class for table "accounts".
 *
 * The followings are the available columns in table 'accounts':
 * @property string $id
 * @property string $type
 * @property string $acnt_date
 * @property string $acnt_no
 * @property string $accounttype
 * @property string $person_id
 * @property string $party_id
 * @property string $amount
 * @property string $discount
 * @property string $scamount
 * @property string $paid
 * @property string $status
 * @property string $remarks
 * @property string $closed_at
 * @property string $created_at
 * @property string $updated_at
 */
class Account extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'accounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('acnt_no, acnt_date, 
                            person_id, party_id,
                            order_or_ot_id, amount', 'required'),
			array('type, status', 'length', 'max'=>12),
			array('accounttype', 'length', 'max'=>16),
			array('person_id, party_id, amount, discount, scamount, paid', 'length', 'max'=>10),
			array('remarks', 'length', 'max'=>256),
			array('scamount, closed_at, created_at,
                            updated_at, isapplysurcharge, discount, paid, 
                            remarks, acnt_date, order_or_ot_id', 'safe'),
                        array('amount','positiveValidation'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, acnt_date, acnt_no, 
                            accounttype, person_id, party_id, amount, 
                            discount, scamount, paid, status, remarks, 
                            closed_at, created_at, updated_at, ordername', 'safe', 'on'=>'search'),
		);
	}
        public function afterFind()
        {
            $dateformat = Yii::app()->controller->cJuiDatePickerViewFormat;
            $this->acnt_date = $this->getDisplayAcnt_date();
            if(empty($this->acnt_date)) $this->acnt_date = date($dateformat);
            if(strtolower($this->accounttype) === strtolower(Helper::CONST_Receivables))
            {
                if(!empty($this->orders)) $this->order_or_ot_id = $this->orders[0]->id;
            }
            if(strtolower($this->accounttype) === strtolower(Helper::CONST_Payables))
            {
                if(!empty($this->ordertasks)) $this->order_or_ot_id = $this->ordertasks[0]->id;
            }
            parent::afterFind();
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
                $dateformat = Yii::app()->controller->datetimemysqlformatYMDHIS;
                $this->acnt_date = Yii::app()->controller->getMysqlFormattedDatetime($this->acnt_date);
                if(empty($this->acnt_date))
                {
                    $this->acnt_date = date($dateformat);
                }
                if(empty($this->closed_at) 
                        && strtolower( $this->status) === strtolower( Helper::CONST_CLOSED)
                )
                {
                    $this->closed_at = date($dateformat);
                }
                else
                {
                    $this->closed_at = null;
                }
            }
            else
            {
                return false;
            }
            return true;
        }
        public function getMetaData()
        {
            $data = parent::getMetaData();
            $this->addAdditionalColumns($data);
            return $data;
        }
        private function addAdditionalColumns(&$data)
        {
            $data->columns['isapplysurcharge'] = array('name' => 'isapplysurcharge');
            $data->columns['order_or_ot_id'] = array('name' => 'order_or_ot_id');
        }
        public function positiveValidation($attribute, $params)
        {
            $value = $this->amount;
            if (!is_numeric($value) || $value < 1) 
            {//|| $value != round($value)
                $this->addError($attribute, " Amount should be  > 0" );
                return false;
            }            
            return true;
        }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
                'party' => array(self::BELONGS_TO, 'Person', 'party_id'),
                'accountorders' => array(self::HAS_MANY, 'Accountorder', 'account_id'),
                'orders' => array(self::HAS_MANY, 'Order', 'order_id',
                    'through' => 'accountorders'),
                'ordertasks' => array(self::HAS_MANY, 'Ordertask', 'ordertask_id',
                    'through' => 'accountorders'),
                'payments' => array(self::HAS_MANY, 'Payment', 'account_id'),
                'accountpurchases' => array(self::HAS_MANY, 'Accountpurchase', 'account_id'),
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
                        'acnt_date' => 'Date',
			'acnt_no' => 'Inv.No.',
			'accounttype' => 'Type',//Helper::CONST_Receivables . ' / ' . Helper::CONST_Payables,
			'person_id' => 'Person',
			'party_id' => Helper::CONST_Receivable_From . ' / ' . Helper::CONST_Payable_To,//(($this->accounttype === Helper::CONST_Receivables)?Helper::CONST_Customer:Helper::CONST_Contractor),
			'amount' => 'Amount',
                        'discount' => 'Discount',                    
			'scamount' => 'Scamount',
			'paid' => 'Paid',
			'status' => 'Status',
			'remarks' => 'Remarks',
			'closed_at' => 'Closed At',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
                        'isapplysurcharge' => 'Surcharge',
                        'order_or_ot_id' => (($this->accounttype === Helper::CONST_Receivables)? Yii::app()->controller->getMenuLabels(Helper::CONST_Order):Helper::CONST_Ordertask),
                        'partyname' => (($this->accounttype === Helper::CONST_Receivables)?Helper::CONST_Customer:Helper::CONST_Contractor),
                        'ordername' => $this->getOrdername()
		);
	}
        public function getPartyname()
        {
            $rtn = '';
            if(!empty($this->party))
            {
                $rtn = $this->party->name;
            }
            return $rtn;
        }
        public function getOrdername()
        {
            $rtn = '';
            //$rtn = (($this->accounttype === Helper::CONST_Receivables)? Yii::app()->controller->getMenuLabels(Helper::CONST_Order):Helper::CONST_Ordertask);
            if(strtolower($this->accounttype) === strtolower(Helper::CONST_Receivables))
            {
                if(!empty($this->orders))
                {
                    $rtn = $this->orders[0]->name;
                }
            }
            if(strtolower($this->accounttype) === strtolower(Helper::CONST_Payables))
            {
                if(!empty($this->ordertasks))
                {
                    $rtn = $this->ordertasks[0]->order->name . '[ ' . $this->ordertasks[0]->task->name . ' ]';
                }
            }
            return $rtn;
        }
        public function getDisplayAcnt_date()
        {
            $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
            $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->acnt_date, $dateformat, false);
            return $fdate;
        }
        public function getDisplayAcntNo()
        {
            $value = $this->acnt_no;
            $rtn = CHtml::link($value, Yii::app()->controller->getEditUrl(true, $this->id, 'account'));
            return $rtn;
        }
        public function getDisplayParty()
        {
            $value = 'Not Available';
            if(!empty($this->party))
            {
                $value = $this->party->name;
            }
            return $value;
        }
        public function getDisplayOrders()
        {
            $rtn = 'N/A';
            if(!empty($this->orders))
            {
                $count = count($this->orders);
                $rtn = ($count>1)? 'Mulitple Consignments':$this->orders[0]->addnlinfo;
            }
            return $rtn;
        }
        public function getDisplayOrderOrOrderTask()
        {
            $rtn = '';
            if(  strtolower( $this->accounttype) === strtolower(Helper::CONST_Receivables))
            {
                $rtn = $this->getDisplayOrdersII();
            }
            if(  strtolower( $this->accounttype) === strtolower(Helper::CONST_Payables))
            {
                $rtn = $this->getDisplayOrdertasks();
            }
            return $rtn;
        }
        public function getDisplayOrdersII()
        {
            $rtn = '';
            if(!empty($this->orders))
            {
                $count = count($this->orders);
                $rtn = ($count>1)? 'Mulitple ' . Yii::app()->controller->getMenuLabels(Helper::CONST_Order) :$this->orders[0]->name;
            }
            return $rtn;
        }
        public function getDisplayOrdertasks()
        {
            $rtn = '';
            if(!empty($this->ordertasks))
            {
                $count = count($this->ordertasks);
                if($count>1)
                {
                    $rtn = 'Mulitple Tasks';
                }
                else
                {
                    $rtn = $this->ordertasks[0]->order->name;
                    $rtn .= ' [ ' . $this->ordertasks[0]->task->name . ' ]';
                
                }                
            }
            return $rtn;
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

		$criteria=new CDbCriteria;
                $criteria->with = array(
                    'party'
                    ,'accountorders'=>array(
                                            'with'=>array('order','ordertask' => array('with'=>array('task')))
                                        )
                    );
		$criteria->compare('id',$this->id,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('LCASE(acnt_no)',strtolower($this->acnt_no),true);
                $criteria->compare('acnt_date',$this->acnt_date,true);                
		$criteria->compare('LCASE(accounttype)',strtolower($this->accounttype),true);
                $order_or_ot_id = strtolower($this->order_or_ot_id);
                if(!empty($order_or_ot_id))
                {
                    if(strtolower($this->accounttype) === strtolower(Helper::CONST_Receivables))
                    {
                        $criteria->compare('LCASE(order.name)',$order_or_ot_id,true);
                    } else if(strtolower($this->accounttype) === strtolower(Helper::CONST_Payables))
                    {
                        $criteria->compare('LCASE(task.name)',$order_or_ot_id,true);
                    }
                    else
                    {
                        $condition = "(LCASE(order.name) LIKE '%$order_or_ot_id%'";
                        $condition .= " OR LCASE(task.name) LIKE '%$order_or_ot_id%')";
                        $criteria->addCondition($condition);
                    }
                }
		$criteria->compare('person_id',$this->person_id,true);
		$criteria->compare('LCASE(party.name)',strtolower($this->party_id),true);
		$criteria->compare('t.amount',$this->amount,false);
                $criteria->compare('discount',$this->discount,true);
		$criteria->compare('scamount',$this->scamount,true);
		$criteria->compare('t.paid',$this->paid,false);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('LCASE(t.remarks)',strtolower($this->remarks),true);
		$criteria->compare('closed_at',$this->closed_at,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		$options = array('criteria'=>$criteria,);
                Yii::app()->controller->setDefaultGVProviderOptions($options);
		return new CActiveDataProvider($this
                        , $options
                        );
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Account the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
