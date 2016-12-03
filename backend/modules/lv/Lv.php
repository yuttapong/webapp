<?php

namespace backend\modules\lv;

/**
 * lv module definition class
 */
class Lv extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\lv\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->layout = "@backend/modules/lv/views/layouts/main";
    }
}
