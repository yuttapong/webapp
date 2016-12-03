<?php

namespace common\models;

use Yii;
use common\models\SysTable;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "sys_module".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_th
 * @property string $description
 * @property integer $create_at
 * @property integer $create_id
 * @property string $img
 * @property string $url
 * @property integer $table_id
 * @property integer $bd_id
 * @property integer $active
 *
 * @property AuthRight[] $authRights
 * @property SysBasicData $bd
 */
class SysModule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description','slug'], 'string'],
            [['slug'], 'unique'],
            [['created_at', 'created_by', 'table_id', 'bd_id', 'active'], 'integer'],
            [['active', 'bd_id', 'name_th'], 'required'],
            [['name_en', 'name_th', 'img', 'url', 'icon'], 'string', 'max' => 255],
            [['bd_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysBasicData::className(), 'targetAttribute' => ['bd_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'slug' => 'Slug',
            'name_en' => 'Name',
            'name_th' => 'ชื่อ',
            'description' => 'รายละเอียด',
            'created_at' => 'สร้างเมื่อ',
            'created_by' => 'สร้างโดย',
            'img' => 'รูปภาพ',
            'url' => 'ลิ้งค์',
            'table_id' => 'ชุดข้อมูล',
            'bd_id' => 'หมวดหมู่',
            'active' => 'Active',
            'sysTable.name' => 'หมวดหมู่',
            'sysBd.name' => 'หมวดหมู่',
            'icon' => 'Icon',
            'updated_at' => 'แก้ไขล่าสุด',
            'updated_by' => 'แก้ไขโดย',
        ];
    }
    public  function attributeHints(){
        return [
          'Slug' => 'Module ID อ้างอิงโมดูล ซึ่งได้จาก Gii',
        ];
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthRights()
    {
        return $this->hasMany(AuthRight::className(), ['model_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysBd()
    {
        return $this->hasOne(SysBasicData::className(), ['id' => 'bd_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysTable()
    {
        return $this->hasOne(SysTable::className(), ['id' => 'table_id']);
    }

    public function getSysMenus()
    {
        return $this->hasMany(SysMenu::className(), ['module_id' => 'id'])
            ->orderBy(['order' => SORT_ASC]);
    }


    /**
     * @inheritdoc
     * @return SysModuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SysModuleQuery(get_called_class());
    }

    public function getListModuleForWidget()
    {
        $db = Yii::$app->getDb();
        $command = $db->createCommand("
                        SELECT
                        bd.name as group_name,
                        bd.id as group_id,
                        m.description,
                        m.id as module_id,
                        m.name_th as module_name_th,
                        m.name_en as module_name_en,
                        bd.code as data_code,
                        m.url,
                        m.img
                        FROM sys_module m
                        left JOIN sys_basic_data bd on bd.table_id=m.table_id and m.bd_id=bd.id
                        WHERE bd.table_id=:code AND m.active=:active
                        ORDER BY group_name ASC
                        ",
            [':code' => 2, ':active' => 1]
        );
        $modules = $command->queryAll();
        $groups = [];
        foreach ($modules as $key => $m) {
            $groups[$m['group_id']]['label'] = $m['group_name'];
            $groups[$m['group_id']]['visible'] = true;
            $groups[$m['group_id']]['items'][] = [
                'label' => $m['module_name_th'].'<br>'.$m['module_name_en'],
                'url' => Url::to([$m['url']]),
                'icon' => $m['img'],
                'visible' => true,
            ];

        }

        return $groups;
    }


    //for dropdown list
    public function getAModuleList()
    {
        $model = SysModule::find()->orderBy('name_th')->all();
        return ArrayHelper::map($model, 'id', 'name_th');
    }



    /**
     * หาเมนู
     * @param $module_id
     * @return array
     */
    public function  getMenuForNav($module_id)
    {
        $models = SysMenu::find(['parent' => 0])
            ->where(['module_id' => $module_id])
            ->orderBy(['order' => SORT_ASC])
            ->all();
        $items = [];
        if ($models) {
            foreach ($models as $m) {
                $items[$m->id]['label'] = $m->name;
                $items[$m->id]['icon'] = $m->icon;
                $items[$m->id]['items'] = SysModule::getMenuChild($m->id);
            }
        }
        return $items;
    }

    /**
     * หาเมนูย่อย sub ของ
     * @param $id
     * @return array
     */
    private function  getMenuChild($id)
    {
        $model = SysMenu::find()
            ->where(['parent' => $id])
            ->orderBy(['order' => SORT_ASC])
            ->all();
        $items = [];
        if ($model) {
            foreach ($model as $m) {
                $items[] = [
                    'label' => $m->name,
                    'icon' => $m->icon,
                ];
            }
        }
        return $items;
    }


    /**
     *  get menu  of app for navbar
     * @return array
     */
    public function getItemModuleForButtonApp(){
        $models = SysModule::find()
            ->where(['active' => 1])
            ->all();
        $items = [];
        if ($models) {
            foreach ($models as $m) {
                $items[$m->id]= [
                    'icon' => $m->icon,
                    'label' => $m->name_en,
                    'name_th' => $m->name_th,
                    'name_en' => $m->name_en,
                    'url' => $m->url,
                    'visible' => true,
                ];
            }
        }
        return $items;
    }

}
