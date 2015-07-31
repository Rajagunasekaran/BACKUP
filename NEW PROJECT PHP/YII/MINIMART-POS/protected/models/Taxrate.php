<?php

/**
 * This is the model class for table "taxrates".
 *
 * The followings are the available columns in table 'taxrates':
 * @property string $id
 * @property string $taxname
 * @property string $taxrate
 * @property string $taxtype
 * @property string $remarks
 */
class Taxrate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'taxrates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('taxname, taxtype', 'required'),
			array('taxname, taxtype, remarks', 'length', 'max'=>128),
			array('taxrate', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, taxname, taxrate, taxtype, remarks', 'safe', 'on'=>'search'),
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
			'taxname' => 'Taxname',
			'taxrate' => 'Taxrate',
			'taxtype' => 'Taxtype',
			'remarks' => 'Remarks',
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
		$criteria->compare('taxname',$this->taxname,true);
		$criteria->compare('taxrate',$this->taxrate,true);
		$criteria->compare('taxtype',$this->taxtype,true);
		$criteria->compare('remarks',$this->remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Taxrate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getDisplay()
        {
            $rtn = $this->taxname;
            $type = $this->taxtype;
            $rtn .= '[ ' . $this->taxrate . (($type === Helper::CONST_Percentage)?Helper::CONST_PercentSymbol:Helper::CONST_CurrencySymbol) . ' ]';
            return $rtn;
        }
        public function getTaxrateId($name, $isrtnDflt = true)
        {
            $dflt = null;
            if($isrtnDflt)
            {
                $dfltname = Helper::CONST_No_Tax;
                $dflt=$this->findByAttributes(array('taxname' => $dfltname));
            }
            $recId = null;
            $criteria = new CDbCriteria;
            $criteria->select = array( 'id' , 'taxname');
            $criteria->condition = 'LCASE(taxname)="' . strtolower($name) . '"';
            $result = $this->findAll( $criteria );
            if(count($result) === 1)
            {
                $rec = $result[0];
                $recId = $rec->id;
            }
            else if($isrtnDflt && !empty($dflt))
            {
                $recId = $dflt->id;
            }
            return $recId;
        }
}
