<?php

/**
 * This is the model class for table "mailqueues".
 *
 * The followings are the available columns in table 'mailqueues':
 * @property string $id
 * @property string $event_id
 * @property string $mailids
 * @property string $subject
 * @property string $mail_body
 * @property string $status
 * @property integer $attempts
 * @property string $last_attempt_on
 * @property string $created_at
 * @property string $updated_at
 */
class Mailqueue extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mailqueues';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject, mail_body, updated_at', 'required'),
			array('attempts', 'numerical', 'integerOnly'=>true),
			array('event_id', 'length', 'max'=>10),
			array('subject', 'length', 'max'=>128),
			array('mail_body', 'length', 'max'=>1024),
			array('status', 'length', 'max'=>12),
			array('mailids, last_attempt_on, created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_id, mailids, subject, mail_body, status, attempts, last_attempt_on, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'event_id' => 'Event',
			'mailids' => 'Mailids',
			'subject' => 'Subject',
			'mail_body' => 'Mail Body',
			'status' => 'Status',
			'attempts' => 'Attempts',
			'last_attempt_on' => 'Last Attempt On',
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
		$criteria->compare('event_id',$this->event_id,true);
		$criteria->compare('mailids',$this->mailids,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('mail_body',$this->mail_body,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('attempts',$this->attempts);
		$criteria->compare('last_attempt_on',$this->last_attempt_on,true);
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
	 * @return Mailqueue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
