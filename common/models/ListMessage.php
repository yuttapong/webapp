<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sys_list_apprever".
 *
 * @property integer $id
 * @property integer $document_id
 * @property string $table_name
 * @property integer $table_key
 * @property string $titie
 * @property string $option
 * @property integer $user_id
 * @property integer $user_apprever_id
 * @property string $user_apprever_name
 * @property string $link
 * @property string $description
 * @property integer $app_status
 * @property integer $status

 * @property integer $company_id
 * @property integer $site_id
 * @property string $color_code
 */
class ListMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_list_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_id','module_id', 'table_key', 'user_id', 'user_apprever_id', 'app_status', 'status', 'company_id', 'site_id'], 'integer'],
            [['titie', 'option', 'link', 'description'], 'string'],
            [['table_name'], 'string', 'max' => 100],
            [['user_apprever_name'], 'string', 'max' => 255],
            [['color_code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document_id' => 'Document ID',
            'table_name' => 'Table Name',
            'table_key' => 'Table Key',
        	'table_key2' => 'Table Key2',
            'titie' => 'Titie',
            'option' => 'Option',
            'user_id' => 'User ID',
            'user_apprever_id' => 'User Apprever ID',
            'user_apprever_name' => 'User Apprever Name',
            'link' => 'Link',
            'description' => 'Description',
            'app_status' => 'สถานะ',
            'status' => 'Status',
            'company_id' => 'Company ID',
            'site_id' => 'Site ID',
            'color_code' => 'Color Code',
        		'module_id' => 'module_id Code',
        ];
    }
    public function getDocuments()
    {
    	return $this->hasOne(SysDocument::className(), ['document_id' => 'document_id']);
    }
}
