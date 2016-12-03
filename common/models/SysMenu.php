<?php

namespace common\models;

use Yii;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $module_id
 * @property string $name
 * @property integer $parent
 * @property string $route
 * @property integer $order
 * @property string $data
 * @property integer $table_id
 * @property integer $table_key
 * @property string $url
 * @property integer $created_at
 * @property integer $created_by
 *
 * @property SysMenu $parent0
 * @property SysMenu[] $sysMenus
 */
class SysMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_header', 'module_id', 'parent', 'order', 'table_id', 'table_key', 'created_at', 'created_by', 'active'], 'integer'],
             [['name'], 'required'],
            [['order', 'is_header', 'parent'], 'default', 'value' => 0],
            [['data', 'icon'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['route'], 'string', 'max' => 256],
            [['url'], 'string', 'max' => 255],
            // [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => SysMenu::className(), 'targetAttribute' => ['parent' => 'id']],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module ID',
            'name' => 'Name',
            'parent' => 'Parent',
            'route' => 'Route',
            'order' => 'Order',
            'data' => 'Data',
            'table_id' => 'Table ID',
            'table_key' => 'Table Key',
            'url' => 'Url',
            'created_at' => 'สร้างเมื่อ',
            'created_by' => 'สร้างโดย',
            'updated_at' => 'แก้ไขเมื่อ',
            'updated_by' => 'แก้ไขโดย',
            'is_header' => 'ตั้งเป็นหัวข้อหมวดหมู่',
            'active' => 'Active'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentMenu()
    {
        return $this->hasOne(SysMenu::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysMenus()
    {
        return $this->hasMany(SysMenu::className(), ['parent' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(SysModule::className(), ['_id' => 'module_id']);
    }

    /**
     * เมนูของแต่ละโมดูล
     * get array for widget
     */
    public function getSidebarItem($slug = '')
    {

        $items = [];
        $module = SysModule::find()->where(['slug' => $slug])->one();
        if ($module) {

            $model = SysMenu::find()
                ->where(['module_id' => $module->id, 'parent' => 0])
                ->orderBy(['order' => SORT_ASC])
                ->all();
            if ($model) {
                foreach ($model as $m) {
                    $items[$m->id]['label'] = $m->name;
                    $items[$m->id]['icon'] = ($m->icon) ? $m->icon : 'fa fa-list';
                    $items[$m->id]['url'] = '#';
                    $items[$m->id]['items'] = SysMenu::getSidebarItemSub($m->id);
                    $items[$m->id]['options'] = ['class' => $m->is_header ? 'header' : ''];
                }
            }
        }
        return $items;
    }


    private function getSidebarItemSub($parent)
    {
        $model = SysMenu::find()
            ->where(['parent' => $parent, 'active' => 1])
            ->orderBy(['order' => SORT_ASC])
            ->all();
        $items = [];
        if ($model) {
            foreach ($model as $m) {
                $items[] = [
                    'label' => $m->name,
                    'url' => [$m->route],
                   // 'icon' => ($m->icon) ? $m->icon : 'fa fa-dot-circle-o'
                ];
            }
        }
        return $items;
    }

    //Array for dropdown parent of menu
    public function getArrayParent()
    {
        $model = SysMenu::find()
            ->where(['parent' => 0, 'module_id' => $this->module_id])
            // ->andWhere(['<>', 'id', $this->id])
            ->all();
        $items = ArrayHelper::map($model, 'id', 'name');
        return $items;
    }
}
