<?php

/**
 * This is the model class for table "logins".
 *
 * The followings are the available columns in table 'logins':
 * @property string $id
 * @property string $login
 * @property string $pass
 * @property string $hash_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Login extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'logins';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, pass,', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('login', 'length', 'max'=>24),
			array('pass, hash_id', 'length', 'max'=>88),
			array('created_at, updated_at, hash_id', 'safe'),
                        array('login', 'uniqueLogin'),
                        array('pass', 'minlength'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, login, pass, hash_id, status, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}
        public function uniqueLogin($attribute, $params)
        {
            $rtnValue = false;
            $records = $this->findAllByAttributes(array('login'=> $this->getAttribute($attribute)));
            $rtnValue = count($records) === 0;
            if($rtnValue)
            {
               return $rtnValue; 
            }
            $loginids = array();
            foreach($records as $record)
            {
                $loginids[] = $record->id;
            }
            $company_id = Yii::app()->user->company->id;
            $records = Personcompanyrole::model()->findByAttributes(                    
                    array('login_id'=> $loginids,
                            'company_id' => $company_id
                        )
                    );
            $rtnValue = count($records) === 0;
            return $rtnValue;
        }
        public function minlength($attribute, $params)
        {
            $rtnValue = strlen(trim($this->getAttribute($attribute))) >= 5;
            if(!$rtnValue)
            {
                $this->addError($attribute, "Minimum 5 Charecters" );
            }
            return $rtnValue;
        }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'personcompanyroles' => array(self::HAS_MANY, 'Personcompanyrole', 'login_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Login',
			'pass' => 'Password',
			'hash_id' => 'Hash',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}
        private function setHash()
        {
            $login = $this->login;
            $pass = $this->pass;            
            $salt = "d30bd965c0e92fae88258a8defa365ea415ed907";//sha1($this->getRandomSalt());
            
            $sh1 = sha1($login.$pass.$salt);
            $sh2 = sha1($sh1.$salt);
            $passdigest = $sh1.'$'.$salt;
            $hashdigest = $sh2.'$'.$salt;
            $this->pass = $passdigest;
            $this->hash_id = $hashdigest;
        }
        private function getRandomSalt()
        {
            return microtime(true)*100000;
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
                $this->setHash();
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
		$criteria->compare('login',$this->login,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('hash_id',$this->hash_id,true);
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
	 * @return Login the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
