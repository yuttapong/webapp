<?php
/**
 * Created by PhpStorm.
 * User: Yuttapong Napikun
 * Date: 7/9/2559
 * Time: 1:24
 */
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

?>

<?php
NavBar::begin([
    'brandLabel' => '<strong>ระบบแจ้งซ่อม</strong>',
    'brandUrl' => Yii::$app->urlManager->baseUrl.'/fix',
]);

$items= [ 
		
		['label' => '<i class="fa fa-table fa-2x"></i> ตารางงาน', 'url' => ['work-event/index']],
		['label' => '<i class="fa fa-calendar fa-2x"></i> ปฏิทินงาน', 'url' => ['work-event/show']],
		['label' => '<i class="fa fa-bullhorn  fa-2x"></i> แจ้งซ้อมบ้าน', 'url' => ['inform-fix/index']],
		['label' => '<i class="fa fa-book fa-2x"></i> เอกสาร', 'url' => ['send-documents/index']],
		//['label' => '<i class="fa fa-home fa-2x"></i> แปลงบ้าน', 'url' => ['home/index']],
		['label' => '<i class="fa fa-book fa-1x"></i>แปลงบ้าน', 'url' => ['home/index']],
    	
   	 ];
$items[]=['label' => '<i class="fa fa-list  fa-1x"></i>รายการงาน', 'url' => ['inform-job/index']];
if(Yii::$app->user->id=='133'){
	$items[]=['label' => '<i class="fa fa-book fa-1x"></i>รายการ  po', 'url' => ['poin/index']];
	$items[]=['label' => '<i class="fa fa-book fa-1x"></i>รายการ pr', 'url' => ['prin/index']];
	$items[]=['label' => '<i class="fa fa-book fa-1x"></i>pr to po', 'url' => ['prin/pr-to-po']];
	$items[]=['label' => '<i class="fa fa-book fa-1x"></i> อนุมัติแจ้งซ่อม', 'url' => ['list-apprever/index']];
		
		
		//['label' => '<i class="fa fa-book fa-1x"></i>รับวัสดุ', 'url' => ['inform-fix/index']],
    	//['label' => '<i class="fa fa-book fa-1x"></i>เบิกวัสดุ', 'url' => ['inform-fix/index']],

}
echo Nav::widget([
    'encodeLabels' => false,
    'items' =>$items,
    'options' => ['class' => 'navbar-nav'],
]);
NavBar::end();
?>
