<?php

namespace backend\modules\purchase\models;

use Yii;

/**
 * This is the model class for table "psm_approver_comfirm".
 *
 * @property integer $id
 * @property string $slug
 * @property integer $pk_key
 * @property integer $fk_key
 * @property integer $approver_user_id
 * @property integer $seq
 * @property string $comment
 * @property integer $approver_status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $active
 */
class ApproverComfirm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'psm_approver_comfirm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pk_key', 'fk_key', 'approver_user_id', 'seq', 'approver_status', 'created_at', 'created_by', 'active'], 'integer'],
            [['comment'], 'string'],
            [['slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'pk_key' => 'Pk Key',
            'fk_key' => 'Fk Key',
            'approver_user_id' => 'Approver User ID',
            'seq' => 'Seq',
            'comment' => 'Comment',
            'approver_status' => 'Approver Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'active' => 'Active',
        ];
    }
}
