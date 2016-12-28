   <?php
use yii\helpers\Html;
   ?>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <?php if (!Yii::$app->user->isGuest) : ?>
                <ul class="nav navbar-nav">
                    <li class=""> <a href="<?=Yii::$app->urlManagerFrontend->baseUrl?>"><i class="fa fa-windows"></i> Website</a></li>
                    <li class="dropdown notifications-menu">
                        <a href="#"  class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-windows"></i> App</a>
                        <ul class="dropdown-menu">
                            <li class="header">Application</li>
                            <li>
                                <ul class="menu">
                            <?php
                            foreach ($appmenu as $moduleId => $item):
                                echo Html::tag('li', Html::a('<i class="fa fa-desktop fa-2x"></i><span style="margin-left:15px">'. $item['label'].'</span>', [$item['url']],[
                                    'title' => $item['name_th']
                                ]));
                                echo Html::tag('li',null,['class'=>'divider']);
                                ?>
                            <?php endforeach; ?>
                                    </ul>
                            </li>
                        </ul>
                    </li>
                    <li  class="hidden"><a href="<?= Yii::$app->urlManagerFrontend->baseUrl ?>"><i class="fa fa-windows"></i>
                            เว็บไซต์บริษัท</a></li>
                    <!-- Messages: style can be found in dropdown.less-->

                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg"
                                                     class="img-circle"
                                                     alt="User Image"/>
                                            </div>
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="<?= $directoryAsset ?>/img/user3-128x128.jpg"
                                                     class="img-circle"
                                                     alt="user image"/>
                                            </div>
                                            <h4>
                                                AdminLTE Design Team
                                                <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="<?= $directoryAsset ?>/img/user4-128x128.jpg"
                                                     class="img-circle"
                                                     alt="user image"/>
                                            </div>
                                            <h4>
                                                Developers
                                                <small><i class="fa fa-clock-o"></i> Today</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="<?= $directoryAsset ?>/img/user3-128x128.jpg"
                                                     class="img-circle"
                                                     alt="user image"/>
                                            </div>
                                            <h4>
                                                Sales Department
                                                <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="<?= $directoryAsset ?>/img/user4-128x128.jpg"
                                                     class="img-circle"
                                                     alt="user image"/>
                                            </div>
                                            <h4>
                                                Reviewers
                                                <small><i class="fa fa-clock-o"></i> 2 days</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
             
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <?php
                            if ($totalNewMessage > 0):
                                ?>
                                <span class="label label-danger"><?= $totalNewMessage ?></span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">คุณมี <span
                                    class="slabel label-dangers"><?= $totalNewMessage ?></span> รายการอนุมัติ
                            </li>
                            <li>
                                <?php
                                if ($newMessages) {
                                    echo ' <ul class="menu">';
                                    foreach ($newMessages as $message) {
                                        if ($message['countNew'] > 0) {
                                            echo '<li>';
                                            echo '<a href="' . Yii::$app->urlManager->baseUrl . '' . $message['url_message'] . '"><span class="badge badge-red">' . $message['countNew'] . '</span> ' . $message['document'];
                                            echo '</a>';
                                            echo '</li>';
                                        }
                                    }
                                    echo '</ul>';
                                }
                                ?>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu hidden">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 ใบสั่งซื้อ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-warning text-yellow"></i> 3 ใบขอซื้อ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-red"></i> 5 new members joined
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-user text-red"></i> You changed your username
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer hidden"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks: style can be found in dropdown.less -->
                    <li class="dropdown tasks-menu hidden">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Create a nice theme
                                                <small class="pull-right">40%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-green" style="width: 40%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">40% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Some task I need to do
                                                <small class="pull-right">60%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-red" style="width: 60%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Make beautiful transitions
                                                <small class="pull-right">80%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-yellow" style="width: 80%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">80% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>

                    <!-- User Account: style can be found in dropdown.less -->
                    <?php
                    if (!Yii::$app->user->isGuest):
                        $userId = Yii::$app->user->id;
                        $user = \common\models\User::findIdentity($userId);
                        ?>
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= $user->personnel->photoThumbnailLink ?>" class="user-image"
                                     alt="User Image"/>
                                <span
                                    class="hidden-xs"><?= ($user->personnel) ? $user->personnel->fullnameTH : $user->username ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($user): ?>
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?= $user->personnel->photoThumbnailLink ?>" class="img-circle"
                                             alt="User Image"/>

                                        <p>
                                            รหัสพนักงาน : <?= @$user->personnel->code ?>
                                            <small>
                                                <?= @$user->personnel->prefix_name_th ?>
                                                <?= @$user->personnel->fullnameTH ?>
                                            </small>
                                        </p>
                                    </li>
                                <?php endif; ?>
                                <!-- Menu Body -->
                                <li class="user-body hidden">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?= Yii::$app->urlManager->baseUrl ?>/profile"
                                           class="btn btn-default btn-flat"><i class="fa fa-user"></i> โปรไฟล์</a>
                                    </div>
                                    <div class="pull-right">
                                        <?= Html::a(
                                            '<i class="fa fa-lock"></i> ออกจากระบบ',
                                            ['/site/logout'],
                                            ['data-method' => 'post', 'class' => 'btn btn-danger btn-flat']
                                        ) ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="hidden">
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>

            <?php endif; ?>
        </div>
    </nav>