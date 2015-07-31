<?php

/**
 * This is the model class for table "orderaddresses".
 *
 * The followings are the available columns in table 'orderaddresses':
 * @property string $id
 * @property string $customer_id
 * @property string $order_id
 * @property string $location_id
 * @property string $name
 * @property string $mobile
 * @property string $type
 */
class Orderaddress extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orderaddresses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, order_id, location_id', 'required'),
			array('customer_id, order_id, location_id', 'length', 'max'=>10),
			array('name', 'length', 'max'=>128),
			array('mobile', 'length', 'max'=>16),
			array('type', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, order_id, location_id, name, mobile, type', 'safe', 'on'=>'search'),
		);
	}
        public function getFromDisplay()
        {
            return $this->location->street . ' - ' . $this->location->pincode;
        }
        public function getToDisplay()
        {
            return $this->name . ' - ' . $this->location->mobile;
        }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'location' => array(self::BELONGS_TO, 'Location', 'location_id'),
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
			'order_id' => 'Order',
			'location_id' => 'Location',
			'name' => 'Person Name',
			'mobile' => 'Person Mobile',
			'type' => 'Type',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('customer_id',$this->customer_id,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('location_id',$this->location_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orderaddress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
