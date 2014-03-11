<?php
/**
 * @property integer $id
 * @property integer $parent_id
 * @property string $password
 * @property string $email
 * @property string $activate_key
 * @property string $reset_key
 * @property integer $is_admin
 * @property integer $status
 * @property string $create_date
 * @property string $last_login
 * @property string $email_verified
 *
 */
class User extends MyActiveRecord
{
    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = -1;

    const EMAIL_VERIFIED = 1;
    const EMAIL_NOTVERIFIED = 0;

    const SALT = 'ckFdFErhf}yS';

    const AFFILIATE_COOKIE_NAME = 'af';

    public static function getStatuses($keys = false)
    {
        $result = array(
            self::STATUS_NOACTIVE => Yii::t('app', 'No Active'),
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_BANNED => Yii::t('app', 'Banned'),
        );

        return $keys ? array_keys($result) : $result;
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'users';
    }

    public static function t($str = '', $params = array())
    {
        return Yii::t('user', $str, $params);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'User|Users', $n);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        /*return array(
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'activate_key' => Yii::t('app', 'Activate key'),
            'reset_key' => Yii::t('app', 'Reset key'),
            'is_premium' => Yii::t('app', 'Is Premium'),
            'is_affiliate' => Yii::t('app', 'Is Affiliate'),
            'is_admin' => Yii::t('app', 'Is Admin'),
            'status' => Yii::t('app', 'Status'),
            'create_date' => Yii::t('app', 'Create Date'),
            'last_billing_date' => Yii::t('app', 'Last Billing Date'),
            'next_billing_date' => Yii::t('app', 'Next Billing Date'),
            'premium_expire' => Yii::t('app', 'Premium Expire'),
            'last_login' => Yii::t('app', 'Last Login'),
            'affiliate_id' => Yii::t('app', 'Affiliate'),
            'affiliate_hash' => Yii::t('app', 'Affiliate Hash'),
            'affiliate_balance' => Yii::t('app', 'Affiliate Balance'),
            'email_verified' => Yii::t('app', 'Email verified'),
        );*/
    }

    public function validatePassword($password)
    {
        return $this->hashPassword($password) === $this->password;
    }

    public static function checkPassword($this,$user_pass)
    {
        return self::hashPassword($this) === $user_pass;
    }

    public function hashPassword($password)
    {
        return md5(self::SALT . $password);
    }

    public static function generateRandomHash()
    {
        return md5(time() . ':' . uniqid(rand()));
    }

    public static function setAffiliateCookieId($id)
    {
        $cookie = new CHttpCookie(self::AFFILIATE_COOKIE_NAME, $id);
        $cookie->expire = time() + (60 * 60 * 24 * 7);
        Yii::app()->request->cookies[self::AFFILIATE_COOKIE_NAME] = $cookie;

        return true;
    }

    public static function getAffiliateCookieId()
    {
        if (!empty(Yii::app()->request->cookies[self::AFFILIATE_COOKIE_NAME]))
            return Yii::app()->request->cookies[self::AFFILIATE_COOKIE_NAME]->value;

        return null;
    }

    public static function generatePassword($length = 6)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

    public function afterSave()
    {
        if ($this->isNewRecord)
            $this->createProfile();

        return true;
    }

    public function createProfile()
    {
        $profile = new Profile();
        $profile->user_id = $this->id;

        return $profile->save();
    }

    public function getAvatar()
    {
        if (empty($this->profile->image))
            return '/images/no_avatar.png';

        $thumber = Yii::app()->thumber;

        $thumb = new ImageThumb($this->id, $this->profile->image);

        return  $thumb->getUrl();
    }

    public function getName()
    {
        if (empty($this->profile->name))
            return preg_replace('/([^@]*).*/', '$1', $this->email);
        else
            return $this->profile->name;

    }

}