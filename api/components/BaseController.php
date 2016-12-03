<?php
/**
 *
 *
 * @author Carsten Brandt <mail@cebe.cc>
 */

namespace api\components;

use common\models\ApiSystem;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\ContentNegotiator;
use yii\filters\RateLimiter;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\Response;
use Yii;

/**
 * Base class for all API Controllers
 */
abstract class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [

                'class' => HttpBearerAuth::className(),
            ],
        ];
    }
}
