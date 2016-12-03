<?php

namespace backend\modules\fix;

/**
 * fix module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\fix\controllers';
    public $module_id='11';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->layout = "@backend/modules/fix/views/layouts/main";
    }
}
