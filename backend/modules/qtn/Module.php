<?php

namespace backend\modules\qtn;

/**
 * qtn module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\qtn\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = "@backend/modules/qtn/views/layouts/main";

        // custom initialization code goes here
    }
}
