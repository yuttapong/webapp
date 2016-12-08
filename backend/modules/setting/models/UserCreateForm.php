<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 7/12/2559
 * Time: 16:38
 */
namespace backend\modules\setting\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class UserCreateForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status;
    public $roles;
    public $modules;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 3, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 4],
            [['status'],'number'],
            [['roles','status'],'required'],
            [['modules'],'safe'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */

    public function createUser()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                $auth = Yii::$app->authManager;
                $auth->revokeAll($user->id);
                if ($this->roles && is_array($this->roles)) {
                    foreach ($this->roles as $role) {
                        $auth->assign($auth->getRole($role), $user->id);
                    }
                }
                return $user;
            }
        }
    }

    public function update($id)
    {
        if ($this->validate()) {
            $user = User::find()->where(['id'=>$id])->one();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = $this->status;
            //$user->setPassword($this->password);
            //$user->generateAuthKey();
            if ($user->save()) {
                $auth = Yii::$app->authManager;
                $auth->revokeAll($user->id);
                if ($this->roles && is_array($this->roles)) {
                    foreach ($this->roles as $role) {
                        $auth->assign($auth->getRole($role), $user->id);
                    }
                }
                return $user;
            }
        }
    }


}
