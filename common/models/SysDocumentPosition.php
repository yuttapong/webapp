<?php

namespace common\models;

use Yii;
use common\models\SysDocumentPersonnel;
use backend\modules\org\models\OrgPosition;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "sys_document_position".
 *
 * @property integer $document_id
 * @property integer $position_id
 * @property integer $seq
 */
class SysDocumentPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_document_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'position_id'], 'required'],
            [['document_id', 'position_id', 'seq'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'document_id' => 'Document ID',
            'position_id' => 'Position ID',
            'seq' => 'Seq',
        ];
    }
    public function getDocumentPersonnels()
    {
    	return $this->hasMany(SysDocumentPersonnel::className(), ['document_position_id' => 'id']);//->orderBy('seq');
    }
    public function getPositions()
    {
    	return $this->hasMany(OrgPosition::className(), ['id' => 'position_id'])->orderBy('name_th');
    }
    public function getPositionList(){
    	$model = OrgPosition::find()->orderBy('name_th')->all();
    	return ArrayHelper::map($model,'id','name_th');
    }
}

