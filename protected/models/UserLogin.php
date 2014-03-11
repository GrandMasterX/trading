<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserLogin extends CFormModel
{
    public $email;
    public $password;
    public $remember;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('email, password', 'required'),
            // remember needs to be a boolean
            array('remember', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'remember' => UserAuth::t("Remember me next time"),
            'email' => UserAuth::t("email"),
            'password' => UserAuth::t("password"),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors()) // we only want to authenticate when no input errors
        {
            $identity = new UserIdentity($this->email, $this->password);
            $identity->authenticate();
            switch ($identity->errorCode) {
                case UserIdentity::ERROR_NONE:
                    $duration = $this->remember ? 3600 * 24 * 14 : 0; // 14 days
                    Yii::app()->user->login($identity, $duration);
                    break;
                case UserIdentity::ERROR_EMAIL_INVALID:
                    die('234');
                    $this->addError("email", UserAuth::t("Email is incorrect."));
                    break;
                case UserIdentity::ERROR_STATUS_NOACTIVE:
                    die('345');
                    $this->addError("status", UserAuth::t("You account is suspended."));
                    break;
                case UserIdentity::ERROR_STATUS_BAN:
                    die('456');
                    $this->addError("status", UserAuth::t("You account is blocked."));
                    break;
                case UserIdentity::ERROR_PASSWORD_INVALID:
                    die('567');
                    $this->addError("password", UserAuth::t("Password is incorrect."));
                    break;
            }
        }
    }

    protected function afterValidate(){

        parent::afterValidate();

        if(!$this->getErrors()){
            $lastVisit = User::model()->findByPk(Yii::app()->user->getId());
            $lastVisit->last_login = new CDbExpression('NOW()');
            $lastVisit->save();

            //Session::model()->startSession(Yii::app()->user->getId());
        }

        return true;

    }
}
