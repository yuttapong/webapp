<?php

namespace frontend\modules\recruitment\controllers;

use backend\modules\org\models\OrgPersonnel;
use backend\modules\org\models\OrgPosition;
use backend\modules\recruitment\models\RcmAppManpower;
use backend\modules\org\models\OrgPersonnelEducation;
use backend\modules\org\models\OrgPersonnelPosition;
use backend\modules\org\models\OrgPersonnelWork;
use common\models\SysAmphur;

use frontend\modules\recruitment\models\LoginResumeForm;
use frontend\modules\recruitment\models\Resume;
use Yii;
use frontend\modules\recruitment\models\RcmAppForm;
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

        $dataProvider = new ActiveDataProvider([
            'query' => Resume::find()
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'sessionResumeCode' => $this->getSessionCode(),
        ]);
    }

    public function actionList()
    {


        $dataProvider = new ActiveDataProvider([
            'query' => Resume::find()
        ]);


        return $this->render('index', [
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
        if($login->isLoggedIn()){
            $model = Resume::findOne(['code'=>$login->getSession()]);
            //$model = $this->findModel($id);
            $modelPersonnel = OrgPersonnel::findOne($model->personnel_id);
            return $this->render('view', [
                'model' => $model,
                'modelPersonnel' => $modelPersonnel,
            ]);
        }else{
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
        if (($model = Resume::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionLoginUser()
    {
        $model = new LoginResumeForm();

        if($model->isLoggedIn())
            return $this->redirect(['myresume']);

        if ($this->resumeCode == '') {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                if($model->isLoggedIn()){
                    return $this->redirect(['myresume']);
                }else{
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


    public function actionApply($id)
    {
        $model = new Resume();
        $model->created_at = time();

        $modelPersonnel = new OrgPersonnel();
        $modelsEducation = [new OrgPersonnelEducation];
        $modelsWork = [new OrgPersonnelWork];
        $modelsPosition = [new OrgPersonnelPosition];
        $modelManpower = RcmAppManpower::findOne($id);
        $model->position_name = $modelManpower->position->name_th;
        $modelPersonnel->work_type = 'Applicant';


        if ($modelPersonnel->load(Yii::$app->request->post())) {

            $model = $model->load(Yii::$app->request->post());
            // Model::loadMultiple($model,Yii::$app->request->post());

            $modelsEducation = Model::createMultiple(OrgPersonnelEducation::className());
            Model::loadMultiple($modelsEducation, Yii::$app->request->post());

            $modelsWork = Model::createMultiple(OrgPersonnelWork::className());
            Model::loadMultiple($modelsWork, Yii::$app->request->post());

            //validate all models
            $valid = $modelPersonnel->validate();


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

                        $this->uploadPhoto($model);

                        //resume
                        $keyrun = SysKeyRun::generateKey([
                            'tableName' => Resume::CODE_TABLE_NAME,
                            'prefix' => Resume::CODE_STRING,
                        ]);
                        $model = new Resume();
                        $model->load(Yii::$app->request->post());
                        $model->company_id = $modelManpower->company_id;
                        $model->personnel_id = $modelPersonnel->id;
                        $model->position_id = $modelManpower->position_id;
                        $model->code = "{$keyrun->prefix}-{$keyrun->seq_count}";//รูปแบบเลขที่ใบสมัคร
                        $model->created_at = time();
                        $model->save();

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
                'modelManpower' => $modelManpower,
                'modelPersonnel' => $modelPersonnel,
                'modelPosition' => OrgPosition::findOne($modelManpower->position_id),
                'modelsEducation' => $modelsEducation,
                'modelsWork' => $modelsWork,
                'modelsPosition' => $modelsPosition,
                'citizenAmphur' => [],
                'initialPreviewPhoto' => [],
                'initialPreviewPhotoConfig' => [],
            ]);
        }


    }

    /**
     * @param $model
     * @throws ForbiddenHttpException
     */
    public function isOwnerResume($model){
        $login = new LoginResumeForm();
        if( ($login->getSession() != $model->code) ){
            throw  new ForbiddenHttpException;
        }
    }

    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $model->updated_at = time();

        //เฉพาะเจ้าของใบสมัครถึงจะแก้ไขได้
        $this->isOwnerResume($model);

        $modelPersonnel = OrgPersonnel::findOne($model->personnel_id);

        //ข้อมูลประวัติการศึกษา
        $modelsEducation = OrgPersonnelEducation::find(['personnel_id'=>$modelPersonnel->id])
            ->where(['personnel_id'=>$modelPersonnel->id])
            ->orderBy('sorter')->all();

        //ประวัติการทำงาน
        $modelsWork =  OrgPersonnelWork::find(['personnel_id'=>$modelPersonnel->id])
            ->where(['personnel_id'=>$modelPersonnel->id])
            ->orderBy('seq')->all();

        $citizenAmphur = $this->getAmphurByProvince($modelPersonnel->idcard_province_id);

        $modelManpower = RcmAppManpower::findOne($id);

        //Position Name
        $model->position_name = ! empty($model->position_name)?$model->position_name:$modelManpower->position->name_th;



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
            }else{
                print_r($model->errors);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelManpower' => $modelManpower,
                'modelPersonnel' => $modelPersonnel,
                'modelPosition' => OrgPosition::findOne($modelManpower->position_id),
                'modelsEducation' => (!empty($modelsEducation)) ? $modelsEducation : [new OrgPersonnelEducation],
                'modelsWork' => (!empty($modelsWork)) ? $modelsWork : [new OrgPersonnelWork()],
                'citizenAmphur' => $citizenAmphur,
                'initialPreviewPhoto' => [],
                'initialPreviewPhotoConfig' => [],
            ]);
        }
    }


    private  function uploadPhoto($model){
        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        if ( $photo = $model->upload()) {
             if( ! empty($photo)){
                 $upload = Resume::findOne($model->id);
                 $upload->photo = $photo;
                 $upload->save();
             }
            return;
        }
    }

}
