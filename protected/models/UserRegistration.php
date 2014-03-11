<?php
/**
 *
 * @property string $password
 * @property string $email
 * @property string $login
 *
 */
class UserRegistration extends User
{
    public $email;
    public $password;
    //public $remail;
    //public $login;

    public function rules()
    {
        return array(
            array('password, email', 'required'),
            array('email', 'email'),
            array('email', 'unique', 'message' => "Email address already exists"),
            array('password', 'length', 'max' => 128, 'min' => 4, 'message' => "Incorrect password (minimal length 4 symbols)"),
        );
    }


}