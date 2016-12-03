<?php

namespace backend\modules\fix\models;

use Yii;

/**
 * This is the model class for table "fix_inform_job".
 *
 * @property integer $id
 * @property integer $inform_fix_id
 * @property string $list
 * @property string $description
 * @property integer $status
 * @property integer $job_list_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $responsible_id
 * @property string $responsible_name
 * @property integer $job_status
 * @property string $pate_price
 * @property string $net_price
 * @property integer $apprever_type
 */
class InformJob extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	const  CODE_TABLE_NAME = 'fix_inform_job'; // table_id จากตาราง sys_table
    public static function tableName()
    {
        return 'fix_inform_job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'inform_fix_id','list'], 'required'],
        	[['list'], 'unique'],
            [['id', 'inform_fix_id', 'status', 'created_at', 'created_by', 'responsible_id', 'job_status', 'apprever_type'], 'integer'],
            [['description'], 'string'],
            [['pate_price', 'net_price'], 'number'],
            [['list', 'responsible_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inform_fix_id' => 'Inform Fix ID',
            'list' => 'รายการ',
            'description' => 'รายละเอียด',
            'status' => 'สถานะ',
            'job_list_id' => 'Job List ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'responsible_id' => 'ผู้รับผิดช่อบ',
            'responsible_name' => 'ผู้รับผิดชอบ',
            'job_status' => 'Job Status',
            'pate_price' => 'Pate Price',
            'net_price' => 'Net Price',
            'apprever_type' => 'Apprever Type',
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformFix()
    {
    	return $this->hasOne(InformFix::className(), ['id' => 'inform_fix_id']);
    }
    public function getMaterial()
    {
    	return $this->hasMany(InformMaterial::className(), ['inform_job_id' => 'id']);
    }
    
}
