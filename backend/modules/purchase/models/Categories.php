<?php

namespace backend\modules\purchase\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "psm_categories".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $status
 * @property integer $create_at
 * @property integer $create_by
 * @property integer $upadte_at
 * @property integer $update_by
 */
class Categories extends \yii\db\ActiveRecord
{

    const  STATUS_ACTIVE = 1;
    const  STATUS_INACTIVE = 0;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'psm_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'create_at', 'create_by', 'upadte_at', 'update_by'], 'integer'],
            [['status'], 'string'],
            [['update_by'], 'required'],
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
            'code' => 'Code',
            'name' => 'Name',
            'status' => 'Status',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'upadte_at' => 'Upadte At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @inheritdoc
     * @return CategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriesQuery(get_called_class());
    }

    public static function getCategoryItems() {
        $model =  Categories::find()->where(['status'=>self::STATUS_ACTIVE])->all();
        return ArrayHelper::map($model,'id','name');
    }

    public static function getSidebarItem() {
        $data = [];
        $product = new InventorySearch();
        $product->load(Yii::$app->request->get());
        $models = Categories::find()->orderBy(['name'=>SORT_ASC])
            ->where(['status' => self::STATUS_ACTIVE ])
            ->orderBy(['name' => SORT_ASC])
            ->all();
        if($models) {
            foreach ($models as $key => $item) {
                $countProduct = Inventory::find()->where(['categories_id'=>$item->id])->count();
                $data[] = [
                   'label' =>  $item->name . ($countProduct>0?" <span class='badge pull-right'>{$countProduct}</span>":''),
                    'icon' => '',
                    'url' => ['/purchase/inventory/index','InventorySearch[categories_id]' =>$item->id],
                    'active' => ($product->categories_id == $item->id)?true:false,
                ];
            }
        }
        return $data;
    }
}
