<?php

namespace backend\modules\document;

/**
 * document module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\document\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = "@backend/modules/document/views/layouts/main";

        // custom initialization code goes here
    }


}
