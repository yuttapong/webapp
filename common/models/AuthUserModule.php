<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auth_user_module".
 *
 * @property integer $user_id
 * @property integer $module_id
 */
class AuthUserModule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_user_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'module_id'], 'required'],
            [['user_id', 'module_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('auth', 'User ID'),
            'module_id' => Yii::t('auth', 'Module ID'),
        ];
    }

    public function getModule(){
        return $this->hasOne(SysModule::className(),['id'=>'module_id']);
    }
}
