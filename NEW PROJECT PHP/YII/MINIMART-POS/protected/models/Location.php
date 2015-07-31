<?php

/**
 * This is the model class for table "locations".
 *
 * The followings are the available columns in table 'locations':
 * @property string $id
 * @property string $street
 * @property string $locality
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $pincode
 * @property string $remarks
 * @property string $created_at
 * @property string $updated_at
 */
class Location extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'locations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        //array( 'street', 'required' ),
			array('street, locality', 'length', 'max'=>128),
			array('city, state, country', 'length', 'max'=>32),
			array('pincode', 'length', 'max'=>6),
                        array('pincode', 'numerical', 'integerOnly'=>true),
			array('remarks', 'length', 'max'=>64),
			array('created_at, updated_at, street, pincode', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, street, locality, city, state, country, pincode, remarks, created_at, updated_at', 'safe', 'on'=>'search'),
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
        public function getDisplay()
        {
            return $this->street . ' , ' . $this->pincode;
        }
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'street' => 'Street',
			'locality' => 'Locality',
			'city' => 'City',
			'state' => 'State',
			'country' => 'Country',
			'pincode' => 'Postal Code',
			'remarks' => 'Remarks',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}
        public function beforeSave()
        {
            if ( parent::beforeSave() )
            {
                $isupdate = $this->id > 0;                
                if($isupdate)
                {
                    $this->updated_at = new CDbExpression('NULL');
                }
                else
                {
                    $this->created_at = new CDbExpression('NULL'); 
                    $this->updated_at = new CDbExpression('NULL');                    
                }
            }
            else
            {
                return false;
            }
            return true;
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
		$criteria->compare('street',$this->street,true);
		$criteria->compare('locality',$this->locality,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('pincode',$this->pincode,true);
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
	 * @return Location the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
