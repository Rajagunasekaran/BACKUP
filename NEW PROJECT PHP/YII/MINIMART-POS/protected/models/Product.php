<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property string $id
 * @property integer $enableprdcode
 * @property string $code
 * @property string $name
 * @property string $desc
 * @property string $remarks
 * @property integer $enableprdauxname
 * @property string $auxname
 * @property string $taxrate_id
 * @property string $tax
 * @property string $manufacturer
 * @property string $supplier_id
 * @property string $color
 * @property string $size
 * @property string $unit_cp
 * @property integer $sptype
 * @property string $unit_sp_per
 * @property string $unit_sp
 * @property string $discper
 * @property string $disc
 * @property string $sku
 * @property integer $stock
 * @property string $stockvalue
 * @property integer $rol
 * @property integer $moq
 * @property string $imagepath
 * @property string $dontsyncwithstock
 * @property string $person_id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Product extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('name, taxrate_id, person_id,', 'required'),
                    array('name', 'unique', 'on' => 'insert', 
                        'message' => '{attribute}:{value} already exists!'),
                    array('enableprdcode, enableprdauxname, sptype, stock, rol, moq', 'numerical', 'integerOnly'=>true),
                    array('code', 'length', 'max'=>16),
                    array('name, desc, auxname, manufacturer, color, size, sku', 'length', 'max'=>128),
                    array('taxrate_id, tax, supplier_id, unit_cp, unit_sp_per, 
                        unit_sp, stockvalue, person_id', 'length', 'max'=>10),
                    array('imagepath', 'length', 'max'=>1024),
                    array('code, sku, supplier_id, remarks, category_id 
                        ,display, idCombined, created_at, updated_at, discper, 
                        disc,dontsyncwithstock, status, spminusdisc, value, label', 'safe'),
//                    array('code','checkCode'),
//                    array('sku','checkSKU'),
//                    array('dontsyncwithstock','checkDontsyncwithstock'),
                    array('unit_cp, unit_sp', 'checkMinimum', array('minimum'=>  Helper::CONST_Number0)),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
//       FOR REFERENCE WHICH FROM PRODUCT.PHP         			array('id, product_id, code, sku, supplier_id, unit_cp, sptype, unit_sp_per, unit_sp, stock, stockvalue, rol, moq, dontsyncwithstock, status, tax, disc, created_at, updated_at', 'safe', 'on'=>'search'),

                    array('id, enableprdcode, code, sku,
                        desc, remarks, enableprdauxname, auxname, taxrate_id, 
                        tax, manufacturer, supplier_id, color, size, unit_cp, sptype,
                        unit_sp_per, unit_sp, discper, disc, 
                        sku, stock, stockvalue, rol, moq, imagepath, 
                        dontsyncwithstock, person_id, status, 
                        created_at, updated_at', 'safe', 'on'=>'search'),
            );
	}
        public function checkCode($attribute, $params)
        {
            return $this->checkCodeOrSKU();
        }
        public function checkSKU($attribute, $params)
        {
            return $this->checkCodeOrSKU();
        }
        public function checkDontsyncwithstock($attribute, $params)
        {
            return $this->checkCodeOrSKU();
        }
        public function checkCodeOrSKU()
        {
            if(empty($this->code) && empty($this->sku) && empty($this->dontsyncwithstock))
            {
                $this->addError('code', "Give Code/SKU or select Don't maintain on stock" );
                return false;
            }else if(empty($this->dontsyncwithstock))
            {
                if(empty($this->code) && empty($this->sku))
                {
                    $this->addError('code', "Give Code/SKU" );
                    return false;
                }
            }
            return true;
        }
        public function checkMinimum($attribute, $params)
        {
            $min = $params[0]['minimum'];
            if( $min > $this->$attribute)
            {
                $this->addError($attribute, $this->getAttributeLabel($attribute) . ": Should be >= " . $min );
            }
        }
        public function getMetaData()
        {
            $data = parent::getMetaData();
            $data->columns['category_id'] = array('name' => 'category_id');
//            $data->columns['adjusted_stock'] = array('name' => 'adjusted_stock');
//            $data->columns['display'] = array('name' => 'display');
//            $data->columns['idCombined'] = array('name' => 'idCombined');            
//            $data->columns['spminusdisc'] = array('name' => 'spminusdisc');
//            $data->columns['value'] = array('name' => 'value');
//            $data->columns['label'] = array('name' => 'label');
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
                'prdcategories' => array(self::HAS_MANY, 'Productcategory', 'product_id'),
                'categories' => array(self::HAS_MANY, 'Category', 'category_id',
                    'through'=>'prdcategories'),
                'supplier' => array(self::BELONGS_TO, 'Person', 'supplier_id'),
                'taxrate' => array(self::BELONGS_TO, 'Taxrate', 'taxrate_id'),                
                'productprices' => array(self::HAS_MANY, 'Productprice', 'product_id',
                    'condition' => 'productprices.status = 1',                  
                    'order'=> 'productprices.updated_at asc'
                    ), 
                  'subproductprices' => array(self::HAS_MANY, 'Subproductprice', 'product_id',
                    'condition' => 'subproductprices.status = 1'),
                'allproductprices' => array(self::HAS_MANY, 'Productprice', 'product_id',),
            );
	}
        
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Product',
                        'category_id' => 'Category[Type]',
			'enableprdcode' => 'Enableprdcode',
                        'status' => 'Status',
			'code' => 'Code',
			'name' => 'Name',
			'desc' => 'Description',
			'remarks' => 'Remarks',
			'enableprdauxname' => 'Enableprdauxname',
			'auxname' => 'Auxname',
			'taxrate_id' => 'Sales Tax %',
			'tax' => 'Tax Amount',
			'manufacturer' => 'Manufacturer',
			'supplier_id' => 'Supplier',
			'color' => 'Color',
			'size' => 'Size',
			'unit_cp' => 'Purchase Price',
			'sptype' => 'Sptype',
			'unit_sp_per' => 'Margin %',
			'unit_sp' => 'Selling Price',
                        'discper' => 'Discount %',
                        'disc' => 'Discount',
			'sku' => 'SKU[Barcode]',
			'stock' => 'Stock In Hand',
                        'qnty' => 'Quantity',
			'stockvalue' => 'Stock value',
			'rol' => 'Re-Order Level',
			'moq' => 'Min. Order Quantity',
			'imagepath' => 'Image',
                        'dontsyncwithstock'=> 'Don\'t Maintain Stock',
			'person_id' => 'Person',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}
        public function beforeSave()
        {
            if ( parent::beforeSave() )
            {
//                $codeok = $this->checkCodeOrSKU();
//                if(!$codeok) return $codeok;
                $isupdate = $this->id > 0;
                if($isupdate)
                {
                    $this->updated_at = new CDbExpression('NULL');
                }
                else
                {
                    $this->created_at = new CDbExpression('NULL'); 
                    $this->updated_at = new CDbExpression('NULL');
                    $this->status = 1;
                }
                if($this->dontsyncwithstock)
                {
                    $this->code = substr('nocode_' . rand(),0,16);
                }
                if(!empty($this->code))
                {
                    $this->sku = $this->code;
                }
                else if(!empty($this->sku) && empty($this->code))
                {
                    $this->code = $this->sku;
                }
                if(!empty($this->unit_sp)
                        && $this->unit_sp > 0 
                        && !empty($this->unit_cp) && $this->unit_cp > 0
                )
                {
                    $diff = $this->unit_sp - $this->unit_cp;
                    $this->unit_sp_per = round(($diff/$this->unit_cp * 100), 2);
                }
                else if(!empty($this->unit_sp_per) && $this->unit_sp_per > 0
                        && !empty($this->unit_cp) && $this->unit_cp > 0)
                {
                    $this->unit_sp = round(($this->unit_sp_per/100 * $this->unit_cp), 2);
                }
//                if(!empty($this->discper) && $this->discper >= 0)
//                {
//                    $this->disc = round(($this->discper/100 * $this->unit_sp), 2);
//                    //$this->unit_sp = $this->unit_sp - $this->disc;
//                }
//                if(!empty($this->taxrate_id) && $this->taxrate_id > 0)
//                {
//                    $taxrateobj = $this->taxrate;
//                    $taxtype = $taxrateobj->taxtype;
//                    
//                    $taxamount = $taxrateobj->taxrate;
//                    if(strtolower($taxtype) === strtolower(Helper::CONST_Percentage))
//                    {
//                        $taxamount = round(($taxamount/100 * $this->unit_sp), 2);
//                    }
//                    $this->tax = $taxamount;
//                }
//                $isstackadjust = is_numeric($this->adjusted_stock) && $this->adjusted_stock != $this->stock;
//                if($isstackadjust)
//                {
//                    $tmp = $this->stock - $this->adjusted_stock;
//                    $this->stock = $this->adjusted_stock;
//                    $cday = date('Y-m-d');
//                    if($tmp > 0){
//                        $this->remarks .= "\nLost " . $tmp . " on " . $cday;
//                    }else{
//                        $this->remarks .= "\nGained " . $tmp . " on " . $cday;
//                    }
//                }
//                $this->stockvalue = $this->stock * $this->unit_cp;
            }
            else
            {
                return false;
            }
            return true;
        }
        public function afterFind()
        {
//            $this->display = $this->name . ' @ ' . ($this->unit_sp - $this->disc);
//            $this->spminusdisc = ($this->unit_sp - $this->disc);            
//            $topcatid = 0;
//            $catid = 0;
//            if(!empty($this->categories))
//            {
//                $catid = $this->categories[0]->id;
//                $parent = $this->categories[0]->section;
//                if(!empty($parent))
//                {
//                    $topcatid = $parent->id;
//                }
//            }
//            $this->idCombined = $this->id . ":" . $catid . ":" . $topcatid;
//            $this->value = $this->idCombined;
//            $this->label= $this->display;
            if(!empty($this->categories))
            {
                $this->category_id = $this->categories[0]->id;
            }
            else
            {
                $this->category_id = 0;
            }
            parent::afterFind();
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
                $criteria->with = array('categories',
                'productprices' => array('with'=>array('supplier')));
		$criteria->compare('id',$this->id,true);
		$criteria->compare('enableprdcode',$this->enableprdcode);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('enableprdauxname',$this->enableprdauxname);
		$criteria->compare('auxname',$this->auxname,true);
		$criteria->compare('taxrate_id',$this->taxrate_id,true);
		$criteria->compare('tax',$this->tax,true);
		$criteria->compare('manufacturer',$this->manufacturer,true);
		$criteria->compare('supplier.id',$this->supplier_id);
                $criteria->compare('categories.id',$this->category_id);
                
		$criteria->compare('color',$this->color,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('unit_cp',$this->unit_cp,true);
		$criteria->compare('sptype',$this->sptype);
		$criteria->compare('unit_sp_per',$this->unit_sp_per,true);
		$criteria->compare('unit_sp',$this->unit_sp,true);
                $criteria->compare('discper',$this->discper,true);
		$criteria->compare('disc',$this->disc,true);                
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('stock',$this->stock);
		$criteria->compare('stockvalue',$this->stockvalue,true);

		$criteria->compare('rol',$this->rol);
		$criteria->compare('moq',$this->moq);
		$criteria->compare('imagepath',$this->imagepath,true);
		$criteria->compare('person_id',$this->person_id,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);               

		$options = array('criteria'=>$criteria,);
                 
                Yii::app()->controller->setDefaultGVProviderOptions($options);
		return new CActiveDataProvider($this
                        , $options
                        );
	}
	public function searchProduct()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('categories',
                'subproductprices' => array('with'=>array('supplier')));
		$criteria->compare('id',$this->id,true);
		$criteria->compare('enableprdcode',$this->enableprdcode);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('enableprdauxname',$this->enableprdauxname);
		$criteria->compare('auxname',$this->auxname,true);
		$criteria->compare('taxrate_id',$this->taxrate_id,true);
		$criteria->compare('tax',$this->tax,true);
		$criteria->compare('manufacturer',$this->manufacturer,true);
		$criteria->compare('supplier.id',$this->supplier_id);
                $criteria->compare('categories.id',$this->category_id);
                
		$criteria->compare('color',$this->color,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('unit_cp',$this->unit_cp,true);
		$criteria->compare('sptype',$this->sptype);
		$criteria->compare('unit_sp_per',$this->unit_sp_per,true);
		$criteria->compare('unit_sp',$this->unit_sp,true);
                $criteria->compare('discper',$this->discper,true);
		$criteria->compare('disc',$this->disc,true);                
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('stock',$this->stock);
		$criteria->compare('stockvalue',$this->stockvalue,true);

		$criteria->compare('rol',$this->rol);
		$criteria->compare('moq',$this->moq);
		$criteria->compare('imagepath',$this->imagepath,true);
		$criteria->compare('person_id',$this->person_id,true);
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
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}