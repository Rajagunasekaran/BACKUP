<?php

/**
 * This is the model class for table "purchaseproducts".
 *
 * The followings are the available columns in table 'purchaseproducts':
 * @property string $id
 * @property string $purchase_id
 * @property string $product_id
 * @property integer $quantity
 * @property string $unit_cp
 * @property string $amount
 * @property string $taxrate_id
 * @property string $tax
 */
class Purchaseproduct extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'purchaseproducts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_id, product_id, taxrate_id', 'required'),
			array('quantity', 'numerical', 'integerOnly'=>true),
			array('purchase_id, product_id, unit_cp, amount, taxrate_id, tax', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, purchase_id, product_id, quantity, unit_cp, amount, taxrate_id, tax', 'safe', 'on'=>'search'),
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
			'purchase_id' => 'Purchase',
			'product_id' => 'Product',
			'quantity' => 'Quantity',
			'unit_cp' => 'Unit Cp',
			'amount' => 'Amount',
			'taxrate_id' => 'Taxrate',
			'tax' => 'Tax',
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
		$criteria->compare('purchase_id',$this->purchase_id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('unit_cp',$this->unit_cp,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('taxrate_id',$this->taxrate_id,true);
		$criteria->compare('tax',$this->tax,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Purchaseproduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
