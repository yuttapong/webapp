<?php

namespace common\models;

use backend\modules\org\models\OrgSite;
use Yii;


/**
 * This is the model class for table "sys_document".
 *
 * @property integer $document__id
 * @property string $name
 * @property string $description
 * @property integer $document_status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class SysDocument extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_document';
    }

    /**
     * นับข้อความที่ยังไม่ได้อ่านเพื่อแจ้งเตือนที่ navbar ด้านบน
     * @return array
     */
    public static function countNewDocument()
    {
        $userId = Yii::$app->user->id;
        $query = new \yii\db\Query;
        $query->select('d.name as document,m.document_id, count(m.document_id) as countNew, d.url_message')
            ->from('sys_list_message m')
            ->leftJoin('sys_document d', 'd.document_id = m.document_id')
            ->where("m.app_status='0' AND user_apprever_id='$userId' ");
        $command = $query->createCommand();
        $model = $command->queryAll();
        return $model;
    }

    /**
     * นับความแจ้งเตือนใหม่ทั้งหมด
     * @return int
     */
    public static function CountTotalNewDocument()
    {
        $newMessages = SysDocument::countNewDocument();
        $totalNewMessage = 0;
        foreach ($newMessages as $message) {
            $totalNewMessage += $message['countNew'];
        }
        return $totalNewMessage;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['document_status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'document_id' => Yii::t('system', 'Document  ID'),
            'name' => Yii::t('system', 'Name'),
            'description' => Yii::t('system', 'Description'),
            'document_status' => Yii::t('system', 'Document Status'),
            'created_at' => Yii::t('system', 'Created At'),
            'created_by' => Yii::t('system', 'Created By'),
            'updated_at' => Yii::t('system', 'Updated At'),
            'updated_by' => Yii::t('system', 'Updated By'),
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentOptions()
    {
        return $this->hasMany(SysDocumentOption::className(), ['document_id' => 'document_id']);
    }

    /**
     * ไซต์งาน
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(OrgSite::className(), ['site_id' => 'document_id']);
    }

}
