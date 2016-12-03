<?php

namespace backend\modules\org\models;

use Yii;

/**
 * This is the model class for table "tree".
 *
 * @property integer $id
 * @property string $first_name
 * @property integer $parent_id
 * @property integer $hide
 */
class Tree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'first_name', 'parent_id', 'hide'], 'required'],
            [['id', 'parent_id', 'hide'], 'integer'],
            [['first_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'parent_id' => 'Parent ID',
            'hide' => 'Hide',
        ];
    }

    /**
     * @inheritdoc
     * @return TreeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TreeQuery(get_called_class());
    }
}
