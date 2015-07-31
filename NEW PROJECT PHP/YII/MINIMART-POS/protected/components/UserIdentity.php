<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */           
    private $_id;
    private $_su;
    private $_admin;
    public $isPassencoded;
    
    
    public function authenticate()
    {
        $this->setState(Helper::CONST_SU, false);
        $this->setState(Helper::CONST_Admin, false);
        $this->setState(Helper::CONST_Non_su, false);
        if(strtolower($this->username) 
                === strtolower(Helper::CONST_SU))
        {
            $this->suLogin();
        }
        else
        {
            $this->nonSuLogin();
        }
        return !$this->errorCode;
    }    
    private function suLogin()
    {
        $rtnisnonsu = false;
        $appConfigs = array();
        $rtn = Yii::app()->controller->checkForLogin($this->username, $this->password, $this->isPassencoded, $appConfigs, Helper::CONST_SU, $rtnisnonsu);
        if(!is_a($rtn, 'Personcompanyrole'))        
        {
            $this->errorCode= Helper::CONST_InvalidUserPassword;
            return;
        }
        $this->_id=$rtn->id;
        $this->setUserStates(true, false, false, $rtn, $appConfigs);
    }
    private function setUserStates($issu, $isnonsu, $isadmin, &$record, $appConfigs)
    {
        $this->setState('appConfigs', $appConfigs);
        $this->setState('title', (($issu || $isnonsu)?$record->login->login:$record->person->name));
        $this->setState(Helper::CONST_SU, $issu);
        $this->setState(Helper::CONST_Non_su, $isnonsu);
        $this->setState(Helper::CONST_Admin, $isadmin);
        if($issu || $isnonsu)
        {
            $companymodels = $this->getAllCompanies();
            if(!isset($companymodels[0])) $companymodels[0] = new Company();
            $record->company = $companymodels[0];
        }
        else
        {
            $this->setState('person', (isset($record->person))?$record->person:null);
            $this->setState('role', $record->role);
            $this->setState('login',$record->login);
            $companymodels = array($record->company);            
        }
        $this->setState('company', $record->company);
        $this->setCompaniesLookupInState($companymodels);
        $this->setRegister($record);
        $this->errorCode=self::ERROR_NONE;
    }
    public function setRegister($record)
    {
        if(strtolower($record->role->role) 
                                    === strtolower(Helper::CONST_Sales))
        {
            $loginid = $record->login->id;
            $roleid = $record->role->id;
            $criteria=new CDbCriteria;
            $criteria->addCondition('login_id = :loginid AND role_id=:roleid
                    AND DATE(salesdate) = DATE(NOW())
                    AND open_time IS NOT NULL
                    AND close_time IS NULL');
            $criteria->params = array(':loginid' => $loginid, ':roleid' => $roleid, );
            $result = Register::model()->findAll($criteria);
            if(empty($result))
            {
                $result = null;
                $register = new Register;
                $register->login_id = $loginid;
                $register->role_id = $roleid;
                $register->salesdate = date(Yii::app()->controller->datetimemysqlformatYMD);
                $register->op_balance = null;
                $rtn = $register->save();
                if($rtn)
                {
                    $result = $register;
                }
            }
            else
            {
                $result = $result[0];
            }
            $this->setState('register',$result);
        }
        else
        {
            $this->setState('register',null);
        }
    }
    private function nonSuLogin()
    {
        $rtnisnonsu = false;
        $appConfigs = array();
        $rtn = Yii::app()->controller->checkForLogin($this->username, $this->password, $this->isPassencoded, $appConfigs, Helper::CONST_Non_su, $rtnisnonsu);
        if(!is_a($rtn, 'Personcompanyrole'))
        {
            $this->errorCode= Helper::CONST_InvalidUserPassword;
            return;
        }
        
        $isadmin = false;
        if(!$rtnisnonsu)
        {
            $isadmin = strtolower($rtn->role->role) === strtolower(Helper::CONST_Admin);
        }
        $this->_id=$rtn->id;
        $this->setUserStates(false, $rtnisnonsu, $isadmin, $rtn, $appConfigs);
    }
    
    private function getAllCompanies()
    {
        $companymodels = Company::model()->findAll();
        return $companymodels;
    }
    public function setCompaniesLookupInState($companymodels)
    {
        $companies = CHtml::listData($companymodels, 'id', 'name');        
        $this->setState('companies', $companies);
    }    
    public function getId()
    {
        return $this->_id;
    }
    public function getSU(){
        return $this->_su;
    }
    public function getAdmin(){
        return $this->_admin;
    }
}