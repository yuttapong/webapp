<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sys_job_list".
 *
 * @property integer $id
 * @property integer $mater_id
 * @property string $name
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $status
 * @property string $table_name
 */
class JobList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_job_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mater_id', 'created_at', 'created_by', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mater_id' => 'Mater ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'status' => 'Status',
            'slug' => ' slug',
        ];
    }
    public function beforeSave($insert){
    	if (parent::beforeSave($insert)) {
    
    		if ($this->isNewRecord) {
    			$this->created_at=time();
    			$this->created_by=Yii::$app->user->id;
    		}else{
    
    		}
    		return true;
    	} else {
    		 
    		return false;
    	}
    }
}
