<?php

namespace frontend\modules\recruitment\controllers;

use backend\modules\org\models\OrgPersonnel;
use backend\modules\recruitment\models\RcmAppFormPosition;
use backend\modules\recruitment\models\RcmAppFormSearch;
use backend\modules\recruitment\models\RcmAppManpower;
use backend\modules\org\models\OrgPersonnelEducation;
use backend\modules\org\models\OrgPersonnelPosition;
use backend\modules\org\models\OrgPersonnelWork;
use common\models\SysAmphur;
use backend\models\SysKeyRun;
use frontend\modules\recruitment\models\LoginResumeForm;
use backend\modules\recruitment\models\RcmAppForm;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\ConflictHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\GoneHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use backend\models\Model;
use yii\web\UploadedFile;


/**
 * ResumeController implements the CRUD actions for RcmAppForm model.
 */
class ResumeController extends Controller
{

    public $resumeCode;


    public $layout = 'recruitment';

    /**
     * @return mixed
     */
    private function getSessionCode()
    {
        return LoginResumeForm::getSession();
    }

    private function clearSessionCode()
    {
        return LoginResumeForm::removeSession();
    }

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
        ];
    }


    /**
     * Lists all RcmAppForm models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($this->getSessionCode() == null) {
            return $this->redirect(['login-user']);
        }


        $searchModel = new RcmAppFormSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sessionResumeCode' => $this->getSessionCode(),
        ]);
    }

    public function actionList()
    {


        $searchModel = new RcmAppFormSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sessionResumeCode' => $this->getSessionCode(),
        ]);
    }

    public function actionPosition()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RcmAppManpower::find()
        ]);

        return $this->render('position', [
            'dataProvider' => $dataProvider,
            'sessionResumeCode' => $this->getSessionCode(),
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

    public function actionMyresume()
    {
        $login = new LoginResumeForm();
        if ($login->isLoggedIn()) {
            $model = RcmAppForm::findOne(['code' => $login->getSession()]);
            //$model = $this->findModel($id);
            $modelPersonnel = OrgPersonnel::findOne($model->personnel_id);
            return $this->render('view', [
                'model' => $model,
                'modelPersonnel' => $modelPersonnel,
            ]);
        } else {
            throw  new ForbiddenHttpException;
        }
    }



    /**
     * Updates an existing RcmAppForm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    /*

    /**
     * Deletes an existing RcmAppForm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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


    public function actionLoginUser()
    {
        $model = new LoginResumeForm();

        if ($model->isLoggedIn())
            return $this->redirect(['myresume']);

        if ($this->resumeCode == '') {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                if ($model->isLoggedIn()) {
                    return $this->redirect(['myresume']);
                } else {
                    return $this->redirect(['index']);
                }
            } else {
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->redirect(['index']);
        }

    }

    public function actionLogoutUser()
    {
        LoginResumeForm::removeSession();
        return $this->redirect(['login-user']);
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
     * @param $model
     * @throws ForbiddenHttpException
     */
    public function isOwnerResume($model)
    {
        $login = new LoginResumeForm();
        if (($login->getSession() != $model->code)) {
            throw  new ForbiddenHttpException;
        }
    }


    public function actionApply($id='')
    {
        $model = new RcmAppForm();
        $modelPersonnel = new OrgPersonnel();
        $modelsEducation = [new OrgPersonnelEducation];
        $modelsWork = [new OrgPersonnelWork];
        $modelsPosition = [new OrgPersonnelPosition];
        $modelPersonnel->work_type = 'Applicant';

        if($id){
            $modelManpower = RcmAppManpower::findOne($id);
            $model->positionApply = [$modelManpower->position_id];
        }else{
            $model->positionApply = [];
        }


        if ($model->load(Yii::$app->request->post()) && $modelPersonnel->load(Yii::$app->request->post())) {

            $modelsEducation = Model::createMultiple(OrgPersonnelEducation::className());
            Model::loadMultiple($modelsEducation, Yii::$app->request->post());

            $modelsWork = Model::createMultiple(OrgPersonnelWork::className());
            Model::loadMultiple($modelsWork, Yii::$app->request->post());


            echo '<pre>';
           // print_r($_POST);
            print_r($model->errors);
            echo '</pre>';
           // echo $model->position_apply;

           //  exit();
            $dataAppForm = Yii::$app->request->post('RcmAppForm');
            $positionApp = isset($dataAppForm['positionApply'])?$dataAppForm['positionApply']:[];
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

                        //resume
                        $model->created_at = time();
                        $model->personnel_id = $modelPersonnel->id;
                        $model->code = $codeFormat; //รูปแบบเลขที่ใบสมัคร
                        $model->created_at = time();
                        $model->save();

                        //Save Position
                        $this->savePositionApply($model);
                        $this->uploadPhoto($model);

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

    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $model->updated_at = time();
        $model->positionApply =  ArrayHelper::map($model->applyPositions,'position_id','position_id');

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

            //validate all models
            $valid = $model->validate();
            $valid = $modelPersonnel->validate() && $valid;
            $valid = Model::validateMultiple($modelsEducation) && $valid;
            $valid = Model::validateMultiple($modelsWork) && $valid;

            $dataAppForm = Yii::$app->request->post('RcmAppForm');
            $positionApp = !empty($dataAppForm['positionApply'])?$dataAppForm['positionApply']:[];
            $model->positionApply = $positionApp;


            echo '<pre>';
            print_r($_POST);
            print_r($model->errors);
            echo '</pre>';

          // exit();

            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false) && $modelPersonnel->save(false)) {




                        //delete education
                        if (!empty($eduDeletedIDs)) {
                            OrgPersonnelEducation::deleteAll(['id' => $eduDeletedIDs]);
                        }

                        //delete work
                        if (!empty($jobDeletedIDs)) {
                            OrgPersonnelWork::deleteAll(['id' => $jobDeletedIDs]);
                        }


                        $this->savePositionApply($model); // save position

                        $this->uploadPhoto($model); //photo

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
            return $this->render('update', [
                'model' => $model,
                'modelPersonnel' => $modelPersonnel,
                'modelsEducation' => (!empty($modelsEducation)) ? $modelsEducation : [new OrgPersonnelEducation],
                'modelsWork' => (!empty($modelsWork)) ? $modelsWork : [new OrgPersonnelWork()],
                'citizenAmphur' =>  $citizenAmphur,
            ]);
        }
    }


    /**
     * บันทึกตำแหน่งที่สม้คร
     * @param $model
     * @throws \Exception
     */
    private function savePositionApply($model)
    {
        $positions = RcmAppFormPosition::findAll(['app_form_id' => $model->id]);
        $oldPos = ArrayHelper::map($positions,'position_id','position_id');
        $deletedPos = array_diff($oldPos,array_filter($model->positionApply));

            if( ! empty($deletedPos)){
                foreach ($deletedPos as $posId){
                    $rs = RcmAppFormPosition::find()->where(['position_id'=>$posId,'app_form_id'=>$model->id])->one();
                    $rs->delete();
                }
            }
            $seqPosition = 1;
            foreach ($model->positionApply as $posId) {
                $modelPositionApply = RcmAppFormPosition::findOne(['app_form_id' => $model->id, 'position_id' => $posId]);
                if (count($modelPositionApply)>0) {
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

    private function uploadPhoto($model)
    {
        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        if ($photo = $model->upload()) {
            if (!empty($photo)) {
               // $upload = RcmAppForm::findOne($model->id);
                $model->photo = $photo;
                $model->save();
               // print_r($model->errors);exit();
            }
            return;
        }
    }

}
