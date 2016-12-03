<?php
/**
 * Author: Yuttapong Napikun
 * Date: 4/6/2559
 * Time: 13:28
 */

namespace common\siricenter\nav;

use yii\bootstrap\Widget;

class NavHome extends Widget
{
    public $heading;
    public $items;


    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->getModule();
    }


    public function getModule()
    {
        return $this->render("module", [
            'items' => $this->items,
            'heading' => $this->heading ? $this->heading : '',
        ]);
    }

    public function getNavehome()
    {
        return $this->render("nav-home", [
            'items' => $this->items,
            'heading' => $this->heading ? $this->heading : '',
        ]);
    }

}