<?php

/**
 * This is the model class for table "personcompanyroles".
 *
 * The followings are the available columns in table 'personcompanyroles':
 * @property string $id
 * @property string $person_id
 * @property string $company_id
 * @property string $role_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Personcompanyrole extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'personcompanyroles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person_id, company_id, role_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('person_id, company_id, role_id', 'length', 'max'=>10),
			array('created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, person_id, company_id, role_id, status, created_at, updated_at', 'safe', 'on'=>'search'),
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
                    'login' => array(self::BELONGS_TO, 'Login', 'login_id'),
                    'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
                    'person' => array(self::BELONGS_TO, 'Person', 'person_id'),
                    'role' => array(self::BELONGS_TO, 'Role', 'role_id'),
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
			'company_id' => 'Company',
			'role_id' => 'Role',
			'status' => 'Status',
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
		$criteria->compare('person_id',$this->person_id,true);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('role_id',$this->role_id,true);
		$criteria->compare('status',$this->status);
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
	 * @return Personcompanyrole the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
