<?php

namespace backend\modules\construction;

/**
 * construction module definition class
 */
class Contruction extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\construction\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->layout = "@backend/modules/construction/views/layouts/main";
    }
}
