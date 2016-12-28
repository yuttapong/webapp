<?php

namespace backend\modules\crm\models;

use Yii;


/**
 * This is the model class for table "qtn_question".
 *
 * @property string $id
 * @property integer $master_id
 * @property string $survey_id
 * @property integer $survey_tab_id
 * @property integer $survey_title_id
 * @property double $seq
 * @property string $name
 * @property string $type_id
 * @property string $result_id
 * @property integer $length
 * @property integer $precise
 * @property string $position
 * @property string $content
 * @property string $required
 * @property string $deleted
 * @property string $public
 * @property string $log_status
 * @property integer $created_at
 * @property integer $created_by
 *
 * @property QtnQuestionType $type
 * @property QtnSurveyTitle $surveyTitle
 * @property QtnQuestionChoice[] $qtnQuestionChoices
 */
class Question extends \yii\db\ActiveRecord
{

    const TYPE_BOOLEAN = 1;
    const TYPE_TEXT = 2;
    const TYPE_TEXTAREA = 3;
    const TYPE_RADIO = 4;
    const TYPE_CHECKBOX = 5;
    const TYPE_NUMBER = 10;
    const TYPE_DATE = 9;
    const TYPE_DROPDOWN = 6;
    const TYPE_TABLE_RADIO = 11;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'master_id', 'survey_id', 'survey_tab_id', 'survey_title_id', 'type_id', 'result_id', 'length', 'precise', 'position', 'created_at', 'created_by'], 'integer'],
            [['survey_id', 'name', 'type_id'], 'required'],
            [['seq'], 'number'],
            [['content', 'required', 'deleted', 'public', 'log_status'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['survey_title_id'], 'exist', 'skipOnError' => true, 'targetClass' => SurveyTitle::className(), 'targetAttribute' => ['survey_title_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('crm.question', 'ID'),
            'master_id' => Yii::t('crm.question', 'Master ID'),
            'survey_id' => Yii::t('crm.question', 'Survey ID'),
            'survey_tab_id' => Yii::t('crm.question', 'Survey Tab ID'),
            'survey_title_id' => Yii::t('crm.question', 'Survey Title ID'),
            'seq' => Yii::t('crm.question', 'Seq'),
            'name' => Yii::t('crm.question', 'Name'),
            'type_id' => Yii::t('crm.question', 'Type ID'),
            'result_id' => Yii::t('crm.question', 'Result ID'),
            'length' => Yii::t('crm.question', 'Length'),
            'precise' => Yii::t('crm.question', 'Precise'),
            'position' => Yii::t('crm.question', 'Position'),
            'content' => Yii::t('crm.question', 'Content'),
            'required' => Yii::t('crm.question', 'Required'),
            'deleted' => Yii::t('crm.question', 'Deleted'),
            'public' => Yii::t('crm.question', 'Public'),
            'log_status' => Yii::t('crm.question', 'Log Status'),
            'created_at' => Yii::t('crm.question', 'Created At'),
            'created_by' => Yii::t('crm.question', 'Created By'),
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(QuestionType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyTitle()
    {
        return $this->hasOne(SurveyTitle::className(), ['id' => 'survey_title_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyTab()
    {
        return $this->hasOne(SurveyTab::className(), ['id' => 'survey_tab_id']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionChoices()
    {
        return $this->hasMany(QuestionChoice::className(), ['question_id' => 'id'])->orderBy('seq');
    }

    /**
     * @inheritdoc
     * @return QuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestionQuery(get_called_class());
    }

    public function getSurvey()
    {
        return $this->hasOne(Survey::className(), ['id' => 'survey_id']);
    }


    public static function getQuestionTable($survey_id)
    {
        $questions = [];
        $models = Question::find()
            ->innerJoinWith('surveyTab', 'qtn_question.survey_tab_id = surveyTab.id')
            ->where(['qtn_question.survey_id' => $survey_id,'qtn_question.public'=>'Y'])
            ->orderBy(
                [
                    'qtn_survey_tab.seq' => SORT_ASC,
                    'qtn_question.survey_title_id' => SORT_ASC,
                    'qtn_question.seq' => SORT_ASC]
            )->all();
        foreach ($models as $model) {
            if (empty($questions[$model->survey_tab_id])) {
                $questions[$model->survey_tab_id]['tab_name'] = $model->surveyTitle->surveyTab->name;
            }
            if (empty($questions[$model->survey_tab_id]['item'][$model->survey_title_id])) {
                $questions[$model->survey_tab_id]['item'][$model->survey_title_id]['title_name'] = $model->surveyTitle->name;
                $questions[$model->survey_tab_id]['item'][$model->survey_title_id]['title_hide'] = $model->surveyTitle->hide;
            }
            if ($model->type_id == 11) {
                $questions[$model->survey_tab_id]['item'][$model->survey_title_id]['item'][$model->type_id]['modelQuestion'] = '11';
                $questions[$model->survey_tab_id]['item'][$model->survey_title_id]['item'][$model->type_id]['question'][$model->id] = $model->name;
            } else {
                $questions[$model->survey_tab_id]['item'][$model->survey_title_id]['items'][$model->id]['type_id'] = $model->type_id;
                $questions[$model->survey_tab_id]['item'][$model->survey_title_id]['items'][$model->id]['modelQuestion'] = $model;

            }
        }

        return $questions;
    }

    public static function getResponse($arr_typ, $response_id)
    {
        $arr_question = [];
        foreach ($arr_typ as $val) {
            if ($val == 1) {
                $bool = ResponseBool::find()
                    ->andWhere(['response_id' => $response_id])
                    ->all();
                foreach ($bool as $val_b) {
                    $arr_question[$val_b->question_id] = $val_b->choice_id;
                }

            }
            if ($val == 5) {
                $multiple = ResponseMultiple::find()
                    ->andWhere(['response_id' => $response_id])
                    ->all();
                foreach ($multiple as $val_m) {
                    $arr_question[$val_m->question_id]['choice'][$val_m->choice_id] = $val_m->choice_id;
                }
            }
        }
        $multiple = ResponseOther::find()
            ->andWhere(['response_id' => $response_id])
            ->all();
        foreach ($multiple as $val_o) {
            $arr_question[$val_o->question_id]['choice'][$val_o->choice_id] = $val_o->response;
        }
        return $arr_question;
    }
}
