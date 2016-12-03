<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 7/6/2559
 * Time: 11:15
 */

use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use kartik\helpers\Html;
use yii\bootstrap\Nav;
use frontend\modules\recruitment\models\LoginResumeForm;
use kartik\icons\Icon;

$session = new LoginResumeForm();
?>
<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>

<div class="col-md-3">

    <?php
    if($session->isLoggedIn()){
        echo  Html::tag('p', "เลขที่ใบสมัคร: ". Html::badge($session->getSession()));
    }

    $items =  [
        [
            'label' => 'ตำแหน่งงานที่เปิดรับสม้คร',
            'url' => ['position/index'],
        ],
        [
            'label' => 'ขั้นตอนการรับสมัคร',
            'url' => ['default/index'],
        ],
        [
            'label' => 'ใบสมัคร',
            'url' => ['resume/list'],
            // 'visible' =>  $isLogin,
        ],
        [
            'label' => 'ใบสมัครของฉัน',
            'url' => ['resume/myresume'],
             'visible' =>  $session->isLoggedIn(),
        ],
        [
            'label' => 'เข้าสู่ระบบแบบสอบถาม',
            'url' => ['resume/login-user'],
            'visible' => ! $session->isLoggedIn(),
        ],
        [
            'label' => 'ออกจากระบบ',
            'url' => ['resume/logout-user'],
            'visible' =>  $session->isLoggedIn(),
        ]
    ];
    echo kartik\sidenav\SideNav::widget([
        'items' => $items,
    ]);
     Nav::widget([
        'items' => $items,
        'options' => ['class' =>'nav nav-tab'], // set this to nav-tab to get tab-styled navigation
    ]);
    ?>

</div>
<div class="col-md-9">
    <div class="pull-right">
        <?php
        echo Nav::widget([
            'encodeLabels' => false,
            'activateItems' => false,
            'items' => [
                [
                    'label' => Icon::show('file-text') .  ' ใบสมัครของฉัน',
                    'url' => ['resume/myresume'],
                    'linkOptions' => [],
                    'visible' => $session->isLoggedIn()
                ],
                [
                    'label' => 'Dropdown',
                    'items' => [
                        ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                        '<li class="divider"></li>',
                        '<li class="dropdown-header">Dropdown Header</li>',
                        ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
                    ],
                    'visible' => $session->isLoggedIn()
                ],
                [
                    'label' => Icon::show('key'). ' เข้าสู่ระบบ',
                    'url' => ['resume/login-user'],
                    'visible' => ! $session->isLoggedIn()
                ],
                [
                    'label' => Icon::show('lock').' ออกจากระบบ',
                    'url' => ['resume/logout-user'],
                    'visible' => $session->isLoggedIn()
                ],
            ],
            'options' => ['class' =>'nav-pills'], // set this to nav-tab to get tab-styled navigation
        ]);
        ?>
    </div>
    <div class="clearfix"></div>

    <?=$content?>
</div>

<br>
<?php $this->endContent(); ?>