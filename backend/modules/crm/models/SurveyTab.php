<?php

namespace backend\modules\crm\models;

use Yii;

/**
 * This is the model class for table "qtn_survey_tab".
 *
 * @property integer $id
 * @property integer $survey_id
 * @property string $name
 * @property integer $hide
 * @property string $description
 * @property integer $seq
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
            [['survey_id', 'hide', 'seq'], 'integer'],
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
            'id' => Yii::t('crm.survey', 'ID'),
            'survey_id' => Yii::t('crm.survey', 'Survey ID'),
            'name' => Yii::t('crm.survey', 'Name'),
            'hide' => Yii::t('crm.survey', 'Hide'),
            'description' => Yii::t('crm.survey', 'Description'),
            'seq' => Yii::t('crm.survey', 'Seq'),
        ];
    }

    /**
     * @inheritdoc
     * @return SurveyTabQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SurveyTabQuery(get_called_class());
    }
}
