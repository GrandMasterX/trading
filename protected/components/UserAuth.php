<?php

class UserAuth extends CWebUser
{

    public $sendActivationMail = true;
    public $loginNotActiv = false;
    public $activeAfterRegister = false;
    public $autoLogin = true;

    public $registrationUrl = array("/user/registration");
    public $recoveryUrl = array("/user/recovery/recovery");
    public $loginUrl = array("/user/login");
    public $logoutUrl = array("/user/logout");
    public $profileUrl = array("/user/profile");
    public $returnUrl = array("/user/profile");
    public $returnLogoutUrl = array("/user/login");

    public $captcha = array('registration' => true);

    public $tableUsers = 'users';

    static private $_user;

    public $componentBehaviors = array();

    public function getBehaviorsFor($componentName)
    {
        if (isset($this->componentBehaviors[$componentName])) {
            return $this->componentBehaviors[$componentName];
        } else {
            return array();
        }
    }

    public static function t($str = '', $params = array(), $dic = 'user')
    {
        return Yii::t("user." . $dic, $str, $params);
    }

    public static function user($id = 0)
    {
        if ($id)
            return User::model()->active()->findbyPk($id);
        else {
            if (Yii::app()->user->isGuest) {
                return false;
            }
            else {
                if (!self::$_user)
                    self::$_user = User::model()->active()->findbyPk(Yii::app()->user->id);
                return self::$_user;
            }
        }
    }
}
