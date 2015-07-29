<?php

/**
 * This is the model class for table "productprices".
 *
 * The followings are the available columns in table 'productprices':
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
 * @property integer $disc
 * @property integer $tax
 * @property string $created_at
 * @property string $updated_at
 */
class Productprice extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'productprices';
    }

    public $stockCount;
    public $keyField;

    public function displaySubproducts() {
        $criteria = new CDbCriteria;
        $criteria->select = array('sum(stock) as stockCount,t.*');
        $criteria->order = 't.created_at DESC';
        $criteria->group = 't.code';
        //$criteria->addCondition('dontsyncwithstock != 1');
        $options = array('criteria' => $criteria,);
        Yii::app()->controller->setDefaultGVProviderOptions($options);
        return new CActiveDataProvider($this
            , $options
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('invno,invdate,product_id, supplier_id,code,stock,unit_cp,stockinhand', 'required'),
            array('sptype, stock, rol, moq, status', 'numerical', 'integerOnly' => true),
            array('product_id, supplier_id, unit_cp, unit_sp_per, unit_sp,
                        stockvalue, disc, tax, ', 'length', 'max' => 10),
            array('code', 'length', 'max' => 16),
            array('sku', 'length', 'max' => 128),
            array('code, sku,
                        category_id , adjusted_stock, name,
                        imagepath,idCombined, spminusdisc, value, label,
                        tax, disc,dontsyncwithstock, status,expdate, created_at, updated_at',
                'safe'),
            array('unit_cp, unit_sp', 'checkMinimum', array('minimum' => Helper::CONST_Number0)),
//                        array('code','checkCode'),
//                        array('sku','checkSKU'),
//                        array('dontsyncwithstock','checkDontsyncwithstock'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_id, code, sku, supplier_id, unit_cp,
                        sptype, unit_sp_per, unit_sp, stock,expdate,invno,invdate, stockvalue, rol, moq,stockinhand,
                        dontsyncwithstock, status, disc, tax, created_at, updated_at',
                'safe', 'on' => 'search'),
        );
    }

    public function checkCode($attribute, $params) {
        return $this->checkCodeOrSKU();
    }

    public function checkSKU($attribute, $params) {
        return $this->checkCodeOrSKU();
    }

    public function checkDontsyncwithstock($attribute, $params) {
        return $this->checkCodeOrSKU();
    }

    public function checkCodeOrSKU() {
//            if($this->dontsyncwithstock !=  1)
//            {
//                if(empty($this->code) && empty($this->sku))
//                {
//                    $this->addError('code', "Give Code/SKU or select Don't maintain on stock" );
//                    return false;
//                }
//            }
        return true;
    }

    public function checkMinimum($attribute, $params) {
        $min = $params[0]['minimum'];
        if ($min > $this->$attribute) {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . ": Should be >= " . $min);
        }
    }

    public function getMetaData() {
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

    public function getDisplayCategoryForUpdate() {
        $id = $this->id;
        $elementname = "Product[$id][category_id]";
        $elementtag = CHtml::dropdownlist($elementname, $this->category_id, Yii::app()->controller->getCategoriesLookup(), array('empty' => '--Select--'));
        return $elementtag;
    }

    public function getDisplayProductForUpdate() {
        $id = $this->id;
        $elementname = "Product[$id][product_id]";
        $elementvalue = $this->product_id;
        $elementtag = CHtml::textField($elementname, $elementvalue);
        return $elementtag;
    }

    public function getDisplayCodeForUpdate() {
        $id = $this->id;
        $elementname = "Product[$id][Productprice][code]";
        $elementvalue = $this->code;
        $options = array('class' => 'input70percent');
        $elementtag = CHtml::textField($elementname, $elementvalue, $options);
        return $elementtag;
    }

    public function getDisplaySKUForUpdate() {
        $id = $this->id;
        $elementname = "Product[$id][Productprice][sku]";
        $elementvalue = $this->sku;
        $options = array('class' => 'input70percent');
        $elementtag = CHtml::textField($elementname, $elementvalue, $options);
        return $elementtag;
    }

    public function getDisplayDontsyncwithstockForUpdate() {
        $id = $this->id;
        $elementname = "Product[$id][Productprice][dontsyncwithstock]";
        $elementvalue = $this->dontsyncwithstock;
        $elementtag = CHtml::CheckBox($elementname, $elementvalue);
        return $elementtag;
    }

    public function getDisplaySupplierForUpdate() {
        $id = $this->id;
        $elementname = "Product[$id][Productprice][supplier_id]";
        $elementtag = CHtml::dropdownlist($elementname, $this->supplier_id, Yii::app()->controller->getPeopleLookup(Helper::CONST_Supplier), array('empty' => '--Select--'));
        return $elementtag;
    }

    public function getDisplayUnitCPForUpdate() {
        $id = $this->id;
        $elementname = "Product[$id][Productprice][unit_cp]";
        $elementvalue = $this->unit_cp;
        $options = array('class' => 'input50percent');
        $elementtag = CHtml::textField($elementname, $elementvalue, $options);
        return $elementtag;
    }

    public function getDisplayUnitSPForUpdate() {
        $id = $this->id;
        $elementname = "Product[$id][Productprice][unit_sp]";
        $elementvalue = $this->unit_sp;
        $options = array('class' => 'input50percent');
        $elementtag = CHtml::textField($elementname, $elementvalue, $options);
        return $elementtag;
    }

    public function getDisplayStockForUpdate() {
        $id = $this->id;
        $elementname = "Product[$id][Productprice][stock]";
        $elementvalue = $this->stock;
        $options = array('class' => 'input50percent');
        $elementtag = CHtml::textField($elementname, $elementvalue, $options);
        return $elementtag;
    }

    //Display the product history individually
    public function displayProductHistory($id) {
        $rowsql = "select code from subproductprices where id=$id";
        $result = Yii::app()->db->createCommand($rowsql)->queryScalar();

        $criteria = new CDbCriteria;
        $criteria->with = array('prdcategories' => array('together' => true,),
            'supplier');
        $criteria->compare('t.code', $result);
        $criteria->compare('t.sku', $this->sku);
        $criteria->compare('t.product_id', $this->product_id);
        $criteria->compare('name', $this->supplier_id);
        $criteria->compare('t.unit_cp', $this->unit_cp);
        $criteria->compare('t.unit_sp', $this->unit_sp);
        $criteria->compare('t.stock', $this->stock);
        $date = $this->expdate;
        if (!empty($date)) {
            $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
        }
        $criteria->compare('t.expdate', $date);
        $criteria->compare('t.invno', $this->invno);
        $invdate = $this->invdate;
        if (!empty($invdate)) {
            $invdate = date('Y-m-d', strtotime(str_replace('/', '-', $invdate)));
        }
        $criteria->compare('t.invdate', $invdate);
        $criteria->compare('t.stockvalue', $this->stockvalue);
        $createddate = $this->created_at;
        if (!empty($createddate)) {
            $createddate = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $createddate)));
        }
        $criteria->compare('t.created_at', $createddate, true);
        //$criteria->addCondition('dontsyncwithstock != 1');
        $options = array('criteria' => $criteria,);
        //   Yii::app()->controller->setDefaultGVProviderOptions($options);
        return new CActiveDataProvider($this
            , $options
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'prdcategories' => array(self::HAS_MANY, 'Productcategory', 'productprice_id'),
            'categories' => array(self::HAS_MANY, 'Category', 'category_id',
                'through' => 'prdcategories'),
            'supplier' => array(self::BELONGS_TO, 'Person', 'supplier_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_id' => 'Product',
            'category_id' => 'Category',
            'code' => 'Code',
            'sku' => 'SKU[Barcode]',
            'supplier_id' => 'Supplier',
            'unit_cp' => 'Purchase Price',
            'sptype' => 'Sptype',
            'unit_sp_per' => 'Margin %',
            'unit_sp' => 'Selling Price',
            'stockinhand' => 'Stock In Hand',
            'stock' => 'Quantity',
            'expdate' => 'Expiry Date',
            'invno' => 'Invoice Number',
            'invdate' => 'Invoice Date',
            'stockvalue' => 'Stock value',
            'rol' => 'Re-Order Level',
            'moq' => 'Min. Order Quantity',
            'dontsyncwithstock' => 'Don\'t Maintain Stock',
            'status' => 'Status',
            'disc' => 'Discount',
            'tax' => 'Tax Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->dontsyncwithstock == 1) {
                $this->code = substr('nocode_' . rand(), 0, 16);
            }
//                if(!empty($this->code))
//                {
//                    $this->sku = $this->code;
//                }
            else if (!empty($this->sku) && empty($this->code)) {
                $this->code = $this->sku;
            }
            $codeok = $this->checkCodeOrSKU();
            if (!$codeok)
                return $codeok;
            $isupdate = $this->id > 0;
            if ($isupdate) {
                $this->updated_at = new CDbExpression('NULL');
            } else {
                $this->created_at = new CDbExpression('NULL');
                $this->updated_at = new CDbExpression('NULL');
                $this->status = 1;
            }
            if (!empty($this->unit_sp) && $this->unit_sp > 0 && !empty($this->unit_cp) && $this->unit_cp > 0
            ) {
                $diff = $this->unit_sp - $this->unit_cp;
                $this->unit_sp_per = round(($diff / $this->unit_cp * 100), 2);
            } else if (!empty($this->unit_sp_per) && $this->unit_sp_per > 0 && !empty($this->unit_cp) && $this->unit_cp > 0) {
                $this->unit_sp = round(($this->unit_sp_per / 100 * $this->unit_cp), 2);
            }
            if (!empty($this->product->discper) && $this->product->discper >= 0) {
                $this->disc = round(($this->product->discper / 100 * $this->unit_sp), 2);
                //$this->unit_sp = $this->unit_sp - $this->disc;
            }
            if (!empty($this->product->taxrate_id) && $this->product->taxrate_id > 0) {
                $taxrateobj = $this->product->taxrate;
                $taxtype = $taxrateobj->taxtype;

                $taxamount = $taxrateobj->taxrate;
                if (strtolower($taxtype) === strtolower(Helper::CONST_Percentage)) {
                    $taxamount = round(($taxamount / 100 * $this->unit_sp), 2);
                }
                $this->tax = $taxamount;
            }
            $isstackadjust = is_numeric($this->adjusted_stock) && $this->adjusted_stock != $this->stock;
            if ($isstackadjust) {
                $tmp = $this->stock - $this->adjusted_stock;
                $this->stock = $this->adjusted_stock;
                $cday = date('Y-m-d');
                if ($tmp > 0) {
                    $this->remarks .= "\nLost " . $tmp . " on " . $cday;
                } else {
                    $this->remarks .= "\nGained " . $tmp . " on " . $cday;
                }
            }
            $this->stockvalue = $this->stock * $this->unit_cp;
        } else {
            return false;
        }
        return true;
    }

    public function afterFind() {
        $this->spminusdisc = round($this->unit_sp - $this->disc, 2);
//            $this->name = $this->product->name . ' @ ' . $this->spminusdisc;
        $this->name = $this->product->name . ' @ ' . $this->code . ' @ ' . $this->spminusdisc;
        $this->imagepath = $this->product->imagepath;
        if (!empty($this->categories)) {
            $this->category_id = $this->categories[0]->id;
        } else {
            $this->category_id = 0;
        }
        $topcatid = 0;
        $catid = 0;
        if (!empty($this->categories)) {
            $catid = $this->categories[0]->id;
            $parent = $this->categories[0]->section;
            if (!empty($parent)) {
                $topcatid = $parent->id;
            }
        }
        $this->idCombined = $this->id . ":" . $catid . ":" . $topcatid;
        $this->value = $this->idCombined;
        $this->label = $this->name;
        $dateformat = Yii::app()->controller->cJuiDatePickerViewFormat;
        $this->invdate = $this->getDisplayPayment_at();
        if (empty($this->invdate))
            $this->invdate = date($dateformat);
        $dateformat = Yii::app()->controller->cJuiDatePickerViewFormat;
        $this->expdate = $this->getDisplayExpiry();
        if (empty($this->expdate))
            $this->expdate = '';
//            $dateformat = Yii::app()->controller->boosterTbDateRangePickerFormatHMS;
//            $this->created_at = $this->getCreated_at();
//            if(empty($this->created_at)) $this->created_at = date($dateformat);
        parent::afterFind();
    }

    public function getDisplayPayment_at() {
        $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
        $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->invdate, $dateformat, false);
        return $fdate;
    }

    public function getCreated_at() {
        $dateformat = Yii::app()->controller->datetimemysqlformatDMYHI;
        $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->created_at, $dateformat, false);
        return $fdate;
    }

    public function getDisplayExpiry() {
        $dateformat = Yii::app()->controller->datetimemysqlformatDMY;
        $fdate = Yii::app()->controller->getMysqlFormattedDatetime($this->expdate, $dateformat, false);
        return $fdate;
    }

    public function listROLProducts() {
        $criteria = new CDbCriteria;
        $criteria->order = 'stock ASC';
        $criteria->addCondition('stock <= rol AND dontsyncwithstock != 1');
        if (!empty($this->product_id)) {
            $criteria->compare('LCASE(name)', strtolower($this->product_id), true);
        }
        if (
            !Yii::app()->request->isAjaxRequest && Helper::CONST_lazy_page_load
        ) {
            $criteria->addCondition('1 = 0'); // You could also use 0, but I think this is more clear
        }
        $options = array('criteria' => $criteria,);
        Yii::app()->controller->setDefaultGVProviderOptions($options);
        return new CActiveDataProvider($this
            , $options
        );
    }

    public function getBulkNewRecords() {
        $rawData = array();
        for ($i = 0; $i < 10; $i++) {
            $obj = new Productprice;
            $obj->id = $i;
            $rawData[] = $obj;
        }
        $arrayDataProvider = new CArrayDataProvider($rawData, array(
            'id' => 'id',
        ));
        return $arrayDataProvider;
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
    public function searchInvoice() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('prdcategories' => array('together' => true,),
            'supplier');

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.product_id', $this->product_id, true);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.sku', $this->sku, true);
        $criteria->compare('t.supplier_id', $this->supplier_id, true);
        $criteria->compare('prdcategories.category_id', $this->category_id);
        $criteria->compare('t.unit_cp', $this->unit_cp, true);
        $criteria->compare('t.sptype', $this->sptype);
        $criteria->compare('t.unit_sp_per', $this->unit_sp_per, true);
        $criteria->compare('t.unit_sp', $this->unit_sp, true);
        $criteria->compare('t.stock', $this->stock);
        $criteria->compare('t.expdate', $this->expdate);
        $criteria->compare('t.invno', $this->invno, true);
        $criteria->compare('t.invdate', $this->invdate);
        $criteria->compare('t.stockvalue', $this->stockvalue, true);
        $criteria->compare('t.rol', $this->rol);
        $criteria->compare('t.moq', $this->moq);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.created_at', $this->created_at, true);
        $criteria->compare('t.updated_at', $this->updated_at, true);
//                $criteria->addCondition('dontsyncwithstock != 1');
//                $criteria->group = 'invno';

        $options = array('criteria' => $criteria,);
        //Yii::app()->controller->setDefaultGVProviderOptions($options);
        return new CActiveDataProvider($this
            , $options
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->order = 't.id desc';
        $criteria->with = array('prdcategories' => array('together' => true,),
            'supplier');

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.product_id', $this->product_id, false);
        $criteria->compare('t.code', $this->code, false);
        $criteria->compare('t.sku', $this->sku, false);
        $criteria->compare('t.supplier_id', $this->supplier_id, true);
        $criteria->compare('prdcategories.category_id', $this->category_id);
        $criteria->compare('t.unit_cp', $this->unit_cp, true);
        $criteria->compare('t.sptype', $this->sptype);
        $criteria->compare('t.unit_sp_per', $this->unit_sp_per, true);
        $criteria->compare('t.unit_sp', $this->unit_sp, true);
        $criteria->compare('t.stock', $this->stock);
        $criteria->compare('t.expdate', $this->expdate);
        $criteria->compare('t.invno', $this->invno, false);
        $date = $this->invdate;
        if (!empty($date)) {
            $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
        }
        $criteria->compare('invdate', $date, true);
        $criteria->compare('t.stockvalue', $this->stockvalue, true);
        $criteria->compare('t.rol', $this->rol);
        $criteria->compare('t.moq', $this->moq);
        $criteria->compare('t.status', $this->status);
        $createddate = $this->created_at;
        if (!empty($createddate)) {
            $createddate = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $createddate)));
        }
        $criteria->compare('t.created_at', $createddate, true);
        $criteria->compare('t.updated_at', $this->updated_at, true);
        $criteria->group = 'invno';
        //$criteria->addCondition('dontsyncwithstock != 1');
        $options = array('criteria' => $criteria,);
        //Yii::app()->controller->setDefaultGVProviderOptions($options);
        return new CActiveDataProvider($this
            , $options
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Productprice the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getDisplayStock() {
        $rtn = $this->stock;
        if ($this->rol >= $this->stock) {
            $rtn = "<span style='color:red;'>$rtn</span>";
        }
        return $rtn;
    }

    //******stock enquiry************//
    public $date;

    public function StockReport() {

        if (isset($_REQUEST['Productprice'])) {
            $sku = $_REQUEST['Productprice']; //
            if (!empty($sku['sku'])) {
                $CONDITION = 'WHERE SKU=' . '"' . $sku['sku'] . '"';
                $COND_LOG = 'BARCODE=' . '"' . $sku['sku'] . '"' . ' AND';
            } else if (!empty($sku['code'])) {
                $CONDITION = 'WHERE SKU=(SELECT SKU FROM SUBPRODUCTPRICES WHERE CODE= ' . '"' . $sku['code'] . '"' . ')';
                $COND_LOG = 'BARCODE=(SELECT SKU FROM SUBPRODUCTPRICES WHERE CODE= ' . '"' . $sku['code'] . '"' . ') AND';
            } else {
                $CONDITION = '';
                $COND_LOG = '';
            }
        } else {
            $CONDITION = '';
            $COND_LOG = '';
        }
        $sql = 'SELECT  ID,CODE,SKU ,INVNO AS INVOICE_NUMBER,INVDATE AS INVOICE_DATE,STOCK AS QUANTITY,STOCKINHAND,CREATED_AT FROM productprices  ' . $CONDITION . ' UNION ALL SELECT DISTINCT SNO,productprices.code,BARCODE,NULL,DATE,NULL,CURRENT_AVAL_STOCK,POSLOGREPORT.UPDATED_AT FROM POSLOGREPORT, productprices WHERE productprices.sku=POSLOGREPORT.barcode AND ' . $COND_LOG . ' POSLOGREPORT.UPDATED_AT!="" AND CURRENT_AVAL_STOCK!=0 ORDER BY CREATED_AT DESC,SKU';
        echo $sql;
        exit;
        $count = Yii::app()->db->createCommand($sql)->queryAll();
        $count = count($count);
        return new CSqlDataProvider($sql, array('keyField' => 'ID', 'totalItemCount' => $count, 'pagination' => array('pageSize' => 10), 'sort' => array(
//                'defaultOrder' => 'CREATED_AT',
            'attributes' => array('CODE','SKU', 'INVOICE_NUMBER', 'INVOICE_DATE', 'QUANTITY', 'STOCKINHAND', 'CREATED_AT')
        ),));
    }

    public function ExpirydateProductList() {
        $criteria = new CDbCriteria;
        $criteria->with = array('product');
        $criteria->addCondition('if(t.status=1,((SELECT DATE_ADD(t.expdate,INTERVAL 3 DAY)) > curdate() OR t.expdate < curdate()),(SELECT DATE_ADD(t.expdate,INTERVAL 3 DAY))>curdate()) and t.expdate is not null');
        $criteria->order = 'expdate DESC';
        $options = array('criteria' => $criteria,);
        $date = $this->expdate;
        if (!empty($date)) {
            $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
        }
        $idate = $this->invdate;
        if (!empty($idate)) {
            $idate = date('Y-m-d', strtotime(str_replace('/', '-', $idate)));
        }
        $criteria->compare('t.expdate', $date, false);
        $criteria->compare('t.code', $this->code, false);
        $criteria->compare('t.sku', $this->sku, false);
        $criteria->compare('t.invno', $this->invno, false);
        $criteria->compare('t.invdate', $idate, false);
        $criteria->compare('name', $this->product_id, false);
//            $criteria->compare( 'product_id', $this->product_id, false );
        return new CActiveDataProvider($this
            , $options
        );
    }

}
