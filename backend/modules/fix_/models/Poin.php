<?php

namespace backend\modules\fix\models;

use Yii;

/**
 * This is the model class for table "fix_poin".
 *
 * @property integer $id
 * @property string $title
 * @property integer $site_id
 * @property integer $project_id
 * @property string $code
 * @property integer $user_order_id
 * @property integer $create_at
 * @property integer $create_by
 */
class Poin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_poin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'project_id', 'user_order_id', 'create_at', 'create_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'site_id' => 'Site ID',
            'project_id' => 'Project ID',
            'code' => 'Code',
            'user_order_id' => 'User Order ID',
        	'delivery_price'=>'delivery_price',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
        ];
    }
}
