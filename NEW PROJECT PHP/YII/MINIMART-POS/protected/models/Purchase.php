<?php

/**
 * This is the model class for table "purchases".
 *
 * The followings are the available columns in table 'purchases':
 * @property string $id
 * @property string $purchase_number
 * @property string $purchase_at
 * @property string $supplier_id
 * @property string $remarks
 * @property string $amount
 * @property string $tax
 * @property string $paid
 * @property string $status
 * @property string $invstatus
 * @property string $person_id
 * @property string $created_at
 * @property string $updated_at
 */
class Purchase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'purchases';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_number, supplier_id, person_id, updated_at', 'required'),
			array('purchase_number', 'length', 'max'=>16),
			array('supplier_id, amount, tax, paid, person_id', 'length', 'max'=>10),
			array('remarks', 'length', 'max'=>1024),
			array('status, invstatus', 'length', 'max'=>12),
			array('purchase_at, created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, purchase_number, purchase_at, supplier_id, remarks, amount, tax, paid, status, invstatus, person_id, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'purchase_number' => 'Purchase Number',
			'purchase_at' => 'Purchase At',
			'supplier_id' => 'Supplier',
			'remarks' => 'Remarks',
			'amount' => 'Amount',
			'tax' => 'Tax',
			'paid' => 'Paid',
			'status' => 'Status',
			'invstatus' => 'Invstatus',
			'person_id' => 'Person',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('purchase_number',$this->purchase_number,true);
		$criteria->compare('purchase_at',$this->purchase_at,true);
		$criteria->compare('supplier_id',$this->supplier_id,true);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('tax',$this->tax,true);
		$criteria->compare('paid',$this->paid,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('invstatus',$this->invstatus,true);
		$criteria->compare('person_id',$this->person_id,true);
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
	 * @return Purchase the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
