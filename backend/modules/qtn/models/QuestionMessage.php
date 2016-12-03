<?php

namespace backend\modules\qtn\models;

use Yii;

/**
 * This is the model class for table "qtn_question_message".
 *
 * @property string $id
 * @property integer $master_id
 * @property string $name
 * @property integer $created_at
 * @property integer $created_by
 *
 * @property QtnQuestionChoice[] $qtnQuestionChoices
 * @property QtnQuestionGroupChoice[] $qtnQuestionGroupChoices
 */
class QuestionMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_question_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['master_id', 'created_at', 'created_by'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_id' => 'Master ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        	'table_name' => 'table_name By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionChoices()
    {
        return $this->hasMany(QuestionChoice::className(), ['question_message_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionGroupChoices()
    {
        return $this->hasMany(QuestionGroupChoice::className(), ['question_message_id' => 'id']);
    }
}
