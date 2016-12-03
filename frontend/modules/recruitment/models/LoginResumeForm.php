<?php

namespace frontend\modules\recruitment\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class LoginResumeForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'เลขที่ใบสม้คร',
            'password' => 'รหัสผ่าน',
            'verifyCode' => 'Verification Code',
        ];
    }


    private function validCode()
    {
        $model = Resume::findOne(['code' => trim($this->username)]);
        if ($model) {
            return true;
        } else {
            $this->addError('username', 'ไม่พบ เลขที่สมัคร');
            return false;
        }
    }


    private function validCodeAndPwd()
    {
        $model = Resume::findOne(['code' => trim($this->username), 'pwd' => trim($this->password)]);
        if ($model) {
            return $model;
        } else {
            $this->addErrors(['Username หรือ Password ไม่ถูกต้อง']);
            return false;
        }
    }

    public function login()
    {
        if ($this->validCode())
            if ($login = $this->validCodeAndPwd()) {
                self::saveSession($login);
                return true;
            }
    }

    private function saveSession($model)
    {
        $session = Yii::$app->session;
        $session->set(Resume::SESSION_NAME, $model->code);
    }

    public function getSession()
    {
        return Yii::$app->session->get(Resume::SESSION_NAME);
    }

    public function removeSession()
    {
        return Yii::$app->session->remove(Resume::SESSION_NAME);
    }

    public function isLoggedIn()
    {
        if (!empty(self::getSession())) {
            return true;
        }
        return false;
    }
}
