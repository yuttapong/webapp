<?php

namespace backend\modules\fix\models;

use Yii;

/**
 * This is the model class for table "fix_question_choice".
 *
 * @property string $id
 * @property integer $question_id
 * @property string $content
 * @property double $score
 * @property integer $seq
 * @property integer $created_at
 * @property integer $created_by
 * @property string $type
 * @property string $log_status
 */
class QuestionChoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_question_choice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'seq', 'created_at', 'created_by'], 'integer'],
            [['content'], 'required'],
            [['content', 'type', 'log_status'], 'string'],
            [['score'], 'number'],
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
            'content' => 'Content',
            'score' => 'Score',
            'seq' => 'Seq',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'type' => 'Type',
            'log_status' => 'Log Status',
        ];
    }
}
