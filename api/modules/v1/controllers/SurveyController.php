<?php

namespace api\modules\v1\controllers;

use backend\modules\crm\models\Question;
use backend\modules\crm\models\QuestionChoice;
use backend\modules\crm\models\Survey;

use yii\rest\Controller;

use yii\helpers\ArrayHelper;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;

class SurveyController extends Controller
{

/*    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];

        return $behaviors;
    }*/

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(), [
                'authenticator' => [
                    'class' => CompositeAuth::className(),
                    'except' => ['create', 'login', 'resetpassword'],
                    'authMethods' => [
                        HttpBasicAuth::className(),
                        HttpBearerAuth::className(),
                        QueryParamAuth::className(),
                    ],
                ],
            ]
        );
    }



    public function actionIndex()
    {
        $models = Survey::findAll(['public' => Survey::STATUS_ACTIVE]);
        $total = count($models);
        return [
            'total' => $total,
            'rows' => $models,
        ];
    }

    public function actionView($id)
    {
        $models = Survey::findAll(['public' => Survey::STATUS_ACTIVE]);
        $total = count($models);
        return [
            'questions' => $this->findQuestions($id),
            'choices' => null,
        ];
    }


    private function findModel($id)
    {
        return Survey::findOne($id);
    }


    private function findQuestions($survey_id)
    {
        $questions = Question::find()->where(['survey_id' => $survey_id])->all();
        $data = [];
        foreach ($questions as $index => $question) {
            $data[$index] = [
                'questionId' => $question->id,
                'name' => $question->name,
                'choices' => $this->findChoices($question->id),
            ];
        }
        return $data;
    }

    private function findChoices($question_id)
    {
        $model = QuestionChoice::find()
            ->where(['question_id' => $question_id])
            ->asArray()
            ->all();
        return $model;
    }

}
