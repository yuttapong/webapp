<?php

namespace backend\modules\crm\controllers;

use backend\modules\crm\models\Communication;
use backend\modules\crm\models\CustomerResponsible;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use backend\modules\crm\models\CustomerSearch;
use backend\modules\crm\models\Customer;







/**
ault controller for the `crm` module
 */
class DefaultController extends Controller
{
	public $layout = 'dashboard';
	
	
	
	
	
	/**
	* Renders the index view for the module
					     * @return string
					     */
					    public function actionIndex()
					    {
		
		$searchModel = new CustomerSearch;
		$dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
		
		$dataProviderLastComment =  new ActiveDataProvider([
										            'query' => Communication::find()->orderBy(['created_at' => SORT_DESC])->limit(10)
										        ]);
		
		return $this->render('index', [
										            'model' => new Customer(),
										            'dataProvider' => $dataProvider,
										            'searchModel' => $searchModel,
										            'dataProviderLastComment' => $dataProviderLastComment
										        ]);
		
		// 		return $this->redirect(['response/index']);
	}
	
	public function actionFindCustomer($q)
					    {
		$name = 'Hello World';
		echo $name . ' <br> : <strong> Beam </strong> ';
		$leng = strlen($name);
		
		
		$out = [];
		if ($q) {
			$customers = Customer::find()
															                ->andFilterWhere(['like', 'firstname', $q])
															                ->orFilterWhere(['like', 'lastname', $q])
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
	
	public function actionCustomerDetail($id)
					    {
		$model = Customer::findOne($id);
		if (Yii::$app->request->isAjax) {
			return $this->renderPartial('customer-detail', ['model' => $model]);
		}
		else {
			return $this->render('customer-detail', ['model' => $model]);
		}
	}
	
	
}
