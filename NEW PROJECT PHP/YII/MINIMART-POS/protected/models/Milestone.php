<?php

/**
 * This is the model class for table "milestones".
 *
 * The followings are the available columns in table 'milestones':
 * @property string $id
 * @property string $person_id
 * @property string $order_id
 * @property string $details
 * @property string $remarks
 * @property string $start_at
 * @property string $end_at
 * @property integer $alertbefore
 * @property string $completed
 * @property string $completed_at
 * @property string $completed_remarks
 * @property string $mailids
 * @property integer $mailcount
 * @property string $lastmailsent_at
 * @property string $started_at
 * @property string $closed_at
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Milestone extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'milestones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person_id, order_id, details, updated_at', 'required'),
			array('alertbefore, mailcount', 'numerical', 'integerOnly'=>true),
			array('person_id, order_id, completed', 'length', 'max'=>10),
			array('details, completed_remarks', 'length', 'max'=>1024),
			array('remarks', 'length', 'max'=>256),
			array('status', 'length', 'max'=>12),
			array('start_at, end_at, completed_at, mailids, lastmailsent_at, started_at, closed_at, created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, person_id, order_id, details, remarks, start_at, end_at, alertbefore, completed, completed_at, completed_remarks, mailids, mailcount, lastmailsent_at, started_at, closed_at, status, created_at, updated_at', 'safe', 'on'=>'search'),
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
                    'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
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
			'order_id' => Yii::app()->controller->getMenuLabels(Helper::CONST_Order),
			'details' => 'Name',
			'remarks' => 'Remarks',
			'start_at' => 'Start',
			'end_at' => 'End At',
			'alertbefore' => 'Alert Before',
			'completed' => 'Completed',
			'completed_at' => 'Completed At',
			'completed_remarks' => 'Completed Remarks',
			'mailids' => 'Send Alerts to',
			'mailcount' => 'Mailcount',
			'lastmailsent_at' => 'Lastmailsent At',
			'started_at' => 'Started At',
			'closed_at' => 'Closed At',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}
        public function getDisplayStart_at()
        {
            $fdate = $this->start_at;
            $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
            $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->start_at, $dateformat, false);
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('person_id',$this->person_id,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('details',$this->details,true);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('start_at',$this->start_at,true);
		$criteria->compare('end_at',$this->end_at,true);
		$criteria->compare('alertbefore',$this->alertbefore);
		$criteria->compare('completed',$this->completed,true);
		$criteria->compare('completed_at',$this->completed_at,true);
		$criteria->compare('completed_remarks',$this->completed_remarks,true);
		$criteria->compare('mailids',$this->mailids,true);
		$criteria->compare('mailcount',$this->mailcount);
		$criteria->compare('lastmailsent_at',$this->lastmailsent_at,true);
		$criteria->compare('started_at',$this->started_at,true);
		$criteria->compare('closed_at',$this->closed_at,true);
		$criteria->compare('status',$this->status,true);
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
	 * @return Milestone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
