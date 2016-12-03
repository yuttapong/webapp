<?php

namespace backend\controllers;

use bubasuma\simplechat\controllers\ControllerTrait;

class MessageController extends \yii\web\Controller
{
    /**
     * @return string
     */
    public function getMessageClass()
    {
        return Message::className();
    }

    /**
     * @return string
     */
    public function getConversationClass()
    {
        return Conversation::className();
    }
}
