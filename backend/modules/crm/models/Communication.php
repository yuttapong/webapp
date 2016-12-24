<?php

namespace backend\modules\crm\models;

use backend\modules\org\models\OrgPersonnel;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "crm_communication".
 *
 * @property string $id
 * @property string $title
 * @property string $detail
 * @property string $type
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $customer_id
 */
class Communication extends \yii\db\ActiveRecord
{
    public $fromTime;
    public $toTime;
    public $date;
    public $time;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crm_communication';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'time', 'detail', 'datetime','title'], 'required'],
            [['detail'], 'string'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'customer_id'], 'integer'],
            [['title'], 'string', 'max' => 120],
            [['type'], 'string', 'max' => 60],
            [['datetime'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('crm.communication', 'ID'),
            'title' => Yii::t('crm.communication', 'หัวข้อ'),
            'detail' => Yii::t('crm.communication', 'รายละเอียด'),
            'type' => Yii::t('crm.communication', 'ประเภท'),
            'created_at' => Yii::t('crm.communication', 'บันทึกเมื่อ'),
            'created_by' => Yii::t('crm.communication', 'บันทึกโดย'),
            'updated_at' => Yii::t('crm.communication', 'แก้ไขล่าสุด'),
            'updated_by' => Yii::t('crm.communication', 'แก้ไขโดย'),
            'customer_id' => Yii::t('crm.communication', 'ลูกค้า'),
            'datetime' => Yii::t('crm.datetime', 'เวลา'),
            'createdName' => Yii::t('crm.communication', 'บันทึกโดย'),
            'updatedName' => Yii::t('crm.communication', 'แก้ไขโดย'),

        ];
    }

    /**
     * @inheritdoc
     * @return CommunicationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommunicationQuery(get_called_class());
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getCreatedName()
    {
        $model = OrgPersonnel::findOne(['user_id' => $this->created_by]);
        return @$model->fullnameTH;
    }

    public function getUpdatedName()
    {
        $model = OrgPersonnel::findOne(['user_id' => $this->updated_by]);
        return @$model->fullnameTH;
    }


}
