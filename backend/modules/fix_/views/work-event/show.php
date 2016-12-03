<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\tools\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>

<?= yii2fullcalendar\yii2fullcalendar::widget([
      'options' => [
        'lang' => 'th',
      ],
      'ajaxEvents' => Url::to(['/fix/work-event/jsoncalendar'])
    ]);
?>
