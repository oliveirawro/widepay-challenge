<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Url".
 *
 * @property int $EnterpriseCode
 * @property int $Code
 * @property int $UserCode
 * @property string DateTimeCreate
 * @property string DateTimeLastCheck
 * @property string $Address
 * @property string $Response
 * @property string $Status
 * @property string $StatusCode
 *
 * @property User $enterpriseCode
 */
class Url extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Url';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EnterpriseCode', 'Code', 'UserCode', 'DateTimeCreate', 'Address'], 'required'],
            [['EnterpriseCode', 'Code', 'UserCode'], 'integer'],
            [['DateTimeCreate'], 'safe'],
            [['DateTimeLastCheck'], 'safe'],
            [['Address'], 'string', 'max' => 300],
            [['Response', 'Status'], 'string', 'max' => 50],
            [['StatusCode'], 'string', 'max' => 10],
            [['EnterpriseCode', 'Code', 'Address'], 'unique', 'targetAttribute' => ['EnterpriseCode', 'Code', 'Address']],
            [['EnterpriseCode', 'UserCode'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['EnterpriseCode' => 'EnterpriseCode', 'UserCode' => 'Code']],
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
            'UserCode' => 'User Code',
            'DateTimeCreate' => 'DateTimeCreate',
            'DateTimeLastCheck' => 'DateTimeLastCheck',
            'Address' => 'Address',
            'Response' => 'Response',
            'Status' => 'Status',
            'StatusCode' => 'StatusCode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnterpriseCode()
    {
        return $this->hasOne(User::className(), ['EnterpriseCode' => 'EnterpriseCode', 'Code' => 'UserCode']);
    }
}
