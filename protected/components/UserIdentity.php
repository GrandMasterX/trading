<?php

class UserIdentity extends CUserIdentity
{
    private $_id;
    const ERROR_EMAIL_INVALID = 3;
    const ERROR_STATUS_NOACTIVE = 4;
    const ERROR_STATUS_BAN = 5;

    public function authenticate()
    {
        $user = User::model()->findByAttributes(array('email' => $this->username));

        if ($user === null)
            $this->errorCode = self::ERROR_EMAIL_INVALID;
        else if (!User::checkPassword($this->password, $user->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else if ($user->status == User::STATUS_NOACTIVE)
            $this->errorCode = self::ERROR_STATUS_NOACTIVE;
        else if ($user->status == User::STATUS_BANNED)
            $this->errorCode = self::ERROR_STATUS_BAN;
        else {
            $this->_id = $user->id;
            $this->username = $user->email;
            $this->errorCode = self::ERROR_NONE;
            $this->setState('role', $user->is_admin ? 'admin' : 'user');
        }

        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}