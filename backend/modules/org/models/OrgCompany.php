<?php

namespace backend\modules\org\models;

use backend\modules\org\Org;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "org_company".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $address_full
 * @property string $contact
 * @property string $img
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class OrgCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['address_full'], 'string'],
            [['created_at', 'created_by', 'updated_at', 'updated_by','active'], 'integer'],
            [['code'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 150],
            [['contact', 'img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'ชื่อบริษัท',
            'address_full' => 'ที่อยู่',
            'contact' => 'Contact',
            'img' => 'รูปภาพ',
            'created_at' => 'สร้างเมื่อ',
            'created_by' => 'สร้างโดย',
            'updated_at' => 'แก้ไขเมื่อ',
            'updated_by' => 'แก้ไขโดย',
            'active' => 'Active',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     * @return OrgCompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgCompanyQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getOrgSites()
    {
        return $this->hasMany(OrgSite::className(), ['company_id' => 'id']);
    }

    /**
     * @return int
     */
    public function countOrgSite()
    {
        return count($this->orgSites);

    }

    public function getCompanyItems(){
        $models = OrgCompany::find()->orderBy('name')->all();
        return ArrayHelper::map($models,'id','name');
    }
}
