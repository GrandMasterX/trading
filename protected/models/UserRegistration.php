<?php
/**
 *
 * @property string $password
 * @property string $email
 * @property string $remail
 * @property string $login
 *
 */
class UserRegistration extends User
{
    public $email;
    public $password;
    public $remail;
    public $login;

    public function rules()
    {
        Yii::import('ext.customValidators.CustomPassword');

        return array(
            array('password', 'ext.customValidators.CustomPassword'),
            array('password, email', 'required'),
            array('email', 'email'),
            array('email', 'unique', 'message' => self::t("Email address already exists")),
        );
    }


}