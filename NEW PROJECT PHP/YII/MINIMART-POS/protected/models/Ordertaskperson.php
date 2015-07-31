<?php

/**
 * This is the model class for table "ordertaskpeople".
 *
 * The followings are the available columns in table 'ordertaskpeople':
 * @property string $id
 * @property string $order_id
 * @property string $order_type
 * @property string $ordertask_id
 * @property string $person_id
 * @property string $efforts
 * @property string $cost
 * @property string $amount
 * @property string $tax
 * @property integer $level
 * @property string $type
 */
class Ordertaskperson extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ordertaskpeople';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, order_type, ordertask_id, person_id', 'required'),
			array('level', 'numerical', 'integerOnly'=>true),
			array('order_id, ordertask_id, person_id, efforts, cost, amount, tax', 'length', 'max'=>10),
			array('order_type, type', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, order_type, ordertask_id, person_id, efforts, cost, amount, tax, level, type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Order',
			'order_type' => 'Order Type',
			'ordertask_id' => 'Ordertask',
			'person_id' => 'Person',
			'efforts' => 'Efforts',
			'cost' => 'Cost',
			'amount' => 'Amount',
			'tax' => 'Tax',
			'level' => 'Level',
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
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('order_type',$this->order_type,true);
		$criteria->compare('ordertask_id',$this->ordertask_id,true);
		$criteria->compare('person_id',$this->person_id,true);
		$criteria->compare('efforts',$this->efforts,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('tax',$this->tax,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('type',$this->type,true);

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
	 * @return Ordertaskperson the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
