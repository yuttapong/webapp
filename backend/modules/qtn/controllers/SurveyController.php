<?php

namespace backend\modules\qtn\controllers;

use Yii;
use backend\modules\qtn\models\Survey;
use backend\modules\qtn\models\SurveySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\qtn\models\SurveyTabSearch;
use backend\modules\qtn\models\SurveyTitleSearch;
use backend\modules\qtn\models\QuestionMessage;
use backend\modules\qtn\models\SurveyTitle;
use backend\modules\qtn\models\QuestionGroupChoice;
use backend\modules\qtn\models\Question;
use backend\modules\qtn\models\QuestionSearch;
use backend\modules\qtn\models\SurveyTab;
use backend\models\Model;
use backend\modules\qtn\models\QuestionChoice;
use yii\helpers\ArrayHelper;


/**
 * SurveyController implements the CRUD actions for Survey model.
 */
class SurveyController extends Controller
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
     * Lists all Survey models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SurveyTitleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Survey model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$searchModel = new Question();
    	$questions=	$searchModel->getQuestionTable($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
        	 'questions' =>	$questions,
        		'survey_id'=>$id,
        ]);
    }

    /**
     * Creates a new Survey model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelsSurvey = new Survey();
        $modelsTab= [new SurveyTab];
        $modelsTitle= [[new SurveyTitle]];
       // echo '<pre>';
      //  print_r($_POST);
      //  echo '</pre>';
      //  exit();
       if ($modelsSurvey->load(Yii::$app->request->post())) {
            $modelsTab = Model::createMultiple(SurveyTab::classname());
            Model::loadMultiple($modelsTab, Yii::$app->request->post());

            // validate person and houses models
            $valid = $modelsSurvey->validate();
            $valid = Model::validateMultiple($modelsTab) && $valid;

            if (isset($_POST['SurveyTitle'][0][0])) {
                foreach ($_POST['SurveyTitle'] as $indexTab => $rooms) {
                    foreach ($rooms as $indexTitle => $room) {
                        $data['SurveyTitle'] = $room;
                        $modelTitle = new SurveyTitle;
                        $modelTitle->load($data);
                        $modelsTitle[$indexTab][$indexTitle] = $modelTitle;
                        $valid = $modelTitle->validate();
                    }
                }
            }

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelsSurvey->save(false)) {
                        foreach ($modelsTab as $indexTab => $modelTab) {

                            if ($flag === false) {
                                break;
                            }

                            $modelTab->survey_id = $modelsSurvey->id;

                            if (!($flag = $modelTab->save(false))) {
                                break;
                            }

                            if (isset($modelsTitle[$indexTab]) && is_array($modelsTitle[$indexTab])) {
                                foreach ($modelsTitle[$indexTab] as $indexTitle => $modelTitle) {
                                    $modelTitle->survey_tab_id = $modelTab->id;
                                    $modelTitle->survey_id = $modelsSurvey->id;
                                    if (!($flag = $modelTitle->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelsSurvey->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
         return $this->render('create', [
            'modelsSurvey' => $modelsSurvey,
            'modelsTab' => (empty($modelsTab)) ? [new SurveyTab] : $modelsTab,
            'modelsTitle' => (empty($modelsTitle)) ? [[new SurveyTitle]] : $modelsTitle,
        ]);
    }
    public function actionUpdate($id){
    	$modelsSurvey= $this->findModel($id);
    	$modelsTab =$modelsSurvey->surveyTabs;
    	$modelsTitle = [];
    	$oldTitle= [];
    	if (!empty($modelsTab)) {
    		foreach ($modelsTab as $indexTab => $modelTab) {
    			$title = $modelTab->title;
    			$modelsTitle[$indexTab] = $title;
    			$oldTitle = ArrayHelper::merge(ArrayHelper::index($title, 'id'), $oldTitle);
    		}
    	}
    
    	if ($modelsSurvey->load(Yii::$app->request->post())) {
    		// reset
    		$modelsTitle = [];
    		$oldTabIDs = ArrayHelper::map($modelsTab, 'id', 'id');
    		$modelsTab = Model::createMultiple(SurveyTab::classname(), $modelsTab);
    		Model::loadMultiple($modelsTab, Yii::$app->request->post());
    		$deletedTabIDs = array_diff($oldTabIDs, array_filter(ArrayHelper::map($modelsTab, 'id', 'id')));
    
    		// validate person and houses models
    		$valid = $modelsSurvey->validate();
    		$valid = Model::validateMultiple($modelsTab) && $valid;
    
    		$titeIDs = [];
    		if (isset($_POST['SurveyTitle'][0][0])) {
    			foreach ($_POST['SurveyTitle'] as $indexTab => $rooms) {
    				$titeIDs = ArrayHelper::merge($titeIDs, array_filter(ArrayHelper::getColumn($rooms, 'id')));
    				foreach ($rooms as $indexTite => $room) {
    					$data['SurveyTitle'] = $room;
    					$modelTitle = (isset($room['id']) && isset($oldTitle[$room['id']])) ? $oldTitle[$room['id']] : new SurveyTitle;
    					$modelTitle->load($data);
    					$modelsTitle[$indexTab][$indexTite] = $modelTitle;
    					$valid = $modelTitle->validate();
    				}
    			}
    		}
    
    		$oldTitleIDs = ArrayHelper::getColumn($oldTitle, 'id');
    		$deletedRoomsIDs = array_diff($oldTitleIDs, $titeIDs);
    
    		if ($valid) {
    			$transaction = Yii::$app->db->beginTransaction();
    			try {
    				if ($flag = $modelsSurvey->save(false)) {
    
    					if (! empty($deletedRoomsIDs)) {
    						SurveyTitle::deleteAll(['id' => $deletedRoomsIDs]);
    					}
    
    					if (! empty($deletedHouseIDs)) {
    						SurveyTab::deleteAll(['id' => $deletedHouseIDs]);
    					}
    
    					foreach ($modelsTab as $indexTab => $modelTab) {
    
    						if ($flag === false) {
    							break;
    						}
    						$modelTab->survey_id = $modelsSurvey->id;
    						if (!($flag = $modelTab->save(false))) {
    							break;
    						}
    
    						if (isset($modelsTitle[$indexTab]) && is_array($modelsTitle[$indexTab])) {
    							foreach ($modelsTitle[$indexTab] as $indexTite => $modelTitle) {
    								$modelTitle->survey_tab_id = $modelTab->id;
    								$modelTitle->survey_id = $modelsSurvey->id;
    								if (!($flag = $modelTitle->save(false))) {
    									break;
    								}
    							}
    						}
    					}
    				}
    
    				if ($flag) {
    					$transaction->commit();
    					return $this->redirect(['view', 'id' => $modelsSurvey->id]);
    				} else {
    					$transaction->rollBack();
    				}
    			} catch (Exception $e) {
    				$transaction->rollBack();
    			}
    		}
    	}
    
    
    	$tab['SurveyTabSearch']['survey_id']=$id;
    
    	return $this->render('update', [
    			 
    			'modelsSurvey' => $modelsSurvey,
    			'modelsTab' => (empty($modelsTab)) ? [new SurveyTab] : $modelsTab,
    			'modelsTitle' => (empty($modelsTitle)) ? [[new SurveyTitle]] : $modelsTitle,
    	]);
    }
    /**
     * Deletes an existing Survey model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Survey model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Survey the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Survey::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
   

 
    public function actionTitle($id) {
    	$title['SurveyTitleSearch']['survey_tab_id']=$id;
    	$searchModel = new SurveyTitleSearch();
    	$dataProvider = $searchModel->search($title);
    	
    	return $this->render('title/index', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }

    protected function saveQuestionTitl($id,$arr){ 

    	if(isset($arr['Question'])){
    		$group_question=$arr['Question'];

    		if(isset($arr['que-check'])&&count($arr['que-check'])>0 ){
    			foreach ($arr['que-check'] as $key =>$val){
    				if($val=='add'){
    					$question=new Question();
    					$question->survey_id=$arr['survey_id'];
    					$question->survey_tab_id=$arr['survey_tab_id'];
    					$question->type_id=11;
    					$question->survey_title_id=$arr['survey_title_id'];
    					$question->name=$group_question['name'][$key];
    					$question->content=$group_question['content'][$key];
    					$question->save();
    				}elseif($val=='edit'){
    					$question = Question::findOne($group_question['old_id'][$key]);
    					$question->survey_id=$arr['survey_id'];
    					$question->survey_tab_id=$arr['survey_tab_id'];
    					$question->survey_title_id=$arr['survey_title_id'];
    					$question->name=$group_question['name'][$key];
    					$question->content=$group_question['content'][$key];
    					$question->save();
    				}elseif($val=='del'){
    					$question = Question::findOne($group_question['old_id'][$key]);
    					$question->delete();
    				}
    			}
    		}
    	}
    }
    public function actionQuestion($id)
    { 
    	$searchModel = new Question();
   	 $questions=	$searchModel->getQuestionTable($id);
    	$modelTitle = SurveyTitle::find()
    	->where(['survey_id' => $id])
    	->all();
    	foreach ($modelTitle as $v_title){
    		$questions[$v_title->survey_tab_id]['tab_name']=$v_title->surveyTab->name;
    		$questions[$v_title->survey_tab_id]['item'][$v_title->id]['title_name']=$v_title->name;
    	}
    
    	return $this->render('question/index', [
    			'survey_id'=>$id,
    			'question_c' => 	$questions,
    	]);
    }
    public function actionQuestionView($id)
    {
    	if (Yii::$app->request->isAjax) {
    		return $this->renderAjax('question/xxxx', [
    				'model' => '',
    		]);
    	} else {
    		return $this->render('question/xxxx', [
    				'model' => '',
    		]);
    	}
    }
    protected function saveChoiceTitl($id,$arr){
    	if(isset($arr['QuestionGroupChoice'])){
    	$group_choice=$arr['QuestionGroupChoice'];
    	
    	if(isset($arr['con-check'])&&count($arr['con-check'])>0 ){
    		foreach ($arr['con-check'] as $key =>$val){
    				if($val=='add'){	
    					if($group_choice['question_message_id'][$key]==0){
    					$message =new QuestionMessage();
    					$message->name=$group_choice['name'][$key];
    					$message->created_at=time();
    					$message->created_by=Yii::$app->user->id;
    					$message->table_name='qtn_question_group_choice';
    					$message->save();
    					$question_message_id=$message->id;
    					}else{
    						$question_message_id=$group_choice['question_message_id'][$key];
    					}
    					
    					$choice =new QuestionGroupChoice();
    					$choice->survey_title_id=$id;
    					$choice->question_message_id=$question_message_id;
    					$choice->content=$group_choice['name'][$key];
    					$choice->score=$group_choice['score'][$key];
    					$choice->created_at=time();
    					$choice->created_by=Yii::$app->user->id;
    					$choice->save();
    		
    				}elseif($val=='edit'){
    					$choice = QuestionGroupChoice::findOne($group_choice['old_id'][$key]);
    					$choice->survey_title_id=$id;
    					$choice->question_message_id=$group_choice['question_message_id'][$key];
    					$choice->content=$group_choice['name'][$key];
    					$choice->score=$group_choice['score'][$key];
    					$choice->save();
    				}elseif($val=='del'){  			
    					$choice = QuestionGroupChoice::findOne($group_choice['old_id'][$key]);
    					$choice->delete();
    				}
    		}
    	}
    	}
    }
public function actionSaveChoice() {
    	$type_id=$_POST['Question']['type_id'];
    	$name=$_POST['Question']['name'];
    	$survey_id=$_POST['survey_id'];
    	$tab_id=$_POST['tab_id'];
    	$tite_id=$_POST['tite_id'];
    	$question_id=$_POST['id'];
    	if($question_id!=''){
    		$question = Question::findOne($question_id);
    		$question->survey_id=$survey_id;
    		$question->survey_tab_id=$tab_id;
    		$question->survey_title_id=$tite_id;
    		$question->type_id=$type_id;
    		$question->name=$name;
    	}else {
	    	$question=new Question();
	    	$question->survey_id=$survey_id;
	    	$question->survey_tab_id=$tab_id;
	    	$question->survey_title_id=$tite_id;
	    	$question->type_id=$type_id;
	    	$question->name=$name;
    	}
    	if($question->save()){
    		$question_id=$question->id;
    		if(isset($_POST['cho-check'])&&count($_POST['cho-check'])>0 ){
    			$group_choice=$_POST['QuestionChoice'];
    			$row=1;
    			foreach ($group_choice['name'] as $key_n =>$val_n){
    				$group_choice['seq'][$key_n]=$row;
    				$row++;
    			}
    			foreach ($_POST['cho-check'] as $key =>$val){
    				if($val=='add'){ 
    					if($group_choice['question_message_id'][$key]==0){
    						$message =new QuestionMessage();
    						$message->name=$group_choice['name'][$key];
    						$message->created_at=time();
    						$message->created_by=Yii::$app->user->id;
    						$message->table_name='qtn_question_choice';
    						$message->save();
    						$question_message_id=$message->id;
    					}else{
    						$question_message_id=$group_choice['question_message_id'][$key];
    					}
    					$choice =new QuestionChoice();
    					$choice->question_id=$question_id;
    					$choice->question_message_id=$question_message_id;
    					$choice->content=$group_choice['name'][$key];
    					$choice->score=$group_choice['score'][$key];
    					$choice->seq=$group_choice['seq'][$key];
    					$choice->type=$group_choice['type'][$key];
    					$choice->created_at=time();
    					$choice->created_by=Yii::$app->user->id;
    					$choice->save();
    				}elseif($val=='edit'){
    					$choice = QuestionChoice::findOne($group_choice['old_id'][$key]);
    					$choice->question_message_id=$group_choice['question_message_id'][$key];
    					$choice->content=$group_choice['name'][$key];
    					$choice->score=$group_choice['score'][$key];
    					$choice->seq=$group_choice['seq'][$key];
    					$choice->type=$group_choice['type'][$key];
    					$choice->save();
    				}elseif($val=='del'){
    					$choice = QuestionChoice::findOne($group_choice['old_id'][$key]);
    					$choice->delete();
    				}
    				
    			}
    		}
			if($question->type_id=='4' || $question->type_id=='5'){
				return	$this->renderAjax('question/type_choice', [
							'survey_id' =>  $survey_id,
							'tab_id' =>  $tab_id,
							'tite_id' => $tite_id,
							'modelQuestion' =>$question,
							'proc' =>['edit'=>'edit'] ,
					]);
			}else{
		    		return  $this->renderAjax('question/type_choice_single', [
		    				'type_id' =>  $type_id,
		    				'survey_id' =>  $survey_id,
		    				'tab_id' =>  $tab_id,
		    				'tite_id' => $tite_id,
		    					'modelQuestion' =>$question,
		    				'proc' =>['edit'=>'edit'] ,
		    		]);
			}
    	}

    }
    public function actionTypeAjax() {
    	$type_id=$_POST['type_id'];
    	if($type_id==11){
    		$tite_id=$_POST['tite_id'];
    		echo $tite_id.'===';
    	
	    	$modelTite =SurveyTitle::findOne($tite_id); //renderPartial
	    		echo $modelTite->surveyTab->survey_id;
	    	return $this->renderAjax('title/choice', [
	    				'id'=>$tite_id,
	    				'modelTite' => $modelTite,
	    	]);
    	}elseif($type_id==4 ||$type_id==5 ){
    		$tite_id=$_POST['tite_id'];
    		if(isset($_POST['question_id'])){
    			$modelQuestion = Question::findOne($_POST['question_id']);
    		
    		}else{
    			$modelQuestion = new Question();
    		}
    		
    		return $this->renderAjax('question/_form_choice', [
    				'id'=>$tite_id,
    				'type_id'=>$type_id,
    				'modelQuestion'=>$modelQuestion,
    		]);
    	}elseif($type_id==1 || $type_id==2 || $type_id==9 || $type_id==10 ){
    		$tite_id=$_POST['tite_id'];
    		if(isset($_POST['question_id'])){
    			$modelQuestion = Question::findOne($_POST['question_id']);
    		
    		}else{
    		$modelQuestion = new Question();
    		}
    		return $this->renderAjax('question/_form_choice_single', [
    					'id'=>$tite_id,
    					'type_id'=>$type_id,
    					'modelQuestion'=>$modelQuestion,
    			]);
    	}else{
    		echo 'ddd';
    	}
    	
    }
    public function actionChoiceTitle($id) {
    	$modelTite =SurveyTitle::findOne($id);
    	$request = Yii::$app->request;

    	$this->saveChoiceTitl($id,Yii::$app->request->post());
    	$this->saveQuestionTitl($id,Yii::$app->request->post());
    	if(	 !empty($request->post('que-check')) ){
    		$survey_id=$_POST['survey_id'];
    		return $this->redirect(['survey/question' ,'id'=>$survey_id]);
    	}
    	return $this->render('title/choice', [
    			'id'=>$id,
    			'modelTite' => $modelTite,
    	]);
    }
    public function actionMessageList($q = null) {

    	$models = QuestionMessage::find()
    	->select('id,name')
    	->where('name LIKE "%' .trim($q) .'%" AND  status = \'1\' ')
    	->asArray()->all();
 
    	echo json_encode($models);
    }
}
