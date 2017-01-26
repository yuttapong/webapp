<?php

namespace backend\modules\purchase\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sys_job_list".
 *
 * @property integer $id
 * @property string $slug
 * @property integer $mater_id
 * @property string $name
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $status
 */
class JobList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_job_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mater_id', 'created_at', 'created_by', 'status'], 'integer'],
            [['slug'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'mater_id' => 'Mater ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }

    public function getJobListItem()
    {
        $models = JobList::find()->where(['status' => 1])->orderBy(['name' => SORT_ASC])->all();
        return ArrayHelper::map($models, 'id', 'name');
    }
}
