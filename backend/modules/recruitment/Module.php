<?php
/**
 * Developed By :: Yuttapong Napikun
 * yuttaponk@gmail.com
 */

namespace backend\modules\recruitment;

/**
 * recruitment module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\recruitment\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['breadcrumbs'][] = 'ระบบสรรหาบุคคลากร';
        $this->layout = "@backend/modules/recruitment/views/layouts/main";
    }
}
