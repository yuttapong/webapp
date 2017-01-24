<?php

namespace backend\modules\purchase\models;

use Yii;
use common\models\Project;

/**
 * This is the model class for table "fix_poin".
 *
 * @property integer $id
 * @property string $title
 * @property integer $site_id
 * @property integer $project_id
 * @property string $code
 * @property integer $user_order_id
 * @property integer $create_at
 * @property integer $create_by
 */
class Po extends \yii\db\ActiveRecord
{
	const  CODE_TABLE_NAME = 'psm_poin'; // table_id จากตาราง sys_table
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'psm_poin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'project_id', 'user_order_id', 'created_at', 'created_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 20],
        		[['date_send'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'site_id' => 'Site ID',
            'project_id' => 'Project ID',
            'code' => 'Code',
            'user_order_id' => 'User Order ID',
        	'delivery_price'=>'delivery_price',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
        	'date_send'=> 'กำหนดส่ง',
        ];
    }
    public function getProject()
    {
    	return $this->hasOne(Project::className(), ['id' => 'project_id']);
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
