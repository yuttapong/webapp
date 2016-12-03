<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sys_key_run".
 *
 * @property integer $id
 * @property integer $table_name
 * @property string $key_char
 * @property integer $seq_count
 */
class SysKeyRun extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_key_run';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_name', 'year', 'seq_count'], 'required'],
            [['seq_count', 'month', 'year'], 'integer'],
            [['prefix', 'suffix', 'table_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_name' => 'Table Name',
            'prefix' => 'Prefix',
            'suffix' => 'Suffix',
            'year' => 'Year',
            'Month' => 'Month',
            'seq_count' => 'Seq Count',
        ];
    }

    /**
     * @inheritdoc
     * @return SysKeyRunQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SysKeyRunQuery(get_called_class());
    }


    public function generateKey($config = array())
    {
        $model = SysKeyRun::find()
            ->where(['table_name' => $config['tableName'], 'prefix' => $config['prefix']])
            ->one();
        if (count($model) > 0) {
            $model->updateCounters(['seq_count' => 1]);
            $model->year = date('Y');
            $model->month = date('m');
            $model->save();
        } else {
            $model = new SysKeyRun();
            $model->seq_count = 1;
            $model->prefix = $config['prefix'];
            $model->suffix = $config['prefix'];
            $model->table_name = $config['tableName'];
            $model->year = date('Y');
            $model->month = date('m');
            $model->save();
        }
        return $model;

    }
}
