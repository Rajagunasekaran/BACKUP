<?php

/**
 * This is the model class for table "orderproducts".
 *
 * The followings are the available columns in table 'orderproducts':
 * @property string $id
 * @property string $order_id
 * @property string $order_type
 * @property string $product_id
 * @property string $productprice_id
 * @property integer $quantity
 * @property integer $delivered
 * @property string $unit_sp
 * @property string $cost
 * @property string $amount
 * @property string $tax
 * @property string $discper
 * @property string $disc
 * @property string $description
 */
class Orderproduct extends CActiveRecord
{
        public $totalAmount;
        public $totalQuantity;
        public $billno;
        public $rptprdwse_namecol1;
        public $rptprdwse_namecol2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orderproducts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, order_type, productprice_id', 'required'),
			array('quantity, delivered', 'numerical', 'integerOnly'=>true),
			array('order_id, product_id, productprice_id, unit_sp, cost, amount, 
                            tax, discper, disc', 'length', 'max'=>10),
			array('order_type', 'length', 'max'=>12),
                        array('daterange, groupby, product_id', 'safe'),
                        //array('quantity','greaterthanzero'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, order_type, product_id, productprice_id,
                            quantity, delivered, unit_sp, cost, amount, 
                            tax, discper, disc, description, daterange, groupby ', 
                                'safe', 'on'=>'search'),
		);
	}
        
        public function getMetaData()
        {
            $data = parent::getMetaData();
            $this->addAdditionalColumns($data);
            return $data;
        }
        private function addAdditionalColumns(&$data)
        {
            $data->columns['daterange'] = array('name' => 'daterange');
            $data->columns['groupby'] = array('name' => 'groupby');
        }
        public function afterFind()
        {            
            parent::afterFind();
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
        public function greaterthanzero($attribute, $params)
        {
            $rtn = Yii::app()->controller->greaterthanzero($this->$attribute);
            if(!$rtn)
            {
                $this->addError($attribute, 'invalid number');
            }
            return $rtn;
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
                'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
                'productprice' => array(self::BELONGS_TO, 'Subproductprice', 'productprice_id'),  
//                'subproductprice' => array(self::BELONGS_TO, 'Subproductprice', 'productprice_id'),
            );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Order',
			'order_type' => 'Order Type',
			'product_id' => 'Product',
                        'productprice_id' => 'Product',                    
			'quantity' => 'Quantity',
			'delivered' => 'Delivered',
			'unit_sp' => 'Unit Selling Price',
			'cost' => 'Cost',
			'amount' => 'Amount',
			'tax' => 'Tax',
			'discper' => 'Discount %',
			'disc' => 'Discount',
                        'description' => 'Description',
                        'daterange' => 'Period',
                        'groupby' => 'Group by',
                        'rptprdwse_namecol1' => 'Name',
                        'rptprdwse_namecol2' => 'Product',
		);
	}
        public function searchSupplierProducts()
	{
            // @todo Please modify the following code to remove attributes that should not be searched.

            $criteria = new CDbCriteria( array (
            'order' => 'product.name asc',
                ) );
            $criteria->with = array ( 'product' => array(
                'select' => array('product.code,product.name '),
                'with' => array('supplier'=>array('select' => array('supplier.code,supplier.name'),))
                ) 
                ) ;
            //$criteria->group = 'supplier.id, product.id';
            $criteria->group = 'supplier.id';
            
            $criteria->select = 'sum(amount) as amount';
            if (!Yii::app()->request->isAjaxRequest) 
            {
                //$criteria->addCondition('1 = 0'); // You could also use 0, but I think this is more clear
            }
            $options = array('criteria'=>$criteria,);
            Yii::app()->controller->setDefaultGVProviderOptions($options);
            $dataProvider = new CActiveDataProvider($this, $options);
            return $dataProvider;
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
	public function search($id)
	{
            // @todo Please modify the following code to remove attributes that should not be searched.    
            $criteria = new CDbCriteria( array (
            'order' => 'product.name asc',
            'with' => array ( 'product' ) ) );
            $criteria->addCondition('order_id='.$id);
            $criteria->compare('order_id',$this->order_id,true);
            $criteria->compare('name',$this->product_id);
            $criteria->compare('t.quantity',$this->quantity);
            $criteria->compare('t.unit_sp',$this->unit_sp);
            $criteria->compare('t.tax',$this->tax);
            $criteria->compare('t.amount',$this->amount);
            if (!Yii::app()->request->isAjaxRequest) 
            {
                //$criteria->addCondition('1 = 0'); // You could also use 0, but I think this is more clear
            }
            $options = array('criteria'=>$criteria,);
            Yii::app()->controller->setDefaultGVProviderOptions($options);
            $dataProvider = new CActiveDataProvider($this, $options);
            return $dataProvider;
	}
        public function periodWiseSales()
	{
            $criteria=new CDbCriteria;
            $criteria->with = array(
                'productprice' => array(
                    'with'=> array(
                        'product',
                        'supplier' => array('select' => 'name',),
                         'prdcategories' =>array('together' => true,),
                        )
                    ),
                'order' => array(
                    'with'=> array('customer' => array('select' => 'name',))
                    ),
                );
            $criteria->order = 'totalAmount DESC';
            $ttlamountfld = array(                                    
                                    new CDbExpression("IFNULL(SUM(t.amount),0) as totalAmount"),
                                   );
            $prdnamefld = array('CONCAT(product.name," @ ", ROUND((productprice.unit_sp - productprice.disc),2)) as rptprdwse_namecol2');
            if(!empty($this->daterange))
            {
                $dateary = explode(" - ", $this->daterange);
                //check for ' - date' formatted input
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
            $groupby = $this->groupby;
            switch($groupby)
            {
                case Helper::CONST_Category:
                   $groupby = 'prdcategories.category_id, t.productprice_id';
                   $selectarray = array_merge(
                                  array('(select name from categories where id=prdcategories.category_id) as rptprdwse_namecol1'),
                                   $prdnamefld,
                                   $ttlamountfld
                               );
                   break;
                case Helper::CONST_Supplier:
                    $groupby = 'supplier.id, t.productprice_id';
                    $selectarray = array_merge(
                                    array('supplier.name as rptprdwse_namecol1'),
                                    $prdnamefld,
                                    $ttlamountfld
                                );
                    break;
                case Helper::CONST_Customer:
                    $groupby = 'customer.id, t.productprice_id';
                    $selectarray = array_merge(
                                    array('customer.name as rptprdwse_namecol1'),
                                    $prdnamefld,
                                    $ttlamountfld
                                );
                    break;
                default:
                    $groupby = 't.productprice_id';
                    $selectarray = array_merge(
                                    $prdnamefld,
                                    $ttlamountfld
                                );
                    break;
            }
            
            $criteria->select = $selectarray;
            $criteria->group = $groupby;
            if(!empty($startdate) && !empty($enddate))
            {
                $startdate = Yii::app()->controller->getMysqlFormattedDatetime($startdate);
                $enddate = Yii::app()->controller->getMysqlFormattedDatetime($enddate);
//                $tmp = "t.created_at <= '$startdate' AND t.created_at >= '$enddate'";
//                $criteria->addCondition($tmp);
                $criteria->addBetweenCondition('t.created_at', "$startdate" , "$enddate");
            }
            $options = array('criteria'=>$criteria,);
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        public function dayWiseItemSales()
	{
            $criteria=new CDbCriteria;
            $criteria->with = array(
                'productprice' => array(
                    'with'=> array(
                        'product',
                        )
                    ),
                );
            $criteria->order = 'totalAmount DESC';
            $ttlamountfld = array(                                    
                                    new CDbExpression("IFNULL(SUM(t.quantity),0) as totalQuantity"),
                                    new CDbExpression("IFNULL(SUM(t.amount),0) as totalAmount"),
                                   );
            
            $prdnamefld = array('CONCAT(product.name," @ ", ROUND((productprice.unit_sp - productprice.disc),2)) as rptprdwse_namecol2');
            
            $selectarray = array_merge(
                                    $prdnamefld,
                                    $ttlamountfld
                                );
            $criteria->select = $selectarray;
            $criteria->group = 't.productprice_id';
            
            $tmp = ' DATE(t.created_at) = DATE(NOW()) ';
            $criteria->addCondition($tmp);
            
            $options = array('criteria'=>$criteria,);
           
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
        public function listTopProducts()
        {
            $criteria=new CDbCriteria;
            $criteria->with = array(
                'product' => array(
                    'select' => 'name',
                    ),
                );            
            $criteria->order = 'totalAmount DESC';
            $criteria->select = array(
                            new CDbExpression("IFNULL(SUM(t.amount),0) as totalAmount"),
                );            
            $criteria->group = 'product_id';            
            $tmp = 't.created_at <= NOW() AND t.created_at >= DATE_SUB(NOW(), INTERVAL ' . Helper::CONST_TopProducts_days . ' DAY)';
            $criteria->addCondition($tmp);
            //SELECT * FROM orders WHERE end_at <= NOW() AND end_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            if (
                !Yii::app()->request->isAjaxRequest 
                && Helper::CONST_lazy_page_load
            )
            {
                $criteria->addCondition('1 = 0'); // You could also use 0, but I think this is more clear
            }
            $options = array('criteria'=>$criteria,);
            Yii::app()->controller->setDefaultGVProviderOptions($options);
            return new CActiveDataProvider($this
                , $options
                );
        }
        public function productWiseSales()
	{
            $criteria=new CDbCriteria;
            $criteria->with = array(
                'product' => array(
                    'select' => 'name',
                    ),
                );
            
            $criteria->select = array(
                            new CDbExpression("IFNULL(SUM(t.amount),0) as totalAmount"),
                            //new CDbExpression("order_id as bilorder_idlno"),
                );

            $criteria->group = 'product_id';
            
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
	 * @return Orderproduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}