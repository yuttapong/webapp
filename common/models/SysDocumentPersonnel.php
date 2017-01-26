<?php

namespace common\models;

use Yii;
use backend\modules\org\models\OrgPersonnel;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "sys_document_personnel".
 *
 * @property integer $id
 * @property integer $document_position_id
 * @property integer $document_id
 * @property integer $position_id
 * @property string $position_name
 * @property integer $site_id
 * @property integer $user_id
 * @property integer $personnel_id
 * @property string $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property string $note
 */
class SysDocumentPersonnel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_document_personnel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_position_id', 'document_id', 'position_id', 'site_id', 'user_id', 'personnel_id', 'status', 'created_at', 'created_by'], 'integer'],
            [['type'], 'required'],
            [['type', 'note'], 'string'],
            [['position_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document_position_id' => 'Document Position ID',
            'document_id' => 'Document ID',
            'position_id' => 'Position ID',
            'position_name' => 'Position Name',
            'site_id' => 'Site ID',
            'user_id' => 'User ID',
            'personnel_id' => 'Personnel ID',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'note' => 'Note',
        ];
    }
    public function getPersonnel()
    {
    	return $this->hasOne(OrgPersonnel::className(), ['user_id' => 'created_by']);
    }
    public function getPersonnelList(){
    	$model = OrgPersonnel::find()->orderBy('firstname_th')->all();
    	return ArrayHelper::map($model,'id','firstname_th');
    }
  
}
