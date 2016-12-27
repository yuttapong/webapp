<?php

namespace backend\modules\crm\controllers;


use backend\models\Model;
use backend\modules\crm\models\Customer;
use backend\modules\crm\models\QuestionChoice;
use backend\modules\org\models\OrgPersonnel;
use backend\modules\crm\models\Question;
use backend\modules\crm\models\Survey;
use backend\modules\crm\models\SurveySearch;
use backend\modules\crm\models\Response;


use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class SurveyController extends \yii\web\Controller
{


    public $_answer = [];


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $module = Yii::$app->controller->module->id;
                            $action = Yii::$app->controller->action->id;
                            $controller = Yii::$app->controller->id;
                            $route = "/$module/$controller/$action";
                            if (Yii::$app->user->can($route)) {
                                return true;
                            }
                        }
                    ]
                ]
            ]
        ];
    }


    public function actionSaveSortQuestion()
    {
        $items = Yii::$app->request->post('item');
        if(Yii::$app->request->isAjax) {

            if ($items) {
                $seq = 1;
                foreach ($items as $id) {
                    $model = Question::findOne($id);
                    $model->seq = $seq;
                    $model->save(false);
                    $seq++;
                }
                echo json_encode(['result' => 1,'message' => 'Successfully Update','error' => $model->errors]);
            }else{
                echo json_encode(['result' => 0,'message' => 'item is empty','item'=>$items]);
            }
        }

    }


    public function actionSaveSortChoice()
    {
        $items = Yii::$app->request->post('item');
        if(Yii::$app->request->isAjax) {

            if ($items) {
                $seq = 1;
                foreach ($items as $id) {
                    $model = QuestionChoice::findOne($id);
                    $model->seq = $seq;
                    $model->save(false);
                    $seq++;
                }
                echo json_encode(['result' => 1,'message' => 'Successfully Update','error' => $model->errors]);
            }else{
               echo json_encode(['result' => 0,'message' => 'item is empty']);
            }
        }

    }

    /**
     * @return string
     */

    public function actionIndex()
    {
        $searchModel = new  SurveySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDo()
    {
        $id = Yii::$app->request->get('id');
        $customer_id = Yii::$app->request->get('customer_id');
        if ($id && $customer_id) {


            $modelSurvey = Survey::findOne($id);

            if (Yii::$app->request->post()) {
                $this->_answer = Yii::$app->request->post();

                $survey_id = $this->_answer['survey_id'];
                $customer_id = $this->_answer['customer_id'];
                //$submitted = $this->_answer['submitted_date'] . ' ' . $this->_answer['submitted_time'];
                $submitted = date("Y-m-d") . ' ' . $this->_answer['submitted_time'];


                //ตรวจสอบว่าทำแบบสอบถามนี้แล้วหรือยังก่อน
                $countResponse = Response::find()->where([
                    'survey_id' => $survey_id,
                    'table_name' => Customer::TABLE_NAME,
                    'table_key' => $customer_id,
                ])->count();


                if ($countResponse == 0) {
                    $seq = 1;
                } else {
                    $modelResponse = Response::find()
                        ->where([
                            'survey_id' => $survey_id,
                            'table_name' => Customer::TABLE_NAME,
                            'table_key' => $customer_id,
                        ])
                        ->orderBy(['id' => SORT_DESC])
                        ->one();
                    $seq = $modelResponse->seq + 1;
                }


                $modelResponse = new Response();
                $modelResponse->datetime = strtotime($submitted);
                $modelResponse->customer_id = $customer_id;
                $modelResponse->table_name = Customer::TABLE_NAME;
                $modelResponse->submitted = $submitted; // ทีแรกใช้ field นี้


                //ใช้ field ชื่อว่า datetime เป็นหลัก ในการเก็บข้อมูลวันที่ลูกค้ามาเยี่ยมชม
                $modelResponse->datetime = strtotime($submitted);
                $modelResponse->table_key = $customer_id;
                $modelResponse->survey_id = $survey_id;
                $modelResponse->created_at = time();
                $modelResponse->created_by = Yii::$app->user->id;
                $modelResponse->updated_at = time();
                $modelResponse->updated_by = Yii::$app->user->id;
                $modelResponse->seq = $seq;
                $modelResponse->site_id = $modelSurvey->site_id;


                if ($modelResponse->save()) {
                    return $this->redirect(['response/update', 'id' => $modelResponse->id]);
                }
            }


            $countSeq = $this->countSeqOfResponse($id, $customer_id);
            if ($countSeq > 0) {
                $rs = Response::find()
                    ->where(['table_key' => $customer_id, 'survey_id' => $id])
                    ->orderBy(['id' => SORT_DESC])
                    ->one();
                return $this->redirect(['response/view', 'id' => $rs->id]);
            }
            return $this->render('do', [
                'modelSurvey' => $modelSurvey,
                'answerSingle' => [],
                'answerMultiple' => [],
                'answerOther' => [],
                'answerText' => [],
                'countSeq' => $countSeq,
                'modelCustomer' => Customer::findOne($customer_id),
            ]);

        }
    }

    /**
     * นับแบบสอบถามที่ลูกค้าคนนี้เคยกรอกในฟอร์มนั้นๆ
     * @param $surveyId
     * @param $customerId
     * @return int|string
     */
    protected function countSeqOfResponse($surveyId, $customerId)
    {
        $count = Response::find()->where([
            'table_name' => Customer::TABLE_NAME,
            'table_key' => $customerId,
            'survey_id' => $surveyId
        ])->count();
        return $count;
    }

    public function actionView($id)
    {
        $model = Survey::findOne($id);
        return $this->render('view', [
            'model' => $model,
            'models' => Question::getQuestionTable($model->id),
            'customer_id' => null,
            'survey_id' => $model->id,
            'answerSingle' => [],
            'answerMultiple' => [],
            'answerText' => [],
            'modelResponse' => new Response(),
        ]);
    }


    public function actionUser($id)
    {
        $searchModel = new  SurveySearch();
        $modelsResponse = Response::find()
            ->where(['survey_id' => $id, 'table_name' => Customer::TABLE_NAME])
            ->groupBy(['created_by']);

        $dataProvider = new ActiveDataProvider([
            'query' => $modelsResponse,
        ]);

        return $this->render('report/user', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelSurvey' => Survey::findOne($id)
        ]);
    }

    public function actionSurvey($surveyId, $userId)
    {
        $user = OrgPersonnel::findOne(['user_id' => $userId]);
        $searchModel = new  SurveySearch();
        $modelsResponse = Response::find()
            ->where([
                'survey_id' => $surveyId,
                'table_name' => Customer::TABLE_NAME,
                'created_by' => $userId
            ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $modelsResponse,
        ]);

        return $this->render('report/survey', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelSurvey' => Survey::findOne($surveyId),
            'modelUser' => $user,
        ]);
    }


    // แก้ไขแบบสอบถาม
    public function actionUpdate($id)
    {
        $model = Survey::findOne($id);
        $questions = $model->questions;

        if (Yii::$app->request->post()) {
            Model::loadMultiple($questions, Yii::$app->request->post());
            foreach ($questions as $question) {
                 $saved =   $question->save();
                echo'<br>' . $question->public . '/' . $question->name;
            }
            if($saved){
                Yii::$app->session->setFlash('success','Successfullly Update.');
                 return $this->redirect(['survey/update','id'=>$model->id]);
            }

        }
        $searchQ = new ActiveDataProvider([
            'query' => Question::find()->where(['survey_id' => $model->id]),
            'sort' => [
                'defaultOrder' => [
                    'seq' => SORT_ASC,]
            ]
        ]);
        return $this->render('update', [
            'model' => $model,
            'questions' => $questions,
            'searchQ' => $searchQ,
        ]);
    }

    public function actionEditTopic($id)
    {

        $topic = Question::findOne($id);
        $choices = $topic->questionChoices;

        if (Yii::$app->request->post() && $topic->load(Yii::$app->request->post())) {
            if ($topic->save()) {
                if (Model::loadMultiple($choices, Yii::$app->request->post())) {
                    foreach ($choices as $choice) {
                         $choice->save(false);
                    }

                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                    return $this->redirect(['edit-topic', 'id' => $id]);
                }
            }
        } else {

            return $this->render('topic', ['topic' => $topic]);
        }


    }

}
