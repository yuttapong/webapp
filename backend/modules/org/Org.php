<?php

namespace backend\modules\org;

/**
 * org module definition class
 */
class Org extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\org\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->params['breadcrumbs'][] = [
            'label' => 'องค์',
            'url' => ['/org']
        ];

        // custom initialization code goes here
        $this->layout = "@backend/modules/org/views/layouts/main";


    }
}
