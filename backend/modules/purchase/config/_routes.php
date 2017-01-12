<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 12/1/2560
 * Time: 13:42
 */
return [
    '/purchase/category/<id:\d+>'  => '/sales/index/index',
    '/sales/company'                    => '/sales/company/index',
    '/sales/company/view/<sID:\d+>'     => '/sales/company/view',
    '/sales/company/update/<sID:\d+>'   => '/sales/company/update',
    '/sales/company/delete/<sID:\d+>'   => '/sales/company/delete',
];