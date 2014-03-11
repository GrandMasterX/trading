<?php

class CMessageTextBehavior extends CActiveRecordBehavior
{
    public $attributes =array();
    protected $purifier;

    function __construct(){

        $this->purifier = new CHtmlPurifier;
        $this->purifier->options = array(
            'HTML.Allowed' => 'b, strong, i, em, ul, ol, li, blockquote',
        );

    }

    public function beforeSave($event)
    {
        foreach($this->attributes as $attribute){

            $this->getOwner()->{$attribute} = trim($this->purifier->purify($this->getOwner()->{$attribute}));

        }
    }
}