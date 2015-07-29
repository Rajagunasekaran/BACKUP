<?php

/**
 * This is the model class for table "categories".
 *
 * The followings are the available columns in table 'categories':
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $desc
 * @property string $imagepath
 * @property integer $status
 */
class Category extends CActiveRecord
{
    public $name;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'categories';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array( 'parent_id, name', 'required' ),
            array( 'parent_id', 'length', 'max' => 10 ),
            array( 'name, desc', 'length', 'max' => 128 ),
            array( 'status, imagepath', 'length', 'max' => 512 ),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array( 'id, parent_id, name, desc, status, imagepath', 'safe', 'on' => 'search' ),
        );
    }
        public function beforeSave()
        {
            if ( parent::beforeSave() )
            {
//                $isupdate = $this->id > 0;                
//                if($isupdate)
//                {
//                    $this->updated_at = new CDbExpression('NULL');
//                }
//                else
//                {
//                    $this->created_at = new CDbExpression('NULL'); 
//                    $this->updated_at = new CDbExpression('NULL');
//                }                
                $this->status = 1;
            }
            else
            {
                return false;
            }
            return true;
        }
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'section' => array(self::BELONGS_TO, 'Category', 'parent_id'),
            'categories' => array(self::HAS_MANY, 'Category', 'parent_id'
                ,'condition' => 'categories.status=1'
                ),
            'allcategories' => array(self::HAS_MANY, 'Category', 'parent_id'),
            'productcategories' => array(self::HAS_MANY, 'Productcategory', 'category_id'),
            'products' => array(self::HAS_MANY, 'Product', 'product_id',
                'through' => 'productcategories'
                ,'condition' => 'products.status=1'
                ),
            'productprices' => array(self::HAS_MANY, 'Productprice', 'productprice_id',
                'through' => 'productcategories'
                ,'condition' => 'productprices.status=1'
                ),
                      'masterproductcategories' => array(self::HAS_MANY, 'Masterproductcategory', 'category_id'),
                        'subproductprices' => array(self::HAS_MANY, 'Subproductprice', 'productprice_id',
                'through' => 'masterproductcategories'
                ,'condition' => 'subproductprices.status=1'
                ),
            'allproducts' => array(self::HAS_MANY, 'Product', 'product_id',
                'through' => 'productcategories'
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
            'parent_id' => 'Section',
            'name' => 'Name',
            'desc' => 'Description',
            'status' => 'Status',
            'imagepath' => 'Image',
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

        $criteria = new CDbCriteria;

        $criteria->compare( 'id', $this->id, true );
        if(!empty($this->parent_id))
        {
            if($this->parent_id === Helper::CONST_RootCategory)
            {
                $criteria->addCondition( 'parent_id = 0');
            }
            else
            {
                $criteria->addCondition( 'parent_id > 0');
            }
            
        }
        
        $criteria->compare( 'name', $this->name, true );
        $criteria->compare( 'desc', $this->desc, true );
        $criteria->compare( 'imagepath', $this->imagepath, true );
        $criteria->addCondition('status = 1');
        
        $options = array( 'criteria' => $criteria, );
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Category the static model class
     */
    public static function model( $className=__CLASS__ )
    {
        return parent::model( $className );
    }
    public function getCategoryId($catname, $isrtnDflt = true, $isRoot = false)
    {
        $controller = Yii::app()->controller;
        $dflt = null;
        if($isrtnDflt)
        {
            if($isRoot)
            {
                $dflt=$this->findByAttributes(array('name' => Helper::CONST_General_Section));
            }
            else
            {
                $dflt=$this->findByAttributes(array('name' => Helper::CONST_General));                
            }
            
        }
        $catId = null;
        $criteria = new CDbCriteria;
        $criteria->select = array( 'id' , 'name');
        $criteria->condition = 'LCASE(name)="' . strtolower($catname) . '"';
        $result = $this->findAll( $criteria );
        if(count($result) === 1)
        {
            $rec = $result[0];
            $catId = $rec->id;
        }
        else if($isrtnDflt && !empty($dflt))
        {
            $catId = $dflt->id;
        }
        return $catId;
    }
}