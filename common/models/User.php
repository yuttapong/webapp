<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use backend\modules\org\models\OrgPersonnel;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    public $password;
    public $confirm_password;
    public $roles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['avatar', 'logo'], 'unique'],
            ['email', 'email'],
            [['email', 'username'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['roles'], 'safe'],
        ];
    }



    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    public function getStatusName()
    {
        $items = $this->getItemStatus();
        return array_key_exists($this->status, $items) ? $items[$this->status] : '';
    }

    public function getItemStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive'
        ];
    }

    public function getRoleByUser()
    {
        $auth = Yii::$app->authManager;
        $rolesUser = $auth->getRolesByUser($this->id);
        $roleItems = $this->getAllRoles();
        $roleSelect = [];

        foreach ($roleItems as $key => $roleName) {
            foreach ($rolesUser as $role) {
                if ($key == $role->name) {
                    $roleSelect[$key] = $roleName;
                }
            }
        }
        $this->roles = $roleSelect;
    }

    public function getAllRoles()
    {
        $auth = $auth = Yii::$app->authManager;
        return ArrayHelper::map($auth->getRoles(), 'name', 'name');
    }

    public function assignment()
    {
        $auth = Yii::$app->authManager;
        $roleUser = $auth->getRolesByUser($this->id);
        $auth->revokeAll($this->id);
        foreach ($this->roles as $key => $roleName) {
            $auth->assign($auth->getRole($roleName), $this->id);
        }
    }

    public function assignModule()
    {
        $auth = Yii::$app->authManager;
        $roleUser = $auth->getRolesByUser($this->id);
        $auth->revokeAll($this->id);
        foreach ($this->roles as $key => $roleName) {
            $auth->assign($auth->getRole($roleName), $this->id);
        }
    }

    public function getPersonnel()
    {
        return $this->hasOne(OrgPersonnel::className(), ['user_id' => 'id']);
    }

    public function updateLastLogin()
    {
        $now = new \DateTime();
        $today = $now->format('Y-m-d H:i:s');
        $user = User::findOne(Yii::$app->user->id);
        $user->logged_in_ip = Yii::$app->request->getUserIP();
        $user->logged_in_at = $today;
        $user->save();
    }

}
