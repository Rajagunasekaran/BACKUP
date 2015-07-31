<?php

/**
 * This is the model class for table "poslogreport".
 *
 * The followings are the available columns in table 'poslogreport':
 * @property integer $sno
 * @property string $date
 * @property string $barcode
 * @property integer $previous_stock
 * @property integer $current_stock
 * @property integer $sold_out
 * @property integer $today_purchase
 * @property integer $current_aval_stock
 * @property integer $log_status
 * @property string $updated_at
 */
class Poslogreport extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'poslogreport';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, barcode, previous_stock, current_stock, sold_out, today_purchase,rtn_product_quantity, current_aval_stock, log_status, updated_at', 'required'),
			array('previous_stock, current_stock, sold_out, today_purchase,rtn_product_quantity, current_aval_stock, log_status', 'numerical', 'integerOnly'=>true),
			array('barcode', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sno, date, barcode, previous_stock, current_stock, sold_out, today_purchase,rtn_product_quantity, current_aval_stock, log_status, updated_at', 'safe', 'on'=>'search'),
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
			'sno' => 'Sno',
			'date' => 'Date',
			'barcode' => 'Barcode',
			'previous_stock' => 'Previous Stock',
			'current_stock' => 'Current Stock',
			'sold_out' => 'Sold Out',
			'today_purchase' => 'Today Purchase',
                    'rtn_product_quantity'=>'Returned/Cancel',
                     'stock_adjustment' => 'Stock Adjustment',
 			'current_aval_stock' => 'Current Aval Stock',
			'log_status' => 'Log Status',
			'updated_at' => 'Updated At',
		);
	}
        public function afterfind()
        {
//           $dateformat = Yii::app()->controller->cJuiDatePickerViewFormat;
//           $this->date = $this->getDisplaydate();
//           if(empty($this->date)) $this->date = date($dateformat);
          
           $dateformat = Yii::app()->controller->boosterTbDateRangePickerFormatHMS;
           $this->updated_at = $this->getUpdated_at();
           if(empty($this->updated_at)) $this->updated_at = date($dateformat);
           parent::afterFind();
        }
        
        public function getDisplaydate()
       {
           $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
           $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->date, $dateformat, false);
           return $fdate;
       } 
       public function getUpdated_at()
       {
           $dateformat = Yii::app()->controller->datetimemysqlformatDMYHI;
           $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->updated_at, $dateformat, false);
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
        
        //Display the product history individually
        public function displayStockHistory($id)
       {
        
        $rowsql = "select sku from subproductprices where id=$id";
        $result = Yii::app()->db->createCommand( $rowsql )->queryScalar();       
        $criteria=new CDbCriteria;         
       $criteria->compare('t.barcode',$result,true); 
       $date=$this->date;
//               if(!empty($date))
//               {
//                   $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
//               }
       $criteria->compare('date',$date,true);
       $criteria->compare('t.barcode',$this->barcode);
       $criteria->compare('t.previous_stock',$this->previous_stock);
       $criteria->compare('t.sold_out',$this->sold_out);
       $criteria->compare('t.today_purchase',$this->today_purchase);
       $criteria->compare('t.rtn_product_quantity',$this->rtn_product_quantity);
       $criteria->compare('t.stock_adjustment',$this->stock_adjustment);
       $criteria->compare('t.current_aval_stock',$this->current_aval_stock);
       $createddate=$this->updated_at;
               if(!empty($createddate))
               {
                   $createddate = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $createddate)));
               }
       $criteria->compare('t.updated_at',$createddate,true);
       $criteria->addCondition('log_status=1');
       $options = array('criteria'=>$criteria,);
               return new CActiveDataProvider($this
                       , $options
       );
               
       }
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
              
                $criteria->compare('t.sno',$this->sno);
		$criteria->compare('t.date',$this->date,true);
		$criteria->compare('t.barcode',$this->barcode,true);
		$criteria->compare('t.previous_stock',$this->previous_stock);
		$criteria->compare('t.current_stock',$this->current_stock);
		$criteria->compare('t.sold_out',$this->sold_out);
		$criteria->compare('t.today_purchase',$this->today_purchase);
                $criteria->compare('t.stock_adjustment',$this->stock_adjustment);
		$criteria->compare('t.current_aval_stock',$this->current_aval_stock);
		$criteria->compare('t.log_status',$this->log_status);
		$criteria->compare('t.updated_at',$this->updated_at,true);
                $criteria->condition='log_status=1';  
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Poslogreport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
