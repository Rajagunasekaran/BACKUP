<?php

/**
 * This is the model class for table "paymentreceipts".
 *
 * The followings are the available columns in table 'paymentreceipts':
 * @property string $id
 * @property string $customer_id
 * @property string $amount
 * @property string $details
 * @property string $paid_date
 * @property string $created_at
 * @property string $updated_at
 */
class Paymentreceipt extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'paymentreceipts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id,amount,paid_date', 'required'),
			array('customer_id, amount', 'length', 'max'=>10),
			array('details', 'length', 'max'=>256),
			array('paid_date, created_at,updated_at, details', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, amount, details, paid_date, 
                                created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}
        public function afterFind()
        {
            $dateformat = Yii::app()->controller->cJuiDatePickerViewFormat;
            $this->paid_date = $this->getDisplayPayment_at();
            if(empty($this->paid_date)) $this->paid_date = date($dateformat);

            parent::afterFind();
        }
        public function getDisplayPayment_at()
        {
            $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
            $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->paid_date, $dateformat, false);
            return $fdate;
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
                $this->paid_date = Yii::app()->controller->getMysqlFormattedDatetime($this->paid_date);
                if(empty($this->paid_date))
                {
                    $this->paid_date = date($dateformat);
                }
            }
            else
            {
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
                    'customer' => array(self::BELONGS_TO, 'Person', 'customer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_id' => 'Customer',
			'amount' => 'Amount',
			'details' => 'Details',
			'paid_date' => 'Paid Date',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
        public $pdate;
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with=array('customer');
		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->customer_id,false);
		$criteria->compare('amount',$this->amount,false);
		$criteria->compare('details',$this->details,false);                
                $paydate=$this->paid_date;
                if(!empty($paydate)){
                    $paydate=date('Y-m-d',strtotime(str_replace('/','-',$paydate)));
                }
                $criteria->compare('paid_date',$paydate,false);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Paymentreceipt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
