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
    public $roles;
    public $modules;


    public function rules()
    {
        return [
           [[ 'modules'],'safe'],
            [[ 'modules','username','email','status','roles'],'required']
        ];
    }

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
            '_fullname' => Yii::t('setting.role', 'Fullname'),
            'statusName' => 'Status',
            'roles' => 'Roles',
        ];
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */

    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public function getPersonnel()
    {
        return $this->hasOne(OrgPersonnel::className(),['user_id'=>'id']);
    }


}
