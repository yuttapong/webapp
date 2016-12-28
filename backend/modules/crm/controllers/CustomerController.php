<?php


namespace backend\modules\crm\controllers;


use backend\modules\crm\models\AddressOfficeForm;
use backend\modules\crm\models\Communication;
use backend\modules\crm\models\CustomerResponsible;
use backend\modules\crm\models\Response;
use backend\modules\org\models\OrgPersonnel;
use common\models\GeneralAddress;
use Yii;
use backend\modules\crm\models\Customer;
use backend\modules\crm\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\crm\models\SurveySearch;
use backend\modules\crm\models\ResponseSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\SysAmphur;
use common\models\SysTambon;
use yii\helpers\Json;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use backend\modules\crm\models\CommunicationSearch;


/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'delete-address' => ['post'],
                ],
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
     * Lists all Customer models.
     * @return mixed
     */

    public function actionIndex()

    {
        $searchModel = new CustomerSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    /**
     * Lists all Customer models.
     * @return mixed
     */

    public function actionAll()

    {
        $searchModel = new CustomerSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    /**
     * ดูรายรายชื่อผู้มุ่งหวังของฉัน
     */

    public function actionMylead()
    {
        $query = CustomerResponsible::find();
        //$query->joinWith('customer');
        $query->where(['active' => 1]);
        $query->andFilterWhere(['user_id' => Yii::$app->user->getId()]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('mylead', [
            'dataProvider' => $dataProvider,
            //  'searchModel' => $searchModel,
        ]);
    }


    /**
     * Lists all Customer models.
     * @return mixed
     */

    public function actionCommunication()

    {
        $searchModel = new CommunicationSearch;
        $dataProvider = $searchModel->searchMyCommunication(Yii::$app->request->getQueryParams());

        return $this->render('mycommunication', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    /**
     * Lists all Customer models.
     * @return mixed
     */

    public function actionSearch()

    {
        $searchModel = new CustomerSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('search', [
            'model' => new Customer(),
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    /**
     * Displays a single Customer model.
     * @param string $id
     * @return mixed
     */

    public function actionView($id)
    {
        //ข้อมูลลูกค้า
        $model = $this->findModel($id);
        $dataProviderAddress = new ActiveDataProvider([
            'query' => $model->getAddresses(),
            'sort' => false,
        ]);

        //คำตอบ
        $searchModelResponse = new ResponseSearch();
        $dataProviderResponse = new ActiveDataProvider([
            'query' => $model->getQuestionnaires()
        ]);

        //แบบสอบถาม
        $searchModelSurvey = new  SurveySearch();
        $dataProviderSurvey = $searchModelSurvey->searchCustomerServey(Yii::$app->request->queryParams);


        // ข้อมุลการติดต่อสือสาร
        $searchComm = new CommunicationSearch();
        $searchComm->load(Yii::$app->request->get());
        $dataProviderComm = new ActiveDataProvider([
            'query' => Communication::find()
                ->andFilterWhere([
                    'customer_id' => $model->id,
                ])
                ->andFilterWhere(['like', 'title', $searchComm->title])
                ->andFilterWhere(['like', 'detail', $searchComm->detail])
                ->orderBy(['id' => SORT_DESC]),

        ]);


        $dataProviderPersonInCharge = new ActiveDataProvider([
            'query' => $model->getPersonsInCharge()
        ]);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', [
                'model' => $model,
                'searchModelResponse' => $searchModelResponse,
                'dataProviderResponse' => $dataProviderResponse,
                'dataProviderAddress' => $dataProviderAddress,
                'searchModelSurvey' => $searchModelSurvey,
                'dataProviderSurvey' => $dataProviderSurvey,
                'searchComm' => $searchComm,
                'dataProviderComm' => $dataProviderComm,
                'dataProviderPersonInCharge' => $dataProviderPersonInCharge,
                'customerId' => $id,
            ]);

        }

    }


    /**
     * Displays a single Customer model.
     * @param string $id
     * @return mixed
     */

    /*    public function actionSurvey($customerId)
        {
            $modelCustomer = $this->findModel($customerId);
            $searchModelSurvey = new  SurveySearch();
            $dataProviderSurvey = new ActiveDataProvider([
                'query' => Survey::find()->where(['status' => 1])
            ]);

            $searchModel = new  SurveySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->renderAjax('_survey', [
                'modelCustomer' => $modelCustomer,
                'searchModelSurvey' => $searchModel,
                'dataProviderSurvey' => $dataProvider,
                'customerId' => $customerId,
            ]);

        }*/


    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        /*
        $CustomerResponsible = $modelCustomer->getPersonsInCharge();
        $dataProviderPersonInCharge = new ActiveDataProvider([
            'query' => $CustomerResponsible
        ]);
        */
        $model = new Customer();
        $modelAddressContact = new GeneralAddress();
        $modelAddressOffice = new AddressOfficeForm();
        $model->active = Customer::STATUS_ACTIVE;

        $modelAddressContact->type = GeneralAddress::TYPE_CONTACT;
        $modelAddressContact->is_default = 1;

        if ($model->load(Yii::$app->request->post())
            && $modelAddressContact->load(Yii::$app->request->post())
            && $modelAddressOffice->load(Yii::$app->request->post())
        ) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            $isValid = $model->validate();
            $isValidContact = $modelAddressContact->validate();
            $isValidOffice = $modelAddressOffice->validate();

            if ($isValid && $isValidContact && $isValidOffice) {
                if ($model->save()) {

                    // บันทึกข้อมูลผู้รับผิดชอบ
                    $modelCustomerResponsible = new CustomerResponsible();
                    $modelCustomerResponsible->created_at = time();
                    $modelCustomerResponsible->created_by = $model->created_by;
                    $modelCustomerResponsible->user_id = $model->created_by;
                    $modelCustomerResponsible->customer_id = $model->id;
                    $modelCustomerResponsible->note = 'CE ที่เพิ่มข้อมูลคือผู้รับผิดชอบลูกค้า (ค่าเริ่มต้น)';
                    $modelCustomerResponsible->save(false);


                    //address contact
                    $modelAddressContact->table_name = Customer::TABLE_NAME;
                    $modelAddressContact->table_key = $model->id;
                    $modelAddressContact->is_default = 1;
                    $modelAddressContact->save(false);

                    //address office
                    $modelAddressOffice->saveAddress($model);

                    Yii::$app->session->setFlash('success', 'เพิ่มข้อมูลเรียบร้อยแล้ว');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'dataProviderAddress' => [],
                'modelAddressContact' => $modelAddressContact,
                'modelAddressOffice' => $modelAddressOffice,
            ]);
        }
    }


    public function actionUpdate($id)
    {
        $modelCustomer = $this->findModel($id);
        $modelsAddress = $modelCustomer->addresses;
        $dataProviderAddress = new ActiveDataProvider([
            'query' => \common\models\GeneralAddress::find()->where([
                'table_name' => \backend\modules\crm\models\Customer::TABLE_NAME,
                'table_key' => $modelCustomer->id,
            ])
        ]);

        $CustomerResponsible = $modelCustomer->getPersonsInCharge();
        $dataProviderPersonInCharge = new ActiveDataProvider([
            'query' => $CustomerResponsible
        ]);


        if ($modelCustomer->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($modelCustomer);
            }


            if ($modelCustomer->save()) {
                Yii::$app->session->setFlash('success', 'ปรับปรุงข้อมูลเรียบร้อยแล้ว');
                return $this->redirect(['view', 'id' => $modelCustomer->id]);
            } else {
                print_r($modelCustomer->errors);
            }
        }
        return $this->render('update', [
            'model' => $modelCustomer,
            'modelsAddress' => $modelsAddress,
            'dataProviderAddress' => $dataProviderAddress,
            'dataProviderPersonInCharge' => $dataProviderPersonInCharge,
        ]);


    }


    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */

    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        echo 'Not Allowed';
        exit();
        return $this->redirect(['index']);

    }


    public function actionChooseSurvey($customerId)
    {
        if ($customerId) {
            //แบบสอบถาม
            $searchModelSurvey = new  SurveySearch();
            $dataProviderSurvey = $searchModelSurvey->searchCustomerServey(Yii::$app->request->queryParams);
            return $this->render('choose-survey', [
                'dataProviderSurvey' => $dataProviderSurvey,
                'searchModelSurvey' => $searchModelSurvey,
                'modelCustomer' => $this->findModel($customerId),
            ]);
        }
    }


    /**
     * action to fetch customer
     */
    public function actionFindCustomer($q)
    {
        $out = [];
        if ($q) {
            $customers = Customer::find()
                ->filterWhere(['like', 'firstname', $q])
                ->all();
            $out = [];
            foreach ($customers as $d) {
                $out[] = [
                    'id' => $d->id,
                    'value' => $d->fullname,
                    'name' => $d->id . ' - ' . $d->fullname
                ];
            }
        }
        echo Json::encode($out);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)

    {

        if (($model = Customer::findOne($id)) !== null) {

            return $model;

        } else {

            throw new NotFoundHttpException('The requested page does not exist.');

        }

    }


    public function actionQuestionnareDetail()
    {
        if (isset($_POST['expandRowKey'])) {

            $customerId = $_POST['expandRowKey'];
            $dataProvider = new ActiveDataProvider([
                'query' => Response::find()
                    ->andFilterWhere([
                        'customer_id' => $customerId,
                    ])
            ]);
            $searchModelResponse = new ResponseSearch();
            return $this->renderPartial('_questionnaire', [
                'searchModelResponse' => $searchModelResponse,
                'dataProviderResponse' => $dataProvider,
                'modelCustomer' => Customer::findOne($customerId),
                'customerId' => $customerId,

            ]);

        } else {

            return '<div class="text-danger">ยังไม่มีข้อมูลแบบสอบถาม</div>';

        }

    }


    public function actionAddAddress()
    {
        $customerId = Yii::$app->request->get('customerId');
        $modelAddress = new GeneralAddress();
        $modelAddress->active = 1;

        if (Yii::$app->request->post() && $modelAddress->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($modelAddress);
            }


            $customerId = Yii::$app->request->post('customerId');


            $modelAddress->table_name = Customer::TABLE_NAME;
            $modelAddress->table_key = $customerId;


            if (!empty($modelAddress->is_default)) {
                GeneralAddress::updateAll(['is_default' => 0], ['table_key' => $modelAddress->table_key]);
            }


            if ($modelAddress->save()) {
                Yii::$app->session->setFlash('success', 'เพิ่มที่อยู่เรียบร้อย');
                return $this->redirect(['customer/view', 'id' => $modelAddress->table_key]);
            } else {
                $error = \yii\widgets\ActiveForm::validate($modelAddress);
                $status = ['error' => true];
                array_merge($error, $status);
                return json_encode($error);
            }
        } else {
            return $this->renderAjax('address/_form', [
                'customerId' => $customerId,
                'modelAddress' => $modelAddress,
                'modelCustomer' => Customer::findOne($customerId),

            ]);

        }
    }


    public function actionUpdateAddress($id)
    {
        $modelAddress = GeneralAddress::findOne($id);
        if (Yii::$app->request->post() && $modelAddress->load(Yii::$app->request->post())) {


            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($modelAddress);

            }

            if (!empty($modelAddress->is_default)) {
                GeneralAddress::updateAll(['is_default' => 0], ['table_key' => $modelAddress->table_key]);
            }


            if ($modelAddress->save()) {
                Yii::$app->session->setFlash('success', 'แก้ไขที่อยู่เรียบร้อยแล้ว');
                return $this->redirect(['customer/view', 'id' => $modelAddress->table_key]);
            }
        } else {
            return $this->renderAjax('address/_form', [
                'customerId' => $modelAddress->table_key,
                'modelAddress' => $modelAddress,
                'modelCustomer' => Customer::findOne($modelAddress->table_key),

            ]);
        }
    }

    /**
     * ลบช้อมูลที่อยู่
     * @param $id
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDeleteAddress($id)
    {
        if (Yii::$app->request->isPost) {
            $modelAddress = GeneralAddress::findOne($id);
            $customerId = $modelAddress->table_key;
            if ($modelAddress->is_default === 1) {
                Yii::$app->session->setFlash('warning', 'ที่อยู่นี้เป็นที่อยู่เริ่มต้นไม่สามารถลบได้');
                return $this->redirect(['view', 'id' => $customerId]);
            } else {
                $modelAddress->active = 0;
                if ($modelAddress->save()) {
                    Yii::$app->session->setFlash('success', 'ลบเรียบร้อยแล้ว');
                    return $this->redirect(['view', 'id' => $customerId]);
                }
            }

        }
    }


    /**
     * See Customer Address
     * @param $id
     * @return string
     */

    public function actionViewAddress($id)
    {
        $modelAddress = GeneralAddress::findOne($id);
        return $this->renderAjax('address/view', [
            'modelAddress' => $modelAddress,
        ]);
    }


    public function actionViewCommunication($id)
    {
        $model = Communication::findOne($id);
        return $this->renderAjax('communication/view', [
            'model' => $model,
        ]);
    }


    public function actionAddCommunication($customerId)
    {
        $customerId = Yii::$app->request->get('customerId');
        $model = new Communication();
        $model->customer_id = $customerId;

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $datetime = date('Y-m-d H:i:s', strtotime($model->date . ' ' . $model->time));
            $model->datetime = strtotime($datetime);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'เพิ่มที่ข้อมูลเรียบร้อย');
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => 1];
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => 0];
            }
        } else {
            return $this->renderAjax('communication/_form', [
                'model' => $model,
                'customer' => Customer::findOne($customerId),
            ]);

        }
    }


    public function actionUpdateCommunication($id)
    {
        $model = Communication::findOne($id);
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $datetime = date('Y-m-d H:i:s', strtotime($model->date . ' ' . $model->time));
            $model->datetime = strtotime($datetime);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
                //return $this->renderAjax(['customer/communication/view', 'model' => $model]);
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => 1];
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => 0];
            }
        } else {
            return $this->renderAjax('communication/_form', [
                'model' => $model,
                'customer' => Customer::findOne($model->customer_id),
            ]);
        }
    }


    public function actionDeleteCommunication($id)
    {
        if (Yii::$app->request->isPost) {
            $model = Communication::findOne($id);
            $customerId = $model->customer_id;
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'ลบเรียบร้อยแล้ว');
                return $this->redirect(['view', 'id' => $customerId]);
            }
        }
    }


    public function actionChangePersonInCharge($customerId)
    {
        $customerId = Yii::$app->request->get('customerId', '');
        if ($customerId != '') {
            $model = new CustomerResponsible();
            $model->customer_id = $customerId;

            if (Yii::$app->request->post() && $model->load(Yii::$app->request->post()) && $model->validate()) {

                // ปิดสถานะก่อนหน้าทั้งหมดเป็น Inacttive ก่อน
                CustomerResponsible::updateAll(['active' => 0], [
                    'customer_id' => $customerId
                ]);

                $model->created_by = Yii::$app->user->id;
                $model->created_at = time();


                //$personnel =  OrgPersonnel::findOne(['user_id'=> $model->user_id]);
                //$model->name = $personnel->fullnameTH;


                // เปิดใช้งาน user ปัจจุบัน เป็น Active แทน
                $model->active = 1;

                if ($model->save()) {
                    // update ผู้รับผิดที่ชอบที่ ตาราง customer
                    $customer = Customer::findOne($customerId);
                    $customer->person_in_charge = $model->user_id;
                    $customer->save(false);

                    Yii::$app->session->setFlash('success', 'เพิ่มที่ข้อมูลเรียบร้อย');
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['success' => 1, 'msg' => 'เพิ่มผู้รับผิดชอบเรียบร้อยแล้ว', 'msgClass' => 'text text-success'];
                } else {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'success' => 0,
                        'msg' => 'ไม่สามารถเพิ่มข้อมูลได้',
                        'msgClass' => 'text text-danger',
                        'errors' => $model->errors
                    ];
                }
            } else {
                return $this->renderAjax('person-in-charge/_form', [
                    'model' => $model,
                    'customer' => Customer::findOne($customerId),
                ]);

            }
        }

    }


    public function actionGetAmphur()

    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];

            if ($parents != null) {
                $province_id = $parents[0];
                $out = $this->getAmphur($province_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }

        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionGetTambon()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $province_id = empty($ids[0]) ? null : $ids[0];
            $amphur_id = empty($ids[1]) ? null : $ids[1];

            if ($province_id != null) {
                $data = $this->getTambon($amphur_id);
                echo Json::encode(['output' => $data, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);

    }


    /**
     * @param $datas
     * @param $fieldId
     * @param $fieldName
     * @return array
     */

    protected function mapData($datas, $fieldId, $fieldName)

    {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }


    protected function getAmphur($id)

    {
        $datas = SysAmphur::find()->where(['province_id' => $id])->all();
        return $this->MapData($datas, 'id', 'name_th');
    }


    protected function getTambon($id)
    {
        $datas = SysTambon::find()
            ->where(['amphur_id' => $id])
            ->all();
        return $this->MapData($datas, 'id', 'name_th');
    }


    /**
     * action to fetch customer
     */
    public function actionPersonnelList($q = null)
    {
        $customers = OrgPersonnel::find()
            ->andFilterWhere(['like', 'firstname', $q])
            ->orFilterWhere(['like', 'lastname', $q])
            ->limit(100)
            ->all();
        $out = [];
        foreach ($customers as $d) {
            $out[] = [
                'id' => $d->user_id,
                'value' => $d->fullnameTH,
                'name' => $d->code . ' :: ' . $d->fullnameTH
            ];
        }
        echo Json::encode($out);
    }


}
