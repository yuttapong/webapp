<?php

/* @var $this yii\web\View */

use app\models\SysModule;
use yii\bootstrap\Html;
use kartik\icons\Icon;
use yii\bootstrap\Carousel;

// Initialize framework as per <code>icon-framework</code> param in Yii config
Icon::map($this);

$this->title = 'Siricenter App';
?>
<div class="site-index">
    <div class="row">
        <?php
        echo Carousel::widget([
            'items' => [
                [
                    'caption' => '<h4>Promotion Text</h4><button class="btn btn-default">ลงทะเบียนรับสิทธิ์</button>',
                    'content' => '<img src="http://www.sirivalai.com/images/slide/main1.jpg"/>',
                ],
                [
                    'content' => '<img src="http://www.sirivalai.com/images/slide/main2.jpg"/>',
                ],
                [
                    'content' => '<img src="http://www.sirivalai.com/images/slide/main3.jpg"/>',
                ],


                //  '<img src="http://beehivestartups.com/media/blogimages/2014/09/18/backoffice_black_png.png.900x400_q85_crop.png"/>',

            ]
        ]);
        ?>
    </div>


    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-sm-3"><br><i class="fa fa-heart fa-5x"></i></div>
                    <div class="col-sm-9">
                        <h2> With Love</h2>
                        ทุกโครงการของ สิริวลัย สร้างด้วยความรัก
                        เพื่อให้บ้านทุกหลังเป็นที่อยู่อาศัยที่ดีที่สุดของทุกครอบครัว
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-sm-3"><br><i class="fa fa-facebook-square fa-5x"></i></div>
                    <div class="col-sm-9">
                        <h2>Good Social</h2>
                        เราสร้างสังคมที่ดี เพื่อให้บ้าน เป็นสังคมที่น่าอยู่ มีเพื่อนบ้านที่น่ารัก
                        และบริการทุกครอบครัวอย่างเท่าเทียมและเป็นกันเอง
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-sm-3"><br><i class="fa fa-desktop fa-5x"></i></div>
                    <div class="col-sm-9">
                        <h2>Best Design</h2>
                        บ้านทุกหลังออกแบบให้ร่วมสมัย และสาธรณูปโภคที่ครบครัน เพื่อให้บ้านเป็นบ้านที่มีความอบอุ่น
                        และสูขสบายแก่ผู้พักอาศัย
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="body-content hidden">
        <div class="row">
            <div class="col-lg-4">
                <h2><i class="fa fa-book"></i> ข่าวสาร</h2>
                <ul>
                    <li>ขณะนี้ระบบใช้งานได้แต่ระบบบริหารข้อมูลค้า หรือ (CRM)</li>
                    <li>ปัจจุบันกำลังพัฒนาระบบงานอื่น ๆ อยู่</li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h2>ดาวน์โหลดแบบฟอร์มต่าง ๆ</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                    dolore eu
                    fugiat nulla pariatur.</p>
            </div>
            <div class="col-lg-4">
                <h2>คู่มือถือการใช้งาน</h2>
                <ul>
                    <li>ระบบบริหางานบุคคล</li>
                    <li>ระบบใบลางานและสลับวันหยุด</li>
                    <li>ระบบ PR ทั่วไป</li>
                    <li>ระบบแจ้งปัญญาการใช้งาน</li>
                    <li>ระบบบริหารงานก่อสร้าง</li>
                    <li>ระบบบริหารงานขาย</li>
                </ul>
            </div>
        </div>

    </div>


</div>
