<?php

class SiteController extends ControllerFrontEnd
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
        if(!Yii::app()->user->isGuest)
            $this->redirect(array('trading/index'));
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
        if(!Yii::app()->user->isGuest)
            $this->redirect(array('trading/index'));

		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
    public function actionLogin() {
        if (!Yii::app()->user->isGuest){
            if(Yii::app()->user->returnUrl){
                $this->redirect(Yii::app()->user->returnUrl);
            }else{
                $this->redirect(array('trading/index'));
            }
        }
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $model = new UserLogin;
            $model->setAttributes($_POST['UserLogin']);

            if (!$model->validate())
                return $this->renderAjaxModel($model);

            $lastVisit = User::model()->findByPk(Yii::app()->user->getId());
            $lastVisit->last_login = new CDbExpression('NOW()');
            $lastVisit->save();

            $this->redirect(array('trading/index'));

        } else {

            $model = new UserLogin;
            return $this->render('login', array('model'=>$model));

        }
    }

    public function actionAbout() {
        if(!Yii::app()->user->isGuest)
            $this->redirect(array('trading/index'));

        $this->render('about');
    }
	/**
	 * Logs out the current user and redirect to homepage.
	 */
    public function actionLogout() {

        Yii::app()->user->logout();

        $this->redirect(array('site/index'));
    }

    public function actionRegistration()
    {
        if(!Yii::app()->user->isGuest)
            $this->redirect(array('trading/index'));

        if (Yii::app()->getRequest()->getIsPostRequest())
        {
            $registrationModel = new UserRegistration();

            $registrationModel->setAttributes($_POST);

            if (!$registrationModel->validate())
                return $this->renderAjaxError($registrationModel->getErrors());

            $user = new User();
            $user->email = $registrationModel->email;
            $user->password = $user->hashPassword($registrationModel->password);
            $user->status = User::STATUS_ACTIVE;
            $user->create_date = new CDbExpression('NOW()');

            if (!$user->save())
                return $this->renderAjaxError($user->getErrors());

            //TODO: need to move sendNotification action to User Model
            /*MailNotification::sendNotification(
                $user->email,'Welcome!','registration'
                //array(
                //    'url' => Yii::app()->createAbsoluteUrl('site/activateaccount', array('url' => $user->activate_key))
                //)
            );*/

            //Auto login
            $identity = new UserIdentity($registrationModel->email, $registrationModel->password);
            $identity->authenticate();
            Yii::app()->user->login($identity, $duration = 3600);

            return $this->redirect(array('trading/index'));

        } else {
            return $this->render('signup');

        }
    }
}