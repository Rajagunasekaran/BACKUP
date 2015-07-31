<?php

/**
 * This is the model class for table "stockadjustment".
 *
 * The followings are the available columns in table 'stockadjustment':
 * @property integer $sno
 * @property string $referenceno
 * @property string $dateofadjustment
 * @property string $code
 * @property string $sku
 * @property integer $stock
 * @property integer $stock_adjustment
 * @property string $Remarks
 */
class Stockadjustment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stockadjustment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('referenceno, dateofadjustment, code, sku, Remarks', 'required'),
			array('product_id,stock, stock_adjustment', 'numerical', 'integerOnly'=>true),
			array('referenceno, code, sku', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sno,product_id, referenceno, dateofadjustment, code, sku, stock, stock_adjustment, Remarks', 'safe', 'on'=>'search'),
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
                    'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sno' => 'Sno',
			'referenceno' => 'Reference No',
			'dateofadjustment' => 'Date Of Adjustment',
                        'product_id' => 'Product',
			'code' => 'Code',
			'sku' => 'SKU[Barcode]',
			'stock' => 'Stock',
			'stock_adjustment' => 'Stock Adjustment',
			'Remarks' => 'Remarks',
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

		$criteria->compare('sno',$this->sno);
		$criteria->compare('referenceno',$this->referenceno,true);
		$criteria->compare('dateofadjustment',$this->dateofadjustment,true);
                $criteria->compare('name',$this->product_id,false);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('stock',$this->stock);
		$criteria->compare('stock_adjustment',$this->stock_adjustment);
		$criteria->compare('Remarks',$this->Remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function StockAdjustmentList()
        {
            $criteria=new CDbCriteria;
            $criteria->with = array('product');
            $criteria->compare('id',$this->product_id);
            $criteria->compare('t.code',$this->code,true);
            $criteria->compare('t.sku',$this->sku,true);
            if(!empty($this->dateofadjustment))
            {
                $dateary = explode(" - ", $this->dateofadjustment);
                $needle = "-";
                $tmpdt = trim(isset($dateary[0])?$dateary[0]:'');
                $isstartswithminus = ($needle === "" || strpos($tmpdt, $needle) === 0);
                if($isstartswithminus)
                {
                    $tmpdt = substr($tmpdt, strlen($needle), strlen($tmpdt) - strlen($needle));
                    $tmpdt = trim($tmpdt);
                }
                if(empty($tmpdt))
                {
                    $startdate = null;
                    $enddate = null;
                }else
                {
                    $startdate = $tmpdt;
                    $enddate = (isset($dateary[1])?$dateary[1]:$this->stdate);
                }                
            }
            else
            {
               $startdate = null;
               $enddate = null;
            }
            if(!empty($startdate) && !empty($enddate))
            {
                $startdate = Yii::app()->controller->getMysqlFormattedDatetime($startdate);
                $enddate = Yii::app()->controller->getMysqlFormattedDatetime($enddate);
                $criteria->addBetweenCondition('t.dateofadjustment', "$startdate" , "$enddate");
            }
//            $adjustmentdate=$this->dateofadjustment;
//            if(!empty($adjustmentdate))
//            {
//                $adjustmentdate = date('Y-m-d', strtotime(str_replace('/', '-', $adjustmentdate)));
//            }
//            $criteria->compare('t.dateofadjustment',$adjustmentdate);
            $criteria->order = 't.dateofadjustment DESC';
            
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                ));
        }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Stockadjustment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
