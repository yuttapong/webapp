<?php


namespace backend\modules\fix\controllers;


use backend\models\SysKeyRun;
use backend\modules\crm\models\Customer;
use backend\modules\fix\models\InformFix;
use backend\modules\fix\models\InformFixSearch;
use backend\modules\fix\models\InformJob;
use backend\modules\fix\models\InformJobSearch;
use backend\modules\fix\models\Question;
use backend\modules\fix\models\ResponseChoice;
use backend\modules\fix\models\ResponseOther;
use backend\modules\fix\models\ResponseText;
use backend\modules\fix\models\SendDocuments;
use backend\modules\fix\models\Uploads;
use backend\modules\fix\models\WorkEvent;
use backend\modules\org\models\OrgApprove;
use common\models\Home;
use common\models\JobList;
use common\models\Project;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\BaseFileHelper;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


/**
 * InformFixController implements the CRUD actions for InformFix model.
 */
class InformFixController extends Controller
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
                    'delete' => [
                        'post'
                    ],
                    'delete-address' => [
                        'post'
                    ]
                ]
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
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

    /**
     * Lists all InformFix models.
     *
     * @return mixed
     */

    public function actionIndex()
    {
        $searchModel = new InformFixSearch ();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            $keys = Yii::$app->request->post('editableKey');
            $editableAttribute = Yii::$app->request->post('editableAttribute');
            $model = $this->findModel($keys);
            $option = [];
            if ($model->option != '') {
                $option = unserialize($model->option);
            }

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = [];
            $posted = current($_POST ['InformFix']);
            $post = [
                'InformFix' => $posted
            ];

            if ($model->load($post)) {
                $ModelJob = $model->informJobs;
                if (count($ModelJob) > 0) {
                    $textJob = '';
                    $i = 1;
                    foreach ($ModelJob as $val) {
                        $textJob .= $i . ' ' . $val->list;
                        if ($i / count($ModelJob) != 1) {
                            $textJob .= '<br>';
                        };
                        $i++;
                    }
                    $option['inforJob'] = $textJob;
                }

                if ($editableAttribute == 'work_status' && $posted['work_status'] == '3') {
                    $model->option = serialize($option);
                }
                $model->save();
                $value = $model->workStatus [$model->work_status];
                return [
                    'output' => $value,
                    'message' => ''
                ];
            } else {
                return [
                    'output' => '',
                    'message' => ''
                ];
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);

    }


    /**
     * Finds the InformFix model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return InformFix the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)
    {
        if (($model = InformFix::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException ('The requested page does not exist.');
        }
    }


    /**
     * Displays a single InformFix model.
     *
     * @param integer $id
     * @return mixed
     */

    public function actionView($id)
    {
        $searchModel = new InformJobSearch ();
        $arr ['InformJobSearch'] ['inform_fix_id'] = $id;
        $dataProvider = $searchModel->search($arr);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider
        ]);
    }


    /**
     * Creates a new InformFix model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new InformFix ();
        $modelJob = [new InformJob ()];
        $modelhome = [];
        $post = Yii::$app->request->post();
        if (isset ($post ['InformFix'] ['project_id'])) {
            if ($post ['InformFix'] ['project_id'] != '') {
                $modelhome = $this->getHomeList($post ['InformFix'] ['project_id']);
            }
        }
        $chek_new = 0;
        $prefixname = $firstname = $lastname = '';
        if ($post) {
            if (trim($post ['customer_id']) == 'new' || $post ['customer_id'] == '') {
                $customer_name = explode(" ", $_POST ['InformFix'] ['customer_name']);
                if (count($customer_name) < 2) {
                    $chek_new = 1;
                } else {
                    $firstname = $customer_name [0];
                    $lastname = $customer_name [1];
                }
            }
        }

        if ($model->load($post) && $chek_new == 0) {


            if (trim($post ['customer_id']) == 'new' || $_POST ['customer_id'] == '') {
                $custmoer = new Customer ();
                $custmoer->firstname = $firstname;
                $custmoer->lastname = $lastname;
                $custmoer->gender = 'N';
                $custmoer->active = '1';
                $custmoer->prefixname = $_POST ['InformFix'] ['prefixname'];
                $custmoer->save();
                $model->customer_id = $custmoer->id;
            }


            $keyrun = SysKeyRun::generateKey([
                'tableName' => InformFix::CODE_TABLE_NAME,
                'prefix' => (date('Y') + 543) . '_' . $model->project_id
            ]);

            $model->code = $model->project->slug . '-' . $keyrun->seq_count . '/' . (date('Y') + 543);
            $model->save();
            $this->Uploads(false, $model->id);
            $this->proJoB($model->id, $post);
            return $this->redirect([
                'view',
                'id' => $model->id
            ]);
        } else {


            return $this->render('create', [


                'model' => $model,


                'modelhome' => $modelhome,


                'modelJob' => $modelJob

            ]);

        }

    }

    public function getHomeList($project_id)
    {

        $model_p = Project::findOne($project_id);


        $modelhome = [];


        foreach ($model_p->home as $val) {


            $modelhome [$val->id] = 'แปลง ' . $val->plan_no . ' เลขที่ ' . $val->home_no;

        }


        return $modelhome;

    }

    private function Uploads($isAjax = false, $id = '')
    {

        if (Yii::$app->request->isPost) {


            $images = UploadedFile::getInstancesByName('upload_files');


            if ($images) {


                if ($isAjax === true) {


                    $requestId = Yii::$app->request->post('request_id');

                } else {


                    // $emp = Yii::$app->request->post('InformFix');


                    $requestId = $id;

                }


                $this->CreateDir($requestId);


                echo $id;


                foreach ($images as $file) {


                    $fileName = $file->baseName . '.' . $file->extension;


                    $realFileName = md5($file->baseName . time()) . '.' . $file->extension;


                    $savePath = InformFix::UPLOAD_PATH . '/' . $requestId . '/' . $realFileName;


                    if ($file->saveAs($savePath)) {


                        if ($this->isImage(Url::base(true) . '/' . $savePath)) {


                            $this->createThumbnail($requestId, $realFileName);

                        }


                        $model = new Uploads ();


                        $model->ref = $requestId;


                        $model->file_name = $fileName;


                        $model->table_name = 'fix_inform_fix';


                        $model->real_filename = $realFileName;


                        $model->type = $this->isImageType(Url::base(true) . '/' . $savePath);;


                        $model->save();


                        if ($isAjax === true) {


                            echo json_encode([

                                'success' => 'true'

                            ]);

                        }

                    } else {


                        if ($isAjax === true) {


                            echo json_encode([

                                'success' => 'false',

                                'eror' => $file->error

                            ]);

                        }

                    }

                }

            }

        }

    }

    private function CreateDir($folderName)
    {

        if ($folderName != NULL) {


            $basePath = InformFix::getUploadPath() . '/';


            if (BaseFileHelper::createDirectory($basePath . $folderName, 0777)) {


                BaseFileHelper::createDirectory($basePath . $folderName . '/thumbnail', 0777);

            }

        }


        return;

    }

    public function isImage($filePath)
    {

        return @is_array(getimagesize($filePath)) ? true : false;

    }

    private function createThumbnail($folderName, $fileName, $width = 250)
    {

        $uploadPath = InformFix::getUploadPath() . '/' . $folderName . '/';


        $file = $uploadPath . $fileName;


        $image = Yii::$app->image->load($file);


        $image->resize($width);


        $image->save($uploadPath . 'thumbnail/' . $fileName);


        return;

    }

    public function isImageType($path)
    {

        $a = getimagesize($path);


        $image_type = $a [2];


        if (in_array($image_type, array(

            IMAGETYPE_GIF,

            IMAGETYPE_JPEG,

            IMAGETYPE_PNG,

            IMAGETYPE_BMP

        ))) {


            return 1;

        }


        return 0;

    }

    public function proJoB($ref_id, $post)
    {

        if (isset ($post ['inv'] ['check']) && count($post ['inv'] ['check']) > 1) {


            foreach ($post ['inv'] ['check'] as $key => $inv) {


                if ($key > 0) {


                    if ($inv == '') {


                        echo $key;


                        $adaptors = new InformJob ();


                        $adaptors->inform_fix_id = $ref_id;


                        if ($post ['InformJob'] [$key] ['job_list_id'] == '' && $post ['InformJob'] [$key] ['list'] != '') {


                            $jobList = new JobList ();


                            $jobList->name = $post ['InformJob'] [$key] ['list'];


                            $jobList->slug = 'fix_inform_fix';


                            $jobList->status = '1';


                            $jobList->save();


                            $adaptors->job_list_id = $jobList->id;

                        } else {


                            $adaptors->job_list_id = $post ['InformJob'] [$key] ['job_list_id'];

                        }


                        $adaptors->list = $post ['InformJob'] [$key] ['list'];


                        $adaptors->save();


                        // $modelInven[]=$adaptors;

                    } elseif ($inv == 'edit') {


                        $adaptors = InformJob::findOne($post ['InformJob'] [$key] ['id']);


                        $adaptors->inform_fix_id = $ref_id;


                        if ($post ['InformJob'] [$key] ['job_list_id'] == '' && $post ['InformJob'] [$key] ['list'] != '') {


                            $jobList = new JobList ();


                            $jobList->name = $post ['InformJob'] [$key] ['list'];


                            $jobList->slug = 'fix_inform_fix';


                            $jobList->status = '1';


                            $jobList->save();


                            $adaptors->job_list_id = $jobList->id;

                        } else {


                            $adaptors->job_list_id = $post ['InformJob'] [$key] ['job_list_id'];

                        }


                        $adaptors->list = $post ['InformJob'] [$key] ['list'];


                        $adaptors->save();

                    } elseif ($inv == 'del') {


                        $adaptors = InformJob::findOne($post ['inv'] ['key'] [$key]);


                        $adaptors->delete();

                    }

                }

            }

        }

    }


    /**
     * Updates an existing InformFix model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {

        $model = $this->findModel($id);


        $modelJob = $model->informJobs;


        $modelhome = [];


        /*

         *

         * upload รูปภาพ

         *

         */


        list ($initialPreview, $initialPreviewConfig) = $this->getInitialPreview($model->id);


        if ($model->project_id != '') {


            $modelhome = $this->getHomeList($model->project_id);

        }


        $post = Yii::$app->request->post();


        if (!empty ($post ['InformFix'] ['date_inform']) && $post ['InformFix'] ['date_inform'] != '' && $post ['InformFix'] ['date_inform'] != '0') {


            $post ['InformFix'] ['date_inform'] = strtotime($post ['InformFix'] ['date_inform']);

        }


        if (!empty ($post ['InformFix'] ['date_modify']) && $post ['InformFix'] ['date_modify'] != '' && $post ['InformFix'] ['date_modify'] != '0') {


            $post ['InformFix'] ['date_modify'] = strtotime($post ['InformFix'] ['date_modify']);

        }


        if ($model->load($post)) {


            if ($model->date_modify != '' && $model->date_modify != '0') {


                $model->date_modify = strtotime($model->date_modify);

            } else {


                $model->date_modify = '';

            }


            $model->save();


            $this->Uploads(false, $model->id);


            $this->proJoB($model->id, $post);


            return $this->redirect([


                'view',


                'id' => $model->id

            ]);

        } else {


            $model->date_inform = date("d-m-Y H:i", $model->date_inform);


            if ($model->date_modify != '' && $model->date_modify != '0') {


                $model->date_modify = date("d-m-Y H:i", $model->date_modify);

            } else {


                $model->date_modify = '';

            }


            return $this->render('update', [


                'model' => $model,


                'modelhome' => $modelhome,


                'modelJob' => (empty ($modelJob)) ? [

                    new InformJob ()

                ] : $modelJob,


                'initialPreview' => $initialPreview,


                'initialPreviewConfig' => $initialPreviewConfig

            ]);

        }

    }

    private function getInitialPreview($token_forupload)
    {

        $datas = Uploads::find()->where([

            'ref' => $token_forupload

        ])->all();


        $initialPreview = [];


        $initialPreviewConfig = [];


        foreach ($datas as $key => $value) {


            array_push($initialPreview, $this->getTemplatePreview($value));


            array_push($initialPreviewConfig, [


                'caption' => $value->file_name,


                'width' => '120px',


                'url' => Url::to([

                    'inform-fix/deletefile'

                ]),


                'key' => $value->upload_id

            ]);

        }


        return [

            $initialPreview,

            $initialPreviewConfig

        ];

    }

    private function getTemplatePreview(Uploads $model)
    {

        $filePath = InformFix::getUploadUrl() . '/' . $model->ref . '/thumbnail/' . $model->real_filename;


        $isImage = $this->isImage($filePath);


        if ($isImage) {


            $file = Html::img($filePath, [

                'class' => 'file-preview-image',

                'alt' => $model->file_name,

                'title' => $model->file_name

            ]);

        } else {


            $file = "<div class='file-preview-other'> " .


                "<h2><i class='glyphicon glyphicon-file'></i></h2>" .


                "</div>";

        }


        return $file;

    }


    /**
     * Deletes an existing InformFix model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */

    public function actionDelete($id)
    {

        $model = $this->findModel($id);


        $model->is_delete = 1;


        $model->save();


        return $this->redirect([


            'index'

        ]);

    }

    public function actionListApprever($inform_fix_id)
    {


        // ข้อมูลรายชื่อผู้ที่จะอนุมัติและอนุมัติไปแล้ว

        $option ['approver_user_id'] = '158';


        $option ['company_id'] = 3;


        $option ['site_id'] = 5;


        $option ['level'] = 0;


        $listApprove = OrgApprove::getDataOrganization(158, 1, $option);


        // $listApprove =OrgApprove::getDataPosition(1);


        $model = $this->findModel($inform_fix_id);


        return $this->renderAjax('list-approve', [


            'model' => $model,


            'listApprove' => $listApprove,


            'inform_fix_id' => $inform_fix_id

        ]);

    }

    public function actionListPr($inform_fix_id)
    {

    }

    public function actionJobList($term)


    {

        $results = [];


        if (Yii::$app->request->isAjax) {


            $q = addslashes($term);


            foreach (JobList::find()->where("(`name` like '%{$q}%') AND status='1' AND slug='fix_inform_fix'")->orderBy([

                'name' => SORT_ASC

            ])->all() as $model) {


                $results [] = [


                    'id' => $model ['id'],


                    'label' => $model ['name'],


                    'mater_id' => $model ['mater_id']

                ];

            }

        }


        echo Json::encode($results);

    }

    public function actionUpload()


    {

        $this->Uploads(true);

    }

    public function actionDeletefile()
    {

        $model = Uploads::findOne(Yii::$app->request->post('key'));


        if ($model !== NULL) {


            $filename = InformFix::getUploadPath() . '/' . $model->ref . '/' . $model->real_filename;


            $thumbnail = InformFix::getUploadPath() . '/' . $model->ref . '/thumbnail/' . $model->real_filename;


            if ($model->delete()) {


                @unlink($filename);


                @unlink($thumbnail);


                echo json_encode([

                    'success' => true

                ]);

            } else {


                echo json_encode([

                    'success' => false

                ]);

            }

        } else {


            echo json_encode([

                'success' => false

            ]);

        }

    }

    public function actionDownload($id)
    {

        $model = Uploads::findOne($id);


        $path = InformFix::getUploadPath() . '/' . $model->ref . '/' . $model->real_filename;


        if (file_exists($path)) {


            ini_set('max_execution_time', 5 * 60); // 5 minutes


            return Yii::$app->response->sendFile($path, rand(10, 100) . $model->file_name);


            exit ();

        }

    }

    public function actionSendUser($id)
    {

        $modelMain = $this->findModel($id);


        $model = [new SendDocuments ()];


        if (Yii::$app->request->isAjax) {


            if (!empty ($_POST ['SendDocuments'])) {
                $text = '';
                if (count($modelMain->informJobs) > 0) {
                    $i = 1;
                    foreach ($modelMain->informJobs as $val) {
                        $text .= $i . ' ' . BaseStringHelper::truncate($val->list, 50) . '<br>';
                        $i++;
                    }
                }

                $option ['id'] = $modelMain->id;
                $option ['code'] = $modelMain->code;
                $option ['home_no'] = $modelMain->home->plan_no . ' เลขที่ ' . $modelMain->home->home_no;
                $option ['customer'] = $modelMain->prefixname . ' ' . $modelMain->customer_name;
                $option ['job_name'] = $text;
                $option ['project_name'] = $modelMain->project->name;
                $post = Yii::$app->request->post();
                $dataSen = $this->SendUser($id, $post, $modelMain, $option);
                if ($dataSen ['check'] == 1) {
                    $modelMain->is_send = 1;


                    $modelMain->save();


                    $this->renderPartial('templateWord', [


                        'model' => $modelMain,


                        'file' => false,


                        'dataEmail' => $dataSen

                    ]);


                    echo '1';


                    exit ();

                }

            }

        }


        return $this->renderAjax('_form-sen-document', [


            'model' => $model,


            'modelMain' => $modelMain,


            'id' => $id

        ]);

    }

    public function SendUser($ref_id, $post, $model, $option = [])
    {

        $val ['check'] = 0;


        if (isset ($post ['inv'] ['check']) && count($post ['inv'] ['check']) > 1) {


            foreach ($post ['inv'] ['check'] as $key => $inv) {


                if ($key > 0 && $post ['SendDocuments'] [$key] ['recipient_user_id'] != '') {


                    $val ['check'] = 1;


                    if ($inv == '') {


                        $adaptors = new SendDocuments ();


                        $adaptors->table_name = 'fix_inform_fix';


                        $adaptors->table_key = $ref_id;


                        if ($post ['SendDocuments'] [$key] ['recipient_user_id'] != '') {


                            $adaptors->recipient_user_id = $post ['SendDocuments'] [$key] ['recipient_user_id'];


                            $adaptors->recipient_user_name = $adaptors->getPersonnelName($post ['SendDocuments'] [$key] ['recipient_user_id']);

                        }


                        $adaptors->option = serialize($option);


                        $adaptors->title = $post ['SendDocuments'] [$key] ['title'];


                        $adaptors->recipient_at = time();


                        $adaptors->save();


                        $modelisApp = new \common\models\ListMessage ();


                        $modelisApp->title = $adaptors->listOption;


                        $modelisApp->description = $adaptors->detailOption;


                        $modelisApp->user_id = $adaptors->send_user_id;


                        $modelisApp->user_approver_id = $adaptors->recipient_user_id;


                        $modelisApp->user_approver_name = $adaptors->recipient_user_name;


                        $modelisApp->table_name = $adaptors->table_name;


                        $modelisApp->table_key = $adaptors->table_key;


                        $modelisApp->table_key2 = $adaptors->id;


                        $modelisApp->document_id = '8';


                        $modelisApp->link = Url::to(['/fix/inform-fix/view', 'id' => $model->id]);


                        $modelisApp->company_id = $model->project->company_id;


                        $modelisApp->site_id = $model->project->site_id;


                        $modelisApp->option = serialize($option);

                        $modelisApp->type = '1';

                        $modelisApp->slug = InformFix::DOCUMENT_SLUG;

                        $modelisApp->save();

                    } elseif ($inv == 'edit') {


                        $adaptors = SendDocuments::findOne($post ['InformJob'] [$key] ['id']);


                        if ($post ['SendDocuments'] [$key] ['recipient_user_id'] != '') {


                            $adaptors->recipient_user_id = $post ['SendDocuments'] [$key] ['recipient_user_id'];


                            $adaptors->recipient_user_name = $adaptors->getPersonnelName($post ['SendDocuments'] [$key] ['recipient_user_id']);

                        }


                        $adaptors->title = $post ['SendDocuments'] [$key] ['title'];


                        $adaptors->save();

                    } elseif ($inv == 'del') {


                        $adaptors = SendDocuments::findOne($post ['inv'] ['key'] [$key]);


                        $adaptors->delete();

                    }


                    if ($adaptors->user->email != '') {


                        $val ['user'] [$post ['SendDocuments'] [$key] ['recipient_user_id']] = $adaptors->user->email;

                    }

                }

            }

        }


        return $val;

    }

    public function actionSendDateInsurance($id)
    {


        // _form-sen-date-insurance

        $model = Home::findOne($id);


        if (Yii::$app->request->isAjax) {


            if (!empty ($_POST ['Home'])) {


                $post = Yii::$app->request->post();


                $model->date_insurance = strtotime($post ['Home'] ['date_insurance']);


                $model->save();


                echo '1';


                exit ();

            }

        }


        return $this->renderAjax('_form-sen-date-insurance', [


            'model' => $model

        ]);

    }

    public function actionSendAcknowledge($id)
    {

        $modelSen = SendDocuments::findOne(


            [

                'table_name' => 'fix_inform_fix',

                'table_key' => $id,

                'recipient_user_id' => Yii::$app->user->id,

                'is_khow' => '0'

            ]);


        $post = Yii::$app->request->post();


        if ($post) {


            $option = unserialize($modelSen->option);


            if (!empty ($post ['SendDocuments'] ['option'])) {


                $old_option = unserialize($modelSen->option);


                foreach ($post ['SendDocuments'] ['option'] as $key => $val) {


                    if ($key == 'text_khow') {


                        $option ['text_khow'] = $val;

                    }

                }


                $modelSen->option = serialize($option);


                $modelSen->is_khow = $post ['SendDocuments'] ['is_khow'];


                $modelSen->save();


                $modelisApp = \common\models\ListMessage::findOne(


                    [

                        'table_name' => $modelSen->table_name,

                        'table_key' => $modelSen->table_key,

                        'table_key2' => $modelSen->id

                    ]);


                $modelisApp->app_status = 2;


                $modelisApp->status = 1;


                $modelisApp->save();


                echo 1;


                exit ();

            }

        }


        return $this->renderAjax('_form-sen-acknowledge', [


            'modelSen' => $modelSen

        ]);

    }

    public function actionCustomerList($q = null)
    {

        $query = new Query ();


        $query->select('id,prefixname,firstname,lastname')->from('crm_customer')->where('firstname LIKE "%' . $q . '%"')->orderBy('firstname');


        $command = $query->createCommand();


        $data = $command->queryAll();


        $out = [];


        foreach ($data as $d) {


            $out [] = [

                'id' => $d ['id'],

                'value' => $d ['firstname'] . ' ' . $d ['lastname'],

                'show' => $d ['prefixname'] . ' ' . $d ['firstname'] . ' ' . $d ['lastname'],

                'prefixname' => $d ['prefixname']

            ];

        }


        echo Json::encode($out);

    }

    public function actionDataCustomer($id)
    {

        $model_p = Home::findOne($id);


        if ($model_p->customer_id != '') {


            $out = [

                'id' => $model_p->customer->id,

                'mobile' => $model_p->customer->mobile,

                'prefixname' => $model_p->customer->prefixname,

                'value' => $model_p->customer->firstname . ' ' . $model_p->customer->lastname

            ];

        } else {


            $out = [

                'id' => '',

                'mobile' => '',

                'prefixname' => '',

                'value' => ''

            ];

        }


        echo Json::encode($out);

    }

    public function actionWord($id)
    {

        $model = $this->findModel($id);


        return $this->renderPartial('templateWord', [

            'model' => $model,


            'file' => true

        ]);

    }

    public function actionCustomerService($id)
    {

        $modelMain = $this->findModel($id);


        $post = Yii::$app->request->post();


        if ($post) {


            if (!empty ($post ['ResponseChoice'])) {


                foreach ($post ['ResponseChoice'] as $Vchoices) {


                    if (!empty ($Vchoices ['id'])) {


                        $model = ResponseChoice::findOne($Vchoices ['id']);


                        $model->choice_id = $Vchoices ['choice_id'];


                        $model->save();

                    } elseif (!empty ($Vchoices ['choice_id'])) {


                        $model = new ResponseChoice ();


                        $model->table_name = $Vchoices ['table_talbe'];


                        $model->table_key = $Vchoices ['table_key'];


                        $model->question_id = $Vchoices ['question_id'];


                        $model->choice_id = $Vchoices ['choice_id'];


                        $model->type = $Vchoices ['type'];


                        $model->save();

                    }

                }

            }


            if (!empty ($post ['ResponseOther'])) {


                foreach ($post ['ResponseOther'] as $VOther) {


                    if (!empty ($VOther ['other_id'])) {


                        $model = ResponseOther::findOne($VOther ['other_id']);


                        $model->choice_id = $VOther ['choice_id'];


                        $model->response = $VOther ['response'];


                        $model->save();

                    } elseif (!empty ($VOther ['choice_id'])) {


                        $model = new ResponseOther ();


                        $model->table_name = $VOther ['table_talbe'];


                        $model->table_key = $VOther ['table_key'];


                        $model->question_id = $VOther ['question_id'];


                        $model->choice_id = $VOther ['choice_id'];


                        $model->response = $VOther ['response'];


                        $model->save();

                    }

                }

            }


            if (!empty ($post ['ResponseText'])) {


                foreach ($post ['ResponseText'] as $VText) {


                    // echo $VText['table_key'];


                    $modelText = ResponseText::find()->where('table_name = "fix_inform_fix" AND table_key="' . $VText ['table_key'] . '" AND question_id="' . $VText ['question_id'] . '" ')->one();


                    if (isset ($modelText->question_id)) {


                        $modelText->response = $VText ['response'];


                        $modelText->save();

                    } else {


                        $modelText = new ResponseText ();


                        $modelText->table_name = $VText ['table_talbe'];


                        $modelText->table_key = $VText ['table_key'];


                        $modelText->question_id = $VText ['question_id'];


                        $modelText->response = $VText ['response'];


                        $modelText->save();

                    }

                } // findOne

            }


            return '1';

        }


        $modelQuestion = new Question ();

        $dataq = $modelQuestion->getDataQuestion('fix_inform_fix', $id);


        if (Yii::$app->request->isAjax) {

            return $this->renderAjax('form_customer_service', [

                'dataQuestion' => $dataq,

                'model' => $modelMain

            ]);

        } else {


            return $this->renderPartial('form_customer_service', [

                'dataQuestion' => $dataq

            ]);

        }

    }

}
