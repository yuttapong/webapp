<?php
/**
 * Created by PhpStorm.
 * User: Yuttapong
 * Date: 14/7/2559
 * Time: 11:55
 */
use kartik\helpers\Html;
$countApprover = count($listApprove);
if ($countApprover > 0) {
     $j = 0;
    foreach ($listApprove as $seq => $list) {
        echo Html::beginTag('div', ['class' => "col-xs-6  col-sm-4 col-md-4 "]);
        echo Html::beginTag('div', ['align' => 'center','class'=>'']);
        if ($list['active'] == 1) {
            $signature = Html::img('/images/signature.png', [
                'alt' => $list['fullname'],
                'class' => 'imag img-resonsive'
            ]);
        } elseif($list['active'] == 0) {
            $signature =  '..................'.$list['user_code'].'.....................';
        }
        $date = $list['approve_date']?$list['approve_date']:'';
        echo $signature;
        echo Html::tag('div', "<small>({$list['fullname']})<br>{$list['position']}<br><span class=''>{$date}</span></small>");
        echo '<br>';
        echo Html::endTag('div');
        echo Html::endTag('div');
    }
    $j++;
}