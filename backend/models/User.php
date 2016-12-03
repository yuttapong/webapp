<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $role_id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $access_token
 * @property string $logged_in_ip
 * @property string $logged_in_at
 * @property string $banned_reason
 */
class User extends \common\models\User
{

    public function behaviors()
    {
        return [
            [
                'class' => \maxmirazh33\image\Behavior::className(),
                'savePathAlias' => '@web/images/',
                'urlPrefix' => '/images/',
                'crop' => true,
                'attributes' => [
                    'avatar' => [
                        'savePathAlias' => '@web/images/avatars/',
                        'urlPrefix' => '/images/avatars/',
                        'width' => 120,
                        'height' => 120,
                    ],
                    'logo' => [
                        'crop' => false,
                        'thumbnails' => [
                            'mini' => [
                                'width' => 50,
                            ],
                        ],
                    ],
                ],
            ],
            //other behaviors
        ];
    }

}
