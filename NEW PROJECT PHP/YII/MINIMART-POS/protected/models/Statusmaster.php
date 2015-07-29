<?php

/**
 * This is the model class for table "statusmasters".
 *
 * The followings are the available columns in table 'statusmasters':
 * @property string $id
 * @property string $ofwhich
 * @property string $name
 * @property string $display
 * @property string $desc
 */
class Statusmaster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'statusmasters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ofwhich, name, display', 'required'),
			array('ofwhich', 'length', 'max'=>10),
			array('name, display, desc', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ofwhich, name, display, desc', 'safe', 'on'=>'search'),
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
			'ofwhich' => 'Ofwhich',
			'name' => 'Name',
			'display' => 'Display',
			'desc' => 'Desc',
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
		$criteria->compare('ofwhich',$this->ofwhich,true);
                $criteria->compare('LCASE(name)',$this->name,true);
                $criteria->compare('LCASE(display)',$this->display,true);
                $criteria->compare('LCASE(desc)',$this->desc,true);
                //$criteria->addSearchCondition('LCASE(name)', "$this->name", false);
//                $criteria->addSearchCondition('display', "$this->display", false);
//                $criteria->addSearchCondition('desc', "$this->desc", false);
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
	 * @return Statusmaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getStatusByNameOrId($name, $ofwhich = 1, $isId = false)
        {
            $cndn = 't.ofwhich=:ofwhich';
            if($isId)
            {
                $cndn .= ' AND t.id=:name';
            }
            else
            {
                $cndn .= ' AND LCASE(t.name)=LCASE(:name)';
            }
            
            $params = array(':name' => $name, ':ofwhich' => $ofwhich);
            $criteria=new CDbCriteria(array(
                                    'condition' => $cndn,
                                    'params'=> $params,
                            ));
            $statuses = $this->findAll($criteria);

            $status= null;
            if(count($statuses) > 0)
            {
                $status= $statuses[0];
            }
            return $status;
        }
}
