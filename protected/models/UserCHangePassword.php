<?php
class UserChangePassword extends CFormModel
{
    public $password;
    public $oldPassword;
    public $newPassword;
    public $verifyPassword;

    public function rules()
    {
        Yii::import('ext.customValidators.CustomPassword');

        return array(
            array('newPassword', 'ext.customValidators.CustomPassword'),
            array('password, newPassword, verifyPassword, oldPassword, ', 'required'),
            array('newPassword', 'length', 'max' => 128, 'min' => 6, 'message' => User::t("Incorrect new password (minimal length 4 symbols).")),
            array('verifyPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => User::t("Confirm password is incorrect.")),
            array('oldPassword', 'compare', 'compareAttribute' => 'password', 'message' => User::t("Incorrect old password.")),
            array('password, newPassword, verifyPassword, oldPassword, ', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'newPassword' => User::t("New password"),
            'verifyPassword' => User::t("Confirm password"),
            'password' => User::t("Password"),
            'oldPassword' => User::t("Password"),
        );
    }
} 