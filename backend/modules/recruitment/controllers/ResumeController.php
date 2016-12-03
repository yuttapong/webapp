<?php

namespace backend\modules\recruitment\controllers;

use Yii;
use backend\modules\recruitment\models\RcmAppForm;
use backend\modules\recruitment\models\RcmAppFormSearch;
use backend\modules\org\models\OrgPersonnel;
use backend\modules\org\models\OrgPersonnelWork;
use backend\modules\org\models\OrgPersonnelEducation;
use backend\modules\recruitment\models\RcmAppManpower;
use backend\modules\org\models\OrgPosition;
use backend\modules\org\models\OrgPersonnelPosition;
use backend\modules\recruitment\models\RcmAppFormPosition;

use backend\models\Model;
use yii\web\UploadedFile;
use common\models\SysAmphur;
use backend\models\SysKeyRun;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * ResumeController implements the CRUD actions for RcmAppForm model.
 */
class ResumeController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete',
                            'generate-pwd', 'apply', 'get-amphur','form-interview'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all RcmAppForm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RcmAppFormSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RcmAppForm model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelPersonnel = OrgPersonnel::findOne($model->personnel_id);
        return $this->render('view', [
            'model' => $model,
            'modelPersonnel' => $modelPersonnel,
        ]);
    }


    /**
     * Deletes an existing RcmAppForm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->deleteWithRelated();
        $model = $this->findModel($id);
        $model->status = RcmAppForm::STATUS_CANCELED;
        $model->save();
        print_r($model->errors);

        // return $this->redirect(['index']);
    }

    /**
     *
     * for export pdf at actionView
     *
     * @param type $id
     * @return type
     */
    public function actionPdf($id)
    {
        $model = $this->findModel($id);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
        ]);

        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_CORE,
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => \Yii::$app->name],
            'methods' => [
                'SetHeader' => [\Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }

    /**
     * Finds the RcmAppForm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RcmAppForm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RcmAppForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function uploadPhoto($model)
    {
        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        if ($photo = $model->upload()) {
            if (!empty($photo)) {
                $model->photo = $photo;
                $model->save();
            }
            return;
        }
    }

    /**
     *
     */
    public function actionGetAmphur()
    {
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
     * generate new password for resume
     * @throws NotFoundHttpException
     */
    public function actionGeneratePwd()
    {
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $key = mt_rand(1000, 9999);
            $model = $this->findModel($data['id']);
            $model->pwd = $key;
            $model->save();

            echo Json::encode(['key' => $key, 'msg' => $model->errors]);
        }
    }

    protected function mapData($datas, $fieldId, $fieldName)
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
        return $this->mapData($models, 'id', 'name_th');
    }


    /**
     * กรอกใบสมัคร
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */


    /**
     * register new resume
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionApply()
    {
        $model = new RcmAppForm();
        $model->scenario = 'insert';
        $modelPersonnel = new OrgPersonnel();
        $modelsEducation = [new OrgPersonnelEducation];
        $modelsWork = [new OrgPersonnelWork];
        $modelsPosition = [new OrgPersonnelPosition];
        $modelPersonnel->work_type = 'Applicant';
        $model->positionApply = [];


        if ($model->load(Yii::$app->request->post()) && $modelPersonnel->load(Yii::$app->request->post())) {

            $modelsEducation = Model::createMultiple(OrgPersonnelEducation::className());
            Model::loadMultiple($modelsEducation, Yii::$app->request->post());

            $modelsWork = Model::createMultiple(OrgPersonnelWork::className());
            Model::loadMultiple($modelsWork, Yii::$app->request->post());


            $dataAppForm = Yii::$app->request->post('RcmAppForm');
            $positionApp = isset($dataAppForm['positionApply']) ? $dataAppForm['positionApply'] : [];
            $model->positionApply = $positionApp;


            //validate all
            $valid = $model->validate();
            $valid = $modelPersonnel->validate() && $valid;
            $valid = Model::validateMultiple($modelsEducation) && $valid;
            $valid = Model::validateMultiple($modelsWork) && $valid;


            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelPersonnel->save(false)) {


                        //education
                        $eduSorter = 1;
                        foreach ($modelsEducation as $edu) {
                            $edu->personnel_id = $modelPersonnel->id;
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
                            $work->personnel_id = $modelPersonnel->id;
                            $work->seq = $seqWork;
                            if ($work->position_name != '') {
                                if (!($flag = $work->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                                $seqWork++;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        //สร้างเลขที่ใบสมัคร;
                        $keyrun = SysKeyRun::generateKey([
                            'tableName' => RcmAppForm::CODE_TABLE_NAME,
                            'prefix' => RcmAppForm::CODE_STRING,
                        ]);
                        $codeFormat = "{$keyrun->prefix}-{$keyrun->seq_count}";

                        $model->created_at = time();
                        $model->personnel_id = $modelPersonnel->id;
                        $model->code = $codeFormat; //รูปแบบเลขที่ใบสมัคร
                        $model->created_at = time();
                        $model->save();

                        $this->savePositionApply($model); //save positon

                        $this->uploadPhoto($model); // upload image of profile

                        Yii::$app->session->setFlash('success', 'Successfully');
                        return $this->redirect(['update', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    Yii::$app->session->setFlash('danger', 'Error: ' . $e->getMessage());
                    $transaction->rollBack();
                    return $e->getMessage();
                }
            }
        } else {
            return $this->render('apply', [
                'model' => $model,
                'modelPersonnel' => $modelPersonnel,
                'modelsEducation' => $modelsEducation,
                'modelsWork' => $modelsWork,
                'modelsPosition' => $modelsPosition,
                'citizenAmphur' => [],
            ]);
        }


    }

    /**
     * Updates an existing RcmAppForm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $model->updated_at = time();
        $model->positionApply = ArrayHelper::map($model->applyPositions, 'position_id', 'position_id');

        //Position Name
        $model->position_name = !empty($model->position_name) ? $model->position_name : '';

        $modelPersonnel = OrgPersonnel::findOne($model->personnel_id);
        $citizenAmphur = ArrayHelper::map($this->getAmphurByProvince($modelPersonnel->idcard_province_id), 'id', 'name');

        //ข้อมูลประวัติการศึกษา
        $modelsEducation = OrgPersonnelEducation::find(['personnel_id' => $modelPersonnel->id])
            ->where(['personnel_id' => $modelPersonnel->id])
            ->orderBy('sorter')->all();

        //ประวัติการทำงาน
        $modelsWork = OrgPersonnelWork::find(['personnel_id' => $modelPersonnel->id])
            ->where(['personnel_id' => $modelPersonnel->id])
            ->orderBy('seq')->all();


        if ($modelPersonnel->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {

            $eduOldIDs = ArrayHelper::map($modelsEducation, 'id', 'id');
            $modelsEducation = Model::createMultiple(OrgPersonnelEducation::className(), $modelsEducation);
            Model::loadMultiple($modelsEducation, Yii::$app->request->post());
            $eduDeletedIDs = array_diff($eduOldIDs, array_filter(ArrayHelper::map($modelsEducation, 'id', 'id')));


            $jobOldIDs = ArrayHelper::map($modelsWork, 'id', 'id');
            $modelsWork = Model::createMultiple(OrgPersonnelWork::className(), $modelsWork);
            Model::loadMultiple($modelsWork, Yii::$app->request->post());
            $jobDeletedIDs = array_diff($jobOldIDs, array_filter(ArrayHelper::map($modelsWork, 'id', 'id')));


            $dataAppForm = Yii::$app->request->post('RcmAppForm');
            $positionApp = !empty($dataAppForm['positionApply']) ? $dataAppForm['positionApply'] : [];
            $model->positionApply = $positionApp;


            //validate all models
            $valid = $model->validate();
            $valid = $modelPersonnel->validate() && $valid;
            $valid = Model::validateMultiple($modelsEducation) && $valid;
            $valid = Model::validateMultiple($modelsWork) && $valid;

            // print_r( $model->errors);
            //exit();

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelPersonnel->save(false) && $model->save(false)) {


                        //delete education
                        if (!empty($eduDeletedIDs)) {
                            OrgPersonnelEducation::deleteAll(['id' => $eduDeletedIDs]);
                        }

                        //delete work
                        if (!empty($jobDeletedIDs)) {
                            OrgPersonnelWork::deleteAll(['id' => $jobDeletedIDs]);
                        }


                        //position
                        $this->savePositionApply($model);

                        //education
                        $eduSorter = 1;
                        foreach ($modelsEducation as $edu) {
                            $edu->personnel_id = $modelPersonnel->id;
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
                            $work->personnel_id = $modelPersonnel->id;
                            $work->seq = $seqWork;
                            if ($work->position_name != '') {
                                if (!($flag = $work->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                                $seqWork++;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        $this->uploadPhoto($model);
                        Yii::$app->session->setFlash('success', 'Successfully');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    Yii::$app->session->setFlash('danger', 'Error: ' . $e->getMessage());
                    $transaction->rollBack();
                    return $e->getMessage();
                }
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelPersonnel' => $modelPersonnel,
                'modelsEducation' => (!empty($modelsEducation)) ? $modelsEducation : [new OrgPersonnelEducation],
                'modelsWork' => (!empty($modelsWork)) ? $modelsWork : [new OrgPersonnelWork()],
                'citizenAmphur' => $citizenAmphur,
            ]);
        }
    }

    /**
     * บันทึกตำแหน่งที่สม้คร
     * @param $model
     * @throws \Exception
     */
    public function savePositionApply($model)
    {
        $positions = RcmAppFormPosition::findAll(['app_form_id' => $model->id]);
        $oldPos = ArrayHelper::map($positions, 'position_id', 'position_id');
        $deletedPos = array_diff($oldPos, array_filter($model->positionApply));

        if (!empty($deletedPos)) {
            foreach ($deletedPos as $posId) {
                $rs = RcmAppFormPosition::find()->where(['position_id' => $posId, 'app_form_id' => $model->id])->one();
                $rs->delete();
            }
        }

        $seqPosition = 1;
        foreach ($model->positionApply as $posId) {
            $modelPositionApply = RcmAppFormPosition::findOne(['app_form_id' => $model->id, 'position_id' => $posId]);
            if (count($modelPositionApply) > 0) {
                $modelPositionApply->position_name = $modelPositionApply->position->name_th;
                $modelPositionApply->seq = $seqPosition;
                $modelPositionApply->save();
            } else {
                $modelPositionApply = new RcmAppFormPosition();
                $modelPositionApply->position_id = $posId;
                $modelPositionApply->position_name = $modelPositionApply->position->name_th;
                $modelPositionApply->app_form_id = $model->id;
                $modelPositionApply->seq = $seqPosition;
                $modelPositionApply->save();
            }
            $seqPosition++;
        }

    }

    public function actionFormInterview($id)
    {
        $model = $this->findModel($id);
        $modelPersonnel = OrgPersonnel::findOne($model->personnel_id);
        return $this->render('/interview/create', [
            'model' => $model,
            'modelPersonnel' => $modelPersonnel,
        ]);
    }
}
