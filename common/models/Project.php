<?php

namespace common\models;

use Yii;

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
            [['site_id', 'company_id', 'status', 'created_at', 'created_by'], 'integer'],
            [['type'], 'string'],
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
            'name' => 'Name',
            'site_id' => 'Site ID',
            'company_id' => 'Company ID',
            'status' => 'สถานะ',
            'type' => 'โครงการ',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
 
    public function getHome()
    {
    	return $this->hasMany(Home::className(), ['project_id' => 'id']);
    }
    public function beforeSave($insert){
    	 
    	if (parent::beforeSave($insert)) {
    		if ($this->isNewRecord) {
    			$this->created_at=time();
    			$this->created_by=Yii::$app->user->id;
    		}
    		return true;
    	} else {
    		 
    		return false;
    	}
    }
}
