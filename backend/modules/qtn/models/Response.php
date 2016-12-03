<?php

namespace backend\modules\qtn\models;

use Yii;

/**
 * This is the model class for table "qtn_response".
 *
 * @property string $id
 * @property string $survey_id
 * @property integer $company_id
 * @property integer $site_id
 * @property string $complete
 * @property string $username
 * @property string $table_name
 * @property integer $table_key
 * @property string $submitted
 * @property integer $created_by
 * @property integer $created_at
 *
 * @property QtnResponseBool[] $qtnResponseBools
 * @property QtnQuestion[] $questions
 */
class Response extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_response';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['survey_id'], 'required'],
            [['survey_id', 'company_id', 'site_id', 'table_key', 'created_by', 'created_at'], 'integer'],
            [['complete'], 'string'],
            [['submitted'], 'safe'],
            [['username'], 'string', 'max' => 64],
            [['table_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'survey_id' => 'Survey ID',
            'company_id' => 'Company ID',
            'site_id' => 'Site ID',
            'complete' => 'Complete',
            'username' => 'Username',
            'table_name' => 'Table Name',
            'table_key' => 'Table Key',
            'submitted' => 'Submitted',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQtnResponseBools()
    {
        return $this->hasMany(QtnResponseBool::className(), ['response_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(QtnQuestion::className(), ['id' => 'question_id'])->viaTable('qtn_response_bool', ['response_id' => 'id']);
    }
}
