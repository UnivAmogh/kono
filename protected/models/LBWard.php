<?php

/**
 * This is the model class for table "lb_ward".
 *
 * The followings are the available columns in table 'lb_ward':
 * @property integer $id_vward
 * @property integer $id_village
 * @property string $name
 * @property string $updated
 * 
 * @property string $slug
 * @property integer $pri_code
 * @property integer $organizationId
 * @property string $domainName
 * @property string $friendlyUrl
 * @property string $nomenclatureName
 */
class LBWard extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_ward';
	}
	
	public function behaviors()
	{
	    return [
	            'CTimestampBehavior' => array (
	                    'class' => 'zii.behaviors.CTimestampBehavior',
	                    'createAttribute' => null,
	                    'updateAttribute' => 'updated'
	            ),
	            'NameLinkBehavior' => [
	                    'class' => 'application.behaviours.NameLinkBehavior',
	                    'controller' => 'localgov/ward',
	                    'template' => '{link}'
	            ]
	            
	    ];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_village, name', 'required'),
			array('id_village', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>70),
		        
	        array('pri_code,organizationId', 'numerical', 'integerOnly'=>true),
	        array('slug, domainName,friendlyUrl,nomenclatureName', 'length', 'max'=>255),
	        
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_vward, id_village, name, updated', 'safe', 'on'=>'search'),
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
	        'village' => array(self::BELONGS_TO, 'LBVillage', 'id_village'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_vward' => 'Id Vward',
			'id_village' => 'Id Village',
			'name' => 'Name',
			'updated' => 'Updated',
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

		$criteria->compare('id_vward',$this->id_vward);
		$criteria->compare('id_village',$this->id_village);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LBWard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
