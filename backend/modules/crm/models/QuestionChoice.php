<?php

namespace backend\modules\crm\models;

use Yii;

/**
 * This is the model class for table "qtn_question_choice".
 *
 * @property string $id
 * @property string $question_id
 * @property string $question_message_id
 * @property string $content
 * @property double $score
 * @property integer $seq
 * @property integer $created_at
 * @property integer $created_by
 * @property string $type
 *
 * @property QtnQuestionMessage $questionMessage
 * @property QtnQuestion $question
 */
class QuestionChoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_question_choice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'content'], 'required'],
            [['question_id', 'question_message_id', 'seq', 'created_at', 'created_by'], 'integer'],
            [['content', 'type'], 'string'],
            [['score'], 'number'],
            [['question_message_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionMessage::className(), 'targetAttribute' => ['question_message_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('crm.question', 'ID'),
            'question_id' => Yii::t('crm.question', 'Question ID'),
            'question_message_id' => Yii::t('crm.question', 'Question Message ID'),
            'content' => Yii::t('crm.question', 'Content'),
            'score' => Yii::t('crm.question', 'Score'),
            'seq' => Yii::t('crm.question', 'Seq'),
            'created_at' => Yii::t('crm.question', 'Created At'),
            'created_by' => Yii::t('crm.question', 'Created By'),
            'type' => Yii::t('crm.question', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionMessage()
    {
        return $this->hasOne(QuestionMessage::className(), ['id' => 'question_message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    /**
     * @inheritdoc
     * @return QuestionChoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestionChoiceQuery(get_called_class());
    }
}
