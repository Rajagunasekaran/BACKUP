<?php

/**
 * This is the model class for table "idmasters".
 *
 * The followings are the available columns in table 'idmasters':
 * @property string $id
 * @property string $forwhat
 * @property string $foryear
 * @property string $formonth
 * @property string $lastid
 * @property string $created_at
 * @property string $updated_at
 */
class Idmaster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'idmasters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('forwhat, foryear, formonth, lastid', 'required'),
			array('forwhat', 'length', 'max'=>16),
			array('foryear, formonth', 'length', 'max'=>8),
			array('lastid', 'length', 'max'=>10),
			array('created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, forwhat, foryear, formonth, lastid, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'forwhat' => 'Forwhat',
			'foryear' => 'Foryear',
			'formonth' => 'Formonth',
			'lastid' => 'Lastid',
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
		$criteria->compare('forwhat',$this->forwhat,true);
		$criteria->compare('foryear',$this->foryear,true);
		$criteria->compare('formonth',$this->formonth,true);
		$criteria->compare('lastid',$this->lastid,true);
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
	 * @return Idmaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
