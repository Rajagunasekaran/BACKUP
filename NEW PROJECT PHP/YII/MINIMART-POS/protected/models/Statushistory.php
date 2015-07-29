<?php

/**
 * This is the model class for table "statushistories".
 *
 * The followings are the available columns in table 'statushistories':
 * @property string $id
 * @property string $ofwhich_id
 * @property string $status1dt
 * @property string $status2dt
 * @property string $status3dt
 * @property string $status4dt
 * @property string $status5dt
 * @property string $status6dt
 * @property string $status7dt
 * @property string $status8dt
 * @property string $status9dt
 * @property string $status10dt
 * @property string $created_at
 * @property string $updated_at
 */
class Statushistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'statushistories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ofwhich_id', 'required'),
			array('ofwhich_id', 'length', 'max'=>10),
			array('updated_at, status1dt, status2dt, status3dt, status4dt, status5dt, status6dt, status7dt, status8dt, status9dt, status10dt, created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ofwhich_id, status1dt, status2dt, status3dt, status4dt, status5dt, status6dt, status7dt, status8dt, status9dt, status10dt, created_at, updated_at', 'safe', 'on'=>'search'),
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
                    'order' => array(self::BELONGS_TO, 'Order', 'ofwhich_id',),
                    'ordertask' => array(self::BELONGS_TO, 'Ordertask', 'ofwhich_id',),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ofwhich_id' => 'Ofwhich',
			'status1dt' => 'Status1dt',
			'status2dt' => 'Status2dt',
			'status3dt' => 'Status3dt',
			'status4dt' => 'Status4dt',
			'status5dt' => 'Status5dt',
			'status6dt' => 'Status6dt',
			'status7dt' => 'Status7dt',
			'status8dt' => 'Status8dt',
			'status9dt' => 'Status9dt',
			'status10dt' => 'Status10dt',
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
		$criteria->compare('ofwhich_id',$this->ofwhich_id,true);
		$criteria->compare('status1dt',$this->status1dt,true);
		$criteria->compare('status2dt',$this->status2dt,true);
		$criteria->compare('status3dt',$this->status3dt,true);
		$criteria->compare('status4dt',$this->status4dt,true);
		$criteria->compare('status5dt',$this->status5dt,true);
		$criteria->compare('status6dt',$this->status6dt,true);
		$criteria->compare('status7dt',$this->status7dt,true);
		$criteria->compare('status8dt',$this->status8dt,true);
		$criteria->compare('status9dt',$this->status9dt,true);
		$criteria->compare('status10dt',$this->status10dt,true);
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
	 * @return Statushistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
