<?php

namespace backend\modules\qtn\controllers;

use Yii;
use backend\modules\qtn\models\Question;
use backend\modules\qtn\models\QuestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\qtn\models\QuestionGroupChoice;
use yii\helpers\ArrayHelper;
use common\models\Model;
use backend\modules\qtn\models\SurveyTab;
use yii\helpers\Json;
use backend\modules\qtn\models\SurveyTitle;
use backend\modules\qtn\models\QuestionChoice;
use backend\modules\qtn\models\ResponseBool;
use backend\modules\qtn\models\ResponseMultiple;
use backend\modules\qtn\models\ResponseText;
use backend\modules\qtn\models\ResponseSingle;
use yii\db\Query;

/**
 * QuestionController implements the CRUD actions for QtnQuestion model.
 */
class QuestionController extends Controller
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
     * Lists all QtnQuestion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single QtnQuestion model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new QtnQuestion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Question();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing QtnQuestion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $survey_tab    = ArrayHelper::map($this->getSurveyTab($model->survey_id),'id','name');
       $survey_title       = ArrayHelper::map($this->getSurveyTitle ($model->survey_tab_id),'id','name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            	 'survey_tab' =>$survey_tab,
            	 'survey_title' =>	$survey_title
            ]);
        }
    }

    /**
     * Deletes an existing QtnQuestion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
   
    	$arr_re['status']=0;
    	if (Yii::$app->request->isAjax) {
    		$type_id=$_POST['type_id']; 
			
    		switch ($type_id) {
    			case 1:
    				$modBool=ResponseBool::find()->where(['question_id' => $id]  )->count();
    				if($modBool==0){
    					$this->findModel($id)->delete();
    					$arr_re['status']=1;
    				}
    			break;
    			case 4:
    				$cSingle=ResponseSingle::find()->where(['question_id' => $id]  )->count();
    				if($cSingle==0){
    					QuestionChoice::deleteAll(['question_id' =>$id]);
    					$this->findModel($id)->delete();
    					$arr_re['status']=1;
    				}
    			break;
    			case 5:
    				$countMultiple=ResponseMultiple::find()->where(['question_id' => $id]  )->count();
    				if($countMultiple==0){
    					QuestionChoice::deleteAll(['question_id' =>$id]);
    					$this->findModel($id)->delete();
    					$arr_re['status']=1;
    				}
    			break;
    			case 2: 
    			case 10 :
    				$countText=ResponseText::find()->where(['question_id' => $id]  )->count();
    				if($countText==0){
    					$this->findModel($id)->delete();
    					$arr_re['status']=1;
    				}
    			break;
    			case '11' :
    				$survey_id=$_POST['survey_id'];
    				$tite_id=$_POST['tite_id'];
    				$connection = \Yii::$app->db;
    			 	 $sql=" SELECT COUNT(q.id) as row_question  FROM qtn_question q
								INNER JOIN qtn_response_rank rank on rank.question_id=q.id
								WHERE q.survey_id='$survey_id' AND q.survey_title_id='$tite_id' ";
		    			$result = $connection->createCommand($sql)->queryOne();
		    			if($result['row_question']==0){
		    				 //QuestionGroupChoice::deleteAll(['survey_title_id' =>$tite_id]);
		    				 //\backend\modules\qtn\models\Question::deleteAll( ['survey_id' =>$survey_id,'survey_title_id'=>$tite_id,'type_id'=>'11' ]  );
		    			}
    				break;
    		}
    	}
		echo Json::encode($arr_re);
		exit();

    }

    /**
     * Finds the QtnQuestion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return QtnQuestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionType()    {
    	$modelsEducation = QuestionGroupChoice::find()
    	->where(['survey_title_id' => 4])
    	->all();
    	if( count($modelsEducation)==0 ){
    		$modelsEducation = [new QuestionGroupChoice];
    	}
    	//renderPartial renderAjax
   	 return	$this->renderAjax('form_type/_question_group_choice', [
    			'modelsHouse' => $modelsEducation,
    	]);
    	
    }
    public function actionSurveytab() {
    	$out = [];
    	if (isset($_POST['depdrop_parents'])) {
    		$parents = $_POST['depdrop_parents'];
    		if ($parents != null) {
    			$province_id = $parents[0];
    			$out = $this->getSurveyTab($province_id);
    			
    			echo Json::encode(['output'=>$out, 'selected'=>'']);
    			return;
    		}
    	}
    	echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    public function actionGetSurveyTitle() {
    	$out = [];
    	if (isset($_POST['depdrop_parents'])) {
    		$ids = $_POST['depdrop_parents']; 
    	 	$province_id = empty($ids[0]) ? null : $ids[0];
    		 $amphur_id = empty($ids[1]) ? null : $ids[1];
    		if ($province_id != null) {
    			$data = $this->getSurveyTitle($amphur_id);
    			echo Json::encode(['output'=>$data, 'selected'=>'']);
    			return;
    		}
    	}
    	echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    protected  function getSurveyTab($id){
    	$datas = SurveyTab::find()->where(['survey_id'=>$id])->all();
    	return $this->MapData($datas,'id','name');
    }
     protected function getSurveyTitle($id){
    	$datas = SurveyTitle::find()->where(['survey_tab_id'=>$id])->all();
    	return $this->MapData($datas,'id','name');
    }
    protected function MapData($datas,$fieldId,$fieldName){
    	$obj = [];
    	foreach ($datas as $key => $value) {
    		array_push($obj, ['id'=>$value->{$fieldId},'name'=>$value->{$fieldName}]);
    	}
    	return $obj;
    }
     public function actionQuestionSeq(){
     	
     	$seq=$_POST['seq'];
     	$survey_id=$_POST['survey_id'];
     	foreach ($seq as $key_title=> $val){
     		foreach ($val as $key_seq =>$val_seq){
     			if($val_seq!= 'type_id11'){
     				$model = $this->findModel($val_seq);
     				$model->seq=$key_seq+1;
     				 $model->save();
     			}
     		}
     	}
     }
   
}
