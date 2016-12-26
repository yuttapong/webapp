<?php

namespace backend\modules\purchase\models;

use Yii;

/**
 * This is the model class for table "psm_vendor".
 *
 * @property string $id
 * @property string $code
 * @property string $company
 * @property string $detail
 * @property string $address
 * @property string $tel
 * @property string $fax
 * @property string $email
 * @property string $contact_name
 * @property string $contact_position
 * @property string $term_payment
 * @property string $term_delivery
 * @property string $comment
 * @property string $vat
 * @property string $create_at
 * @property string $update_at
 * @property integer $ct_code
 * @property string $create_by
 * @property integer $log_del
 */ 
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 0;
    public static function tableName()
    {
        return 'psm_vendor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detail', 'address', 'term_payment', 'term_delivery', 'comment'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['ct_code', 'log_del','master_id'], 'integer'],
            [['code', 'company', 'tel', 'fax', 'email', 'contact_name', 'contact_position'], 'string', 'max' => 255],
            [['vat'], 'string', 'max' => 2],
            [['create_by'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'company' => 'Company',
            'detail' => 'Detail',
            'address' => 'Address',
            'tel' => 'Tel',
            'fax' => 'Fax',
            'email' => 'Email',
            'contact_name' => 'Contact Name',
            'contact_position' => 'Contact Position',
            'term_payment' => 'Term Payment',
            'term_delivery' => 'Term Delivery',
            'comment' => 'Comment',
            'vat' => 'Vat',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'ct_code' => 'Ct Code',
            'create_by' => 'Create By',
            'log_del' => 'Log Del',
        	'master_id'=>'maping',
        	'status'=>'status',
        ];
    }
    public function getVendor()
    {
    	return $this->hasOne(Vendor::className(), ['id' => 'master_id']);
    }
    public function getStatus()
    {
    	return [
    			self::STATUS_ENABLED => 'ใช้งาน',
    			self::STATUS_DISABLED => 'ไม่ใช่งาน',
    	];
    }
}
