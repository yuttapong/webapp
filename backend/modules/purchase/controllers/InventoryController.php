<?php

namespace backend\modules\purchase\controllers;

use backend\modules\purchase\models\Categories;
use backend\modules\purchase\models\InventoryPrice;
use backend\modules\purchase\models\Vendor;
use Dompdf\Exception;
use Yii;
use backend\modules\purchase\models\Inventory;
use backend\modules\purchase\models\InventorySearch;
use yii\helpers\ArrayHelper;
use yii\validators\RequiredValidator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;


/**
 * InventoryController implements the CRUD actions for Inventory model.
 */
class InventoryController extends Controller
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
        ];
    }

    /**
     * Lists all Inventory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post('hasEditable')) {
            $keys = Yii::$app->request->post('editableKey');
            $model = Inventory::findOne($keys);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


            $post = [];
            $posted = current($_POST['Inventory']);
            $post = ['Inventory' => $posted];

            if ($model->load($post)) {
                $model->save();

                $value = $model->name;

                return ['output' => $value, 'message' => ''];


            } else {
                return ['output' => '', 'message' => ''];
            }
        }
        $category = Categories::find()->where(['id' => $searchModel->categories_id])->one();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'category' => $category,
        ]);
    }

    public function actionCategory()
    {
        $cid = Yii::$app->request->get('cid', '');
        $searchModel = new InventorySearch(['categories_id' => $cid]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryName' => Categories::findOne($searchModel->categories_id)->name
        ]);
    }


    private function getItems()
    {
        $data = [
            [
                'id' => 1,
                'title' => 'Title 1',
                'description' => 'Description 1'
            ],
            [
                'id' => 2,
                'title' => 'Title 2',
                'description' => 'Description 2'
            ],
        ];

        $items = [];
        foreach ($data as $row) {
            $item = new Item();
            $item->setAttributes($row);
            $items[] = $item;
        }


    }

    /**
     * Displays a single Inventory model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->prices = $model->getAllPrices();
        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('view', [
                'model' => $model,
            ]);
        } else {
            return $this->render('view', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Creates a new Inventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Inventory();
        $modelPrice = [new InventoryPrice()];

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $model->created_by = Yii::$app->user->id;
                $model->created_at = time();
                $model->updated_by = Yii::$app->user->id;
                $model->updated_at = time();
                $saved = $model->save();
                $prices = Yii::$app->request->post();

                if (isset($prices['Inventory']['prices'])) {
                    foreach ($prices['Inventory']['prices'] as $key => $item) {
                        if (empty($item['id'])) {
                            $modelPrice = new InventoryPrice();
                            $modelPrice->created_at = time();
                            $modelPrice->created_by = Yii::$app->user->id;
                        } else {
                            $modelPrice = InventoryPrice::findOne($item['id']);
                        }
                        $modelPrice->inventory_id = $model->id;
                        $modelPrice->vendor_id = $item['vendor_id'];
                        $modelPrice->vendor_name = Inventory::getVendorName($modelPrice->vendor_id);
                        $modelPrice->price = $item['price'];
                        $modelPrice->due_date = $item['due_date'];
                        $modelPrice->active = !isset($item['active']) ? InventoryPrice::STATUS_INACTIVE : $item['active'];
                        if ($modelPrice->price && $modelPrice->vendor_id) {
                            $modelPrice->save(false);
                        }
                    }
                }

                if ($saved) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'เพิ่มสินค้าใหม่เรียบร้อย' . $model->id);
                    return $this->redirect(['update', 'id' => $model->id]);
                }

            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'เพิ่มสินค้าใหม่เรียบร้อย');
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelPrice' => $modelPrice,
            ]);
        }
    }

    /**
     * Updates an existing Inventory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->prices = $model->getAllPrices();
        $modelPrice = [new InventoryPrice()];


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $prices = Yii::$app->request->post();
            $oldPrices = ArrayHelper::map($model->prices, 'id', 'id');
            $currentPrices = ArrayHelper::map($prices['Inventory']['prices'], 'id', 'id');
            $deletedPrices = array_diff($oldPrices, array_filter($currentPrices));

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save();

                // detete price
                if (!empty($deletedPrices)) {
                    InventoryPrice::deleteAll(['id' => $deletedPrices]);
                }

                foreach ($prices['Inventory']['prices'] as $key => $item) {
                    if (empty($item['id'])) {
                        $modelPrice = new InventoryPrice();
                        $modelPrice->created_at = time();
                        $modelPrice->created_by = Yii::$app->user->id;
                    } else {
                        $modelPrice = InventoryPrice::find()->where(['id' => $item['id']])->one();
                    }
                    $modelPrice->inventory_id = $model->id;
                    $modelPrice->vendor_id = $item['vendor_id'];
                    $modelPrice->vendor_name = @Inventory::getVendorName($modelPrice->vendor_id);
                    $modelPrice->price = $item['price'];
                    $modelPrice->due_date = $item['due_date'];
                    $modelPrice->active = !isset($item['active']) ? InventoryPrice::STATUS_INACTIVE : $item['active'];


                    if ($modelPrice->price && $modelPrice->vendor_id) {
                        $modelPrice->save(false);
                    }
                }


                $transaction->commit();
                Yii::$app->session->setFlash('success', 'เพิ่มสินค้าใหม่เรียบร้อย');
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(['update', 'id' => $model->id]);
            }


        } else {
            return $this->render('update', [
                'model' => $model,
                'modelPrice' => $modelPrice,
            ]);
        }
    }


    /**
     * Deletes an existing Inventory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Inventory::STATUS_INACTIVE;
        $model->save();

        return $this->redirect(['index']);
    }

    public function actionDeletePrice()
    {
        $id = Yii::$app->request->post('id', null);
        if ($id) {
            $model = InventoryPrice::findOne($id);
            $model->active = InventoryPrice::STATUS_INACTIVE;

            if (Yii::$app->request->isAjax) {
                if ($model->save()) {
                    $result = [
                        'success' => 1,
                        'msg' => 'Success : delete id : ' . $id,
                    ];
                    echo json_encode($result);
                } else {
                    $result = [
                        'success' => 0,
                        'msg' => 'Error : delete id : ' . $id,
                    ];
                    echo json_encode($result);
                }
            } else {
                $model->save();
                return $this->redirect(['index']);
            }
        }
    }

    public function actionChangePriceStatus()
    {
        $id = Yii::$app->request->post('id', null);
        $status = Yii::$app->request->post('status',null);
        if ( ! empty($id) ) {
            $model = InventoryPrice::findOne($id);

            if($status == InventoryPrice::STATUS_ACTIVE)
                    $model->active = InventoryPrice::STATUS_INACTIVE;
            if($status == InventoryPrice::STATUS_INACTIVE)
                    $model->active = InventoryPrice::STATUS_ACTIVE;

            if (Yii::$app->request->isAjax) {

                if ($model->save()) {
                    $result = [
                        'success' => 1,
                        'active' => $model->active,
                        'msg' => 'Success  : ' . $id,
                    ];
                    echo json_encode($result);
                } else {
                    $result = [
                        'success' => 0,
                        'active' => $model->active,
                        'msg' => 'Error  : ' . $id,
                    ];
                    echo json_encode($result);
                }
            } else {
                $model->save();
                return $this->redirect(['index']);
            }
        }
    }



    /**
     * Finds the Inventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Inventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inventory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionInventoryList($q = null, $id = null)
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query();
            $query->select("id, master_id ,name,unit_name")
                ->from('psm_inventory')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $arrData = [];
            foreach ($data as $val) {

                if ($val['master_id'] == $val['id']) {
                    $text = $val['master_id'] . ':' . $val['name'] . ' ' . $val['unit_name'];
                } else {
                    $text = $val['name'];
                }
                $arrData[$val['id']]['id'] = $val['id'];

                $arrData[$val['id']]['text'] = $text;
            }

            $out['results'] = array_values($arrData);
        } elseif ($id > 0) {
            $model = Inventory::find($id);
            $out['results'] = ['id' => $id, 'text' => $model->master_id . ':' . $model->name];
        }
        return $out;
    }


    public function validatePrices($attribute)
    {
        $requiredValidator = new RequiredValidator();

        foreach ($this->$attribute as $index => $row) {
            $error = null;
            $requiredValidator->validate($row['price'], $error);
            if (!empty($error)) {
                $key = $attribute . '[' . $index . '][price]';
                $this->addError($key, $error);
            }
        }
    }

    /**
     * @return Action
     */
    public function actionVendorDetail($id)
    {
        $vendor = Vendor::find()->where(['id' => $id])->one();
        /*         echo json_encode([
                     'success' => 1,
                     'row' => $vendor
                 ]);*/

        echo $vendor->id . '-' . $vendor->company;

    }


}
