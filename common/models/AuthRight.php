<?php

namespace common\models;

use Yii;
use common\models\Menu;
/**
 * This is the model class for table "auth_right".
 *
 * @property integer $_id
 * @property integer $model_id
 * @property integer $menu_id
 * @property string $item_item
 *
 * @property SysModule $model
 */
class AuthRight extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_right';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module_id', 'menu_id'], 'integer'],
            [['item_item'], 'string', 'max' => 64],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysModule::className(), 'targetAttribute' => ['model_id' => '_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'Id',
            'module_id' => 'Module ID',
            'menu_id' => 'Menu ID',
            'item_item' => 'Item Item',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMoule()
    {
        return $this->hasOne(SysModule::className(), ['_id' => 'module_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }




    public function getMenuRights($module_id){
        $model = AuthRight::find()
            ->where(['module_id'=>$module_id])
            ->groupBy(['module_id','menu_id'])
            ->all();
        if($model)
            return $model;
    }


    public function getItemRight($menu_id){
        $model = $this->findAll(['menu_id'=>$menu_id]);
        if($model)
            return $model;
    }

}
