<?php

namespace backend\modules\setting\models;

use backend\modules\org\models\OrgPersonnel;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $role_id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $access_token
 * @property string $logged_in_ip
 * @property string $logged_in_at
 * @property string $banned_reason
 *
 * @property Profile[] $profiles
 * @property DelRole $role
 * @property UserAuth[] $userAuths
 * @property UserToken[] $userTokens
 */
class User extends \common\models\User
{
    public $_fullname;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['role_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at','status'], 'required'],
            [['logged_in_at'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'access_token', 'logged_in_ip', 'banned_reason'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            ['email', 'email'],
            [['email','username'], 'unique'],
            [['username', 'email'], 'required'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('setting.role', 'ID'),
            'role_id' => Yii::t('setting.role', 'Role ID'),
            'username' => Yii::t('setting.role', 'Username'),
            'auth_key' => Yii::t('setting.role', 'Auth Key'),
            'password_hash' => Yii::t('setting.role', 'Password Hash'),
            'password_reset_token' => Yii::t('setting.role', 'Password Reset Token'),
            'email' => Yii::t('setting.role', 'Email'),
            'status' => Yii::t('setting.role', 'Status'),
            'created_at' => Yii::t('setting.role', 'Created At'),
            'updated_at' => Yii::t('setting.role', 'Updated At'),
            'access_token' => Yii::t('setting.role', 'Access Token'),
            'logged_in_ip' => Yii::t('setting.role', 'Logged In Ip'),
            'logged_in_at' => Yii::t('setting.role', 'Logged In At'),
            'banned_reason' => Yii::t('setting.role', 'Banned Reason'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(DelRole::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAuths()
    {
        return $this->hasMany(UserAuth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTokens()
    {
        return $this->hasMany(UserToken::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }


}
