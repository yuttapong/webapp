<?php

namespace backend\modules\qtn\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "qtn_survey_tab".
 *
 * @property integer $id
 * @property integer $survey_id
 * @property string $name
 * @property integer $hide
 * @property string $description
 */
class SurveyTab extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_survey_tab';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        		[['name'], 'required'],
            [['survey_id', 'hide'], 'integer'],
            [['description'], 'string'],
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
            'survey_id' => 'Survey ID',
            'name' => 'Name',
            'hide' => 'Hide',
            'description' => 'Description',
        ];
    }
    public function getSurveyTab(){
    	$datas = SurveyTab::find()->all();
    	return ArrayHelper::map($datas,'id','name');
    }
    public function getSurvey()  {
    	return $this->hasOne(Survey::className(), ['id' => 'survey_id']);
    }
    public function getTitle()  {
    	return $this->hasMany(SurveyTitle::className(), ['survey_tab_id' => 'id']);
    }
    public function getQuestions() {
    	return $this->hasMany(Question::className(), ['survey_tab_id' => 'id']);
    }
}
