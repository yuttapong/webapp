<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "general_contact".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $contact
 * @property string $table_name
 * @property integer $table_key
 * @property integer $address_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $seq
 * @property integer $updated_at
 * @property integer $udpated_by
 */
class GeneralContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'general_contact';
    }

    /**
     * @inheritdoc
     * @return GeneralContactQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneralContactQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name'], 'required'],
            [['type'], 'string'],
            [['table_key', 'address_id', 'created_at', 'created_by', 'seq', 'updated_at', 'updated_by', 'is_default'], 'integer'],
            [['name', 'contact'], 'string', 'max' => 100],
            [['table_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'contact' => 'Contact',
            'table_name' => 'Table Name',
            'table_key' => 'Table Key',
            'address_id' => 'Address ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'seq' => 'Seq',
            'updated_at' => 'Updated At',
            'updated_by' => 'Udpated By',
            'is_default' => 'ค่าเริ่มต้น',
        ];
    }
}
