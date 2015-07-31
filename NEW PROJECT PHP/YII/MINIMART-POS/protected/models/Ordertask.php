<?php

/**
 * This is the model class for table "ordertasks".
 *
 * The followings are the available columns in table 'ordertasks':
 * @property string $id
 * @property string $order_id
 * @property string $order_type
 * @property string $task_id
 * @property string $details
 * @property string $start_at
 * @property string $end_at
 * @property string $started_at
 * @property string $closed_at
 * @property string $completed
 * @property string $completed_at
 * @property string $completed_remarks
 * @property string $status
 * @property string $invstatus
 * @property string $cost
 * @property string $amount
 * @property string $taxper
 * @property string $tax
 * @property integer $alertbefore
 */
class Ordertask extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ordertasks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, order_type, task_id', 'required'),
			array('alertbefore', 'numerical', 'integerOnly'=>true),
			array('order_id, task_id, completed, cost, amount, taxper, tax', 'length', 'max'=>10),
			array('order_type, status, invstatus', 'length', 'max'=>12),
			array('details, completed_remarks', 'length', 'max'=>1024),
			array('start_at, end_at, started_at, closed_at, completed_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, order_type, task_id, details, start_at, end_at, started_at, closed_at, completed, completed_at, completed_remarks, status, invstatus, cost, amount, taxper, tax, alertbefore', 'safe', 'on'=>'search'),
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
                    'task' => array(self::BELONGS_TO, 'Task', 'task_id'),
                    'accountorders' => array(self::HAS_MANY, 'Accountorder', 'ordertask_id'),
                    'apaccount' => array(self::HAS_ONE, 'Account', 'account_id'
                        , 'through'=>'accountorders'
                        ,'condition' => 'accounttype="'.Helper::CONST_Payables.'"'),
                    'araccount' => array(self::HAS_ONE, 'Account', 'account_id'
                        , 'through'=>'accountorders'
                        ,'condition' => 'accounttype="'.Helper::CONST_Receivables.'"'),
                    'ordertaskpeople' => array(self::HAS_MANY, 'Ordertaskperson', 'ordertask_id'),
                    'contractor' => array(self::HAS_ONE, 'Person', 'person_id'
                        , 'through'=>'ordertaskpeople'
                        ,'condition' => 'LCASE(ordertaskpeople.type)="'.strtolower(Helper::CONST_Contractor).'"'
                        ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => Yii::app()->controller->getMenuLabels(Helper::CONST_Order),
			'order_type' => 'Order Type',
			'task_id' => 'Task',
			'details' => 'Details',
			'start_at' => 'Start',
			'end_at' => 'End',
			'started_at' => 'Started On',
			'closed_at' => 'Closed On',
			'completed' => '%-Completion',
			'completed_at' => 'Completed Date',
			'completed_remarks' => 'Remarks',
			'status' => 'Status',
			'invstatus' => 'Invstatus',
			'cost' => 'Payable to Contractor',
			'amount' => 'Bill to Customer',
			'taxper' => 'Taxper',
			'tax' => 'Tax',
			'alertbefore' => 'Alertbefore',
		);
	}
        public function getDisplayStart_at()
        {
            $fdate = $this->start_at;
            $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
            $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->start_at, $dateformat, false);
            return $fdate;
        }
        public function getDisplayEnd_at()
        {
            $fdate = $this->end_at;
            $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
            $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->end_at, $dateformat, false);
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
                $criteria->with = array('order', 'task');
                
		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('LCASE(t.order_id)',strtolower($this->order_id),true);
		$criteria->compare('t.order_type',$this->order_type,true);
		$criteria->compare('LCASE(task.name)',strtolower($this->task_id),true);
		$criteria->compare('LCASE(t.details)',strtolower($this->details),true);
		$criteria->compare('t.start_at',$this->start_at,true);
		$criteria->compare('t.end_at',$this->end_at,true);
		$criteria->compare('t.started_at',$this->started_at,true);
		$criteria->compare('t.closed_at',$this->closed_at,true);
		$criteria->compare('t.completed',$this->completed,true);
		$criteria->compare('t.completed_at',$this->completed_at,true);
		$criteria->compare('t.completed_remarks',$this->completed_remarks,true);
		$criteria->compare('t.status',$this->status,true);
		$criteria->compare('t.invstatus',$this->invstatus,true);
		$criteria->compare('t.cost',$this->cost,true);
		$criteria->compare('t.amount',$this->amount,true);
		$criteria->compare('t.taxper',$this->taxper,true);
		$criteria->compare('t.tax',$this->tax,true);
		$criteria->compare('t.alertbefore',$this->alertbefore);

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
	 * @return Ordertask the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
