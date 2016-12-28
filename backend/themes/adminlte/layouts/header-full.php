<?php
use yii\helpers\Html;
use common\models\SysDocument;

$newMessages = SysDocument::countNewDocument();
$totalNewMessage = SysDocument::CountTotalNewDocument();
$appmenu = \common\models\SysModule::getItemModuleForButtonApp();

/* @var $this \yii\web\View */
/* @var $content string */
?>
<header class="main-header">
    <?= Html::a('
<span class="logo-mini">APP</span>
<span class="logo-lg">' . Yii::$app->name . '</span>',Yii::$app->homeUrl, ['class' => 'logo']) ?>
<?php echo $this->render('partial/navbar',[
      'appmenu' =>$appmenu,
      'directoryAsset'=>$directoryAsset,
      'totalNewMessage' => $totalNewMessage,
      'newMessages' => $newMessages
      ]);
?>
</header>

    <?php
    if( isset($this->blocks['navbar'])){
        echo $this->blocks['navbar'];
    }
    ?>
