<?php

namespace backend\modules\inventory;

/**
 * inventory module definition class
 */
class Inventory extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\inventory\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = "@backend/modules/inventory/views/layouts/main";
    }
}
