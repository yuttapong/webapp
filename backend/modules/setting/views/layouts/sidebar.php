<?php
use common\models\SysMenu;

$items = [
    ['label' => 'Dashboard - ภาพรวม', 'icon' => 'fa fa-dashboard', 'url' => ['/setting/default']],
    // General Setting
    ['label' => 'General - ทั่วไป', 'options' => ['class' => 'headers'],
        'labelEncode' => false,
        'items' => [
            ['label' => 'Module - โมดูล', 'icon' => 'fa fa-file-code-o', 'url' => ['/setting/sys-module']],
            ['label' => 'Laguage - ภาษา', 'icon'=>'fa fa-home', 'url' => ['/setting/language/index']],
            ['label' => 'Currency - อัตราแลกเปลี่ยน', 'icon' => 'fa fa-home', 'url' =>['/setting/currency/index']],
            ['label' => 'Data - ชุดข้อมูลพื้นฐาน', 'icon' => 'fa fa-dashboard', 'url' => ['/setting/sys-table']],
        ]
    ],
    // การอนุมัติ
    ['label' => 'Approval - การอนุมัติ', 'options' => ['class' => ''],
        'icon' => 'fa fa-dashboard',
        'items' => [
            ['label' => 'ผู้มีสิทธิ์อนุมัติ', 'icon' => 'fa fa-user', 'url' => ['/setting/approve/user']],
            ['label' => 'ตั้งการการรูปแบบอนุมัติ', 'icon' => 'fa fa-user', 'url' => ['/setting/approve/index']],
            ['label' => 'รูปแบบ', 'icon' => 'fa fa-user', 'url' => ['/setting/approve/format']],
        ]
    ],
    // ผู้ใช้งาน
    ['label' => 'ผู้ใช้งาน', 'options' => ['class' => 'headers'],
        'items' => [
            ['label' => 'User', 'icon' => 'fa fa-user', 'url' => ['/setting/role']],
            ['label' => 'พนักงาน', 'icon' => 'fa fa-user', 'url' => ['/setting/personnel']],
            ['label' => 'Permission', 'icon' => 'fa fa-user', 'url' => ['/admin']],
        ]
    ],
    // Basic Data
    ['label' => 'ข้ลมูลพื้น', 'options' => ['class' => 'headers'],
        'labelEncode' => false,
        'items' => [
            ['label' => 'Company', 'icon'=>'fa fa-home', 'url' => ['/setting/company/index']],
            ['label' => 'Project', 'icon' => 'fa fa-home', 'url' =>['/setting/project/index']],
            ['label' => 'Project Unit', 'icon'=>'fa fa-home', 'url' => ['/setting/home-unit/index']],
            ['label' => 'ภาค', 'icon' => 'fa fa-dashboard', 'url' => ['/setting/geo-graphy']],
            ['label' => 'จังหวัด', 'icon' => 'fa fa-dashboard', 'url' => ['/setting/province']],
            ['label' => 'อำเภอ', 'icon' => 'fa fa-dashboard', 'url' => ['/setting/amphur']],
            ['label' => 'ตำบล', 'icon' => 'fa fa-dashboard', 'url' => ['/setting/tambon']],
        ]
    ],
    //Email
    ['label' => 'Email', 'options' => ['class' => 'headers'],
        'labelEncode' => false,
        'items' => [
            ['label' => 'SMTP', 'icon'=>'fa fa-book', 'url' => ['/setting/email/smtp']],
        ]
    ],

    // Report
    ['label' => 'Report', 'options' => ['class' => 'headers'],
        'labelEncode' => false,
        'items' => [
            ['label' => 'บ้าน', 'icon'=>'fa fa-home', 'url' => ['/setting/homeplan']],
        ]
    ],
    // Log
    ['label' => 'Log System', 'options' => ['class' => 'headers'],
        'labelEncode' => false,
        'items' => [

        ]
    ],
];


?>

<?php echo  dmstr\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu'],
    'items' => $items
    /*
    'items' => [
        ['label' => 'ข้อมูลพื้นฐาน', 'options' => ['class' => 'header']],
        ['label' => 'บริษัท', 'icon' => 'fa fa-file-code-o', 'url' => ['/org/company']],
        ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
        //
        ['label' => 'งานบุคคล', 'options' => ['class' => 'header']],
        ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
        //
        ['label' => 'รายงาน', 'options' => ['class' => 'header']],
        ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
    ]
    */
]);
?>
<?php
 \kartik\sidenav\SideNav::widget([
    'items' => $items,
])
?>
