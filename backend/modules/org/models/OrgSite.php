<?php

namespace backend\modules\org\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "org_site".
 *
 * @property integer $site_id
 * @property string $site_name
 * @property string $site_description
 * @property integer $company_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class OrgSite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_name', 'company_id','site_type'], 'required'],
            [['site_description','site_type'], 'string'],
            [['company_id', 'created_at', 'created_by', 'updated_at', 'updated_by','active'], 'integer'],
            [['site_name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'site_id' => 'ID',
            'site_type' => 'ประเภทไซค์งาน',
            'site_name' => 'ชื่อ',
            'site_description' => 'รายละเอียด',
            'company_id' => 'บริษัท',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'active' => 'Active',
        ];
    }

    /**
     * @inheritdoc
     * @return OrgSiteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgSiteQuery(get_called_class());
    }


    public function getSiteusers(){
        return $this->hasMany(OrgSiteUser::className(),'site_id','site_id');
    }


    public function getCompany(){
        return $this->hasOne(OrgCompany::className(),['id'=>'company_id']);
    }

    public function getArrayCompany(){
        $model = OrgCompany::find()->all();
        return ArrayHelper::map($model,'id','name');
    }
    public function getArraySite(){
        $datas = OrgSite::find()->all();
        return ArrayHelper::map($datas,'site_id','site_name');
    }
}
