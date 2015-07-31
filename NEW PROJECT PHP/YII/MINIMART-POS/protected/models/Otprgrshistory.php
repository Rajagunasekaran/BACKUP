<?php

/**
 * This is the model class for table "otprgrshistories".
 *
 * The followings are the available columns in table 'otprgrshistories':
 * @property string $id
 * @property string $order_id
 * @property string $order_type
 * @property string $ordertask_id
 * @property string $completed
 * @property string $completed_at
 * @property string $remarks
 * @property string $created_at
 * @property string $updated_at
 */
class Otprgrshistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'otprgrshistories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, order_type, ordertask_id, updated_at', 'required'),
			array('order_id, ordertask_id, completed', 'length', 'max'=>10),
			array('order_type', 'length', 'max'=>12),
			array('remarks', 'length', 'max'=>1024),
			array('completed_at, created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, order_type, ordertask_id, completed, completed_at, remarks, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'completed' => 'Completed',
			'completed_at' => 'Completed At',
			'remarks' => 'Remarks',
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
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('order_type',$this->order_type,true);
		$criteria->compare('ordertask_id',$this->ordertask_id,true);
		$criteria->compare('completed',$this->completed,true);
		$criteria->compare('completed_at',$this->completed_at,true);
		$criteria->compare('remarks',$this->remarks,true);
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
	 * @return Otprgrshistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
