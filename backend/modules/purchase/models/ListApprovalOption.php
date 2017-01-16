<?php

namespace backend\modules\purchase\models;

use Yii;

/**
 * This is the model class for table "psm_list_approval_option".
 *
 * @property integer $id
 * @property integer $list_approval_id
 * @property string $slug
 * @property integer $pk_key
 * @property integer $created_at
 * @property integer $created_by
 */
class ListApprovalOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'psm_list_approval_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['list_approval_id', 'pk_key', 'created_at', 'created_by'], 'integer'],
            [['slug'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'list_approval_id' => 'List Approval ID',
            'slug' => 'Slug',
            'pk_key' => 'Pk Key',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
