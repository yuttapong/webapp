<?php
/**
 * Yii quiz
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.oligalma.com
 * @copyright 2016 Oligalma
 * @license GPL License
 */

namespace app\modules\quiz\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use app\modules\quiz\models\DiplomaForm;
use app\modules\quiz\models\QuizCategory;
use app\modules\quiz\models\QuizQuestion;
use app\modules\quiz\models\QuizUserAnswer;
use yii\data\ArrayDataProvider;

class SiteController extends Controller
{
    const SECONDS_PER_QUESTION = 10; // false to disable the countdown.
    const PAGE_SIZE = 5; // false for all questions in one page.
    const MINIMUM_SCORE = 90; // false to disable diploma.
    const QUESTIONS_NUMBER = false; // false for all questions.
    
    public function actionIndex()
    {                
        $categories = QuizCategory::find()
          ->select('t.id, t.name, count(*) as questionCount')
          ->from(['t' => QuizCategory::tableName()])
          ->innerJoinWith('questions')          
          ->groupBy('t.id') 
          ->orderBy('t.id ASC')
          ->all();
          	  
        return $this->render('index', array('categories' => $categories));
    }

    public function shuffle_assoc(&$array) {
        $keys = array_keys($array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        $array = $new;

        return true;
    }
    
    public function actionStart()
    {
        if(session_id() == '' || !isset($_SESSION))
            session_start();
        
        if(isset($_GET['category']))
        {
            Yii::$app->session['category'] = $_GET['category'];      
        }
        else
        {
            Yii::$app->session['category'] = 1;   
        }
            
	unset(Yii::$app->session['diplomaGot']);
	unset(Yii::$app->session['answers']);

	$answers = array();
	
	$questions = QuizQuestion::find()
	    ->where(array('category_id' => Yii::$app->session['category']))
	    ->all();
	    
	foreach ($questions as $question) {
	    $answer = new QuizUserAnswer;
	    $answer->question_id = $question->id;
	    $answer->title = Html::encode($question->title);
	    $answer->user_answer = null;
	    
	    $answers_indexs = array(1,2,3,4,5,6);
	    shuffle($answers_indexs);

	    $answers2 = array();           
	    $answers2[$answers_indexs[0]] = Html::encode($question->answer);
	    $answer->answer = $answers_indexs[0];
	    if(!is_null($question->answer2))
		$answers2[$answers_indexs[1]] = Html::encode($question->answer2);
	    if(!is_null($question->answer3))
		$answers2[$answers_indexs[2]] = Html::encode($question->answer3);
	    if(!is_null($question->answer4))
		$answers2[$answers_indexs[3]] = Html::encode($question->answer4);
	    if(!is_null($question->answer5))
		$answers2[$answers_indexs[4]] = Html::encode($question->answer5);
	    if(!is_null($question->answer6))
		$answers2[$answers_indexs[5]] = Html::encode($question->answer6);
	    
	    $this->shuffle_assoc($answers2);
	    
	    $answer->answers = $answers2;
			  
	    $answers[] = $answer;  
	}
	
	$this->shuffle_assoc($answers);
	
	$i = 0;
	foreach($answers as &$answer)
	{
	    $answer->id = $i;
	    $i++;
	}
	
	Yii::$app->session['answers'] = array_slice($answers, 0, (self::QUESTIONS_NUMBER ? self::QUESTIONS_NUMBER : count($answers)));
             
        $dataProvider = new ArrayDataProvider(array(
                'allModels' => Yii::$app->session['answers'],
                'pagination'=>array(
                    'pageSize'=>self::PAGE_SIZE,
                    'page'=> 0,
                ),
        ));

        $seconds = $dataProvider->totalCount * self::SECONDS_PER_QUESTION;
        $questionsLeft = $dataProvider->totalCount; 
        
        return $this->render('start',array(
            'dataProvider'=>$dataProvider,
            'seconds'=>$seconds,
            'questionsLeft'=>$questionsLeft,
        ));
    }

    public function actionChange()
    {
        $page = 1;  
        if(isset($_POST['page']))
        {
            $page = $_POST['page'];
        }
        
        $dataProvider = new ArrayDataProvider(array(
                'allModels' => Yii::$app->session['answers'],
                'pagination'=>array(
                    'pageSize'=>self::PAGE_SIZE,
                    'page'=> $page - 1,
                ),
        ));
        
        $paramKeys = array_keys($_POST);
        $paramValues = array_values($_POST);
        
        $i = 0;
        foreach($paramKeys as $paramKey)
        {
            if($paramKey !== 'end' && $paramKey !== 'seconds' && $paramKey !== 'questionsLeft'
               && $paramKey !== '_csrf' && $paramKey !== 'submitButton')
            {
                if($paramKey !== 'page' && $paramKey !== 'category')
                {
                    
                    $session = Yii::$app->session;
                    $answer = $session['answers'][$paramKey];
                    $answer->user_answer = intval($paramValues[$i]);
                }
            }
            elseif($paramKey === 'end' && $paramValues[$i] === '1')
            {
                $this->redirect(array('finish'));
            }
            $i++;
        }
 
        if(isset($_POST['seconds']))
        {
            $seconds = $_POST['seconds'] - 1;
            if($seconds <= 0)
            {
                $this->redirect(array('finish'));
            }
        }
        
        if(isset($_POST['questionsLeft']))
        {
            $questionsLeft = $_POST['questionsLeft'];
        }
        
        return $this->render('start',array(
            'dataProvider'=>$dataProvider,
            'seconds'=>$seconds,
            'questionsLeft'=>$questionsLeft,
        ));   
    }
    
    public function actionFinish()
    {
        if(session_id() == '' || !isset($_SESSION))
            session_start();
        
        $page = 1;  
        if(isset($_POST['page']))
        {
            $page = $_POST['page'];
        }

        $dataProvider = new ArrayDataProvider(array(
                'allModels' => Yii::$app->session['answers'],
                'pagination'=>array(
                    'pageSize'=>self::PAGE_SIZE,
                    'page'=> $page - 1,
                ),
        ));
        
        if($dataProvider->totalCount == 0)
            throw new CHttpException(404, 'Not found');
        
        $userAnswers = Yii::$app->session['answers'];
        $correctAnswers = 0;
        foreach($userAnswers as $answer)
        {
            $question = QuizQuestion::find()
                ->where(array('id' => $answer->question_id, 'category_id' => Yii::$app->session['category']))
                ->one();
                
            if($answer->user_answer === intval($answer->answer))
                $correctAnswers++;
        }
        
        $score = round($correctAnswers / $dataProvider->totalCount * 100, 2);
        
        $diplomaForm = null;
        if(self::MINIMUM_SCORE !== false && $score >= self::MINIMUM_SCORE)
        {            
            $diplomaForm = new DiplomaForm;
            if(isset($_POST['DiplomaForm']))
            {
                $diplomaForm->attributes = $_POST['DiplomaForm'];
                if($diplomaForm->validate())
                {
                    require __DIR__ . '/../lib/fpdf/fpdf.php';
                    $pdf = new \FPDF('L','mm','A4');
                    $pdf->SetDisplayMode('fullpage');
                    $pdf->SetTitle('Diploma for you');
                    $pdf->AddPage();
                    $pdf->Image(__DIR__ . '/../assets/images/marble.jpg',0,0,$pdf->w,$pdf->h);
                    $pdf->Image(__DIR__ . '/../assets/images/diploma-frame.gif',0,0,$pdf->w,$pdf->h);
        
                    $pdf->Ln(45);
                                                
                    $text = 'Certificate of Recognition';
                    $w = $pdf->GetStringWidth($text)+6;
                    $pdf->SetX(($pdf->w-$w)/2);
                    $pdf->SetTextColor(0,0,255);
                    $pdf->SetFont('Arial','I',40);
                    $pdf->Cell($w,9,$text,0,1,'C',false);
    
                    $text = '';
                    $w = $pdf->GetStringWidth($text)+6;
                    $pdf->SetFont('Arial','B',15);
                    $pdf->Cell($w,5,$text,0,0,'C',false);
    
                    $pdf->Ln();
                    
                    $category = QuizCategory::find()
                        ->where(array('id' => Yii::$app->session['category']))
                        ->one();
                                      
                    $text = 'This certificate accredits that the ' . $category->name . ' online test has been successfully passed by:';
                    $w = $pdf->GetStringWidth($text)+6;
                    $pdf->SetX(($pdf->w-$w)/2);
                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFont('Arial','B',15);
                    $pdf->Cell($w,20,$text,0,0,'C',false);
                    
                    $pdf->Ln(30);
                                    
                    $text = $diplomaForm->name;
                    $w = $pdf->GetStringWidth($text)+6;
                    $pdf->SetX(($pdf->w-$w)/2);
                    $pdf->SetFont('Arial','B',40);
                    $pdf->Cell($w,20,$text,0,0,'C',false);
                    
                    $pdf->Ln(50);
                                                    
                    Yii::$app->session['diplomaGot'] = 1;
                    $pdf->Output();
                }
            }
        }
        return $this->render('finish', array(
            'score' => $score,
            'dataProvider' => $dataProvider,
            'diplomaForm' => $diplomaForm,
        ));
    }
}
