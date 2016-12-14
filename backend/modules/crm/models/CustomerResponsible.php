<?php

namespace backend\modules\crm\models;

use backend\modules\org\models\OrgPersonnel;
use Yii;

/**
 * This is the model class for table "crm_customer_responsible".
 *
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $created_at
 * @property integer $created_by
 */
class CustomerResponsible extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crm_customer_responsible';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'customer_id'], 'required'],
            [['user_id', 'customer_id', 'created_at', 'created_by','active'], 'integer'],
            [['note','name'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('crm.customer', 'User'),
            'customer_id' => Yii::t('crm.customer', 'Customer ID'),
            'created_at' => Yii::t('crm.customer', 'Created At'),
            'created_by' => Yii::t('crm.customer', 'Created By'),
            'active' =>  Yii::t('crm.customer', 'Active'),
            'note' =>  Yii::t('crm.customer', 'Note')
    ];
    }

    /**
     * @inheritdoc
     * @return CustomerResponsibleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerResponsibleQuery(get_called_class());
    }

    public function getCustomer(){
        return @$this->hasOne(Customer::className(),['id'=>'customer_id']);
    }

    public function getPersonnel(){
        return @$this->hasOne(OrgPersonnel::className(), ['user_id' => 'user_id']);
    }

    public function getCreatedName() {
        return @$this->hasOne(OrgPersonnel::className(), ['user_id' => 'created_by']);
    }
}
