<?php

/**
 * This is the model class for table "persontimeslots".
 *
 * The followings are the available columns in table 'persontimeslots':
 * @property string $id
 * @property string $slotdate
 * @property string $person_id
 * @property string $ts1
 * @property string $ts2
 * @property string $ts3
 * @property string $ts4
 * @property string $ts5
 * @property string $ts6
 * @property string $ts7
 * @property string $ts8
 * @property string $ts9
 * @property string $ts10
 * @property string $ts11
 * @property string $ts12
 * @property string $ts13
 * @property string $ts14
 * @property string $ts15
 * @property string $ts16
 * @property string $ts17
 * @property string $ts18
 * @property string $ts19
 * @property string $ts20
 * @property string $ts21
 * @property string $ts22
 * @property string $ts23
 * @property string $ts24
 * @property string $created_at
 * @property string $updated_at
 */
class Persontimeslot extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'persontimeslots';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person_id', 'required'),
			array('person_id, ts1, ts2, ts3, ts4, ts5, ts6, ts7, ts8, ts9, ts10, ts11, ts12, ts13, ts14, ts15, ts16, ts17, ts18, ts19, ts20, ts21, ts22, ts23, ts24', 'length', 'max'=>10),
			array('slotdate, created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, slotdate, person_id, ts1, ts2, ts3, ts4, ts5, ts6, ts7, ts8, ts9, ts10, ts11, ts12, ts13, ts14, ts15, ts16, ts17, ts18, ts19, ts20, ts21, ts22, ts23, ts24, created_at, updated_at', 'safe', 'on'=>'search'),
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
                'person' => array(self::BELONGS_TO, 'Person', 'person_id',),
            );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'slotdate' => 'Date',
			'person_id' => Yii::app()->controller->getMenuLabels( 'Person' ),
			'ts1' => '00-01',
			'ts2' => '01-02',
			'ts3' => '02-03',
			'ts4' => '03-04',
			'ts5' => '04-05',
			'ts6' => '05-06',
			'ts7' => '06-07',
			'ts8' => '07-08',
			'ts9' => '08-09',
			'ts10' => '09-10',
			'ts11' => '10-11',
			'ts12' => '11-12',
			'ts13' => '12-13',
			'ts14' => '13-14',
			'ts15' => '14-15',
			'ts16' => '15-16',
			'ts17' => '16-17',
			'ts18' => '17-18',
			'ts19' => '18-19',
			'ts20' => '19-20',
			'ts21' => '20-21',
			'ts22' => '21-22',
			'ts23' => '22-23',
			'ts24' => '23-24',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}
        public function beforeSave()
        {
            if ( parent::beforeSave() )
            {
                //$this->id > 0;                
                if(!$this->isNewRecord)
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
        public function getDisplayTs1() 
        {
          return  $this->getDisplaySlotValue($this->ts1);
        }
        public function getDisplayTs2() 
        {
          return  $this->getDisplaySlotValue($this->ts2);
        }
        public function getDisplayTs3() 
        {
          return  $this->getDisplaySlotValue($this->ts3);
        }
        public function getDisplayTs4() 
        {
          return  $this->getDisplaySlotValue($this->ts4);
        }
        public function getDisplayTs5() 
        {
          return  $this->getDisplaySlotValue($this->ts5);
        }
        public function getDisplayTs6() 
        {
          return  $this->getDisplaySlotValue($this->ts6);
        }
        public function getDisplayTs7() 
        {
          return  $this->getDisplaySlotValue($this->ts7);
        }
        public function getDisplayTs8() 
        {
          return  $this->getDisplaySlotValue($this->ts8);
        }
        public function getDisplayTs9() 
        {
          return  $this->getDisplaySlotValue($this->ts9);
        }
        public function getDisplayTs10() 
        {
          return  $this->getDisplaySlotValue($this->ts10);
        }
        public function getDisplayTs11() 
        {
          return  $this->getDisplaySlotValue($this->ts11);
        }
        public function getDisplayTs12() 
        {
          return  $this->getDisplaySlotValue($this->ts12);
        }
        public function getDisplayTs13() 
        {
          return  $this->getDisplaySlotValue($this->ts13);
        }
        public function getDisplayTs14() 
        {
          return  $this->getDisplaySlotValue($this->ts14);
        }
        public function getDisplayTs15() 
        {
          return  $this->getDisplaySlotValue($this->ts15);
        }
        public function getDisplayTs16() 
        {
          return  $this->getDisplaySlotValue($this->ts16);
        }
        public function getDisplayTs17() 
        {
          return  $this->getDisplaySlotValue($this->ts17);
        }
        public function getDisplayTs18() 
        {
          return  $this->getDisplaySlotValue($this->ts18);
        }
        public function getDisplayTs19() 
        {
          return  $this->getDisplaySlotValue($this->ts19);
        }
        public function getDisplayTs20() 
        {
          return  $this->getDisplaySlotValue($this->ts20);
        }
        public function getDisplayTs21() 
        {
          return  $this->getDisplaySlotValue($this->ts21);
        }
        public function getDisplayTs22()
        {
          return  $this->getDisplaySlotValue($this->ts22);
        }
        public function getDisplayTs23() 
        {
          return  $this->getDisplaySlotValue($this->ts23);
        }
        public function getDisplayTs24() 
        {
          return  $this->getDisplaySlotValue($this->ts24);
        }
        
        
        public function getDisplaySlotValue($value)
        {
            $rtn = $value;
            if($rtn >= Helper::CONST_yellow_ordercount 
                    && $rtn < Helper::CONST_red_ordercount)
            {
                $rtn = '<div style="background-color:brown;color:white;padding:0;font-size:16">' . $rtn .'</div>';
            }
            else if($rtn >= Helper::CONST_red_ordercount)
            {
                $rtn = '<div style="background-color:red;color:white;padding:0;font-size:16">' . $rtn .'</div>';
            }
            else if(!empty($rtn))
            {
                $rtn = '<div style="background-color:green;color:white;padding:0;font-size:16">' . $rtn .'</div>';
            }
            return $rtn;
        }
        public function getDisplayPerson()
        {
            $rtn = '';
            if(!empty($this->person))
            {
                $rtn = $this->person->name;
                if($this->person->enablepplcode)
                {
                    $rtn = "  [$this->person->code] " . $rtn;
                }
            }            
            return $rtn;
        }
        public function getDisplaySlotdate()
        {
            $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
            $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->slotdate, $dateformat, false);
            return $fdate;
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

		$criteria=new CDbCriteria(
                        array(
                            'order'=>'t.slotdate desc, person.name asc',
                            'with' => array('person')
                            )
                        );
                if(!empty($this->slotdate)
                        && strtolower( $this->slotdate ) !== strtolower( Helper::CONST_ALL ))
                {
                    $reqdate = Yii::app()->controller->getDateFromNouns($this->slotdate);                    
                    if(!empty($reqdate))
                    {
                        $criteria->addCondition('DATE(slotdate) = DATE("'. $reqdate .'")');   
                    }
                }
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
	 * @return Persontimeslot the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
