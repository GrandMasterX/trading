<?php

class ControllerFrontEnd extends Controller
{
    public $layout = '//layouts/main';

    public $menu = array();
    public $logo = false;

    public function beforeAction($view)
    {
        /*if( Yii::app()->browser->getBrowser() == Browser::BROWSER_IE && Yii::app()->browser->getVersion() < 8) {
            $this->layout = 'oldbrowser';
            $this->render('/site/index');
            Yii::app()->end();
        }*/

        $this->logo = Yii::app()->params['logo'];

        return parent::beforeAction($view);
    }

    public function accessRules()
    {
        return array(
            array('allow'),
        );
    }

    public function filters()
    {
        return array();
    }
}