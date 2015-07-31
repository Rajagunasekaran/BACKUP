<?php

/**
 * This is the model class for table "roles".
 *
 * The followings are the available columns in table 'roles':
 * @property string $id
 * @property string $role
 * @property string $desc
 * @property string $level
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Role extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('desc, updated_at', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('role', 'length', 'max'=>16),
			array('desc', 'length', 'max'=>128),
			array('level', 'length', 'max'=>10),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, role, desc, level, status, created_at, updated_at', 'safe', 'on'=>'search'),
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
                    'personcompanyroles' => array(self::HAS_MANY, 'Personcompanyrole', 'role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'role' => 'Role',
			'desc' => 'Desc',
			'level' => 'Level',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}
        public function getRoleName($role_id)
        {
            $rolename = '';
            $role = $this->findByPk( $role_id );
            if ( $role !== null )
            {
                $rolename = $role->role;
            }
            return $rolename;
        }
        public function getRoleByName($roleName)
        {
            $cndn = 'LCASE(role)=LCASE(:role) AND t.status=:status';
            $params = array(':role' => strtolower($roleName), ':status' => 1);
            $criteria=new CDbCriteria(array(
                                    'condition' => $cndn,
                                    'params'=> $params,
                            ));
            $roles = $this->findAll($criteria);

            $role= null;
            if(count($roles) > 0)
            {
                $role= $roles[0];
            }
            return $role;
        }
        public function getRoleId(&$rolename, $isrtnDflt = true)
        {
            $controller = Yii::app()->controller;
            if($isrtnDflt)
            {
                $dfltRole = $this->getRoleByName($controller->dfltRole);
                if(empty($dfltRole)
                        || !isset($controller->appRoles[$dfltRole->role])
                        || ($dfltRole->role === Helper::CONST_Admin
                                && !$controller->isARCPermitted)
                )
                {//fix the default to customer
                    $dfltRole = $this->getRoleByName(Helper::CONST_Customer);
                }
            }
            $roleId = null;
            $criteria = new CDbCriteria;
            $criteria->select = array( 'id' , 'role');
            $criteria->condition = 'LCASE(role)="' . strtolower($rolename) . '" AND status = 1';
            $result = $this->findAll( $criteria );
            if(count($result) === 1)
            {
                $role = $result[0];
                if(isset($controller->appRoles[$role->role])
                    && ($role->role !== Helper::CONST_Admin
                            || $controller->isARCPermitted)
                )
                {
                    $roleId = $role->id;
                    $rolename = $role->role;
                }
                else if($isrtnDflt && !empty($dfltRole))
                {
                    $roleId = $dfltRole->id;
                    $rolename = $dfltRole->role;
                }
            }
            else if($isrtnDflt && !empty($dfltRole))
            {
                $roleId = $dfltRole->id;
                $rolename = $dfltRole->role;
            }
            if(empty($roleId)) $rolename = '';
            return $roleId;
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
		$criteria->compare('role',$this->role,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('level',$this->level,true);
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
	 * @return Role the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
