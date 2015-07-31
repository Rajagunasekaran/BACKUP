<?php

/**
 * This is the model class for table "payments".
 *
 * The followings are the available columns in table 'payments':
 * @property string $id
 * @property string $person_id
 * @property string $account_id
 * @property string $party_id
 * @property string $ordertask_id
 * @property string $order_id
 * @property string $type
 * @property string $amount
 * @property string $status
 * @property string $details
 * @property string $payment_at
 * @property string $collected_at
 * @property string $direction
 * @property string $created_at
 * @property string $updated_at
 */
class Payment extends CActiveRecord
{
        public $paymentdate;
        public $paid;
        public $pending;
        public $tmptotal;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('party_id, account_id, amount', 'required'),
			array('person_id, account_id, party_id, ordertask_id, order_id, amount', 'length', 'max'=>10),
			array('type, status', 'length', 'max'=>12),
			array('details', 'length', 'max'=>256),
			array('direction', 'length', 'max'=>16),
			array('collected_at, created_at,  payment_at,
                             ordertask_id, order_id, updated_at, order_or_ot_id', 'safe'),
                        //array('amount','positiveValidation'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, person_id, account_id, party_id, ordertask_id, order_id, type, amount, status, details, payment_at, collected_at, direction, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}        
        public function afterFind()
        {
            $dateformat = Yii::app()->controller->cJuiDatePickerViewFormat;
            $this->payment_at = $this->getDisplayPayment_at();
            if(empty($this->payment_at)) $this->payment_at = date($dateformat);
            if(strtolower($this->direction) === strtolower(Helper::CONST_Inwards))
            {
                if(!empty($this->order)) $this->order_or_ot_id = $this->order->id;
            }
            if(strtolower($this->direction) === strtolower(Helper::CONST_Outwards))
            {
                if(!empty($this->ordertask)) $this->order_or_ot_id = $this->ordertask->id;
            }
            $this->details = str_replace(':', '', $this->details);
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
                $this->payment_at = Yii::app()->controller->getMysqlFormattedDatetime($this->payment_at);
                if(empty($this->payment_at))
                {
                    $this->payment_at = date($dateformat);
                }
                $this->collected_at = Yii::app()->controller->getMysqlFormattedDatetime($this->collected_at);
                if(strtolower($this->type) === strtolower(Helper::CONST_OnAccount))
                {
                    $this->collected_at = new CDbExpression('NULL');
                    $this->status = Helper::CONST_OPEN;
                }
                else
                {
                    $this->collected_at = $this->payment_at;
                    $this->status = Helper::CONST_Payment_COLLECTED;
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
            $data->columns['order_or_ot_id'] = array('name' => 'order_or_ot_id');
        }
        public function positiveValidation($attribute, $params)
        {
            $value = $this->amount;
            if (!is_numeric($value) || $value < 1) 
            {//|| $value != round($value)
                $this->addError($attribute, " Amount should be > 0" );
                return false;
            }            
            return true;
        }
        public function getDisplayPayment_at()
        {
            $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
            $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->payment_at, $dateformat, false);
            return $fdate;
        }  
        public function getDisplayParty()
        {
            $value = 'Not Available';
            if(!empty($this->party))
            {
                $value = $this->party->name;
            }
            $rtn = CHtml::link($value, Yii::app()->controller->getEditUrl(true, $this->id, 'payment'));
            return $rtn;
        }
        public function getDisplayOrderOrOrderTask()
        {
            $rtn = '';
            if(  strtolower( $this->direction) === strtolower(Helper::CONST_Inwards))
            {
                $rtn = $this->getDisplayOrder();
            }
            if(  strtolower( $this->direction) === strtolower(Helper::CONST_Outwards))
            {
                $rtn = $this->getDisplayOrdertask();
            }
            return $rtn;
        }
        public function getDisplayOrder()
        {
            $rtn = 'N/A';
            if(!empty($this->order))
            {
                $rtn = $this->order->name;
            }
            return $rtn;
        }
        public function getDisplayOrdertask()
        {
            $rtn = '';
            if(!empty($this->ordertask))
            {
                $rtn = $this->ordertask->order->name;
                $rtn .= ' [ ' . $this->ordertask->task->name . ' ]';
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
                'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
                'party' => array(self::BELONGS_TO, 'Person', 'party_id'),
                'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
                'payment' => array(self::HAS_ONE, 'Payment', 'order_id'),      
                'ordertask' => array(self::BELONGS_TO, 'Ordertask', 'ordertask_id'),
            );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'person_id' => 'Person',
			'account_id' => Yii::app()->controller->getMenuLabels(Helper::CONST_Account),
			'party_id' => Helper::CONST_Received_From . ' / ' . Helper::CONST_Paid_To,			
			'order_id' => Yii::app()->controller->getMenuLabels(Helper::CONST_Order),
                        'ordertask_id' => Helper::CONST_Ordertask,
			'type' => 'Type',
			'amount' => 'Amount',
			'status' => 'Status',
			'details' => 'Details',
			'payment_at' => 'Date',
			'collected_at' => 'Collected On',
			'direction' => 'In/Out',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
                        'order_or_ot_id' => (($this->direction === Helper::CONST_Inwards)? Yii::app()->controller->getMenuLabels(Helper::CONST_Order):Helper::CONST_Ordertask),
                        'partyname' => (($this->direction === Helper::CONST_Inwards)?Helper::CONST_Customer:Helper::CONST_Contractor),
                        'ordername' => (($this->direction === Helper::CONST_Inwards)? Yii::app()->controller->getMenuLabels(Helper::CONST_Order):Helper::CONST_Ordertask),
                        'accountamount' => Yii::app()->controller->getMenuLabels(Helper::CONST_Account) . '-Amount',
                        'accountpaid' => Yii::app()->controller->getMenuLabels(Helper::CONST_Account) . '-Paid',
                        'paymentdate' => 'Date',
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
            
            if(strtolower($this->direction) === strtolower(Helper::CONST_Inwards))
            {
                if(!empty($this->order))
                {
                    $rtn = $this->order->name;
                }
            }
            if(strtolower($this->direction) === strtolower(Helper::CONST_Outwards))
            {
                if(!empty($this->ordertask))
                {
                    $rtn = $this->ordertask->order->name . '[ ' . $this->ordertask->task->name . ' ]';
                }
            }
            return $rtn;
        }
        public function getAccountpaid()
        {
            $rtn = '';
            if(!empty($this->account))
            {
                $rtn = $this->account->paid;
            }
            return $rtn;
        }
        public function getAccountAmount()
        {
            $rtn = '';
            if(!empty($this->account))
            {
                $rtn = $this->account->amount;
            }
            return $rtn;
        }
        public function customerdatewisepayments()
        {
            return $this->roleDateWisePayments(Helper::CONST_Customer);
        }
        public function customerwisepayments()
        {
            return $this->roleWisePayments(Helper::CONST_Customer);
        }
        public function roleDateWisePayments($role)
	{
            $criteria=new CDbCriteria;
            $criteria->with = array(
                'party' => array(
                    'select' => 'name',
                    'with'=>array('roles')
                    ),
                );
            $criteria->select = array(
                new CDbExpression("DATE(payment_at) as paymentdate"),
                new CDbExpression("IFNULL(SUM(CASE t.STATUS WHEN 'COLLECTED' THEN amount ELSE 0 END),0) as paid"),
                new CDbExpression("IFNULL(SUM(CASE t.STATUS WHEN 'OPEN' THEN amount ELSE 0 END),0) as pending"),
                                    );
            $criteria->order = 'paymentdate desc, party.name ASC';
            $criteria->group = 'paymentdate, party_id';
            if(!empty($this->party_id))
            {
                $criteria->compare('LCASE(party.name)',strtolower($this->party_id),true);   
            }
            if(!empty($role))
            {
                $criteria->compare('LCASE(roles.role)',strtolower($role),true);
//                if(  strtolower( $role ) === strtolower( Helper::CONST_Customer))
//                {
//                    $criteria->addCondition('LCASE(party.name) != "' . strtolower(Helper::CONST_Walk_in_Customer) . '"');
//                }
            }
            $options = array('criteria'=>$criteria,);
            Yii::app()->controller->setDefaultGVProviderOptions($options);
            return new CActiveDataProvider($this
                    , $options
                    );
	}
        public function roleWisePayments($role)
	{
            $criteria=new CDbCriteria;
            $criteria->with = array(                
                'party' => array(
                    'select' => 'name',
                    'with'=>array('roles')
                    ),
                );
            $criteria->select = array(
                new CDbExpression("DATE(payment_at) as paymentdate"),
                new CDbExpression("IFNULL(SUM(CASE t.STATUS WHEN 'OPEN' THEN amount ELSE 0 END),0) as pending"),
                                    );
            $criteria->order = 'pending DESC';
            $criteria->group = 'party_id';
            $criteria->having = 'pending > 0';
            if(!empty($this->party_id))
            {
                $criteria->compare('LCASE(party.name)',strtolower($this->party_id),true);   
            }
            if(!empty($role))
            {
                $criteria->compare('LCASE(roles.role)',strtolower($role),true);
//                if(  strtolower( $role ) === strtolower( Helper::CONST_Customer))
//                {
//                    $criteria->addCondition('LCASE(party.name) != "' . strtolower(Helper::CONST_Walk_in_Customer) . '"');
//                }
            }
            if (
                !Yii::app()->request->isAjaxRequest 
                && Helper::CONST_lazy_page_load
            )
            {
                $criteria->addCondition('1 = 0'); // You could also use 0, but I think this is more clear
            }
            $options = array('criteria'=>$criteria,);
            Yii::app()->controller->setDefaultGVProviderOptions($options);
            return new CActiveDataProvider($this
                    , $options
                    );
	}
        public function searchByRole($role)
	{
            // @todo Please modify the following code to remove attributes that should not be searched.

            $criteria=new CDbCriteria;
            $criteria->with = array(
                'order',
                'ordertask' => array('with'=>array('task')),
                'party' => array('with'=>array('roles')),
                'account'
                );

            $criteria->compare('id',$this->id,true);
            $criteria->compare('person_id',$this->person_id,true);

            $criteria->compare('LCASE(account.acnt_no)',strtolower($this->account_id),true);
            
            if(!empty($this->party_id))
            {
                $criteria->compare('LCASE(party.name)',strtolower($this->party_id),true);   
            }
            
            if(!empty($role))
            {
                $criteria->compare('LCASE(roles.role)',strtolower($role),true);
                if(  strtolower( $role ) === strtolower( Helper::CONST_Customer))
                {
                    $criteria->addCondition('LCASE(party.name) != "' . strtolower(Helper::CONST_Walk_in_Customer) . '"');
                }
            }
            
            $criteria->compare('LCASE(direction)',strtolower($this->direction),true);                                
            $order_or_ot_id = strtolower($this->order_or_ot_id);
            if(!empty($order_or_ot_id))
            {                    
                if(strtolower($this->direction) === strtolower(Helper::CONST_Inwards))
                {
                    $criteria->compare('LCASE(order.name)',$order_or_ot_id,true);
                } else if(strtolower($this->direction) === strtolower(Helper::CONST_Outwards))
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
            $criteria->compare('type',$this->type,true);
            $criteria->compare('t.amount',$this->amount,false);
            $criteria->compare('status',$this->status,true);
            $criteria->compare('details',$this->details,true);
            $criteria->compare('payment_at',$this->payment_at,true);
            $criteria->compare('collected_at',$this->collected_at,true);
            $criteria->compare('created_at',$this->created_at,true);
            $criteria->compare('updated_at',$this->updated_at,true);

            $options = array('criteria'=>$criteria,);
            Yii::app()->controller->setDefaultGVProviderOptions($options);
            return new CActiveDataProvider($this
                    , $options
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
            $this->searchByRole(null);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Payment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}