<?php
/**
 *
 * @property string $password
 * @property string $email
 * @property string $verifyEmail
 *
 */
class UserUpdate extends User
{
    public $email;
    public $verifyEmail;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('email, verifyEmail', 'required'),
            array('email', 'email'),
            array('email', 'unique', 'message' => self::t("This user's email address already exists.")),
            array('verifyEmail', 'compare', 'compareAttribute' => 'email', 'message' => User::t("Retype email is incorrect.")),
        );
    }
}