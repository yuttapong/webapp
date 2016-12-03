<?php

namespace backend\modules\org\models;

use Yii;

/**
 * This is the model class for table "org_structure_item".
 *
 * @property integer $_id
 * @property integer $company_id
 * @property integer $user_id
 * @property integer $user_code
 * @property integer $parent_id
 * @property string $first_name
 * @property integer $hide
 * @property integer $position_id
 * @property integer $level
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class OrgStructureItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_structure_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'user_id', 'user_code', 'parent_id', 'hide', 'created_at', 'created_by'], 'required'],
            [['company_id', 'user_id', 'user_code', 'parent_id', 'hide', 'position_id', 'level', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['first_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'company_id' => 'Company ID',
            'user_id' => 'User ID',
            'user_code' => 'User Code',
            'parent_id' => 'Parent ID',
            'first_name' => 'First Name',
            'hide' => 'Hide',
            'position_id' => 'Position ID',
            'level' => 'Level',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     * @return OrgStructureItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgStructureItemQuery(get_called_class());
    }

    public function getPersonnel(){
        return $this->hasOne(OrgPersonnel::className(),['id'=>'user_id']);
    }
}
