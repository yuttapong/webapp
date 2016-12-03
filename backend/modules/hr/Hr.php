<?php

namespace backend\modules\hr;

/**
 * hr module definition class
 */
class Hr extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\hr\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->layout = "@backend/modules/hr/views/layouts/main";
    }
}
