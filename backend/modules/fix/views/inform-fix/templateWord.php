<?php 

use PhpOffice\PhpWord\TemplateProcessor;
use common\siricenter\thaiformatter\ThaiDate;
use backend\modules\fix\models\Question;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\org\models\OrgPersonnel;

if($model->project_id=='2'){
	$fileName='templateWordMd.docx';
	$templatePath=Yii::getAlias('@backend/modules/fix/views/inform-fix/templateWordMd.docx');

}elseif($model->project_id=='1'){
	$fileName='templateWordSv.docx';
	$templatePath=Yii::getAlias('@backend/modules/fix/views/inform-fix/templateWordSv.docx');
}elseif($model->project_id=='1'){
	$fileName='templateWordFs.docx';
	$templatePath=Yii::getAlias('@backend/modules/fix/views/inform-fix/templateWordFs.docx');
}else{
	echo 'ไม่สามารถออก word ได้ ต้องตั้งค่าก่อน ติดต่อ IT ';
	exit();
}
$templateProcessor = new TemplateProcessor($templatePath);


// Variables on different parts of document
$modelQuestion =new Question();
$dataq=	$modelQuestion->getDataQuestion('fix_inform_fix',$model->id);
$customerDate='..................เวลา...........';
if(!empty($dataq['6']['answer']) && $dataq['6']['answer']!='' ){
	  $customerDate=ThaiDate::widget([ 'timestamp' => strtotime($dataq['6']['answer']), 'type' => ThaiDate::TYPE_MEDIUM,  'showTime' => true   ]);
}

if(!empty($dataq['2']) ){
	foreach ($dataq['2']['choices'] as $k2Que=> $v2Que) { 
		if(!empty($dataq['2']['answer'][$k2Que])){
			$templateProcessor->setValue('cho'.$k2Que, '&#x2611;');
		}else{
			$templateProcessor->setValue('cho'.$k2Que, '&#x2610;'); 
		}
	}
}
if(!empty($dataq['3']) ){
	foreach ($dataq['3']['choices'] as $k3Que=> $v3Que) {
		if(!empty($dataq['3']['answer'][$k3Que])){
			$templateProcessor->setValue('cho'.$k3Que, '&#x2611;');
		}else{
			$templateProcessor->setValue('cho'.$k3Que, '&#x2610;');
		}
		
		if(!empty($dataq['3']['answerOther'][$k3Que]['response'])){
			$templateProcessor->setValue('choOther'.$k3Que,$dataq['3']['answerOther'][$k3Que]['response']);
		}else{
			$templateProcessor->setValue('choOther'.$k3Que, '………………...');
		}
	}
}
$question4='................................................................................................... ................................................................................................... ...................................................................................................';
if(!empty($dataq['4']['answer'])  ){
	$question4=$dataq['4']['answer'];
}
$templateProcessor->setValue('question4', $question4);
$templateProcessor->setValue('customerDate', $customerDate);

$templateProcessor->setValue('datenow', date('Y-m-d H:i:s'));  
$suggestion='................................................................................................... ................................................................................................... ...................................................................................................';           // On footer
$templateProcessor->setValue('suggestion', $suggestion);
$templateProcessor->setValue('code', $model->code);
// Simple table
$templateProcessor->setValue('customerName', $model->prefixname.' '.$model->customer_name); // On header
$templateProcessor->setValue('telephone', $model->telephone);
$templateProcessor->setValue('home_no', $model->home->home_no); 
$templateProcessor->setValue('date_inform', ThaiDate::widget([ 'timestamp' => $model->date_inform, 'type' => ThaiDate::TYPE_MEDIUM,  'showTime' => true   ])  );
$modeldateInrance=$model->home->date_insurance;
$dateInrance= $model->home->date_insurance!=''?ThaiDate::widget([ 'timestamp' => $modeldateInrance, 'type' => ThaiDate::TYPE_MEDIUM,  'showTime' => false   ])  :'';
$templateProcessor->setValue('dateInsurance',$dateInrance ); 
 $dataModify= $model->date_modify!=''?ThaiDate::widget([ 'timestamp' => $model->date_modify, 'type' => ThaiDate::TYPE_FULL,  'showTime' => true   ]) :'';
$templateProcessor->setValue('dataModify',$dataModify );
if($model->home->date_insurance!=''){
	
	$date1 = date("Y-m-d"); 
	 $today = strtotime(date("Y-m-d"));
	  $diff = $modeldateInrance-$today;
	    $days = $diff / 60 / 60 / 24;
 	 $date1 = new DateTime(date("Y-m-d"));
	 $date2 = new DateTime(date("Y-m-d",$modeldateInrance));
	 $diff = $date1->diff($date2);
	 $dateFull=  $diff->y . " ปี, " . $diff->m." เดือน, ".$diff->d." วัน " ;
	    if($days>=0){//ยังไม่่หมุอายุ
	    	
	    	$templateProcessor->setValue('notInrance', '&#x2610;'); 
	    	$templateProcessor->setValue('Inrance', '&#x2611;'); 
	    	$templateProcessor->setValue('TextInrance', $dateFull);
	    	$templateProcessor->setValue('TextNotInrance', '');
	    }else{
	    	$templateProcessor->setValue('Inrance', '&#x2610;'); 
	    	$templateProcessor->setValue('notInrance', '&#x2611;'); 
	    	$templateProcessor->setValue('TextNotInrance', $dateFull);
	    	$templateProcessor->setValue('TextInrance', '');
	    }
}

$templateProcessor->setValue('jobCount', count($model->informJobs));

$rowV=6;
if(count($model->informJobs)>0){
	if(count($model->informJobs)>$rowV){
	$templateProcessor->cloneRow('jobList', count($model->informJobs));
	}else{
		$templateProcessor->cloneRow('jobList', $rowV);
	}
	$i=1;
	foreach ($model->informJobs as $val){
		$templateProcessor->setValue('jobList#'.$i, $val->list);
		$templateProcessor->setValue('problem#'.$i, $val->problem);
		$templateProcessor->setValue('solution#'.$i, $val->solution);
		$templateProcessor->setValue('description#'.$i, $val->description);
		$templateProcessor->setValue('s#'.$i, $i);
		$i++;
	}
	if($i<=10){
		
		for ($x = $i; $x <= $rowV; $x++) {
			$templateProcessor->setValue('jobList#'.$x, '');
			$templateProcessor->setValue('problem#'.$x, '');
			$templateProcessor->setValue('solution#'.$x, '');
			$templateProcessor->setValue('description#'.$x, '');
			$templateProcessor->setValue('s#'.$x, $x);
		}
	}

}else{

$templateProcessor->cloneRow('jobList', 8);

$templateProcessor->setValue('jobList#1', '');
$templateProcessor->setValue('jobList#2', '');
$templateProcessor->setValue('jobList#3', '');
$templateProcessor->setValue('jobList#4', '');
$templateProcessor->setValue('jobList#5', '');
$templateProcessor->setValue('jobList#6', '');
$templateProcessor->setValue('jobList#7', '');
$templateProcessor->setValue('jobList#8', '');


$templateProcessor->setValue('problem#1', '');
$templateProcessor->setValue('problem#2', '');
$templateProcessor->setValue('problem#3', '');
$templateProcessor->setValue('problem#4', '');
$templateProcessor->setValue('problem#5', '');
$templateProcessor->setValue('problem#6', '');
$templateProcessor->setValue('problem#7', '');
$templateProcessor->setValue('problem#8', '');

$templateProcessor->setValue('solution#1', '');
$templateProcessor->setValue('solution#2', '');
$templateProcessor->setValue('solution#3', '');
$templateProcessor->setValue('solution#4', '');
$templateProcessor->setValue('solution#5', '');
$templateProcessor->setValue('solution#6', '');
$templateProcessor->setValue('solution#7', '');
$templateProcessor->setValue('solution#8', '');


$templateProcessor->setValue('description#1', '');
$templateProcessor->setValue('description#2', '');
$templateProcessor->setValue('description#3', '');
$templateProcessor->setValue('description#4', '');
$templateProcessor->setValue('description#5', '');
$templateProcessor->setValue('description#6', '');
$templateProcessor->setValue('description#7', '');
$templateProcessor->setValue('description#8', '');


$templateProcessor->setValue('s#1', '1');
$templateProcessor->setValue('s#2', '2');
$templateProcessor->setValue('s#3', '3');
$templateProcessor->setValue('s#4', '4');
$templateProcessor->setValue('s#5', '5');
$templateProcessor->setValue('s#6', '6');
$templateProcessor->setValue('s#7', '7');
$templateProcessor->setValue('s#8', '8');
}
$templateProcessor->setValue('text', '&#x2611;'); // On header
$templateProcessor->setValue('text1', '&#x2610;'); // On header
$path=Yii::getAlias('@backend/web/'.$fileName);
$templateProcessor->saveAs($path);
if(!empty($dataEmail['user']) &&count($dataEmail['user'])>0){

	$subject=$_POST['subject'];
	$content=nl2br($_POST['content']);
	
	
	if(count($dataEmail['user'])>0){
		foreach ( $dataEmail['user'] as $key1 =>$val1 ){
			if($key1!=''){
			$url= Yii::$app->url->UrlEncode('inform-fix/index', ['id'=>$model->id, 'recipient_user_id'=>$key1]);
			$personnel=OrgPersonnel::findOne(['user_id'=>$key1]); 
			$url=Yii::$app->urlManagerFrontend->createAbsoluteUrl($url);
			 $content.= $personnel->prefix_name_th.' '.$personnel->firstname_th.' '.$personnel->lastname_th.' '. Html::a('คลิก รับทราบ', Url::to($url)).'<br>';
			}
		}
	}
	
	 $message =Yii::$app->mailer->compose(
	 '@common/mail/layouts/fix-home',[
	 'content'=>$content ]
	)
	->setFrom(['noreply@sirivalai.co.th'=>$model->project->name.' แจ้งซ๋อมบ้าน'])
	->setTo($dataEmail['user'])
	->setSubject('Message subject')
	->setSubject($subject)
	->attach($path)
	->send();
}


if($file==true){
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment;  filename='.$path);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($path));
flush();
readfile($path);
unlink($path);
exit();
}
?>