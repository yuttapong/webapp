<?php

namespace backend\controllers;

use doamigos\qrcode\formats\MailTo;
use dosamigos\qrcode\QrCode;

class QrCodeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionQrcode() {
        //$mailTo = new MailTo(['email' => 'email@example.com']);
        return QrCode::png("noom");
        // you could also use the following
        // return return QrCode::png($mailTo);
    }

}
