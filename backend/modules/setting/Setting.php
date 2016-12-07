<?php
/**
 * Developed By :: Yuttapong Napikun
 * yuttaponk@gmail.com
 */

namespace backend\modules\setting;

/**
 * setting module definition class
 */
class Setting extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\setting\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->layout = "@backend/modules/setting/views/layouts/main";
    }
}
