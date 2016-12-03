<?php

namespace backend\modules\crm;

/**
 * crm module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\crm\controllers';

    public $config = [];
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = "@backend/modules/crm/views/layouts/main";
        $this->config  = [
           'moduleName' => 'ระบบบริหารลูกค้า'
        ];
    }
}
