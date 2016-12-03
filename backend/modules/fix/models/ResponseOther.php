<?php

namespace backend\modules\fix\models;

use Yii;

/**
 * This is the model class for table "fix_response_other".
 *
 * @property integer $other_id
 * @property string $table_name
 * @property string $table_key
 * @property integer $seq
 * @property string $question_id
 * @property string $choice_id
 * @property string $response
 * @property integer $created_at
 * @property integer $created_by
 */
class ResponseOther extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_response_other';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_key', 'question_id', 'choice_id'], 'required'],
            [['table_key', 'seq', 'question_id', 'choice_id', 'created_at', 'created_by','status'], 'integer'],
            [['response'], 'string'],
            [['table_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'other_id' => 'Other ID',
            'table_name' => 'Table Name',
            'table_key' => 'Table Key',
            'seq' => 'Seq',
            'question_id' => 'Question ID',
            'choice_id' => 'Choice ID',
            'response' => 'Response',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        		'status'=> 'Created By',
        ];
    }
    public function beforeSave($insert){
    	if (parent::beforeSave($insert)) {
    		if ($this->isNewRecord) {
    			$this->created_at=time();
    			$this->created_by=Yii::$app->user->id;
    		}
    		return true;
    	} else {
    		return false;
    	}
    }
}
