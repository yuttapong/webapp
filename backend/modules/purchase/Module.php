<?php

namespace backend\modules\purchase;

/**
 * purchase module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\purchase\controllers';
    public  $module_name = 'fix';
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = "@backend/modules/purchase/views/layouts/main";
        // custom initialization code goes here
    }
}
