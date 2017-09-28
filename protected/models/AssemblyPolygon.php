<?php

/**
 * This is the model class for table "acpoly".
 *
 * The followings are the available columns in table 'acpoly':
 * @property integer $id_poly
 * @property string $polytype
 * @property integer $acno
 * @property integer $id_parl_consti
 * @property string $zone
 * @property integer $wardno
 * @property string $AC_NAME
 * @property string $poly
 * @property integer $ST_CODE
 * @property string $ST_NAME
 * @property integer $DT_CODE
 * @property string $DIST_NAME
 * @property integer $PC_NO
 * @property string $pc_name
 * @property string $pc_name_clean
 * @property integer $PC_ID
 * @property double $Shape_Leng
 * @property double $Shape_Area
 * @property double $MaxSimpTol
 * @property double $MinSimpTol
 */
class AssemblyPolygon extends CActiveRecord
{
    var $ctr1;
    var $ctr2;
    var $ctr3;
    var $ctr4;
    var $ctr5;
    var $ctr6;

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'acpoly';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array (
                array (
                        'acno, poly',
                        'required'
                ),
                array (
                        'acno',
                        'numerical',
                        'integerOnly' => true
                ),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be
                // searched.
                array (
                        'acno, poly',
                        'safe',
                        'on' => 'search'
                )
        );
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array (
                'states' => array (
                        self::BELONGS_TO,
                        'State',
                        'id_state'
                )
        );
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array (
                'acno' => __('Assembly Number'),
                'poly' => __('Polygon'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will
     * filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     *         based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria ();

        $criteria->compare ( 'acno', $this->acno );
        $criteria->compare ( 'poly', $this->poly, true );

        return new CActiveDataProvider ( $this, array (
                'criteria' => $criteria
        ) );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your
     * CActiveRecord descendants!
     *
     * @param string $className
     *            active record class name.
     * @return AssemblyPolygon the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model ( $className );
    }

    static function repMunicipals()
    {
        $rs = self::model ()->findAll (
                [
                        'group' => 'DIST_NAME',
                        'select' => 'DIST_NAME,count(*) as ctr1,(select count(name) from municipalresults where city=DIST_NAME) as ctr2',
                        'condition' => 'polytype=?',
                        'params' => [
                                'WARD'
                        ]
                ] );

        foreach ( $rs as $r )
        {
            $row [] = [
                    $r->DIST_NAME,
                    $r->ctr1,
                    $r->ctr2
            ];
        }
        return $row;
    }

    static function repACs()
    {
        $rs = AssemblyPolygon::model ()->findAll (
                [
                        'group' => 'id_state,ST_NAME,ST_CODE',
                        'select' => "ST_NAME,count(*) as ctr1,
                            (select count(name) from tnresults2016 r2 where r2.ST_CODE=t.ST_CODE) as ctr2,
                            (select count(phones) from tnresults2016 r3 where phones<>'' and r3.id_state=t.id_state) as ctr3,
                            (select count(emails) from tnresults2016 r4 where emails<>'' and r4.id_state=t.id_state) as ctr4,
                            (select count(address) from tnresults2016 r5 where address<>'' and r5.id_state=t.id_state) as ctr5,
                            (select count(picture) from tnresults2016 r6 where picture<>'' and r6.id_state=t.id_state) as ctr6,
                            id_state",
                        'condition' => 'polytype=?',
                        'params' => [
                                'AC'
                        ]
                ] );

        foreach ( $rs as $r )
        {
            $row [] = [
                    $r->ST_NAME,
                    $r->ctr1,
                    $r->ctr2,
                    $r->ctr3,
                    $r->ctr4,
                    $r->ctr5,
                    $r->ctr6,
                    $r->id_state,
            ];
        }
        return $row;
    }
}
