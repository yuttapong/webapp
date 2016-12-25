<?php

namespace backend\modules\rems;

/**
 * rems module definition class
 */
class Rems extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\rems\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
          $this->layout = "@backend/modules/rems/views/layouts/main";
    }
}
