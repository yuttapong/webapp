<?php

namespace backend\modules\report;

/**
 * report module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\report\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = "@backend/modules/report/views/layouts/main";

        // custom initialization code goes here
    }
}
