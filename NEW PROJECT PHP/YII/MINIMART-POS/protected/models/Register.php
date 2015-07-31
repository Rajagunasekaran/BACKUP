<?php

/**
 * This is the model class for table "registers".
 *
 * The followings are the available columns in table 'registers':
 * @property string $id
 * @property string $name
 * @property string $desc
 * @property string $login_id
 * @property string $role_id
 * @property string $open_time
 * @property string $close_time
 * @property string $op_balance
 * @property string $cl_balance
 * @property string $net_collection
 * @property integer $isdefault
 * @property string $created_at
 * @property string $updated_at
 */
class Register extends CActiveRecord
{
    public $totalcollections;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'registers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login_id, role_id', 'required'),
			array('isdefault', 'numerical', 'integerOnly'=>true),
			array('name, desc', 'length', 'max'=>128),
			array('login_id, role_id, op_balance, cl_balance, net_collection', 'length', 'max'=>10),
			array('name, open_time, close_time, created_at,updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, desc, login_id, role_id, open_time, close_time, op_balance, cl_balance, net_collection, isdefault, created_at, updated_at', 'safe', 'on'=>'search'),
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
                $this->open_time = Yii::app()->controller->getMysqlFormattedDatetime($this->open_time);
                $this->close_time = Yii::app()->controller->getMysqlFormattedDatetime($this->close_time);
            }
            else
            {
                return false;
            }
            return true;
        }
        public function afterFind()
        {
            $this->open_time = Yii::app()->controller->getMysqlFormattedDatetime($this->open_time, Yii::app()->controller->datetimemysqlformatDMYHI, false);
            $this->close_time = Yii::app()->controller->getMysqlFormattedDatetime($this->close_time, Yii::app()->controller->datetimemysqlformatDMYHI, false);
            parent::afterFind();
        }
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'desc' => 'Desc',
			'login_id' => 'Register',
			'role_id' => 'Role',
			'open_time' => 'Open Time',
			'close_time' => 'Close Time',
			'op_balance' => 'Op Balance',
			'cl_balance' => 'Cl Balance',
			'net_collection' => 'Net Collection',
			'isdefault' => 'Isdefault',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
                        'salesdate' => 'Date',
                        'totalcollections' => 'Collections',
		);
	}
        public function registerwisecollections()
	{
            $criteria=new CDbCriteria;
            $criteria->with = array(
                'login' => array(
                    'select' => 'login',
                    ),
                );
            $criteria->select = array(
                                        new CDbExpression("DATE(salesdate) as salesdate"),
                                        new CDbExpression("IFNULL(SUM(net_collection),0) as totalcollections"),
                                    );
            $criteria->order = 'salesdate desc, login.login ASC';
            $criteria->group = 'salesdate, login_id';
            if(!empty($this->login_id))
            {
                $criteria->compare('LCASE(login.login)',strtolower($this->login_id),true);   
            }            
            $options = array('criteria'=>$criteria,);
            Yii::app()->controller->setDefaultGVProviderOptions($options);
            return new CActiveDataProvider($this
                    , $options
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('login_id',$this->login_id,true);
		$criteria->compare('role_id',$this->role_id,true);
		$criteria->compare('open_time',$this->open_time,true);
		$criteria->compare('close_time',$this->close_time,true);
		$criteria->compare('op_balance',$this->op_balance,true);
		$criteria->compare('cl_balance',$this->cl_balance,true);
		$criteria->compare('net_collection',$this->net_collection,true);
		$criteria->compare('isdefault',$this->isdefault);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

                $options = array( 'criteria' => $criteria, );
                Yii::app()->controller->setDefaultGVProviderOptions( $options );
                return new CActiveDataProvider( $this
                        , $options
                );		
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Register the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getDefaultRegisterId()
        {
            $id = null;
            $criteria = new CDbCriteria;
            $criteria->condition = 'isdefault=1';
            $result = $this->findAll( $criteria );
            if(count($result) === 1)
            {
                $id = $result[0]->id;
            }
            return $id;
        }
}