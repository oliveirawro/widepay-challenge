<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property int $EnterpriseCode
 * @property int $Code
 * @property int $GroupCode
 * @property int $BranchCode
 * @property string $Name
 * @property string $Login
 * @property string $Password
 * @property string $AuthKey
 * @property string $ExternalKey
 * @property string $PasswordResetToken
 * @property string $Phone
 * @property string $PasswordExpire
 * @property int $PasswordExpireAfter
 * @property string $LastDateTimePasswordChanged
 * @property string $Active
 *
 * @property Log[] $logs
 * @property Enterprise $enterpriseCode
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EnterpriseCode', 'Code'], 'required'],
            [['EnterpriseCode', 'Code', 'GroupCode', 'BranchCode', 'PasswordExpireAfter'], 'integer'],
            [['LastDateTimePasswordChanged'], 'safe'],
            [['Name', 'Login', 'PasswordResetToken'], 'string', 'max' => 80],
            [['Password', 'Phone'], 'string', 'max' => 60],
            [['AuthKey'], 'string', 'max' => 32],
            [['ExternalKey', 'PasswordExpire', 'Active'], 'string', 'max' => 1],
            [['EnterpriseCode', 'Code'], 'unique', 'targetAttribute' => ['EnterpriseCode', 'Code']],
            [['EnterpriseCode'], 'exist', 'skipOnError' => true, 'targetClass' => Enterprise::className(), 'targetAttribute' => ['EnterpriseCode' => 'Code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'EnterpriseCode' => 'Enterprise Code',
            'Code' => 'Code',
            'GroupCode' => 'Group Code',
            'BranchCode' => 'Branch Code',
            'Name' => 'Name',
            'Login' => 'Login',
            'Password' => 'Password',
            'AuthKey' => 'Auth Key',
            'ExternalKey' => 'External Key',
            'PasswordResetToken' => 'Password Reset Token',
            'Phone' => 'Phone',
            'PasswordExpire' => 'Password Expire',
            'PasswordExpireAfter' => 'Password Expire After',
            'LastDateTimePasswordChanged' => 'Last Date Time Password Changed',
            'Active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::className(), ['EnterpriseCode' => 'EnterpriseCode', 'UserCode' => 'Code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnterpriseCode()
    {
        return $this->hasOne(Enterprise::className(), ['Code' => 'EnterpriseCode']);
    }


    /********************************************* custom *******************************/



    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function getId()
    {
        return $this->Code;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }


    public static function findByUsername($login)
    {
        return self::findOne(['Login' => $login]);
    }

    public function validatePassword($password)
    {

        //return $this->Password === $password;
        return $this->Password === (string)md5($password);
    }

}
