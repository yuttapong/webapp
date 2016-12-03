<?php

namespace backend\modules\org\models;

use Yii;

/**
 * This is the model class for table "org_settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $label
 * @property string $description
 */
class OrgSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['value', 'description'], 'string'],
            [['name'], 'string', 'max' => 60],
            [['label'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'label' => 'Label',
            'description' => 'Description',
        ];
    }
}
