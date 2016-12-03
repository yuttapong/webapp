<?php

namespace backend\modules\org\models;

use Yii;

/**
 * This is the model class for table "org_site_user".
 *
 * @property integer $_id
 * @property integer $site_id
 * @property integer $user_code
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $created_by
 */
class OrgSiteUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_site_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'user_id'], 'required'],
            [['site_id', 'user_code', 'user_id', 'created_at', 'created_by'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'Id',
            'site_id' => 'Site ID',
            'user_code' => 'User Code',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @inheritdoc
     * @return OrgSiteUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgSiteUserQuery(get_called_class());
    }

    public function getSitename(){
        $model =  OrgSite::findOne($this->site_id);
        return $model->site_name;
    }
}
