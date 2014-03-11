<?php

class CCleanTextBehavior extends CActiveRecordBehavior
{
    public $attributes =array();
    protected $purifier;

    function __construct(){

        $this->purifier = new CHtmlPurifier;
        $this->purifier->options = array(
            'HTML.Allowed' => '',
        );

    }

    public function beforeSave($event)
    {
        foreach($this->attributes as $attribute){

            $this->getOwner()->{$attribute} = $this->purifier->purify($this->getOwner()->{$attribute});

        }
    }
}