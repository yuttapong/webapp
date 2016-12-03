<?php

namespace backend\modules\qtn\models;

use Yii;

/**
 * This is the model class for table "qtn_question_choice".
 *
 * @property string $id
 * @property string $question_id
 * @property string $question_message_id
 * @property string $content
 * @property double $score
 * @property integer $created_at
 * @property integer $created_by
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
            [['question_id', 'question_message_id', 'created_at', 'created_by'], 'integer'],
            [['content'], 'string'],
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
            'id' => 'ID',
            'question_id' => 'Question ID',
            'question_message_id' => 'Question Message ID',
            'content' => 'Content',
            'score' => 'Score',
        	'seq' => 'seq ',
        	'type' => 'type ',
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
    public function getQuestion()
    {
        return $this->hasOne(QtnQuestion::className(), ['id' => 'question_id']);
    }
    public function getTypeStatus(){
    
    	return [
    			'choice'=>'choice',
    			'another'=>'another',
    			'other_text'=>'other_text',
    			'other_number'=>'other_number',
    	];
    }

}
