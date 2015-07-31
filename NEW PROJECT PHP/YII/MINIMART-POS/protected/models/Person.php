<?php

/**
 * This is the model class for table "people".
 *
 * The followings are the available columns in table 'people':
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $auxname
 * @property string $firstname
 * @property string $lastname
 * @property string $mobile
 * @property string $mail
 * @property string $website
 * @property string $mobile_addnls
 * @property string $fax
 * @property string $did
 * @property string $cost_center
 * @property string $devicetoken
 * @property string $commission
 * @property string $mhcost
 * @property string $mhrate
 * @property integer $geo_update_frq
 * @property integer $work_hour_start
 * @property integer $work_hour_end
 * @property string $status
 * @property integer $enablelogin
 * @property integer $enablepplcode
 * @property integer $enablecontact
 * @property integer $enablepplauxname
 * @property integer $register_id
 * @property string $created_at
 * @property string $updated_at
 */
class Person extends CActiveRecord
{
    public $name;
    public $purchaseamount;
    public $paidamount;
    public $balancedue;
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'people';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        $rqrd = 'role_id, name,firstname';
        return array(
            array( $rqrd, 'required', 'message'=>'Full Name Cannot be blank.',  ),
            array( 'geo_update_frq, work_hour_start, work_hour_end', 'numerical', 'integerOnly' => true ),
            array( 'code, , fax, did', 'length', 'max' => 16 ),
            array( 'name, auxname, firstname, lastname, mail, website, cost_center', 'length', 'max' => 128 ),
            array('mobile, mobile_addnls', 'length', 'max'=>8),
            array('mobile, mobile_addnls', 'numerical', 'integerOnly'=>true),
            array( 'devicetoken', 'length', 'max' => 512 ),
            array( 'commission, mhcost, mhrate', 'length', 'max' => 10 ),
            array( 'enablelogin, created_at, updated_at, rolename, status
                ,addresstype, editpassword, register_id, lookupDisplay, selected_date', 'safe' ),
            array('firstname, lastname','checkContact'),
            array('addresstype', 'checkAddressFields'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array( 'id, role_id, rolename, code, name, auxname, 
                firstname, lastname, mobile, mail, website, mobile_addnls, fax, 
                did, cost_center, devicetoken, commission, mhcost, mhrate, 
                geo_update_frq, work_hour_start, work_hour_end, status, 
                enablelogin, enablepplcode, enablecontact, enablepplauxname, 
                created_at, updated_at, register_id, selected_date', 'safe', 'on' => 'search' ),
        );
    }
    public function checkContact($attribute, $params)
    {
        switch($this->enablecontact)
        {
            case 0:                
                break;
            case 1:
                if($attribute === 'firstname' && empty($this->firstname))
                {
                    $this->addError($attribute, " Contact cannot be blank" );
                    return false;
                }
                break;
            case 2:
                if($attribute === 'firstname' && empty($this->firstname))
                {
                    $this->addError($attribute, " Contact cannot be blank" );
                    return false;
                }
                if($attribute === 'lastname' && empty($this->lastname))
                {
                    $this->addError($attribute, $this->getAttributeLabel($attribute) . " cannot be blank" );
                    return false;
                }
                break;
        }
        return true;
    }
    public function checkAddressFields($attribute, $params)
    {
        $rtn =true;
        if(!empty($this->addresstype))
        {
            $rtn = (!empty($this->address->street)) && (!empty($this->address->pincode));
            //return $this->address->validate();
            if(empty($this->address->street))
            {
                $this->addError('street', " Street cannot be blank" ); 
            }
            if(empty($this->address->pincode))
            {
                $this->addError('pincode', " Postal Code cannot be blank" ); 
            }
        }
        return $rtn;
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
    public function afterFind()
    {        
        if(!empty($this->roles))
        {
            $this->role_id = $this->roles[0]->id;
            $this->rolename = $this->roles[0]->role;
        }
        $this->lookupDisplay = $this->name;
        if($this->enablepplcode)
        {
            $this->lookupDisplay =  "  [$this->code] " . $this->name;
        }
        parent::afterFind();
    }
    public function getMetaData(){
        $data = parent::getMetaData();
        $data->columns['role_id'] = array('name' => 'role_id');
        $data->columns['rolename'] = array('name' => 'rolename');
        $data->columns['editpassword'] = array('name' => 'editpassword');
        $data->columns['login'] = array('name' => 'login');
        $data->columns['addresstype'] = array('name' => 'addresstype');
        $data->columns['address'] = array('name' => 'address');
        $data->columns['lookupDisplay'] = array('name' => 'lookupDisplay');
        $data->columns['selected_date'] = array('name' => 'selected_date');
        return $data;
    }
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                'personcompanyroles' => array(self::HAS_MANY, 'Personcompanyrole', 'person_id'),
                'roles' => array(self::HAS_MANY, 'Role', 'role_id'
                    , 'through'=>'personcompanyroles'),
                'logins' => array(self::HAS_MANY, 'Login', 'login_id',
                     'through'=>'personcompanyroles',
                     'condition' => 'logins.status = 1'
                ),
                'personaddresses' => array(self::HAS_MANY, 'Personaddress', 'person_id'),
                'myaddresses' => array(self::HAS_MANY, 'Location', 'location_id'
                    , 'through'=>'personaddresses'
                    ),
                'orderaddresses' => array(self::HAS_MANY, 'Orderaddress', 'customer_id'),
                'orderfromaddresses' => array(self::HAS_MANY, 'Location', 'location_id'
                    , 'through'=>'orderaddresses'
                    ,'condition' => 'orderaddresses.type="'.Helper::CONST_From.'"'
                    ),
                'ordertoaddresses' => array(self::HAS_MANY, 'Location', 'location_id'
                    , 'through'=>'orderaddresses'
                    ,'condition' => 'orderaddresses.type="'.Helper::CONST_To.'"'
                    ),
                'geolocations' => array(self::HAS_MANY, 'Geolocation', 'person_id',
                        'order'=>'captured_at desc'),
            
                'orderpeople' => array(self::HAS_MANY, 'Orderperson', 'person_id'),
                'customerorders' => array(self::HAS_MANY, 'Order', 'order_id'
                        , 'through'=>'orderpeople'
                        ,'condition' => 'orderpeople.type="'.Helper::CONST_Customer.'"'
                        ),

                'ordertaskpeople' => array(self::HAS_MANY, 'Ordertaskperson', 'person_id'),
                'contractororders' => array(self::HAS_MANY, 'Order', 'order_id'
                        , 'through'=>'ordertaskpeople'
                        ,'condition' => 'ordertaskpeople.type="'.Helper::CONST_Contractor.'"'
                        ),
                'contractorordertasks' => array(self::HAS_MANY, 'Ordertask', 'ordertask_id'
                        , 'through'=>'ordertaskpeople'
                        ,'condition' => 'ordertaskpeople.type="'.Helper::CONST_Contractor.'"'
                        ),
                'purchasepeople' => array(self::HAS_MANY, 'Purchaseperson', 'person_id'),
                'supplierpurchases' => array(self::HAS_MANY, 'Purchase', 'purchase_id'
                        , 'through'=>'purchasepeople'
                        ,'condition' => 'orderpeople.type="'.Helper::CONST_Supplier.'"'
                        ),
                'araccounts' => array(self::HAS_MANY, 'Account', 'party_id'
                    ,'condition' => 'LCASE(accounttype)="'.strtolower(Helper::CONST_Receivables).'"'
                    ),
                'apaccounts' => array(self::HAS_MANY, 'Account', 'party_id'
                    ,'condition' => 'LCASE(accounttype)="'.strtolower(Helper::CONST_Payables).'"'
                    ),
                'register' => array(self::BELONGS_TO, 'Register', 'register_id'),
                'payments' => array(self::HAS_MANY, 'Payment', 'party_id'),
                'paymentreceipts' => array(self::HAS_MANY, 'Paymentreceipt', 'customer_id'),
        );
    }
    public function getContact()
    {
        if($this->enablecontact == 1)
        {
            return $this->firstname;//first and last saved in first itself.
        }
        if($this->enablecontact == 2)
        {
            return $this->firstname . ' ' . $this->lastname;
        }
        else 
        {
            return "";
        }
    }
    public function getDisplayRegister()
    {
        $rtn = '';
        if(!empty($this->register_id))
        {
            $rtn = $this->register->name;
        }
        return $rtn;
    }
    public function getDisplayRole()
    {
        $rtn = '';
        if(!empty($this->role))
                $rtn = $this->role->role;
        return $rtn;
    }
    public function getRadioCell()
    {
        $id=$this->id;
        $elementname = "Person[id]";
        $elementtag = CHtml::radioButton($elementname
                ,false,
                array("value"=>"$id"));
        return $elementtag;
    }
    public function getDisplayLocation()
    {
        $rtn = 'N/A';
        if(!empty($this->geolocations))
        {
            $tmp = $this->geolocations[0]->locname;
            $rtn = (empty($tmp)?'N/A':$tmp);
        }
        return $rtn;
    }
    public function getDisplayTime()
    {
        $rtn = 'N/A';
        if(!empty($this->geolocations))
        {
            $tmp = $this->geolocations[0]->captured_at;
            $dateformat = Yii::app()->controller->datetimemysqlformatDMYHI;
            $fdate = Yii::app()->controller->getMysqlFormattedDatetime($tmp, $dateformat, false);
            $rtn = (empty($fdate)?'N/A': $fdate);
        }
        return $rtn;
    }
//    public function getLookupDisplay($isIncludeCode = true)
//    {
//        $rtn = $this->name;
//        if($this->enablepplcode && $isIncludeCode)
//        {
//            $rtn = "  [$this->code] " . $rtn;
//        }
//        return $rtn;
//    }
    public function getDisplay()
    {
        $rtn = $this->name;
        return $rtn;
    }
    private function getFNLabel()
    {        
        return "Contacts's Name";
//        if($this->enablecontact === 1)
//        {
//            return "Contacts's Name";
//        }
//        else
//        {
//            return "Contacts's First Name";
//        }
    }
    private function getLNLabel()
    {
        return "Contacts's Last Name";
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Full Name',
            'auxname' => 'Secondary Name',
            'firstname' => $this->getFNLabel(),
            'lastname' => $this->getLNLabel(),
            'mobile' => 'Mobile',
            'mail' => 'Mail',
            'website' => 'Website',
            'mobile_addnls' => 'Mobile Addnls',
            'fax' => 'Fax',
            'did' => 'Did',
            'cost_center' => 'Cost Center',
            'devicetoken' => 'Devicetoken',
            'commission' => 'Commission',
            'mhcost' => 'Mhcost',
            'mhrate' => 'Mhrate',
            'geo_update_frq' => 'Location Update Frequency',
            'work_hour_start' => 'Work Hour Start',
            'work_hour_end' => 'Work Hour End',
            'status' => 'Status',
            'enablelogin' => 'Enable Login',
            'enablepplcode' => 'Enable Code',
            'enablecontact' => 'Enable Contact',
            'enablepplauxname' => 'Enable Secondary Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'role_id' => 'Type',
            'editpassword' => 'Reset Password',
            'display' => 'Customer',
            'register_id' => 'Register',
            'displayRegister' => 'Register',
            'selected_date' => "Select Date"
        );
    }
    public function searchByRole($rolename = null)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria(array(
                            'order'=>'name desc'));
        if(!empty($rolename))
        {
            $this->role_id = Role::model()->getRoleByName($rolename)->id;
        }
        $criteria = Yii::app()->controller->getPeopleCriteria($this->role_id, false);                     
        if (!Yii::app()->request->isAjaxRequest && Helper::CONST_lazy_page_load) 
        {
            $criteria->addCondition('1 = 0'); // You could also use 0, but I think this is more clear
        }
        $options = array( 'criteria' => $criteria, );
        Yii::app()->controller->setDefaultGVProviderOptions( $options );
        return new CActiveDataProvider( $this
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

        $criteria = new CDbCriteria;
        $criteria=new CDbCriteria(array(
                            'order'=>'t.name desc',
                            'with' => array('roles')));
        $criteria = Yii::app()->controller->getPeopleCriteria($this->role_id, false);
        
        $criteria->compare( 'id', $this->id, false );
        $criteria->compare( 'code', $this->code, false );
        $criteria->compare( 'name', $this->name, false );
        $criteria->compare( 'auxname', $this->auxname, true );
        $criteria->compare( 'firstname', $this->firstname, false );
        $criteria->compare( 'lastname', $this->lastname, true );
        $criteria->compare( 'mobile', $this->mobile, false );
        $criteria->compare( 'mail', $this->mail, false );
        $criteria->compare( 'website', $this->website, true );
        $criteria->compare( 'mobile_addnls', $this->mobile_addnls, true );
        $criteria->compare( 'fax', $this->fax, true );
        $criteria->compare( 'did', $this->did, true );
        $criteria->compare( 'cost_center', $this->cost_center, true );
        $criteria->compare( 'devicetoken', $this->devicetoken, true );
        $criteria->compare( 'commission', $this->commission, true );
        $criteria->compare( 'mhcost', $this->mhcost, true );
        $criteria->compare( 'mhrate', $this->mhrate, true );
        $criteria->compare( 'geo_update_frq', $this->geo_update_frq );
        $criteria->compare( 'work_hour_start', $this->work_hour_start );
        $criteria->compare( 'work_hour_end', $this->work_hour_end );
        $criteria->compare( 'status', $this->status, true );
        $criteria->compare( 'enablelogin', $this->enablelogin );
        $criteria->compare( 'enablepplcode', $this->enablepplcode );
        $criteria->compare( 'enablecontact', $this->enablecontact );
        $criteria->compare( 'enablepplauxname', $this->enablepplauxname );
        $criteria->compare( 'created_at', $this->created_at, true );
        $criteria->compare( 'updated_at', $this->updated_at, true );
        $criteria->compare( 'register_id', $this->register_id, false );
        $options = array( 'criteria' => $criteria, );
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    public function customerDueDetails()
    {
        $criteria=new CDbCriteria;
        $criteria->with = array(
            'roles','payments',
            );
        $criteria->select = array(
            't.name',
            new CDbExpression("@total_purchase := IFNULL(SUM(CASE payments.STATUS WHEN 'OPEN' THEN payments.amount ELSE 0 END),0) as purchaseamount"),            
                                );
        $criteria->addCondition('LCASE(roles.role) = "'. strtolower(Helper::CONST_Customer) .'"');
        $criteria->addCondition('LCASE(t.name) != "'. strtolower(Helper::CONST_Walk_in_Customer) .'"');
        $criteria->order = 't.name ASC';
        $criteria->group = 't.id';
        $purchases = Person::model()->findAll($criteria);
        $tmparray = array();
        
        foreach($purchases as $purchase)
        {
            $tmpObj = new stdClass();
            $tmpObj->id = $purchase->id;
            $tmpObj->name = $purchase->name;
            $tmpObj->purchaseamount = $purchase->purchaseamount;
            $tmparray[$tmpObj->id] = $tmpObj;
        }
        $criteria=new CDbCriteria;
        $criteria->with = array(
            'roles','paymentreceipts',
            );
        $criteria->select = array(
            't.name',
            new CDbExpression("@total_paid := IFNULL(SUM(paymentreceipts.amount),0) as paidamount"),            
                                );
        $criteria->addCondition('LCASE(roles.role) = "'. strtolower(Helper::CONST_Customer) .'"');
        $criteria->addCondition('LCASE(t.name) != "'. strtolower(Helper::CONST_Walk_in_Customer) .'"');
        $criteria->order = 't.name ASC';
        $criteria->group = 't.id';
        $payments = Person::model()->findAll($criteria);
        
        foreach($payments as $payment)
        {
            if(empty($tmparray[$payment->id]))
            {
                $tmpObj = new stdClass();
                $tmpObj->id = $payment->id;
                $tmpObj->name = $payment->name;
                $tmpObj->purchaseamount = 0;                
            }
            else
            {
                $tmpObj = $tmparray[$payment->id];
            }
            $tmpObj->paidamount = $payment->paidamount;
            $tmpObj->balancedue = round(($tmpObj->purchaseamount - $payment->paidamount),2);            
            $tmparray[$tmpObj->id] = $tmpObj;
        }
        $rawData = array();
        foreach($tmparray as $key => $val)
        {
            $rawData[] = $val;
        }
        $arrayDataProvider=new CArrayDataProvider($rawData, 
                                    array(
                                        'id'=>'id',
                                    )
                    );
        return $arrayDataProvider;
//        $options = array('criteria'=>$criteria,);
//        Yii::app()->controller->setDefaultGVProviderOptions($options);
//        return new CActiveDataProvider($this
//                , $options
//                );
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Person the static model class
     */
    public static function model( $className=__CLASS__ )
    {
        return parent::model( $className );
    }

}
/*
 * 
 * 
 SELECT DISTINCT l.* FROM people LEFT OUTER JOIN orderpeople op ON people.id = op.person_id LEFT OUTER JOIN orders o ON op.order_id = o.id LEFT OUTER JOIN orderaddresses oa ON o.id = oa.order_id LEFT OUTER JOIN locations l ON oa.location_id = l.id
WHERE op.person_id = 5 AND oa.type ='Shipping' AND op.type='Customer'


SELECT DISTINCT `ordershipaddresses`.`id` AS `t1_c0`, `ordershipaddresses`.`street` AS `t1_c1`, `ordershipaddresses`.`locality` AS `t1_c2`, `ordershipaddresses`.`city` AS `t1_c3`, `ordershipaddresses`.`state` AS `t1_c4`, `ordershipaddresses`.`country` AS `t1_c5`, `ordershipaddresses`.`pincode` AS `t1_c6`, `ordershipaddresses`.`remarks` AS `t1_c7`, `ordershipaddresses`.`created_at` AS `t1_c8`, `ordershipaddresses`.`updated_at` AS `t1_c9` 
FROM `locations` `ordershipaddresses`  
LEFT OUTER JOIN `orderaddresses` `orderaddresses` ON (`orderaddresses`.`location_id`=`ordershipaddresses`.`id`) 
LEFT OUTER JOIN `orders` `customerorders` ON (`customerorders`.`id`=`orderaddresses`.`order_id`) 
LEFT OUTER JOIN `orderpeople` `orderpeople` ON (`orderpeople`.`order_id`=`customerorders`.`id`) 
WHERE (orderpeople.type="Customer") AND (`orderpeople`.`person_id`=5) AND orderaddresses.type ='Shipping'
 * 
 */