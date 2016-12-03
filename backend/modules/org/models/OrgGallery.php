<?php

namespace backend\modules\org\models;

use Yii;

/**
 * This is the model class for table "org_gallery".
 *
 * @property integer $_id
 * @property integer $user_id
 * @property string $img
 * @property integer $sorter
 */
class OrgGallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'img'], 'required'],
            [['user_id', 'sorter','is_deleted'], 'integer'],
            [['img'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'Id',
            'user_id' => 'User ID',
            'img' => 'Img',
            'sorter' => 'Sorter',
        ];
    }
}
