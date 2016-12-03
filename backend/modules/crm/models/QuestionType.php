<?php

namespace backend\modules\crm\models;

use Yii;

/**
 * This is the model class for table "qtn_question_type".
 *
 * @property string $id
 * @property string $type
 * @property string $has_choices
 * @property string $response_table
 * @property string $status
 *
 * @property QtnQuestion[] $qtnQuestions
 */
class QuestionType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_question_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'has_choices', 'response_table'], 'required'],
            [['has_choices', 'status'], 'string'],
            [['type', 'response_table'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('crm.question', 'ID'),
            'type' => Yii::t('crm.question', 'Type'),
            'has_choices' => Yii::t('crm.question', 'Has Choices'),
            'response_table' => Yii::t('crm.question', 'Response Table'),
            'status' => Yii::t('crm.question', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQtnQuestions()
    {
        return $this->hasMany(QtnQuestion::className(), ['type_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return QuestionTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestionTypeQuery(get_called_class());
    }
}
