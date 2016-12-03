<?php

namespace backend\modules\org\models;

use Yii;

/**
 * This is the model class for table "org_position_property".
 *
 * @property integer $option_id
 * @property integer $position_id
 */
class OrgPositionProperty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public  $title='';
    public static function tableName()
    {
        return 'org_position_property';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option_id', 'position_id'], 'required'],
            [['option_id', 'position_id','sorter'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'option_id' => 'Option ID',
            'position_id' => 'Position ID',
        	'sorter'=> 'sorter ID',
        ];
    }
  
}
