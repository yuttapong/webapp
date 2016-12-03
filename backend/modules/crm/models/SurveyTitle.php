<?php

namespace backend\modules\crm\models;

use Yii;

/**
 * This is the model class for table "qtn_survey_title".
 *
 * @property integer $id
 * @property integer $survey_id
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
            [['survey_id', 'survey_tab_id', 'hide'], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('crm.survey', 'ID'),
            'survey_id' => Yii::t('crm.survey', 'Survey ID'),
            'survey_tab_id' => Yii::t('crm.survey', 'Survey Tab ID'),
            'name' => Yii::t('crm.survey', 'Name'),
            'hide' => Yii::t('crm.survey', 'Hide'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQtnQuestions()
    {
        return $this->hasMany(QtnQuestion::className(), ['survey_title_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQtnQuestionGroupChoices()
    {
        return $this->hasMany(QtnQuestionGroupChoice::className(), ['survey_title_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyTab()
    {
        return $this->hasOne(SurveyTab::className(), ['id' => 'survey_tab_id']);
    }

    
    /**
     * @inheritdoc
     * @return SurveyTitleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SurveyTitleQuery(get_called_class());
    }
}
