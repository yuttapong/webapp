<?php

namespace common\models;

use backend\modules\org\models\OrgPersonnel;
use backend\modules\org\models\OrgPosition;
use backend\modules\org\models\OrgSite;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sys_document_option".
 *
 * @property integer $_id
 * @property integer $company_id
 * @property integer $site_id
 * @property integer $document_id
 * @property string $_type
 * @property integer $seq
 * @property string $data
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class SysDocumentOption extends \yii\db\ActiveRecord
{
    // ประเภทการอนุมัติ Type of approve
    const TYPE_ORGANIZATION = 'Organization';
    const TYPE_POSITION = 'Position';
    const TYPE_CUSTOM = 'Custom';

    //สถานะรูปแบบการอนุมัติสามารถ active ได้เพียงรายการเดียว
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;


    public $position;
    public $level;
    public $user_code;

    public $users;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_document_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'site_id', 'document_id', 'seq', 'created_at', 'created_by', 'updated_at', 'updated_by', 'active'], 'integer'],
            [['_type', 'data'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('system', 'Id'),
            'company_id' => Yii::t('system', 'Company ID'),
            'site_id' => Yii::t('system', 'Site ID'),
            'document_id' => Yii::t('system', 'Document ID'),
            '_type' => Yii::t('system', 'Type'),
            'seq' => Yii::t('system', 'Seq'),
            'data' => Yii::t('system', 'เก็บในรู็ตั้งค่าเป็น array'),
            'created_at' => Yii::t('system', 'Created At'),
            'created_by' => Yii::t('system', 'Created By'),
            'updated_at' => Yii::t('system', 'Updated At'),
            'updated_by' => Yii::t('system', 'Updated By'),
            'position' => Yii::t('system', 'ตำแหน่ง'),
            'user_code' => Yii::t('system', 'พนักงาน'),
        ];
    }

    public function getTypeItems()
    {
        return [
            self::TYPE_CUSTOM => 'กำหนดเอง',
            self::TYPE_POSITION => 'อนุมัติตามตำแหน่ง',
            self::TYPE_ORGANIZATION => 'อนุมัติตามแผนผังองค์กร',
        ];
    }

    public function getExtractData()
    {
        return unserialize($this->data);
    }


    public function getSiteItems()
    {
        $model = OrgSite::find()->all();
        return ArrayHelper::map($model, 'site_id', 'site_name');
    }

    public function getPositionItems()
    {
        $model = OrgPosition::find()->orderBy('name_th')->all();
        return ArrayHelper::map($model, 'id', 'name_th');
    }

    public function getPersonnelItems()
    {
        $model = OrgPersonnel::find()->where(['not', ['code' => '']])->orderBy('firstname_th')->all();
        return ArrayHelper::map($model, 'id', 'fullnameWithCode');
    }

    public function getDocument()
    {
        return $this->hasOne(SysDocument::className(), ['document_id' => 'document_id']);
    }
}
