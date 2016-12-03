<?php

namespace backend\modules\document\models;

use Yii;
use karpoff\icrop\CropImageUploadBehavior;

/**
 * This is the model class for table "documents".
 *
 * @property integer $id
 * @property string $photo
 * @property string $file
 */
class Document extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            ['photo', 'file', 'extensions' => 'jpeg, gif, png', 'on' => ['insert', 'update']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo' => 'Photo',
            'file' => 'File',
        ];
    }

    /**
     * @inheritdoc
     * @return DocumentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocumentsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    function behaviors()
    {
        return [
            [
                'class' => CropImageUploadBehavior::className(),
                'attribute' => 'photo',
                'scenarios' => ['insert', 'update'],
                'path' => '@webroot/upload/docs',
                'url' => '@web/upload/docs',
                'ratio' => 1,
                'crop_field' => 'photo_crop',
                'cropped_field' => 'photo_cropped',
            ],
        ];
    }


}
