<?php

/**
 * This is the model class for table "productstockhistories".
 *
 * The followings are the available columns in table 'productstockhistories':
 * @property string $id
 * @property string $product_id
 * @property string $productprice_id
 * @property string $updationdate
 * @property string $beforeupdation
 * @property string $updatedqnty
 * @property string $afterupdation
 */
class Productstockhistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'productstockhistories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, productprice_id', 'required'),
			array('product_id, productprice_id, beforeupdation, updatedqnty, afterupdation', 'length', 'max'=>10),
			array('updationdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, productprice_id, 
                            updationdate, beforeupdation, updatedqnty, 
                            afterupdation', 'safe', 'on'=>'search'),
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
                    'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
                    'productprice' => array(self::BELONGS_TO, 'Productprice', 'productprice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'productprice_id' => 'Product',
			'updationdate' => 'Updated On',
			'beforeupdation' => 'Before',
			'updatedqnty' => 'Updated Qty.',
			'afterupdation' => 'After',
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
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('productprice_id',$this->productprice_id,true);
		$criteria->compare('updationdate',$this->updationdate,true);
		$criteria->compare('beforeupdation',$this->beforeupdation,true);
		$criteria->compare('updatedqnty',$this->updatedqnty,true);
		$criteria->compare('afterupdation',$this->afterupdation,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Productstockhistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}