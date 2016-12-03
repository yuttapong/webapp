<?php

namespace backend\modules\qtn\models;

use Yii;

/**
 * This is the model class for table "qtn_question_group_choice".
 *
 * @property string $id
 * @property integer $survey_title_id
 * @property string $question_message_id
 * @property string $content
 * @property double $score
 * @property integer $created_at
 * @property integer $created_by
 *
 * @property QtnQuestionMessage $questionMessage
 * @property QtnSurveyTitle $surveyTitle
 */
class QuestionGroupChoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_question_group_choice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['survey_title_id', 'question_message_id', 'created_at', 'created_by'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string'],
            [['score'], 'number'],
            [['question_message_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionMessage::className(), 'targetAttribute' => ['question_message_id' => 'id']],
            [['survey_title_id'], 'exist', 'skipOnError' => true, 'targetClass' => SurveyTitle::className(), 'targetAttribute' => ['survey_title_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'survey_title_id' => 'Survey Title ID',
            'question_message_id' => 'Question Message ID',
            'content' => 'Content',
            'score' => 'Score',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionMessage()
    {
        return $this->hasOne(QtnQuestionMessage::className(), ['id' => 'question_message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyTitle()
    {
        return $this->hasOne(QtnSurveyTitle::className(), ['id' => 'survey_title_id']);
    }

  
}
