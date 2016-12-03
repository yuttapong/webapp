<?php

namespace backend\modules\crm\models;

use Yii;

/**
 * This is the model class for table "qtn_question_message".
 *
 * @property string $id
 * @property integer $master_id
 * @property string $name
 * @property integer $created_at
 * @property integer $created_by
 * @property string $table_name
 * @property integer $status
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
            [['master_id', 'created_at', 'created_by', 'status'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['table_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('crm.survey', 'ID'),
            'master_id' => Yii::t('crm.survey', 'Master ID'),
            'name' => Yii::t('crm.survey', 'Name'),
            'created_at' => Yii::t('crm.survey', 'Created At'),
            'created_by' => Yii::t('crm.survey', 'Created By'),
            'table_name' => Yii::t('crm.survey', 'Table Name'),
            'status' => Yii::t('crm.survey', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQtnQuestionChoices()
    {
        return $this->hasMany(QtnQuestionChoice::className(), ['question_message_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQtnQuestionGroupChoices()
    {
        return $this->hasMany(QtnQuestionGroupChoice::className(), ['question_message_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return QuestionMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestionMessageQuery(get_called_class());
    }
}
