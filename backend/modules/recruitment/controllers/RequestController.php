<?php
namespace backend\modules\recruitment\controllers;

use backend\models\SysDocumentOption;
use backend\models\SysKeyRun;
use backend\modules\org\models\OrgBenefits;
use backend\modules\org\models\OrgJobOption;
use backend\modules\recruitment\models\RcmAppProperty;
use backend\modules\recruitment\models\RcmApproverUser;
use Yii;
use backend\modules\recruitment\models\RcmAppManpower;
use backend\modules\recruitment\models\RcmAppManpowerSearch;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\org\models\OrgApprove;

/**
 * RequestController implements the CRUD actions for RcmAppManpower model.
 */
class RequestController extends Controller
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
        ];
    }

    /**
     * Lists all RcmAppManpower models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RcmAppManpowerSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionListApproved()
    {
        $searchModel = new RcmAppManpowerSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }



    /**
     * Displays a single RcmAppManpower model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);


        $config = [
            'table_main' => RcmApproverUser::tableName(),
            'table_name' => RcmAppManpower::CODE_TABLE_NAME,
            'ref_id' => $id,
            'document_id' => 1,
            'company_id' => $model->company_id,
            'site_id' => 1,
            'user_id' => $model->created_by,
            'approver_user_id' => $model->approver_user_id,
            //  '_type' => SysDocumentOption::TYPE_ORGANIZATION,
        ];

        //ข้อมูลรายชื่อผู้ที่จะอนุมัติและอนุมัติไปแล้ว
        $listApprove = OrgApprove::getListApprove($config);




        return $this->render('view', [
            'model' => $model,
            'listApprove' => $listApprove
        ]);
    }


    private function saveApprover($model)
    {
        $modelApprove = new RcmApproverUser();
        $modelApprove->document_id = RcmAppManpower::SYS_DOCUMENT_ID;
        $modelApprove->table_name = RcmAppManpower::CODE_TABLE_NAME;
        $modelApprove->ref_id = $model->id;
        $modelApprove->comment = 'ขออนุมัติ';
        $modelApprove->user_id = Yii::$app->user->id;
        $modelApprove->user_code = Yii::$app->user->identity->personnel->code;
        $modelApprove->created_at = time();
        $modelApprove->created_by = Yii::$app->user->id;
        //$modelApprove->position_name = implode("\n",$arr_pos);


        //เมื่อเปิดใขอัตรกำลังคน คนเปิดจะเป็นผู้คนอนุมัติคนแรกก่อนเสมอในรายการ
        if ($model->approver_seq == 1 && !isset($modelApprove->seq)) {
            $modelApprove->seq = 1;
            $modelApprove->app_status = RcmApproverUser::STATUS_APPROVED;
            $modelApprove->user_type = RcmApproverUser::TYPE_REQUEST;
        }


        //เมื่อมีผู้อนุมัติคนต่อ ๆ ไป
        if ($data = $modelApprove->load(Yii::$app->request->post()) && $modelApprove->seq > 0) {
            $modelApprove->app_status = RcmApproverUser::STATUS_APPROVED;
            $modelApprove->user_type = RcmApproverUser::TYPE_APPROVER;
        }


        // บันทึกข้อมูลอนมัติ
        if ($modelApprove->save()) {

            /*****************************************
             * อัพเดท  ผู้อนุมัติและลำดับ ล่าสุดในตารางหลัก
             * **************************************/
            $model = self::findModel($model->id);
            $model->approver_user_id = Yii::$app->user->id;
            $model->approver_seq = $modelApprove->seq;

            //อนุมัติยังไม่ครบ
            if ($modelApprove->is_complete == 0)
                $model->status = RcmAppManpower::APPROVE_NOT_COMPLETED;

            //อนุมัติครบแล้ว
            if ($modelApprove->is_complete == 1)
                $model->status = RcmAppManpower::APPROVE_COMPLETED;

            $model->save();
            Yii::$app->session->setFlash('success', 'บันทักข้อมูลการอนุมัติเรียบร้อย');
        }

    }


    public function actionApprove($id)
    {
        $model = $this->findModel($id);


        $config = [
            'table_main' => RcmApproverUser::tableName(),
            'table_name' => RcmAppManpower::CODE_TABLE_NAME,
            'ref_id' => $id,
            'document_id' => 1,
            'company_id' => $model->company_id,
            'site_id' => 1,
            'user_id' => $model->created_by,
            'approver_user_id' => $model->approver_user_id,
            //  '_type' => SysDocumentOption::TYPE_ORGANIZATION,
        ];

        //ข้อมูลรายชื่อผู้ที่จะอนุมัติและอนุมัติไปแล้ว
        $listApprove = OrgApprove::getListApprove($config);


        //อนุมัติรายการ
        $modelApprove = new RcmApproverUser();
        if ($modelApprove->load(Yii::$app->request->post())) {

            $this->saveApprover($model);

            return $this->redirect(['view', 'id' => $id]);

        }


        return $this->render('view', [
            'model' => $model,
            'listApprove' => $listApprove,
            'modelApprove' => new RcmApproverUser(),
        ]);
    }


    /**
     * Creates a new RcmAppManpower model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RcmAppManpower;


        if ($model->load(Yii::$app->request->post())) {

            //Responsibilities
            $dataRes = Yii::$app->request->post('dataRes');
            $dataResId = isset($dataRes['id']) ? $dataRes['id'] : [];


            //Property
            $dataProp = Yii::$app->request->post('dataProp');
            $dataPropId = isset($dataProp['id']) ? $dataProp['id'] : [];


            //Benefit
            $dataBenefit = Yii::$app->request->post('dataBenefit');
            $dataBenefitId = isset($dataBenefit['id']) ? $dataBenefit['id'] : [];


            //Validation
            $model->status = RcmAppManpower::APPROVE_NOT_COMPLETED;
            $valid = $model->validate();


            // print_r($model->errors);
            if ($valid) {
                // print_r($_POST);
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save()) {

                        $countRes = count($dataRes['title']);
                        for ($loopRes = 0; $loopRes < $countRes; $loopRes++) {
                            $resId = isset($dataRes['id'][$loopRes]) ? $dataRes['id'][$loopRes] : '';
                            $resTitle = isset($dataRes['title'][$loopRes]) ? $dataRes['title'][$loopRes] : '';


                            $joboption = new OrgJobOption();
                            $joboption->_type = OrgJobOption::TYPE_RESPONSIBILITY;
                            $joboption->title = $resTitle;
                            if (!($flag = $joboption->save())) {
                                $transaction->rollBack();
                                break;
                            }

                            $modelRes = new RcmAppProperty();
                            $modelRes->app_manpower_id = $model->id;
                            $modelRes->_type = $joboption->_type;
                            $modelRes->job_option_id = $joboption->id;
                            $modelRes->title = $joboption->title;
                            $modelRes->sorter = $loopRes;
                            if (!($flag = $modelRes->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }


                        //Update Property
                        $countProp = count($dataProp['title']);
                        for ($loopProp = 0; $loopProp < $countProp; $loopProp++) {
                            $propId = isset($dataProp['id']) ? $dataProp['id'][$loopProp] : '';
                            $propTitle = isset($dataProp['title']) ? $dataProp['title'][$loopProp] : '';


                            $modelProp = new RcmAppProperty();
                            $modelProp->app_manpower_id = $model->id;
                            $modelProp->job_option_id = $propId;
                            $modelProp->title = $propTitle;
                            $modelProp->_type = OrgJobOption::TYPE_PROPERTY;
                            $modelProp->sorter = $loopProp;
                            if (!($flag = $modelProp->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                        }


                    }


                    if ($flag) {
                        $transaction->commit();
                        //ออกรหัสโค้ดใหม่
                        $keyrun = SysKeyRun::generateKey([
                            'tableName' => RcmAppManpower::CODE_TABLE_NAME,
                            'prefix' => RcmAppManpower::CODE_STRING,
                        ]);
                        $model->code = "{$keyrun->prefix}-{$keyrun->seq_count}";
                        $model->approver_user_id = $model->created_by;
                        $model->approver_seq = 1;
                        $model->save();

                        //บันทึกข้อมูลการอนุมัติ
                        self::saveApprover($model);

                        //   return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    return $e->getMessage();
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }

    }


    /**
     * Updates an existing RcmAppManpower model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post())) {

            //Responsibilities
            $dataRes = Yii::$app->request->post('dataRes');
            $dataResId = isset($dataRes['id']) ? $dataRes['id'] : [];
            $oldRes = ArrayHelper::map($model->optionResponsibilities, 'id', 'id');
            $deletedRes = array_diff($oldRes, array_filter($dataResId));

            //Property
            $dataProp = Yii::$app->request->post('dataProp');
            $dataPropId = isset($dataProp['id']) ? $dataProp['id'] : [];
            $oldProp = ArrayHelper::map($model->optionProperties, 'id', 'id');
            $deletedProp = array_diff($oldProp, array_filter($dataPropId));

            //Benefit
            $dataBenefit = Yii::$app->request->post('dataBenefit');
            $dataBenfitId = isset($dataBenefit['id']) ? $dataBenefit['id'] : [];
            $oldBenefit = ArrayHelper::map($model->optionBenefits, 'id', 'id');
            $deletedBenefit = array_diff($oldBenefit, array_filter($dataBenfitId));

            //Validation
            $valid = $model->validate();


            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save()) {

                        /********************************************
                         * Update responsibility
                         *******************************************/
                        if (!empty($deletedRes)) {
                            RcmAppProperty::deleteAll(['id' => $deletedRes]);
                        }
                        if (!empty($dataRes)) {
                            $countRes = count($dataRes['title']);
                            for ($loopRes = 0; $loopRes < $countRes; $loopRes++) {
                                $resId = isset($dataRes['id'][$loopRes]) ? $dataRes['id'][$loopRes] : 0;
                                $resTitle = isset($dataRes['title'][$loopRes]) ? $dataRes['title'][$loopRes] : '';
                                if (in_array($resId, $oldRes)) {
                                    $modelRes = RcmAppProperty::findOne($resId);
                                } else {
                                    // add manual item
                                    if ($resId == 0) {
                                        $joboption = new OrgJobOption();
                                        $joboption->_type = OrgJobOption::TYPE_RESPONSIBILITY;
                                        $joboption->title = $resTitle;
                                        if (!($flag = $joboption->save())) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                        $modelRes = new RcmAppProperty();
                                        $modelRes->app_manpower_id = $model->id;
                                        $modelRes->_type = RcmAppProperty::TYPE_RESPONSIBILITY;
                                        $modelRes->job_option_id = $joboption->id;
                                        $modelRes->title = $joboption->title;
                                    } else {

                                        // add from database by id
                                        $modelRes = new RcmAppProperty();
                                        $modelRes->_type = RcmAppProperty::TYPE_RESPONSIBILITY;
                                        $modelRes->app_manpower_id = $model->id;
                                        $modelRes->job_option_id = $resId;
                                        $modelRes->title = $resTitle;
                                    }
                                }
                                $modelRes->sorter = $loopRes;
                                if (!($flag = $modelRes->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }


                        /********************************************
                         * Update Property
                         *******************************************/
                        if (!empty($deletedProp)) {
                            RcmAppProperty::deleteAll(['id' => $deletedProp]);
                        }
                        if (!empty($dataProp)) {
                            $countProp = count($dataProp['title']);
                            for ($loopProp = 0; $loopProp < $countProp; $loopProp++) {
                                $propId = isset($dataProp['id'][$loopProp]) ? $dataProp['id'][$loopProp] : 0;
                                $propTitle = isset($dataProp['title'][$loopProp]) ? $dataProp['title'][$loopProp] : '';

                                if (in_array($propId, $oldProp)) {
                                    $modelProp = RcmAppProperty::findOne($propId);
                                    $modelProp->title = $propTitle;
                                } else {
                                    // add manual from text
                                    if ($propId == 0) {
                                        $joboption = new OrgJobOption();
                                        $joboption->_type = OrgJobOption::TYPE_PROPERTY;
                                        $joboption->title = $propTitle;
                                        if (!($flag = $joboption->save())) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                        $modelProp = new RcmAppProperty();
                                        $modelProp->_type = RcmAppProperty::TYPE_PROPERTY;
                                        $modelProp->app_manpower_id = $model->id;
                                        $modelProp->job_option_id = $joboption->id;
                                        $modelProp->title = $joboption->title;
                                    } else {
                                        // add from database by ID
                                        $modelProp = new RcmAppProperty();
                                        $modelProp->_type = OrgJobOption::TYPE_PROPERTY;
                                        $modelProp->app_manpower_id = $model->id;
                                        $modelProp->job_option_id = $propId;
                                        $modelProp->title = $propTitle;
                                    }
                                }
                                $modelProp->sorter = $loopProp;
                                if (!($flag = $modelProp->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }

                            }
                        }

                        /********************************************
                         * Update Benefit
                         *******************************************/
                        if (!empty($deletedBenefit)) {
                            RcmAppProperty::deleteAll(['id' => $deletedBenefit]);
                        }


                        if (!empty($dataBenefit)) {

                            $countBenefit = count($dataBenefit['title']);
                            for ($loopBenefit = 0; $loopBenefit < $countBenefit; $loopBenefit++) {
                                $benefitId = isset($dataBenefit['id'][$loopBenefit]) ? $dataBenefit['id'][$loopBenefit] : 0;
                                $benefitTitle = isset($dataBenefit['title'][$loopBenefit]) ? $dataBenefit['title'][$loopBenefit] : '';


                                if (in_array($benefitId, $oldBenefit)) {
                                    $modelBen = RcmAppProperty::findOne($benefitId);
                                    $modelBen->title = $benefitTitle;
                                } else {
                                    // add manual from text
                                    if ($benefitId == 0) {
                                        $joboption = new OrgBenefits();
                                        $joboption->title = $benefitTitle;
                                        $joboption->status = 1;
                                        if (!($flag = $joboption->save())) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                        $modelBen = new RcmAppProperty();
                                        $modelBen->_type = RcmAppProperty::TYPE_BENEFIT;
                                        $modelBen->app_manpower_id = $model->id;
                                        $modelBen->job_option_id = $joboption->id;
                                        $modelBen->title = $joboption->title;
                                    } else {
                                        // add from database by ID
                                        $modelBen = new RcmAppProperty();
                                        $modelBen->_type = RcmAppProperty::TYPE_BENEFIT;
                                        $modelBen->app_manpower_id = $model->id;
                                        $modelBen->job_option_id = $benefitId;
                                        $modelBen->title = $benefitTitle;
                                    }
                                }
                                $modelBen->sorter = $loopBenefit;

                                if (!($flag = $modelBen->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }

                            }
                        }


                    }


                    if ($flag) {

                        $transaction->commit();
                        return $this->redirect(['update', 'id' => $model->id]);
                    }


                } catch (Exception $e) {
                    print_r($e->getMessage());
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }


    }

    /**
     * Deletes an existing RcmAppManpower model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->log_status = RcmAppManpower::LOG_STATUS_DELETED;
        if($model->approver_seq == 1 && $model->status == RcmAppManpower::APPROVE_NOT_COMPLETED){
            $model->save();
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the RcmAppManpower model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RcmAppManpower the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RcmAppManpower::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionResponsibilityList()
    {
        $models = OrgJobOption::find()
            ->select('id,title')
            ->where(['_type' => OrgJobOption::TYPE_RESPONSIBILITY])
            ->asArray()->all();
        echo json_encode($models);
    }


    public function actionPropertyList()
    {
        $models = OrgJobOption::find()
            ->select('id,title')
            ->where(['_type' => OrgJobOption::TYPE_PROPERTY])
            ->asArray()
            ->all();
        echo json_encode($models);
    }

    public function actionBenefitList()
    {
        $models = OrgBenefits::find()
            ->select('id,title')
            ->asArray()
            ->all();
        echo json_encode($models);
    }
}
