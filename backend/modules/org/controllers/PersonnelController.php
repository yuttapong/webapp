<?php

namespace backend\modules\org\controllers;

use backend\modules\org\models\OrgPersonnelPosition;
use common\models\SysAmphur;
use common\models\User;
use Imagine\Image\Box;
use Yii;
use yii\base\Exception;
use yii\debug\Module;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\org\models\OrgPersonnel;
use backend\modules\org\models\OrgPersonnelSearch;
use backend\modules\org\models\OrgPersonnelEducation;
use backend\modules\org\models\OrgPersonnelWork;
use backend\modules\org\models\OrgReasonForLeaving;
use backend\modules\org\models\OrgGallery;
use backend\models\Model;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\helpers\BaseFileHelper;
use yii\helpers\Html;
use yii\filters\AccessControl;

/**
 * PersonnelController implements the CRUD actions for OrgPersonnel model.
 */
class PersonnelController extends Controller
{

    const STATUS_ACTIVE = 1;
    const  STATUS_INACTIVE = 0;


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

    /**
     * Lists all OrgPersonnel models.
     * @return mixed
     */
    public function actionIndex()
    {


        $searchModel = new OrgPersonnelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrgPersonnel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        /*
        $model->jobs = OrgPersonnelWork::find()
            ->where(['personnel_id' => $id])
            ->orderBy('seq')
            ->all();
        $model->educations = OrgPersonnelEducation::find()
            ->where(['personnel_id' => $id])
            ->orderBy('sorter')
            ->all();
        $model->reasonLeaving = OrgReasonForLeaving::find()
            ->where(['personnel_id' => $id])->one();
        */

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new OrgPersonnel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrgPersonnel();
        $modelsEducation = [new OrgPersonnelEducation];
        $modelsWork = [new OrgPersonnelWork];
        $modelsReasonLeaving = [new OrgReasonForLeaving];
        $modelsPosition = [new OrgPersonnelPosition];

        if ($model->load(Yii::$app->request->post())) {


            $modelsEducation = Model::createMultiple(OrgPersonnelEducation::className());
            Model::loadMultiple($modelsEducation, Yii::$app->request->post());


            $modelsWork = Model::createMultiple(OrgPersonnelWork::className());
            Model::loadMultiple($modelsWork, Yii::$app->request->post());


            $modelsReasonLeaving = Model::createMultiple(OrgReasonForLeaving::className());
            Model::loadMultiple($modelsReasonLeaving, Yii::$app->request->post());

            //validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsEducation) && $valid;
            $valid = Model::validateMultiple($modelsWork) && $valid;
            $valid = Model::validateMultiple($modelsReasonLeaving) && $valid;


            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {


                        //education
                        $eduSorter = 1;
                        foreach ($modelsEducation as $edu) {
                            $edu->personnel_id = $model->id;
                            $edu->sorter = $eduSorter;
                            if ($edu->education_name != '') {
                                if (!($flag = $edu->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                                $eduSorter++;
                            }
                        }

                        //work
                        $seqWork = 1;
                        foreach ($modelsWork as $work) {
                            $work->personnel_id = $model->id;
                            $work->seq = $seqWork;
                            if ($work->position_name != '') {
                                if (!($flag = $work->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                                $seqWork++;
                            }
                        }

                        //reason leaving

                        foreach ($modelsReasonLeaving as $rv) {
                            $rv->personnel_id = $model->id;
                            if ($rv->note != '') {
                                if (!($flag = $rv->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }

                    }


                    if ($flag) {
                        $transaction->commit();
                        $this->UploadPhoto(false);
                        Yii::$app->session->setFlash('success', 'Successfully');
                        return $this->redirect("update", ['id' => $model->id]);
                    }


                } catch (Exception $e) {
                    Yii::$app->session->setFlash('danger', 'Error: ' . $e->getMessage());
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'tab' => isset($tab) ? $tab : '',
            'modelsEducation' => (empty($modelsEducation) ? [new OrgPersonnelEducation] : $modelsEducation),
            'modelsWork' => (empty($modelsWork) ? [new OrgPersonnelWork] : $modelsWork),
            'modelsReasonLeaving' => (empty($modelsReasonLeaving) ? [new OrgReasonForLeaving] : $modelsReasonLeaving),
            'modelsPosition' => (empty($modelsPosition) ? [new OrgPersonnelPosition] : $modelsPosition),
            'citizenAmphur' => [],
            'initialPreviewPhoto' => [],
            'initialPreviewPhotoConfig' => []
        ]);
    }

    /**
     * Updates an existing OrgPersonnel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $tab = 'general')
    {
        $model = $this->findModel($id);


        list($initialPreviewPhoto, $initialPreviewPhotoConfig) = $this->getInitialPreview($model->id);

        $citizenAmphur = ArrayHelper::map($this->getAmphurByProvince($model->idcard_province_id), 'id', 'name');

        $modelsEducation = OrgPersonnelEducation::find()
            ->where(['personnel_id' => $model->id])
            ->orderBy('sorter')
            ->all();

        $modelsWork = OrgPersonnelWork::find()
            ->where(['personnel_id' => $model->id])
            ->orderBy('seq')
            ->all();

        $modelsReasonLeaving = OrgReasonForLeaving::find()
            ->where(['personnel_id' => $model->id])
            ->all();

        $modelsPosition = OrgPersonnelPosition::find()
            ->where(['personnel_id' => $model->id])
            ->orderBy('sorter')
            ->all();

        $modelsGallery = $model->galleries;


        if ($model->load(Yii::$app->request->post())) {

            $eduOldIDs = ArrayHelper::map($modelsEducation, 'id', 'id');
            $modelsEducation = Model::createMultiple(OrgPersonnelEducation::className(), $modelsEducation);
            Model::loadMultiple($modelsEducation, Yii::$app->request->post());
            $eduDeletedIDs = array_diff($eduOldIDs, array_filter(ArrayHelper::map($modelsEducation, 'id', 'id')));


            $jobOldIDs = ArrayHelper::map($modelsWork, 'id', 'id');
            $modelsWork = Model::createMultiple(OrgPersonnelWork::className(), $modelsWork);
            Model::loadMultiple($modelsWork, Yii::$app->request->post());
            $jobDeletedIDs = array_diff($jobOldIDs, array_filter(ArrayHelper::map($modelsWork, 'id', 'id')));


            $rsOldIDs = ArrayHelper::map($modelsReasonLeaving, 'id', 'id');
            $modelsReasonLeaving = Model::createMultiple(OrgReasonForLeaving::className(), $modelsReasonLeaving);
            Model::loadMultiple($modelsReasonLeaving, Yii::$app->request->post());
            $rsDeletedIDs = array_diff($rsOldIDs, array_filter(ArrayHelper::map($modelsReasonLeaving, 'id', 'id')));


            //validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsEducation) && $valid;
            $valid = Model::validateMultiple($modelsWork) && $valid;
            $valid = Model::validateMultiple($modelsReasonLeaving) && $valid;


            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {


                        //delete education
                        if (!empty($eduDeletedIDs)) {
                            OrgPersonnelEducation::deleteAll(['id' => $eduDeletedIDs]);
                        }

                        //delete job
                        if (!empty($jobDeletedIDs)) {
                            OrgPersonnelWork::deleteAll(['id' => $jobDeletedIDs]);
                        }

                        //delete reason leaving
                        if (!empty($rsDeletedIDs)) {
                            OrgReasonForLeaving::deleteAll(['id' => $rsDeletedIDs]);
                        }

                        //education
                        $eduSorter = 1;
                        foreach ($modelsEducation as $edu) {
                            $edu->personnel_id = $model->id;
                            $edu->sorter = $eduSorter;
                            if ($edu->education_name != '') {
                                if (!($flag = $edu->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                                $eduSorter++;
                            }
                        }

                        //work
                        $seqWork = 1;
                        foreach ($modelsWork as $work) {
                            $work->personnel_id = $model->id;
                            $work->seq = $seqWork;
                            if ($work->position_name != '') {
                                if (!($flag = $work->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                                $seqWork++;
                            }
                        }

                        //reason leaving

                        foreach ($modelsReasonLeaving as $rv) {
                            $rv->personnel_id = $model->id;
                            if ($rv->note != '') {
                                if (!($flag = $rv->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }


                    }
                    if ($flag) {
                        $transaction->commit();

                        //upload photo
                        $this->UploadPhoto(false);


                        //ตรวจสอบสถานะในตาราง user
                        $user = User::find()->where(['username' => $model->user_id])->one();
                        if($user){
                            if ($model->active == 1) {
                                $user->status = User::STATUS_ACTIVE;
                            } else {
                                $user->status = User::STATUS_INACTIVE;
                            }
                            $user->save();
                        }
                  


                        Yii::$app->session->setFlash('success', 'ข้อมูล  <strong>"' . $model->fullnameTH . '"</strong> แก้ไขเรียบร้อย.');
                        //return $this->redirect(['view', 'id' => $model->id]);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('danger', 'ไม่สามารถบันทึกได้');
                    return $e->getMessage();
                }
            }

        }


        return $this->render('update', [
            'model' => $model,
            'tab' => isset($tab) ? $tab : '',
            'modelsEducation' => (empty($modelsEducation) ? [new OrgPersonnelEducation] : $modelsEducation),
            'modelsWork' => (empty($modelsWork) ? [new OrgPersonnelWork] : $modelsWork),
            'modelsReasonLeaving' => (empty($modelsReasonLeaving) ? [new OrgReasonForLeaving] : $modelsReasonLeaving),
            'modelsPosition' => (empty($modelsPosition) ? [new OrgPersonnelPosition] : $modelsPosition),
            'modelsGallery' => (empty($modelsGallery) ? [new OrgGallery] : $modelsGallery),
            'citizenAmphur' => $citizenAmphur,
            'initialPreviewPhoto' => $initialPreviewPhoto,
            'initialPreviewPhotoConfig' => $initialPreviewPhotoConfig,
        ]);
    }


    /**
     * Deletes an existing OrgPersonnel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id)->delete();
        OrgPersonnelEducation::deleteAll(['personnel_id' => $id]);
        OrgPersonnelWork::deleteAll(['personnel_id' => $id]);
        OrgPersonnelPosition::deleteAll(['personnel_id' => $id]);
        OrgReasonForLeaving::deleteAll(['personnel_id' => $id]);
        $this->removeUploadDir($model->id);

        return $this->redirect(['index']);
    }

    /**
     * Finds the OrgPersonnel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrgPersonnel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrgPersonnel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return string|void
     */
    public function actionFormHistoryJob()
    {
        $model = new OrgPersonnelWork();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('_form-history-job', [
            'model' => $model,
        ]);
    }

    public function actionDeleteEducation($id, $personnel_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = OrgPersonnelEducation::deleteAll(['id' => $id, 'personnel_id' => $personnel_id]);
            return $model;
        }


    }


    protected function MapData($datas, $fieldId, $fieldName)
    {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

    protected function getAmphurByProvince($id)
    {
        $models = SysAmphur::find()
            ->where(['province_id' => $id])
            ->orderBy(['name_th' => SORT_ASC])
            ->all();
        return $this->MapData($models, 'id', 'name_th');
    }


    /**
     *
     */
    public function actionGetAmphur()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $province_id = $parents[0];
                $out = $this->getAmphurByProvince($province_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    /**
     * @param $folderName
     * @param $fileName
     * @param int $width
     */
    private function createThumbnail($folderName, $fileName, $width = 250)
    {
        $uploadPath = OrgPersonnel::getPhotoPath() . $folderName . '/';
        $file = $uploadPath . $fileName;

        //Resizing and Preserving Aspect Ratio
        Image::getImagine()
            ->open($file)
            ->thumbnail(new Box(120, 120))
            ->save($uploadPath . 'thumbnail/' . $fileName, ['quality' => 90]);
        return;
    }

    /**
     * @param $ref
     * @return array
     */
    private function getInitialPreview($ref)
    {
        $datas = OrgPersonnel::find()->where(['id' => $ref])->all();
        $initialPreview = [];
        $initialPreviewConfig = [];
        if (!empty($datas)) {
            foreach ($datas as $key => $value) {
                array_push($initialPreview, $this->getTemplatePreview($value));
                array_push($initialPreviewConfig, [
                    //'caption' => $value->firstname_th,
                    'width' => 'auto',
                    'url' => Url::to(['deletephoto-ajax']),
                    'key' => $value->id
                ]);
            }
        }

        return [$initialPreview, $initialPreviewConfig];
    }

    /**
     * @param $filePath
     * @return bool
     */
    public function isImage($filePath)
    {
        return @is_array(getimagesize($filePath)) ? true : false;
    }


    /**
     * @param OrgPersonnel $model
     * @return string
     */
    private function getTemplatePreview(OrgPersonnel $model)
    {
        $file = '';
        $filePath = OrgPersonnel::getPhotoUrl() . $model->id . '/thumbnail/' . $model->photo;
        $isImage = $this->isImage($filePath);
        if ($isImage) {
            $file = Html::img($filePath, [
                'class' => 'file-preview-image',
                'alt' => $model->firstname_th,
                'title' => $model->firstname_th
            ]);
        } else {
            /*
            $file = "<div class='file-preview-other'> " .
                "<h2><i class='fa fa-image'></i></h2>" .
                "</div>";
            */

        }
        return $file;
    }


    /**
     * @param OrgPersonnel $model
     */
    private function delteOldPhoto($model)
    {
        $filename = OrgPersonnel::getPhotoPath() . $model->id . '/' . $model->photo;
        $thumbnail = OrgPersonnel::getPhotoPath() . $model->id . '/thumbnail/' . $model->photo;
        @unlink($filename);
        @unlink($thumbnail);
        return;
    }

    /**
     * @param $folderName
     * @throws Exception
     */
    private function createPhotoDir($folderName)
    {
        if ($folderName != NULL) {
            $basePath = OrgPersonnel::getPhotoPath();
            if (BaseFileHelper::createDirectory($basePath . '/' . $folderName, 0777)) {
                BaseFileHelper::createDirectory($basePath . '/' . $folderName . '/thumbnail', 0777);
            }
        }
        return;
    }

    /**
     * @param $dir
     * @throws \Exception
     * @throws \yii\base\ErrorException
     */
    private function removeUploadDir($dir)
    {
        BaseFileHelper::removeDirectory(OrgPersonnel::getPhotoPath() . $dir);
    }

    /**
     *
     */
    public function actionUploadPhotoAjax()
    {
        $this->uploadPhoto(true);
    }

    /**
     *
     */
    public function actionDeletephotoAjax()
    {

        $model = OrgPersonnel::findOne(Yii::$app->request->post('key'));

        if ($model !== null) {
            $filename = OrgPersonnel::getPhotoPath() . $model->id . '/' . $model->photo;
            $thumbnail = OrgPersonnel::getPhotoPath() . $model->id . '/thumbnail/' . $model->photo;
            $model->photo = NULL;
            if ($model->save()) {
                @unlink($filename);
                @unlink($thumbnail);
                echo json_encode(['success' => true, 'file' => $filename]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    }


    /**
     * @param bool|false $isAjax
     */

    private function uploadPhoto($isAjax = false)
    {

        if (Yii::$app->request->isPost) {
            //$images = UploadedFile::getInstancesByName('uploadPhoto');
            $images = UploadedFile::getInstance(new OrgPersonnel, 'file');
            if ($images) {
                if ($isAjax === true) {
                    $ref = Yii::$app->request->post('ref');
                } else {
                    $OrgPerseonnel = Yii::$app->request->post('OrgPersonnel');
                    $ref = $OrgPerseonnel['id'];


                }
                if (!empty($ref)) {
                    $this->createPhotoDir($ref);
                    $file = $images;
                    // $realFileName = md5($file->baseName . time()) . '.' . $file->extension;
                    $realFileName = Yii::$app->security->generateRandomString() . '.' . $file->extension;
                    $savePath = OrgPersonnel::DIR_PHOTO . $ref . '/' . $realFileName;

                    $model = OrgPersonnel::findOne($ref);
                    if ($model->validate()) {
                        $this->delteOldPhoto($model);
                        if ($file->saveAs($savePath)) {
                            if ($this->isImage(Url::base(true) . '/' . $savePath)) {
                                $this->createThumbnail($ref, $realFileName);
                                $model->photo = $realFileName;
                                $model->save();
                            }

                            if ($isAjax === true) {
                                echo json_encode(['success' => 'true', 'file' => $realFileName]);
                            }
                        } else {
                            if ($isAjax === true) {
                                echo json_encode(['success' => 'false', 'eror' => $file->error]);
                            }
                        }
                    } else {
                        if ($isAjax === true) {
                            echo json_encode(['success' => 'false', 'eror' => $model->errors]);
                        }
                    }

                }

            }
        }
    }

    public function actionBuildCode($id)
    {
        $model = $this->findModel($id);
        if (empty($model->code)) {
            $model->code = $model->getGenerateNewCode();
            $model->save();
            $this->redirect(['views', 'id' => $id]);
        } else {
            echo 'User already have code.';

            $this->redirect(['views', 'id' => $id]);
        }
    }

    public function actionBuildUsername($id)
    {
        $model = $this->findModel($id);
        $find = User::findOne(['username' => $model->code]);

        //Reset
        if ($find) {
            $title = 'รีเซทรหัสผ่านใหม่';
            $user = User::findOne($find->id);
            // $user->scenario = 'buildUsername';
            $model->user_id = $find->id;
            $model->save();
            $newPassword = rand(00000, 99999);

            if ($user->load(Yii::$app->request->post()) && $user->validate()) {
                // $find->status = User::STATUS_ACTIVE;
                // $find->scenario = 'requestReset';
                // $find->password_hash = Yii::$app->security->generatePasswordHash($newPassword);
                // $find->auth_key = Yii::$app->security->generateRandomString();
                if ($find->email) {
                    if ($model->sendEmailResetPwd()) {
                        Yii::$app->session->setFlash('success', 'ระบบได้ Reset password link  ่ไปยังอีเมล์  :  ' . $find->email . ' เรียบร้อบแล้ว โปรคเช็คอีเมล์และตั้งรหัสผ่านใหม่');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    Yii::$app->session->setFlash('warning', 'การรีเซทรหัสผ่าน จำเป็นต้องมีข้อมูล E-mail ');
                    return $this->refresh();
                }
            }
        }

        if (!$find) {
            $title = 'สร้างรหัสผ่านใหม่';
            $user = new User();
            // $user->scenario = 'buildUsername';
            $user->username = $model->code;
            if ($user->load(Yii::$app->request->post()) && $user->validate()) {
                // $user->status = User::STATUS_ACTIVE;
                $user->password_hash = Yii::$app->security->generatePasswordHash($user->username);
                $user->auth_key = Yii::$app->security->generateRandomString();
                if ($user->save()) {
                    $model->user_id = $user->primaryKey;
                    $model->save();
                    Yii::$app->session->setFlash('success', 'ระบบได้ออกรหัสผ่านให้  : [ ' . $model->fullnameTH . ' ] เรียบร้อบแล้ว');
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }

        }

        return $this->render('form/build-username', [
            'model' => $model,
            'user' => $user,
            'title' => $title,
        ]);

    }
}

