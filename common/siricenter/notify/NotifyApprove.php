<?php
/**
 * Author: Yuttapong Napikun
 * Date: 4/6/2559
 * Time: 13:28
 */

namespace common\siricenter\notify;


use common\models\SysModule;
use yii\bootstrap\Widget;
use yii\bootstrap\Html;

class NotifyApprove extends Widget
{
    /**
     * panel title if choose $type='panel'
     */
    public $heading;
    public $items = [];
    public $type = 'panel';
    public $list = [];

    /**
     * color of background (red,blue,green)
     */
    public $color = 'red';

    public function init()
    {
        parent::init();
        $model = SysModule::find()->all();
        foreach ($model as $m) {
            $this->list[] = [
                'label' => $m->name_th,
                'url' => '',
                'count' => 3,
                'icon' => $m->img,
            ];
        }
        /*
        $this->items = [
            [
                'label' => 'PR',
                'url' => '',
                'count' => 3,
                'color' => 'red',
            ],
            [
                'label' => 'ใบลา',
                'url' => '',
                'count' => 3,
                'color' => 'red',
            ],
            [
                'label' => 'ระบบสลับวันหยุด',
                'url' => '',
                'count' => 3,
                'color' => 'red',
            ],
            [
                'label' => 'เช็ค',
                'url' => '',
                'count' => 3,
                'color' => 'red',
            ],
        ];
        */
    }

    public function run()
    {
        return $this->render("notify-approve", [
            'heading' => $this->heading ? $this->heading : '',
            'items' => $this->list,
            'type' => $this->type,
            'color' => $this->color,
        ]);
    }

}