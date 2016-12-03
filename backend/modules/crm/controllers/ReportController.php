<?php
namespace backend\modules\crm\controllers;

use backend\modules\crm\models\Response;
use backend\modules\crm\models\ResponseText;
use backend\modules\crm\models\Survey;
use common\models\GeneralAddress;
use kartik\helpers\Html;
use Yii;
use yii\helpers\Json;
use backend\modules\crm\models\ResponseSearch;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\modules\crm\models\Question;
use backend\modules\crm\models\ResponseOther;
use backend\modules\crm\models\ResponseSingle;
use backend\modules\crm\models\ResponseBoolean;
use backend\modules\crm\models\ResponseMultiple;

class ReportController extends \yii\web\Controller
{

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


    public function actionIndex()
    {
        $searchModel = new ResponseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        /*        $startDate = new \DateTime($this->dateStart);
                $endDate = new  \DateTime($this->dateEnd);
                $today = new \DateTime();
                switch ($this->duration) {
                    case  'today' :
                        $query->andWhere([
                            "DATE_FORMAT(from_unixtime(datetime),'%Y-%m-%d')" => $today->format("Y-m-d"),
                        ]);
                        break;
                    case  'month' :
                        $query->orWhere([
                            "DATE_FORMAT(from_unixtime(datetime),'%Y-%m')" => $startDate->format("Y-m"),
                        ]);
                        $query->orWhere([
                            "DATE_FORMAT(from_unixtime(datetime),'%Y-%m')" => $endDate->format("Y-m"),
                        ]);
                        break;
                    case  'year' :
                        $query->orWhere([
                            'YEAR(from_unixtime(datetime))' => $startDate->format("Y"),
                        ]);
                        $query->orWhere([
                            'YEAR(from_unixtime(datetime))' => $endDate->format("Y"),
                        ]);
                        break;
                    case  'specify' :
                        $query->andWhere([
                                'between',
                                "DATE_FORMAT(from_unixtime(datetime),'%Y-%m-%d')",
                                $startDate->format("Y-m-d"),
                                $endDate->format("Y-m-d")]
                        );
                        break;
                }*/


        $query = Response::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $ok = $dataProvider->getModels();


        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);

    }

    /*
     * ดึงค่าคำตอบของแบบสำรัวจ
     */
    public function actionExport($id)
    {


        $survey_id = $id;


        $models = Question::find()
            ->where(['survey_id' => $survey_id])
            ->orderBy(['seq' => SORT_ASC])
            ->all();

        $arr_survey = []; // แบบฟอร์ม
        $arr_response = [];//เก็บคำตอบ
        $arr_type = [];
        $arr_other = [];

        // $arr_survey เก็บคำภาม และ Choices
        foreach ($models as $val) {
            $arr_survey[$val->id]['question'] = trim($val->name);
            $arr_survey[$val->id]['type_id'] = trim($val->type_id);
            if (count($val->questionChoices) > 0) {
                foreach ($val->questionChoices as $val_choices) {
                    $arr_survey[$val_choices->question_id]['choices'][$val_choices->id * 1] = trim($val_choices->content);
                    $arr_survey[$val_choices->question_id]['type'][$val_choices->id * 1] = trim($val_choices->type);
                }
            }
            $arr_type[$val->type_id] = $val->type_id;
        }

        //// ดึงคำตอบ ของตาราง ResponseOther
        $modelsOther = ResponseOther::find()
            ->innerJoinWith('response')
            ->where(['qtn_response.survey_id' => $survey_id])
            ->all();

        foreach ($modelsOther as $v_qther) {
            $arr_other[$v_qther->response_id][$v_qther->question_id][$v_qther->choice_id][] = trim($v_qther->response);
            $arr_survey[$v_qther->question_id]['other'] = $v_qther->choice_id;
            $arr_survey[$v_qther->question_id]['type_id'] = 0;
            $arr_response[$v_qther->response_id]['other'][$v_qther->question_id][$v_qther->choice_id][] = trim($v_qther->response);

        }

        // ดึงซื้อลูกค้า
        $modelsResponse = Response::find()
            ->innerJoinWith('survey')
            ->where(['qtn_response.survey_id' => $survey_id])
            ->orderBy(['qtn_response.id' => SORT_DESC])
            ->all();


        //ดึงคำตอบ แต่่ละ type ออกมา
        foreach ($arr_type as $val) {

            if ($val == Question::TYPE_TEXT
                || $val == Question::TYPE_TEXTAREA
                || $val == Question::TYPE_NUMBER
                || $val == Question::TYPE_BOOLEAN
                || $val == Question::TYPE_DATE
            ) {
                $modelsResponseText = ResponseText::find()
                    ->innerJoinWith('response')
                    ->where(['qtn_response.survey_id' => $survey_id])
                    ->all();
                if ($modelsResponseText) {
                    foreach ($modelsResponseText as $v_text) {
                        $arr_response[$v_text->response_id]['name'] = null;
                        $arr_response[$v_text->response_id]['question'][$v_text->question_id] = $v_text->response;
                    }
                }
            } elseif ($val == Question::TYPE_RADIO) {

                $modelsSingle = ResponseSingle::find()
                    ->innerJoinWith('response')
                    ->where(['qtn_response.survey_id' => $survey_id])
                    ->all();

                foreach ($modelsSingle as $v_single) {
                    $answer = $arr_survey[$v_single->question_id]['choices'][$v_single->choice_id];
                    // $arr_response[$v_single->response_id]['name'] = trim($arr_response_name[$v_single->response_id]['name']);
                    $arr_response[$v_single->response_id]['question'][$v_single->question_id] = $answer;
                }
            } elseif ($val == Question::TYPE_CHECKBOX) {
                $modelsMultiple = ResponseMultiple::find()
                    ->select('qtn_response_multiple.*,qtn_response.table_key ')
                    ->innerJoinWith('response')
                    ->where(['qtn_response.survey_id' => $survey_id])
                    ->all();

                foreach ($modelsMultiple as $v_multiple) {
                    $answer = $arr_survey[$v_multiple->question_id]['choices'][$v_multiple->choice_id];
                    // $arr_response[$v_multiple->response_id]['name'] = $arr_response_name[$v_multiple->response_id]['name'];
                    $arr_response[$v_multiple->response_id]['question'][$v_multiple->question_id][$v_multiple->choice_id] = $answer;
                }
            }

        }

        return $this->render('_list_table', [
            'arr_survey' => $arr_survey,
            'arr_response' => $arr_response,
            'arr_other' => $arr_other,
            'modelResponse' => $modelsResponse,
        ]);

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


    /*
     * ดึงค่าคำตอบของแบบสำรัวจ
     */
    public function actionExcel()
    {
        $table = '';

        if (Yii::$app->request->post()) {

            $params = Yii::$app->request->post('Response');

            $survey_id = isset($params['survey_id']) ? $params['survey_id'] : '';
            if ($survey_id > 0) {

                $startDate = $params['dateStart'];
                $endDate = $params['dateEnd'];

                // แบบสอบถามทั้งหมด
                $modelsResponse = Response::find()
                    ->innerJoinWith('survey')
                    ->where(['qtn_response.survey_id' => $survey_id])
                    ->andWhere([
                        'between',
                        "DATE_FORMAT(from_unixtime(qtn_response.datetime),'%Y-%m-%d')",
                        $startDate,
                        $endDate
                    ])
                    ->orderBy(['qtn_response.datetime' => SORT_DESC])
                    ->all();


                $modelsQuestion = Question::find()
                    ->where(['survey_id' => $survey_id])
                    ->orderBy(['seq' => SORT_ASC])
                    ->all();

                $arr_survey = []; // แบบฟอร์ม
                $arr_response = [];//เก็บคำตอบ
                $arr_type = [];
                $_header = [];
                $_answer = [];

                // คำถามทั้งหมด
                foreach ($modelsQuestion as $question) {
                    $arr_survey[$question->id] = [
                        'question' => trim($question->name),
                        'type_id' => $question->type_id,
                        'seq' => $question->seq,
                    ];

                    if (count($question->questionChoices) > 0) {
                        foreach ($question->questionChoices as $choice) {
                            $arr_survey[$choice->question_id]['choices'][$choice->id * 1] = trim($choice->content);
                            $arr_survey[$choice->question_id]['type'][$choice->id * 1] = trim($choice->type);
                        }
                    }
                    $arr_type[$question->type_id] = $question->type_id;
                }
                //// ดึงคำตอบ ของตาราง ResponseOther
                $modelsOther = ResponseOther::find()
                    ->innerJoinWith('response')
                    ->where(['qtn_response.survey_id' => $survey_id])
                    ->all();

                $arr_other = [];
                foreach ($modelsOther as $v_qther) {
                    $arr_other[$v_qther->response_id][$v_qther->question_id][$v_qther->choice_id][] = trim($v_qther->response);
                    $arr_survey[$v_qther->question_id]['other'] = $v_qther->choice_id;
                    $arr_response[$v_qther->response_id]['other'][$v_qther->question_id][$v_qther->choice_id][] = trim($v_qther->response);
                }
                //คำตอบของแต่ละประเภททั้งหมด
                $modelsResponseText = ResponseText::find()
                    ->innerJoinWith('response')
                    ->where(['qtn_response.survey_id' => $survey_id])
                    ->all();
                $modelsSingle = ResponseSingle::find()
                    ->innerJoinWith('response')
                    ->where(['qtn_response.survey_id' => $survey_id])
                    ->all();
                $modelsMultiple = ResponseMultiple::find()
                    ->select('qtn_response_multiple.*,qtn_response.table_key ')
                    ->innerJoinWith('response')
                    ->where(['qtn_response.survey_id' => $survey_id])
                    ->all();


                //ดึงคำตอบทั้งหมด
                foreach ($arr_type as $val) {
                    if ($val == Question::TYPE_TEXT
                        || $val == Question::TYPE_TEXTAREA
                        || $val == Question::TYPE_NUMBER
                        || $val == Question::TYPE_BOOLEAN
                        || $val == Question::TYPE_DATE
                    ) {
                        if ($modelsResponseText) {
                            foreach ($modelsResponseText as $v_text) {
                                $arr_response[$v_text->response_id][$v_text->question_id] = [
                                    'question_id' => $v_text->question_id,
                                    'question_name' => $arr_survey[$v_text->question_id]['question'],
                                    'choice_id' => null,
                                    'answer' => $v_text->response,
                                ];
                            }
                        }
                    } elseif ($val == Question::TYPE_RADIO) {
                        foreach ($modelsSingle as $v_single) {
                            $answer = $arr_survey[$v_single->question_id]['choices'][$v_single->choice_id];
                            $arr_response[$v_single->response_id][$v_single->question_id] = [
                                'question_id' => $v_single->question_id,
                                'question_name' => $arr_survey[$v_single->question_id]['question'],
                                'choice_id' => $v_single->choice_id,
                                'answer' => $answer,
                            ];
                        }
                    } elseif ($val == Question::TYPE_CHECKBOX) {

                        foreach ($modelsMultiple as $v_multiple) {
                            $answer = $arr_survey[$v_multiple->question_id]['choices'][$v_multiple->choice_id];
                            $arr_response[$v_multiple->response_id][$v_multiple->question_id][$v_multiple->choice_id] = [
                                'question_id' => $v_multiple->question_id,
                                'question_name' => $arr_survey[$v_multiple->question_id]['question'],
                                'choice_id' => $v_multiple->choice_id,
                                'answer' => $answer,
                            ];
                        }
                    }
                }


                if (!empty($modelsResponse)) {
                    $table .= '<table border="1">';
                    $table .= ' <tr>';
                    $table .= '<td nowrap>#</td>';
                    $table .= '<td nowrap>วันที่</td>';
                    $table .= '<td nowrap>CE</td>';
                    $table .= '<td nowrap>รหัสลูกค้า</td>';
                    $table .= '<td nowrap>ชือ</td>';
                    $table .= '<td nowrap>สกุล</td>';
                    $table .= '<td nowrap>มือถือ</td>';
                    $table .= '<td nowrap>เบอร์โทรบ้าน</td>';
                    $table .= '<td nowrap>e-mail</td>';
                    $table .= '<td nowrap>ตำบล</td>';
                    $table .= '<td nowrap>อำเภอ</td>';
                    $table .= '<td nowrap>จังหวัด</td>';
                    $_header[] = '#';
                    $_header[] = 'วันที่';
                    $_header[] = 'CE';
                    $_header[] = 'รหัสลูกค้า';
                    $_header[] = 'ชื่อ';
                    $_header[] = 'นามสกุล';
                    $_header[] = 'มือถือ';
                    $_header[] = 'เบอร์โทรบ้าน';
                    $_header[] = 'e-mail';
                    $_header[] = 'ตำบล';
                    $_header[] = 'อำเภอ';
                    $_header[] = 'จังหวัด';
                    if (isset($arr_survey)) {
                        foreach ($arr_survey as $questionId => $question) {
                            if ($question['type_id'] == Question::TYPE_RADIO) {
                                $titleRadio = "{$question['seq']}) {$question['question']}";
                                $table .= "<th nowrap>" . $titleRadio . "</th>";
                                $_header[] = $titleRadio;
                                if (isset($question['other'])) {
                                    $titleRadioOther = $question['seq'] . '.1) อื่น ๆ';
                                    $table .= '<th nowrap>' . $titleRadioOther . '</th>';
                                    $_header[] = $titleRadioOther;
                                }

                            } elseif ($question['type_id'] == Question::TYPE_CHECKBOX) {
                                $titleCheckbox = "{$question['seq']}) {$question['question']}";
                                $table .= "<th nowrap nowrap  style=\"color:red;\">{$titleCheckbox}</th>";
                                $_header[] = $titleCheckbox;
                                $j = 1;
                                foreach ($question['choices'] as $choiceId => $choiceTitle) {
                                    $titleCheckboxSub = $question['seq'] . '.' . $j . ') ' . $choiceTitle;
                                    $table .= '<th nowrap>' . $titleCheckboxSub . '</th>';
                                    $_header[] = $titleCheckboxSub;
                                    if ($question['type'][$choiceId] == 'another') {
                                        $titleCheckboxSubOther = "{$question['seq']}.{$j}.1) ";
                                        $_header[] = $titleCheckboxSubOther;
                                        $table .= "<th nowrap>{$titleCheckboxSubOther}</th>";
                                    }
                                    $j++;
                                }
                            } elseif (
                                $question['type_id'] == Question::TYPE_TEXT
                                || $val == Question::TYPE_TEXTAREA
                                || $val == Question::TYPE_NUMBER
                                || $val == Question::TYPE_BOOLEAN
                                || $val == Question::TYPE_DATE
                            ) {
                                $titleText = "{$question['seq']}) {$question['question']} {$question['type_id']}";
                                $_header[] = $titleText;
                                $table .= "<th nowrap>{$titleText}</th>";
                            }
                        }
                    }

                    $table .= '</tr>';
                    foreach ($modelsResponse as $response) {
                        $datetime_format = '';
                        if ($response->datetime > 0) {
                            $datetime_format = date("d-m-Y", $response->datetime);
                        }

                        $contact = GeneralAddress::find()
                            ->where([
                                'type' => GeneralAddress::TYPE_CONTACT,
                                'table_key' => $response->customer->id,

                            ])
                            ->orderBy(['id' => SORT_DESC])
                            ->limit(1)
                            ->one();

                        $table .= ' <tr>';
                        $table .= '<td nowrap>' . $response->id . '</td>';
                        $table .= '<td nowrap>' . $datetime_format . '</td>';
                        $table .= '<td nowrap>' . $response->created->firstname_th . '</td>';
                        $table .= '<td nowrap>' . $response->customer->id . '</td>';
                        $table .= '<td nowrap>' . $response->customer->firstname . '</td>';
                        $table .= '<td nowrap>' . $response->customer->lastname . '</td>';
                        $table .= '<td nowrap>' . $response->customer->mobile . '</td>';
                        $table .= '<td nowrap>' . $response->customer->tel . '</td>';
                        $table .= '<td nowrap>' . $response->customer->email . '</td>';

                        $table .= '<td nowrap>' . @$contact->tambon->name_th. '</td>';
                        $table .= '<td nowrap>' . @$contact->amphur->name_th. '</td>';
                        $table .= '<td nowrap>' . @$contact->province->name_th. '</td>';


                        $_answer[$response->id] = [
                            $response->id,
                            $datetime_format,
                            $response->created->firstname_th,
                            $response->customer->id,
                            $response->customer->firstname,
                            $response->customer->lastname,
                            $response->customer->mobile,
                            $response->customer->tel,
                            $response->customer->email,
                            @$contact->tambon->name_th,
                            @$contact->amphur->name_th,
                            @$contact->province->name_th,

                        ];


                        if (isset($arr_survey)) {
                            foreach ($arr_survey as $questionId => $question) {

                                //คำตอบประเภท Radio
                                if ($question['type_id'] == Question::TYPE_RADIO) {
                                    $table .= "<td nowrap>";
                                    $answerRadio = (isset($arr_response[$response->id][$questionId]['answer'])) ? $arr_response[$response->id][$questionId]['answer'] : '';
                                    $table .= $answerRadio;
                                    array_push($_answer[$response->id], $answerRadio);
                                    $table .= "</td>";
                                    if (isset($question['other'])) {
                                        $table .= '<td nowrap>';
                                        $answerRadioOther = (isset($arr_response[$response->id]['other'][$questionId][$question['other']])) ? implode(",", $arr_response[$response->id]['other'][$questionId][$question['other']]) : '';
                                        $table .= $answerRadioOther;
                                        array_push($_answer[$response->id], $answerRadioOther);
                                        $table .= '</td>';
                                    }

                                } // คำตอบประเภท checkbox
                                elseif ($question['type_id'] == Question::TYPE_CHECKBOX) {
                                    $titleCheckboxHeader = "{$question['seq']}) {$question['question']}";
                                    array_push($_answer[$response->id], $titleCheckboxHeader);
                                    $table .= "<td nowrap  style=\"color:red;\">{$titleCheckboxHeader}</td>";
                                    $j = 1;
                                    foreach ($question['choices'] as $choiceId => $choiceTitle) {
                                        $table .= '<td nowrap>';
                                        $answerCheckbox = (isset($arr_response[$response->id][$questionId][$choiceId]['answer'])) ? $arr_response[$response->id][$questionId][$choiceId]['answer'] : '';
                                        array_push($_answer[$response->id], $answerCheckbox);
                                        $table .= $answerCheckbox;
                                        $table .= '</td>';
                                        if ($question['type'][$choiceId] == 'another') {
                                            $table .= '<td nowrap>';
                                            $answerCheckboxOther = (isset($arr_response[$response->id]['other'][$questionId][$choiceId]) ? implode('<br>', $arr_response[$response->id]['other'][$questionId][$choiceId]) : '');
                                            array_push($_answer[$response->id], $answerCheckboxOther);
                                            $table .= $answerCheckboxOther;
                                            $table .= '</td>';
                                        }
                                        $j++;
                                    }
                                } // คำตอบประเภทอื่น ๆ
                                elseif (
                                    $question['type_id'] == Question::TYPE_TEXT
                                    || $val == Question::TYPE_TEXTAREA
                                    || $val == Question::TYPE_NUMBER
                                    || $val == Question::TYPE_BOOLEAN
                                    || $val == Question::TYPE_DATE
                                ) {
                                    $table .= '<td nowrap>';
                                    $answerText = (isset($arr_response[$response->id][$questionId]['answer'])) ? $arr_response[$response->id][$questionId]['answer'] : '';
                                    array_push($_answer[$response->id], $answerText);
                                    $table .= $answerText;
                                    $table .= '</td>';
                                }


                            }
                        }
                        $table .= '</tr>';

                    }
                     $table .= '</table>';

                    // $this->print_r($_header);
                    // $this->print_r($_answer);

                }

                $file = \Yii::createObject([
                    'class' => 'codemix\excelexport\ExcelFile',
                    'sheets' => [

                        'Questionnaire Report' => [   // Name of the excel sheet
                            'data' => $_answer,

                            // Set to `false` to suppress the title row
                            'titles' => $_header,

                        ],
                    ]
                ]);
                $qdate = "[{$startDate}_{$endDate}]";
                $fileName = "report-qtn-{$survey_id}{$qdate}_export.xlsx";
                $filePath = Yii::getAlias('@webroot') . '/tmp/' . $fileName;
                $fileUrl = Yii::$app->request->getBaseUrl() . '/tmp/' . $fileName;

                 $file->saveAs($filePath);

                Html::a("ดาวน์โหลด", $fileUrl);
                echo Html::a("คลิกที่นี่ เพื่อดาวโหลดไฟล์ Excel", $fileUrl, ['class' => 'btn btn-default']);
            } else {
                echo Html::tag('p', 'โปรดเลือกประเภทแบบสอบถามและช่วงเวลา');
            }

        } else {
            $modelsResponse = new Response();
            return $this->render('excel', [
                'modelResponse' => $modelsResponse,
            ]);
        }
    }


    public function print_r($str)
    {
        echo '<pre>';
        print_r($str);
        echo '</pre>';
    }
}
