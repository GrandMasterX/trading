<?php

class Deals extends CActiveRecord
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
        return 'deals';
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

    static public function dealsByTicket($ticket,$range)
    {
        $deals = array();
        //$data = Deals::model()->findAll();
        $query='SELECT *
                    FROM `deals`
                    WHERE `id` % 30 = 0';

        $data = Yii::app()->db->createCommand($query)->queryAll();

        foreach($data as $dat) {
            $deals[]= 0+$dat['open'];
        }

        return $deals;
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