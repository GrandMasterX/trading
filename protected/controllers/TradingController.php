<?php

class TradingController extends ControllerFrontAccount
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionGetData() {
        echo json_encode(Deals::dealsByTicket(1,1));
    }

    public function actionDrawTicket() {
        $ticket = Yii::app()->request->getPost('id');
        $stmData = Statement::model()->findByAttributes(array('ticket'=>$ticket));
        list($opendate['year'], $opendate['month'], $opendate['day'], $opendate['hours'], $opendate['minutes'], $opendate['seconds']) = $this->multiexplode(array('-',':',' '), $stmData['opentime']);
        list($closedate['year'], $closedate['month'], $closedate['day'], $closedate['hours'], $closedate['minutes'], $closedate['seconds']) = $this->multiexplode(array('-',':',' '), $stmData['closetime']);
        $trader = Trader::model()->findByPk($stmData['trader_id']);
        $statement = array(
            'open' => 0+$stmData['openprice'],
            'close' => 0+$stmData['closeprice'],
            'oy' => 0+$opendate['year'],
            'om' => 0+$opendate['month'],
            'od' => 0+$opendate['day'],
            'oh' => 0+$opendate['hours'],
            'omin' => 0+$opendate['minutes'],
            'osec' => 0+$opendate['seconds'],
            'cy' => 0+$closedate['year'],
            'cm' => 0+$closedate['month'],
            'cd' => 0+$closedate['day'],
            'ch' => 0+$closedate['hours'],
            'cmin' => 0+$closedate['minutes'],
            'csec' => 0+$closedate['seconds'],
            'trader_name' => $trader['fullname']

        );
        echo json_encode($statement);
    }
}