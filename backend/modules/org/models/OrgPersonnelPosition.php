<?php

namespace backend\modules\org\models;

use Yii;

/**
 * This is the model class for table "org_personnel_position".
 *
 * @property integer $_id
 * @property integer $personel_id
 * @property string $position_name
 */
class OrgPersonnelPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_personnel_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['personnel_id', 'position_name'], 'required'],
            [['personnel_id'], 'integer'],
            [['position_name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'Id',
            'personnel_id' => 'Personnel ID',
            'position_name' => 'Position Name',
        ];
    }
}
