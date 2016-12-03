<?php

namespace backend\modules\org\models;

use Yii;

/**
 * This is the model class for table "org_benefits".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class OrgBenefits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_benefits';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description' ], 'string'],
            [['created_at', 'created_by', 'updated_at', 'updated_by','status'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'สวัสดิการ'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @inheritdoc
     * @return OrgBenefitsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgBenefitsQuery(get_called_class());
    }
}
