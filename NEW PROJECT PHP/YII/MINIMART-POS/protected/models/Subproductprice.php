<?php

/**
 * This is the model class for table "subproductprices".
 *
 * The followings are the available columns in table 'subproductprices':
 * @property string $id
 * @property string $product_id
 * @property string $code
 * @property string $sku
 * @property string $supplier_id
 * @property string $unit_cp
 * @property integer $sptype
 * @property string $unit_sp_per
 * @property string $unit_sp
 * @property integer $stock
 * @property string $stockvalue
 * @property integer $rol
 * @property integer $moq
 * @property integer $dontsyncwithstock
 * @property integer $status
 * @property string $tax
 * @property string $disc
 * @property string $created_at
 * @property string $updated_at
 */
class Subproductprice extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'subproductprices';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id, supplier_id, updated_at,invno,invdate,code,unit_sp,sku', 'required'),
            array('sptype, stock, rol, moq, dontsyncwithstock, status', 'numerical', 'integerOnly'=>true),
            array('product_id, supplier_id, unit_cp, unit_sp_per, unit_sp, stockvalue, tax, disc', 'length', 'max'=>10),
            array('code', 'length', 'max'=>16),
            array('sku', 'length', 'max'=>128),
            array('created_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_id, code, sku, supplier_id, unit_cp, sptype, unit_sp_per, unit_sp, stock, stockvalue, rol, moq, dontsyncwithstock, status, tax, disc, created_at, updated_at', 'safe', 'on'=>'search'),
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
            'prdcategories' => array(self::HAS_MANY, 'Masterproductcategory', 'productprice_id'),
            'categories' => array(self::HAS_MANY, 'Category', 'category_id',
                'through'=>'prdcategories'),
            'supplier' => array(self::BELONGS_TO, 'Person', 'supplier_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }


    public function afterFind()
    {
        $this->spminusdisc = round($this->unit_sp - $this->disc, 2);
        $this->name = $this->product->name.' '.$this->code . ' @ ' . $this->spminusdisc;
        $this->imagepath = $this->product->imagepath;
        if(!empty($this->categories))
        {
            $this->category_id = $this->categories[0]->id;
        }
        else
        {
            $this->category_id = 0;
        }
        $topcatid = 0;
        $catid = 0;
        if(!empty($this->categories))
        {
            $catid = $this->categories[0]->id;
            $parent = $this->categories[0]->section;
            if(!empty($parent))
            {
                $topcatid = $parent->id;
            }
        }
        $this->idCombined = $this->id . ":" . $catid . ":" . $topcatid;
        $this->value = $this->idCombined;
        $this->label= $this->name;
        $dateformat = Yii::app()->controller->cJuiDatePickerViewFormat;
//            $this->invdate = $this->getLastinvoicedate();
//            if(empty($this->invdate)) $this->invdate = null;
        parent::afterFind();

    }
    public function getLastinvoicedate()
    {
        $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
        $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->invdate, $dateformat, false);
        return $fdate;
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'product_id' => 'Product',
            'code' => 'Code',
            'sku' => 'SKU[Barcode]',
            'supplier_id' => 'Supplier',
            'unit_cp' => 'Purchase Price',
            'sptype' => 'Sptype',
            'unit_sp_per' => 'Margin %',
            'unit_sp' => 'Selling Price',
            'stock' => 'Stock',
            'invno' => 'Invoice No',
            'invdate'=>'Invoice Date',
            'stockvalue' => 'Stock Value',
            'rol' => 'ROL',
            'moq' => 'Moq',
            'dontsyncwithstock' => 'Dontsyncwithstock',
            'status' => 'Status',
            'tax' => 'Tax',
            'disc' => 'Discount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

        );
    }
    public function getMetaData()
    {
        $data = parent::getMetaData();
        $data->columns['category_id'] = array('name' => 'category_id');
        $data->columns['adjusted_stock'] = array('name' => 'adjusted_stock');
        $data->columns['name'] = array('name' => 'name');
        $data->columns['imagepath'] = array('name' => 'imagepath');
        $data->columns['idCombined'] = array('name' => 'idCombined');
        $data->columns['spminusdisc'] = array('name' => 'spminusdisc');
        $data->columns['value'] = array('name' => 'value');
        $data->columns['label'] = array('name' => 'label');
        return $data;
    }

    public function beforeSave()
    {
        if ( parent::beforeSave() )
        {
//                if($this->dontsyncwithstock == 1)
//                {
//                    $this->code = substr('nocode_' . rand(),0,16);
//                }
////                if(!empty($this->code))
////                {
////                    $this->sku = $this->code;
////                }
//                else if(!empty($this->sku) && empty($this->code))
//                {
//                    $this->code = $this->sku;
//                }
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
            if(!empty($this->product->discper) && $this->product->discper >= 0)
            {
                $this->disc = round(($this->product->discper/100 * $this->unit_sp), 2);
                //$this->unit_sp = $this->unit_sp - $this->disc;
            }
            if(!empty($this->product->taxrate_id) && $this->product->taxrate_id > 0)
            {
                $taxrateobj = $this->product->taxrate;
                $taxtype = $taxrateobj->taxtype;

                $taxamount = $taxrateobj->taxrate;
                if(strtolower($taxtype) === strtolower(Helper::CONST_Percentage))
                {
                    $taxamount = round(($taxamount/100 * $this->unit_sp), 2);
                }
                $this->tax = $taxamount;
            }
            $isstackadjust = is_numeric($this->adjusted_stock) && $this->adjusted_stock != $this->stock;
            if($isstackadjust)
            {
                $tmp = $this->stock - $this->adjusted_stock;
                $this->stock = $this->adjusted_stock;
                $cday = date('Y-m-d');
                if($tmp > 0){
                    $this->remarks .= "\nLost " . $tmp . " on " . $cday;
                }else{
                    $this->remarks .= "\nGained " . $tmp . " on " . $cday;
                }
            }
            $this->stockvalue = $this->stock * $this->unit_cp;
        }
        else
        {
            return false;
        }
        return true;
    }
    public function getStockcount(){
        $id=$this->id;
        $sku=$this->sku;
        $rowsql = "select stock from subproductprices where sku='".$sku."'";
        $stocksum = Yii::app()->db->createCommand( $rowsql )->queryScalar();
        if($stocksum)
            return $stocksum;
        else
            return 0;

    }
    public function listROLProducts(){
        $criteria=new CDbCriteria;
        $criteria->order = 'stock ASC';
        $criteria->addCondition('stock <= rol AND dontsyncwithstock != 1');
        if(!empty($this->product_id))
        {
            $criteria->compare('LCASE(name)',strtolower($this->product_id),true);
        }
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
        $criteria->with = array('product');

        $criteria->compare('t.id',$this->id,true);
        $criteria->compare('name',$this->product_id,false);
        $criteria->compare('t.code',$this->code,false);
        $criteria->compare('t.sku',$this->sku,false);

        $criteria->compare('t.unit_cp',$this->unit_cp,false);
        $criteria->compare('t.sptype',$this->sptype);
        $criteria->compare('t.unit_sp_per',$this->unit_sp_per,true);
        $criteria->compare('t.unit_sp',$this->unit_sp,false);
        $criteria->compare('t.stock',$this->stock);
        $criteria->compare('t.stockvalue',$this->stockvalue,true);
        $criteria->compare('t.rol',$this->rol);
        $criteria->compare('t.moq',$this->moq);
        $criteria->compare('t.status',$this->status);
        $criteria->compare('t.created_at',$this->created_at,true);
        $criteria->compare('t.updated_at',$this->updated_at,true);
        //$criteria->addCondition('dontsyncwithstock != 1');
        $options = array('criteria'=>$criteria,);
//                Yii::app()->controller->setDefaultGVProviderOptions($options);
        return new CActiveDataProvider($this
            , $options
        );
    }
    public $date;
    public function stockInventory()
    {
        $criteria=new CDbCriteria;
        $criteria->with = array('product');
        $criteria->compare( 'name', $this->product_id);
        $criteria->compare( 't.code', $this->code);
//            $date=$this->invdate;
//            if(!empty($date))
//             {
//               $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
//             }
//            $criteria->compare( 't.invdate', $date);
        $criteria->compare( 't.unit_cp', $this->unit_cp);
        $criteria->compare( 't.unit_sp', $this->unit_sp);
        $criteria->compare( 't.rol', $this->rol);
        $criteria->compare( 't.initial_stock', $this->stock);
        $criteria->compare( 't.invno', $this->invno);
        $options = array('criteria'=>$criteria,);
        return new CActiveDataProvider($this
            , $options
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Subproductprice the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

}
