<?php
/**
 * This is the model class for table "{{profile}}".
 *
 * The followings are the available columns in table '{{profile}}':
 * @property string $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $company
 * @property string $company_url
 * @property integer $timezone
 */
class Profile extends MyActiveRecord
{
    public static $timezones = array(
        array(
            'text' => '+00 - Greenwich Mean',
            'value' => 0
        ),
        array(
            'text' => '+01 - Central European',
            'value' => 1
        ),
        array(
            'text' => '+02 - Baghdad',
            'value' => 2
        ),
        array(
            'text' => '+03 - Kuwait, Nairobi, Kenya',
            'value' => 3
        ),
        array(
            'text' => '+04 - Moscow, Russia, Abu Dhabi',
            'value' => 4
        ),
        array(
            'text' => '+05 - Maldives Time',
            'value' => 5
        ),
        array(
            'text' => '+06 - Novosibirsk Time',
            'value' => 6
        ),
        array(
            'text' => '+07 - Omsk Standard Time',
            'value' => 7
        ),
        array(
            'text' => '+08 - China Coast',
            'value' => 8
        ),
        array(
            'text' => '+09 - Japan Standard',
            'value' => 9
        ),
        array(
            'text' => '+10 - Australia Central Standard',
            'value' => 10
        ),
        array(
            'text' => '+11 - Guam Standard',
            'value' => 11
        ),
        array(
            'text' => '+12 - New Zealand Standard',
            'value' => 12
        ),
        array(
            'text' => '-01 - West Africa',
            'value' => -1
        ),
        array(
            'text' => '-02 - Azores',
            'value' => -2
        ),
        array(
            'text' => '-03 - Brasilia, Argentina',
            'value' => -3
        ),
        array(
            'text' => '-04 - Atlantic Standard',
            'value' => -4
        ),
        array(
            'text' => '-05 - Eastern Standard',
            'value' => -5
        ),
        array(
            'text' => '-06 - Central Standard',
            'value' => -6
        ),
        array(
            'text' => '-07 - Mountain Standard',
            'value' => -7
        ),
        array(
            'text' => '-08 - Pacific Standard',
            'value' => -8
        ),
        array(
            'text' => '-09 - Yukon Standard',
            'value' => -9
        ),
        array(
            'text' => '-10 - Alaska-Hawaii Standard',
            'value' => -10
        ),
        array(
            'text' => '-11 - Nome',
            'value' => -11
        ),
        array(
            'text' => '-12 - International Date Line West',
            'value' => -12
        ),
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'profiles';
    }

    /*public function rules()
    {
        return array(
            array('user_id', 'required'),
            array('user_id', 'length', 'max'=>11),
            array('timezone', 'length', 'max'=>3),
            array('timezone', 'numerical', 'integerOnly'=>true),
            array('company_url', 'url'),
            array('firstname, lastname, company_url', 'length', 'max'=>127),
            array('company', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, firstname, lastname, company, company_url, timezone', 'safe'),
        );
    }*/

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'company' => 'Company',
            'company_url' => 'Company Url',
            'timezone' => 'Timezone',
        );
    }

    /*public function behaviors(){
        return array(
            'CCleanTextBehavior' => array(
                'class' => 'application.behaviors.CCleanTextBehavior',
                'attributes' => array('firstname', 'lastname', 'company'),
            ),
        );
    }*/

    public function getName()
    {

        $name_by_email = preg_replace('/([^@]*).*/', '$1', $this->user->email);

        if (empty($this->profile->firstname) && empty($this->profile->lastname)){

            return $name_by_email;

        } else {

            if(empty($this->profile->lastname)){

                return $this->profile->firstname;

            }else{

                if(empty($this->profile->firstname)){

                    return $this->profile->lastname;

                }else{

                    return $this->profile->firstname . ' ' . $this->profile->lastname;

                }

            }

        }

    }

}