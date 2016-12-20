<?php

namespace backend\modules\crm\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "crm_user_team".
 *
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $created_by
 * @property string $name
 */
class UserTeam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crm_user_team';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'required'],
            [['user_id', 'created_at', 'created_by'], 'integer'],
            [['name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'name' => 'Name',
        ];
    }


}
