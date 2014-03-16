<?php

class Statement extends CActiveRecord
{

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'statements';
    }

    public function behaviors()
    {
        return array(
            'zii.behaviors.CTimestampBehavior',
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
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
            'trader'=>array(self::HAS_ONE, 'Trader', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
        );
    }

    protected function beforeSave()
    {
    }

    public function scopes()
    {

    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
    }

    public static function allTraders() {
        return Trader::model()->findAll();
    }

    public static function toArray()
    {
        $list=array();
        $models=ItemSize::model()->visible()->findAll();
        foreach($models as $model)
        {
            $list[$model->title]=$model->title;
        }
        return array_unique($list);
    }

}