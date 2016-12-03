<?php


namespace backend\modules\fix\controllers;


use Yii;
use backend\modules\fix\models\InformFix;
use backend\modules\fix\models\InformFixSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Project;
use yii\helpers\ArrayHelper;
use backend\models\SysKeyRun;
use backend\modules\fix\models\InformJob;
use backend\modules\fix\models\InformJobSearch;
use backend\modules\fix\models\InformMaterial;
use backend\models\Model;
use backend\modules\org\models\OrgApprove;
use common\models\JobList;
use yii\helpers\Json;
use backend\modules\fix\models\Uploads;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\fix\models\SendDocuments;
use yii\helpers\BaseStringHelper;
use common\models\Home;


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
                        'POST'
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);

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


        $arr['InformJobSearch']['inform_fix_id'] = $id;

        $dataProvider = $searchModel->search($arr);
        $dataProvider->sort = false;
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

        $modelJob = [new InformJob];


        $modelhome = [];


        $post = Yii::$app->request->post();

        if (isset ($post ['InformFix'] ['project_id'])) {

            if ($post ['InformFix'] ['project_id'] != '') {

                $modelhome = $this->getHomeList($post ['InformFix'] ['project_id']);

            }

        }

        if ($model->load($post)) {


            $keyrun = SysKeyRun::generateKey([

                'tableName' => InformFix::CODE_TABLE_NAME,

                'prefix' => (date('Y') + 543) . '_' . $model->project_id

            ]);

            $model->code = $keyrun->seq_count . '/' . (date('Y') + 543);

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

                'modelJob' => $modelJob,


            ]);

        }

    }

    public function proJoB($ref_id, $post)
    {

        if (isset($post['inv']['check']) && count($post['inv']['check']) > 1) {

            foreach ($post['inv']['check'] as $key => $inv) {

                if ($key > 0) {

                    if ($inv == '') {

                        $adaptors = new InformJob();

                        $adaptors->inform_fix_id = $ref_id;

                        $adaptors->job_list_id = $post['InformJob'][$key]['job_list_id'];

                        $adaptors->list = $post['InformJob'][$key]['list'];


                        $adaptors->save();

                        //$modelInven[]=$adaptors;

                    } elseif ($inv == 'edit') {

                        $adaptors = InformJob::findOne($post['InformJob'][$key]['id']);

                        $adaptors->inform_fix_id = $ref_id;

                        $adaptors->job_list_id = $post['InformJob'][$key]['job_list_id'];

                        $adaptors->list = $post['InformJob'][$key]['list'];


                        $adaptors->save();


                    } elseif ($inv == 'del') {

                        $adaptors = InformJob::findOne($post['inv']['key'][$key]);

                        $adaptors->delete();

                    }

                }

            }

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


        $model->date_inform = date("d-m-Y H:i", $model->date_inform);

        $modelhome = [];

        /*

         * upload รูปภาพ

         */

        list($initialPreview, $initialPreviewConfig) = $this->getInitialPreview($model->id);

        if ($model->project_id != '') {

            $modelhome = $this->getHomeList($model->project_id);

        }

        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            $this->proJoB($model->id, $post);

            return $this->redirect([

                'view',

                'id' => $model->id

            ]);

        } else {

            return $this->render('update', [

                'model' => $model,

                'modelhome' => $modelhome,


                'modelJob' => (empty($modelJob)) ? [new InformJob] : $modelJob,

                'initialPreview' => $initialPreview,

                'initialPreviewConfig' => $initialPreviewConfig

            ]);

        }

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

    public function actionListApprover($inform_fix_id)
    {

        //ข้อมูลรายชื่อผู้ที่จะอนุมัติและอนุมัติไปแล้ว
        $option['approver_user_id'] = '158';
        $option['company_id'] = 3;
        $option['site_id'] = 5;
        $option['level'] = 0;
        $listApprove = OrgApprove::getDataOrganization(158, 1, $option);
        $model = $this->findModel($inform_fix_id);

        return $this->renderAjax('list-approve', [

            'model' => $model,

            'listApprove' => $listApprove,

            'inform_fix_id' => $inform_fix_id,

        ]);

    }

    public function actionListPr($inform_fix_id)
    {


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

    public function actionJobList($term)

    {

        $results = [];

        if (Yii::$app->request->isAjax) {

            $q = addslashes($term);

            foreach (JobList::find()
                         ->where("(`name` like '%{$q}%') AND mater_id  is not null AND table_name='fix_inform_fix'")
                         ->orderBy(['name' => SORT_ASC])->all() as $model) {

                $results[] = [

                    'id' => $model['id'],

                    'label' => $model['name'],

                    'mater_id' => $model['mater_id'],

                ];

            }

        }


        echo Json::encode($results);


    }


    private function getInitialPreview($token_forupload)
    {

        $datas = Uploads::find()->where(['ref' => $token_forupload])->all();

        $initialPreview = [];

        $initialPreviewConfig = [];

        foreach ($datas as $key => $value) {

            array_push($initialPreview, $this->getTemplatePreview($value));

            array_push($initialPreviewConfig, [

                'caption' => $value->file_name,

                'width' => '120px',

                'url' => Url::to(['inform-fix/deletefile']),

                'key' => $value->upload_id

            ]);

        }

        return [$initialPreview, $initialPreviewConfig];

    }

    public function actionUpload()

    {


        $this->Uploads(true);

    }

    private function Uploads($isAjax = false, $id = '')
    {

        if (Yii::$app->request->isPost) {

            $images = UploadedFile::getInstancesByName('upload_files');

            if ($images) {


                if ($isAjax === true) {

                    $requestId = Yii::$app->request->post('request_id');

                } else {

                    //$emp = Yii::$app->request->post('InformFix');

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


                        $model = new Uploads;

                        $model->ref = $requestId;

                        $model->file_name = $fileName;

                        $model->table_name = 'fix_inform_fix';

                        $model->real_filename = $realFileName;

                        $model->type = $this->isImageType(Url::base(true) . '/' . $savePath);;

                        $model->save();


                        if ($isAjax === true) {

                            echo json_encode(['success' => 'true']);

                        }


                    } else {

                        if ($isAjax === true) {

                            echo json_encode(['success' => 'false', 'eror' => $file->error]);

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

    public function isImageType($path)
    {

        $a = getimagesize($path);

        $image_type = $a[2];


        if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {

            return 1;

        }

        return 0;

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

    private function getTemplatePreview(Uploads $model)
    {

        $filePath = InformFix::getUploadUrl() . '/' . $model->ref . '/thumbnail/' . $model->real_filename;

        $isImage = $this->isImage($filePath);

        if ($isImage) {

            $file = Html::img($filePath, ['class' => 'file-preview-image', 'alt' => $model->file_name, 'title' => $model->file_name]);

        } else {

            $file = "<div class='file-preview-other'> " .

                "<h2><i class='glyphicon glyphicon-file'></i></h2>" .

                "</div>";

        }

        return $file;

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

                echo json_encode(['success' => true]);

            } else {

                echo json_encode(['success' => false]);

            }

        } else {

            echo json_encode(['success' => false]);

        }

    }

    public function actionDownload($id)
    {

        $model = Uploads::findOne($id);

        $path = InformFix::getUploadPath() . '/' . $model->ref . '/' . $model->real_filename;

        if (file_exists($path)) {

            ini_set('max_execution_time', 5 * 60); // 5 minutes


            return Yii::$app->response->sendFile($path, rand(10, 100) . $model->file_name);

            exit();

        }


    }

    public function actionSendUser($id)
    {

        $modelMain = $this->findModel($id);

        $model = [new SendDocuments];


        if (Yii::$app->request->isAjax) {

            if (!empty($_POST['SendDocuments'])) {

                $text = '';

                if (count($modelMain->informJobs) > 0) {

                    $i = 1;

                    foreach ($modelMain->informJobs as $val) {

                        $text .= $i . ' ' . BaseStringHelper::truncate($val->list, 50) . '<br>';

                        $i++;

                    }

                }

                $option['id'] = $modelMain->id;

                $option['code'] = $modelMain->code;

                $option['home_no'] = $modelMain->home->plan_no . ' เลขที่ ' . $modelMain->home->home_no;

                $option['customer'] = $modelMain->prefixname . ' ' . $modelMain->customer_name;

                $option['job_name'] = $text;

                $option['project_name'] = $modelMain->project->name;

                $post = Yii::$app->request->post();

                $this->SendUser($id, $post, $modelMain, $option);


                $modelMain->is_send = 1;

                $modelMain->save();



                echo '1';
                exit();

            }

            //

        }

        return $this->renderAjax('_form-sen-document', [

            'model' => $model,

            'modelMain' => $modelMain,

            'id' => $id

        ]);


        /*\Yii::$app->mailer->compose()

        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])

        ->setTo('charin.k@sirivalai.co.th')

        ->setSubject('ทดสอบ')

        ->setTextBody('Plain text content')

        ->setHtmlBody('<b>HTML content</b>')

        ->send();*/


    }

    public function actionSendDateInsurance($id)
    {
        $model = Home::findOne($id);
        if (Yii::$app->request->isAjax) {
            if (!empty($_POST['Home'])) {
                $post = Yii::$app->request->post();
                $model->date_insurance = strtotime($post['Home']['date_insurance']);
                $model->save();
                echo '1';
                exit();
            }
        }

        return $this->renderAjax('_form-sen-date-insurance', [
            'model' => $model,
        ]);

    }


    public function SendUser($ref_id, $post, $model, $option = [])
    {

        if (isset($post['inv']['check']) && count($post['inv']['check']) > 1) {

            foreach ($post['inv']['check'] as $key => $inv) {

                if ($key > 0) {

                    if ($inv == '') {

                        $adaptors = new SendDocuments();

                        $adaptors->table_name = 'fix_inform_fix';

                        $adaptors->table_key = $ref_id;

                        if ($post['SendDocuments'][$key]['recipient_user_id'] != '') {

                            $adaptors->recipient_user_id = $post['SendDocuments'][$key]['recipient_user_id'];

                            $adaptors->recipient_user_name = $adaptors->getPersonnelName($post['SendDocuments'][$key]['recipient_user_id']);

                        }

                        $adaptors->option = serialize($option);

                        $adaptors->title = $post['SendDocuments'][$key]['title'];

                        $adaptors->recipient_at = time();

                        $adaptors->save();

                        $modelisApp = new \common\models\ListMessage();

                        $modelisApp->titie = $adaptors->listOption;

                        $modelisApp->description = $adaptors->detailOption;

                        $modelisApp->user_id = $adaptors->send_user_id;

                        $modelisApp->user_apprever_id = $adaptors->recipient_user_id;

                        $modelisApp->user_apprever_name = $adaptors->recipient_user_name;

                        $modelisApp->table_name = $adaptors->table_name;

                        $modelisApp->table_key = $adaptors->table_key;

                        $modelisApp->table_key2 = $adaptors->id;

                        $modelisApp->document_id = '8';

                        $modelisApp->link = Url::to(['/fix/inform-fix/view', 'id' => $model->id]);

                        $modelisApp->company_id = $model->project->company_id;

                        $modelisApp->site_id = $model->project->site_id;

                        $modelisApp->option = serialize($option);

                        $modelisApp->type = '1';

                        $modelisApp->module_id = '11';

                        $modelisApp->save();


                    } elseif ($inv == 'edit') {

                        $adaptors = SendDocuments::findOne($post['InformJob'][$key]['id']);

                        if ($post['SendDocuments'][$key]['recipient_user_id'] != '') {

                            $adaptors->recipient_user_id = $post['SendDocuments'][$key]['recipient_user_id'];

                            $adaptors->recipient_user_name = $adaptors->getPersonnelName($post['SendDocuments'][$key]['recipient_user_id']);

                        }

                        $adaptors->title = $post['SendDocuments'][$key]['title'];

                        $adaptors->save();


                    } elseif ($inv == 'del') {

                        $adaptors = SendDocuments::findOne($post['inv']['key'][$key]);

                        $adaptors->delete();

                    }

                }

            }

        }

    }

    public function actionSendAcknowledge($id)
    {


        $modelSen = SendDocuments::findOne(

            ['table_name' => 'fix_inform_fix', 'table_key' => $id, 'recipient_user_id' => Yii::$app->user->id, 'is_khow' => '0']

        );

        $post = Yii::$app->request->post();

        if ($post) {

            $option = unserialize($modelSen->option);

            if (!empty($post['SendDocuments']['option'])) {

                $old_option = unserialize($modelSen->option);

                foreach ($post['SendDocuments']['option'] as $key => $val) {

                    if ($key == 'text_khow') {

                        $option['text_khow'] = $val;

                    }

                }

                $modelSen->option = serialize($option);

                $modelSen->is_khow = $post['SendDocuments']['is_khow'];

                $modelSen->save();


                $modelisApp = \common\models\ListMessage::findOne(

                    ['table_name' => $modelSen->table_name, 'table_key' => $modelSen->table_key, 'table_key2' => $modelSen->id]

                );

                $modelisApp->app_status = 2;

                $modelisApp->status = 1;

                $modelisApp->save();

                echo 1;

                exit();


            }

        }

        return $this->renderAjax('_form-sen-acknowledge', [

            'modelSen' => $modelSen,

        ]);


    }


}
