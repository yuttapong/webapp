<?php

/* @var $this yii\web\View */

use app\models\SysModule;
use yii\bootstrap\Html;
use kartik\icons\Icon;
use common\siricenter\thaiformatter\ThaiDate;

// Initialize framework as per <code>icon-framework</code> param in Yii config
// Icon::map($this);


$this->title = null;
?>
<div class="site-index">
    <div class="row">
        <div class="xs-12 col-sm-6 col-md-4">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">ข่าวประชาสัมพันธ์</div>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                    </ul>
                </div>

            </div>

        </div>
        <div class="xs-12 col-sm-6 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">ข่าวประชาสัมพันธ์</div>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                        <li  class=""><i class="fa fa-bullhorn"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit</li>
                    </ul>
                </div>

            </div>
            </div>
        <div class="xs-12 col-sm-12 col-md-4">
            <?php
            echo \common\siricenter\nav\NavHome::widget([
                'items' => $module_category
            ]); ?>
        </div>
    </div>
</div>

<hr>

<div class="body-content">
    <div class="row">
        <div class="col-lg-4">
            <h2>ขั้นตอนการอนุมัติ</h2>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                fugiat nulla pariatur.</p>

            <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
        </div>
        <div class="col-lg-4">
            <h2>ดาวน์โหลดแบบฟอร์มต่าง ๆ</h2>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                fugiat nulla pariatur.</p>

            <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
        </div>
        <div class="col-lg-4">
            <h2>คู่มือถือการใช้งาน</h2>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                fugiat nulla pariatur.</p>

            <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
        </div>
    </div>

</div>


</div>
