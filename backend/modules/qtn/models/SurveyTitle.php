<?php

namespace backend\modules\qtn\models;

use Yii;
/**
 * This is the model class for table "qtn_survey_title".
 *
 * @property integer $id
 * @property integer $survey_tab_id
 * @property string $name
 * @property integer $hide
 *
 * @property QtnQuestion[] $qtnQuestions
 * @property QtnQuestionGroupChoice[] $qtnQuestionGroupChoices
 */
class SurveyTitle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_survey_title';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        		[['name'], 'required'],
            [[ 'survey_tab_id', 'hide'], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'survey_tab_id' => 'Survey Tab ID',
            'name' => 'Name',
            'hide' => 'Hide',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions() {
        return $this->hasMany(Question::className(), ['survey_title_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionGroupChoices() {
        return $this->hasMany(QuestionGroupChoice::className(), ['survey_title_id' => 'id']);
    }

    
    public function getSurveyTab()  {
    	return $this->hasOne(SurveyTab::className(), ['id' => 'survey_tab_id']);
    }

}
