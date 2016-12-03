<?php

namespace backend\modules\crm\controllers;

use backend\modules\crm\models\Survey;
use backend\modules\crm\models\Customer;
use backend\modules\crm\models\ResponseOther;
use backend\modules\qtn\models\Question;
use backend\modules\qtn\models\QuestionChoice;
use kartik\grid\EditableColumnAction;
use Yii;
use backend\modules\crm\models\Response;
use backend\modules\crm\models\ResponseSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\crm\models\ResponseText;
use backend\modules\crm\models\ResponseSingle;
use backend\modules\crm\models\ResponseMultiple;
use backend\models\Model;
use yii\filters\AccessControl;

/**
 * ResponseController implements the CRUD actions for Response model.
 */
class ResponseController extends Controller
{

    public $_answer = [];

    /**
     * @inheritdoc
     */
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


    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editResponse' => [                                       // identifier for your editable column action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => Response::className(),                // the model for the record being edited
                'outputValue' => function ($model, $attribute, $key, $index) {
                    return;     // return any custom output value if desired
                },
                'outputMessage' => function ($model, $attribute, $key, $index) {
                    return;                              // any custom error to return after model save
                },
                'showModelErrors' => true,                        // show model validation errors after save
                'errorOptions' => ['header' => '']                // error summary HTML options
                // 'postOnly' => true,
                // 'ajaxOnly' => true,
                // 'findModel' => function($id, $action) {},
                // 'checkAccess' => function($action, $model) {}
            ]
        ]);
    }


    /**
     * Lists all Response models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResponseSearch();

        if (!Yii::$app->user->can('crmResponseManager')) {
            $searchModel->created_by = Yii::$app->user->id;
            $msg = 'ระบบแสดงจะแสดงรายการของคุณเท่านั้น';
        } else {
            $msg = 'คุณสามารถเห็นรายการของทุกคน';
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'msg' => $msg,
        ]);
    }


    /**
     * Displays a single Response model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        // $model->datetime_string = date("Y-m-d H:i:s", $model->datetime);
        return $this->render('view', [
            'modelResponse' => $model,
            'models' => Question::getQuestionTable($model->survey_id),
            'customer_id' => $model->customer_id,
            'survey_id' => $model->survey_id,
            'answerSingle' => $model->answerSingle,
            'answerMultiple' => $model->answerMultiple,
            'answerText' => $model->answerText,
        ]);
    }


    /**
     * Displays a single Response model.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        //บันทึกวันที่ลูกค้ากรอกแบบสอบถาม
        if (isset($_POST['hasEditable'])) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post())) {
                $model->datetime = strtotime($model->datetime_string);
                if ($model->save()) {
                    $customer = Customer::findOne($model->table_key);
                    $customer->day_visit = date("Y-m-d", $model->datetime);
                    $customer->save();

                    $formatShow = new \DateTime($model->datetime_string);
                    return ['output' => $formatShow->format('d/m/Y'), 'message' => ''];
                }
            } else {
                return ['output' => '', 'message' => ''];
            }
        }


        if (Yii::$app->request->post()) {
            $model = $this->findModel($id);
            $this->_answer = Yii::$app->request->post();
            $survey_id = $model->survey_id;
            $customer_id = $model->table_key;


            //ตรวจสอบว่าทำแบบสอบถามนี้แล้วหรือยังก่อน
            $countResponse = Response::find()->where([
                'table_key' => $customer_id,
                'survey_id' => $survey_id,
            ])->count();


            if ($countResponse == 0) {
                $modelResponse = new Response();
                $modelResponse->customer_id = $customer_id;
                $modelResponse->table_key = $customer_id;
                $modelResponse->table_name = Customer::tableName();
                $modelResponse->survey_id = $survey_id;
                $modelResponse->created_at = time();
                $modelResponse->created_by = Yii::$app->user->id;
                $modelResponse->save();
            } else {
                $modelResponse = Response::find()
                    ->where(['survey_id' => $survey_id, 'table_key' => $customer_id])
                    ->one();
                $modelResponse->updated_at = time();
                $modelResponse->updated_by = Yii::$app->user->id;
                $modelResponse->customer_id = $customer_id;
                $modelResponse->table_key = $customer_id;
                $modelResponse->table_name = Customer::tableName();
                $modelResponse->save();
            }


            /**
             * Text
             */
            if (!empty($this->_answer['text'])) {
                foreach ($this->_answer['text'] as $questionId => $val) {
                    if (!empty($val)) {
                        $countText = ResponseText::find()
                            ->where([
                                'response_id' => $modelResponse->id,
                                'question_id' => $questionId,
                            ])->count();

                        if ($countText > 0) {
                            $modelText = ResponseText::find()
                                ->where([
                                    'response_id' => $modelResponse->id,
                                    'question_id' => $questionId,
                                ])->one();
                            $modelText->response = $val;
                            $modelText->save();
                        } else {
                            $modelText = new ResponseText();
                            $modelText->response_id = $modelResponse->id;
                            $modelText->question_id = $questionId;
                            $modelText->response = $val;
                            $modelText->save();
                        }
                    }

                }
            }


            /***************************************************
             * Radio
             ****************************************************/
            if (!empty($this->_answer['radio'])) {
                foreach ($this->_answer['radio'] as $questionId => $val) {
                    $countAns = ResponseSingle::find()->where([
                        'question_id' => $questionId,
                        'response_id' => $modelResponse->id,
                    ])->count();

                    //ถ้ายังไม่เคยตอบให้เพิ่มคำคอบใหม่
                    if ($countAns == 0) {
                        $model = new ResponseSingle();
                        $model->response_id = $modelResponse->id;
                        $model->question_id = $questionId;
                        $model->choice_id = $val;
                        $model->save();
                    } else {
                        $modelSingOld = ResponseSingle::find()
                            ->where([
                                'response_id' => $modelResponse->id,
                                'question_id' => $questionId
                            ])->one();

                        $model = ResponseSingle::find()
                            ->where([
                                'response_id' => $modelResponse->id,
                                'question_id' => $questionId,
                                'choice_id' => $modelSingOld->choice_id,
                            ])->one();
                        $model->choice_id = $val;
                        $model->save();
                    }
                }
            }

            /**
             * Checkbox
             */

            if (!empty($this->_answer['checkbox'])) {
                //Old answer
                $modelMultipleInput = ResponseMultiple::findAll([
                    'response_id' => $modelResponse->id
                ]);
                $oldCheckbox = ArrayHelper::map($modelMultipleInput, 'choice_id', 'choice_id');

                //Current answer
                $currentCheckbox = [];
                foreach ($this->_answer['checkbox'] as $questionId => $items) {
                    foreach ($items as $choice_id) {
                        $currentCheckbox[number_format($choice_id)] = number_format($choice_id);
                    }
                }


                //Deleted answer
                $deletedCheckbox = array_diff($oldCheckbox, array_filter($currentCheckbox));
                if (!empty($deletedCheckbox)) {
                    ResponseMultiple::deleteAll(['response_id' => $modelResponse->id, 'choice_id' => $deletedCheckbox]);
                }



                foreach ($this->_answer['checkbox'] as $questionId => $items) {
                    foreach ($items as $choiceId) {

                        $countAns = ResponseMultiple::find()->where([
                            'question_id' => $questionId,
                            'response_id' => $modelResponse->id,
                            'choice_id' => $choiceId,
                        ])->count();
                        if ($countAns > 0) {
                            $model = ResponseMultiple::findOne([
                                'response_id' => $modelResponse->id,
                                'question_id' => $questionId,
                                'choice_id' => $choiceId
                            ]);
                            $model->choice_id = $choiceId;
                            $model->save();
                        } else {
                            $model = new ResponseMultiple();
                            $model->response_id = $modelResponse->id;
                            $model->question_id = $questionId;
                            $model->choice_id = $choiceId;
                            $model->save();
                        }
                    }
                }
            }


            /**
             * Other
             */

            if (!empty($this->_answer['another'])) {
                foreach ($this->_answer['another'] as $questionId => $items) {
                    foreach ($items as $choiceId => $textOther) {
                        $countAns = ResponseOther::find()->where([
                            'question_id' => $questionId,
                            'response_id' => $modelResponse->id,
                            'choice_id' => $choiceId,
                        ])->count();
                        if ($countAns > 0) {
                            $model = ResponseOther::findOne([
                                'response_id' => $modelResponse->id,
                                'question_id' => $questionId,
                                'choice_id' => $choiceId
                            ]);
                            $model->choice_id = $choiceId;
                            $model->response = $textOther;
                            $model->save();
                        } else {
                            $model = new ResponseOther();
                            $model->response_id = $modelResponse->id;
                            $model->question_id = $questionId;
                            $model->choice_id = $choiceId;
                            $model->response = $textOther;
                            $model->save();
                        }
                    }
                }
            }



            if ($modelResponse && $model) {
                Yii::$app->session->setFlash('success', 'บันทึกแบบสอบถามเรียบร้อย');
                return $this->redirect(['update', 'id' => $modelResponse->id]);
            }


        }

        $model = $this->findModel($id);
        $model->datetime_string = date("d/m/Y", $model->datetime);


        return $this->render('edit', [
            'modelResponse' => $model,
            'models' => Question::getQuestionTable($model->survey_id),
            'customer_id' => $model->customer_id,
            'survey_id' => $model->survey_id,
            'answerSingle' => $model->answerSingle,
            'answerMultiple' => $model->answerMultiple,
            'answerText' => $model->answerText,
        ]);
    }

    /**
     * show data others of answer to modal bootstrap
     * @return string
     */
    public function actionFormOthers()
    {
        $responseId = Yii::$app->request->post('responseId');
        $choiceId = Yii::$app->request->post('choiceId');
        $questionId = Yii::$app->request->post('questionId');

        $modelResponse = Response::findOne($responseId);
        $modelChoice = QuestionChoice::findOne($choiceId);
        $modelQuestion = Question::findOne($questionId);
        $modelsOther = ResponseOther::find()
            ->where(['response_id' => $responseId, 'question_id' => $questionId, 'choice_id' => $choiceId])
            ->all();

        return $this->renderAjax("_others", [
            'modelsOther' => $modelsOther,
            'modelChoice' => $modelChoice,
            'modelQuestion' => $modelQuestion,
            'modelResponse' => $modelResponse,
            'responseId' => $responseId,
            'choiceId' => $choiceId,
        ]);
    }


    /**
     * Save answer others
     * @throws \yii\db\Exception
     */
    public function actionSaveOther()
    {
        if (Yii::$app->request->post()) {
            $responseId = Yii::$app->request->post('responseId');
            $choiceId = Yii::$app->request->post('choiceId');
            $questionId = Yii::$app->request->post('questionId');

            $modelResponse = Response::findOne($responseId);
            $modelChoice = QuestionChoice::findOne($choiceId);
            $modelQuestion = Question::findOne($questionId);
            $modelsOther = ResponseOther::find()
                ->where(['response_id' => $responseId, 'question_id' => $questionId, 'choice_id' => $choiceId])
                ->all();


            $dataOther = Yii::$app->request->post('other');
            $dataOtherId = isset($dataOther['other_id']) ? $dataOther['other_id'] : [];
            $oldOther = ArrayHelper::map($modelsOther, 'other_id', 'other_id');
            $deletedOther = array_diff($oldOther, array_filter($dataOtherId));

            $modelResponse->updated_at = time();
            $modelResponse->updated_by = Yii::$app->user->id;

            $transaction = Yii::$app->db->beginTransaction();
            $json = [];

            try {
                if ($flag = $modelResponse->save()) {


                    if (!empty($deletedOther)) {
                        ResponseOther::deleteAll(['other_id' => $deletedOther]);
                    }

                    if (!empty($dataOther)) {
                        $countRes = count($dataOther['response']);
                        for ($loopOther = 0; $loopOther < $countRes; $loopOther++) {
                            $otherId = isset($dataOther['other_id'][$loopOther]) ? $dataOther['other_id'][$loopOther] : 0;
                            $otherTitle = isset($dataOther['response'][$loopOther]) ? $dataOther['response'][$loopOther] : '';
                            if (in_array($otherId, $oldOther)) {
                                $modelRes = ResponseOther::find()->where(['other_id' => $otherId])->one();
                            } else {
                                // add manual item
                                if ($otherId == 0) {
                                    $modelRes = new ResponseOther();
                                    $modelRes->seq = $loopOther;
                                    $modelRes->response_id = $responseId;
                                    $modelRes->question_id = $questionId;
                                    $modelRes->choice_id = $choiceId;
                                } else {
                                    // add from database by id
                                    $modelRes = new ResponseOther();
                                    $modelRes->seq = $loopOther;
                                    $modelRes->response_id = $responseId;
                                    $modelRes->question_id = $questionId;
                                    $modelRes->choice_id = $choiceId;
                                }
                            }
                            $modelRes->seq = $loopOther;
                            $modelRes->response = $otherTitle;
                            if (!($flag = $modelRes->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            $json['others'][] = [
                                'other_id' => $modelRes->other_id,
                                'seq' => $modelRes->seq,
                                'title' => $modelRes->response,
                            ];
                        }
                    }

                }

                if ($flag) {
                    $transaction->commit();
                    $json['success'] = true;
                    $json['choiceId'] = $choiceId;
                    echo json_encode($json);
                }
            } catch (Exception $e) {
                $json['success'] = false;
                echo json_encode($e->getMessage());
                $transaction->rollBack();
            }


        }


    }

    /**
     * Deletes an existing Response model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Response model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Response the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Response::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * แสดงคำตอบอื่น ๆ ของหัวข้อแบบสอบถาม
     */
    public function actionOtherList()
    {
        $models = ResponseOther::find()
            ->select('other_id as id,response as name')
            ->asArray()->all();
        echo json_encode($models);
    }


    /**
     * ลบคำตอบของหัวข้อแบบสอบถามประเภท Radio
     */
    public function actionClearAnswerRadio()
    {
        $radio = Yii::$app->request->post();
        $result = [];
        if ($radio['qid'] > 0) {
            if (\backend\modules\crm\models\Question::TYPE_RADIO == $radio['qtype']) {
                $ans = ResponseSingle::find()->where(['question_id' => $radio['qid'], 'response_id' => $radio['responseid']])->one();
                if ($ans) {
                    $deletedChoice = $ans->delete();
                    if($deletedChoice){
                        ResponseOther::deleteAll(['choice_id' => $ans->choice_id]);
                    }
                    $result = ['success' => true, 'message' => 'ลบตำตอบเรียบร้อยแล้ว'];
                } else {
                    $result = ['success' => false, 'message' => 'ไม่พบคำตอบข้อนี้'];
                }
            }
        }
        echo json_encode($result);
    }


    /**
     * ข้อมูลแบบสอบถามตามโครงการ
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionGetSurvey()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $site_id = $parents[0];
                $out = Survey::find()->select(['id', 'name'])->where(['site_id' => $site_id])->all();
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }



}
