<?php

namespace common\models;

use backend\modules\org\models\OrgCompany;
use backend\modules\org\models\OrgSite;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sys_project".
 *
 * @property integer $id
 * @property string $name
 * @property integer $site_id
 * @property integer $company_id
 * @property integer $status
 * @property string $type
 * @property integer $created_at
 * @property integer $created_by
 */
class Project extends \yii\db\ActiveRecord
{


    /**
     * Status of project
     */
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    const STATUS_DELETED = 'DELETED';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'site_id', 'company_id', 'status'], 'required'],
            [['site_id', 'company_id', 'created_at', 'created_by'], 'integer'],
            [['type', 'status'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Project',
            'site_id' => 'Site',
            'company_id' => 'Company',
            'status' => 'Status',
            'type' => 'ประเภทโครงการ',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    // get the homes in this project
    public function getHomes()
    {
        return $this->hasMany(Home::className(), ['project_id' => 'id']);
    }

    // this method is the same above method getHomes(), but he name getHome() 
    public function getHome()
    {
        return $this->hasMany(Home::className(), ['project_id' => 'id']);
    }


    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->created_by = Yii::$app->user->id;
            }
            return true;
        } else {
            return false;
        }
    }

    public function getSite()
    {
        return $this->hasOne(OrgSite::className(), ['site_id' => 'site_id']);
    }


    public function getCompany()
    {
        return $this->hasOne(OrgCompany::className(), ['id' => 'company_id']);
    }

    public function getCompanyItems()
    {
        $companies = OrgCompany::find()->all();
        return ArrayHelper::map($companies, 'id', 'name');
    }

    public function getSiteItems()
    {
        $sites = OrgSite::find()->all();
        return ArrayHelper::map($sites, 'site_id', 'site_name');
    }

    public function getStatusItems()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_DELETED => 'Deleted',
        ];
    }

}
