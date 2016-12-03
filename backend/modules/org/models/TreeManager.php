<?php

namespace backend\modules\org\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use backend\modules\tree\TreeView;
use kartik\helpers\Html;

/**
 * This is the model class for table "tree_manager".
 *
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $lvl
 * @property string $name
 * @property string $icon
 * @property integer $icon_type
 * @property integer $active
 * @property integer $selected
 * @property integer $disabled
 * @property integer $readonly
 * @property integer $visible
 * @property integer $collapsed
 * @property integer $movable_u
 * @property integer $movable_d
 * @property integer $movable_l
 * @property integer $movable_r
 * @property integer $removable
 * @property integer $removable_all
 */
class TreeManager extends ActiveRecord
{


    use \kartik\tree\models\TreeTrait {
        isDisabled as parentIsDisabled; // note the alias
    }

    public $sites;

    /**
     * @var string the classname for the TreeQuery that implements the NestedSetQueryBehavior.
     * If not set this will default to `kartik    ree\models\TreeQuery`.
     */
    public static $treeQueryClass; // change if you need to set your own TreeQuery

    /**
     * @var bool whether to HTML encode the tree node names. Defaults to `true`.
     */
    public $encodeNodeNames = true;

    /**
     * @var bool whether to HTML purify the tree node icon content before saving.
     * Defaults to `true`.
     */
    public $purifyNodeIcons = true;

    /**
     * @var array activation errors for the node
     */
    public $nodeActivationErrors = [];

    /**
     * @var array node removal errors
     */
    public $nodeRemovalErrors = [];

    /**
     * @var bool attribute to cache the `active` state before a model update. Defaults to `true`.
     */
    public $activeOrig = true;
	public $nameAttribute='name';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_structure_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['root', 'lft', 'rgt', 'lvl', 'icon_type', 'selected',
                'disabled', 'readonly', 'visible', 'collapsed', 'movable_u',
                'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all',
                'position_id', 'user_id', 'user_code', 'company_id',
            ], 'integer'],
        		['active', 'boolean'],
            [['name',  'position_id'], 'required'],
            [['icon','name'], 'string', 'max' => 255],
           // [['parent_id'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'root' => 'Root',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'lvl' => 'Lvl',
            'name' => 'ชื่อตำแหน่ง',
            'icon' => 'Icon',
            'icon_type' => 'Icon Type',
            'active' => 'Active',
            'selected' => 'Selected',
            'disabled' => 'Disabled',
            'readonly' => 'Readonly',
            'visible' => 'Visible',
            'collapsed' => 'Collapsed',
            'movable_u' => 'Movable U',
            'movable_d' => 'Movable D',
            'movable_l' => 'Movable L',
            'movable_r' => 'Movable R',
            'removable' => 'Removable',
            'removable_all' => 'Removable All',
            'user_id' => 'พนักงาน',
            'position_id' => 'ตำแหน่ง',
            'parent_id' => 'หัวหน้างาน',
            'sites' => 'ไซต์งานที่รับผิดชอบ',
        ];
    }


    /**
     * @inheritdoc
     * @return TreeManagerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TreeManagerQuery(get_called_class());
    }

    public function getPersonnelCode()
    {
        $model = OrgPersonnel::findOne(['user_id'=>$this->user_id]);
        if ($model) {
            return $model->code;
        }

    }

    public function getPersonnelName()
    {
        $model = OrgPersonnel::findOne(['user_id'=>$this->user_id]);
        if ($model) {
            return $model->fullnameTH;
        }

    }




    public function getSiteUsers()
    {
        return $this->hasMany(OrgSiteUser::className(), ['user_id', 'user_id']);
    }

    public function getSitename()
    {
        $this->site->site_name;

    }


    public function getSiteDropdown()
    {
        $list = \backend\modules\org\models\OrgSite::find()
            ->select('site_id,site_name')
            ->orderBy(['site_name' => SORT_ASC])
            ->all();
        $list = ArrayHelper::map($list, 'site_id', 'site_name');
        return $list;
    }

    public function getPositionDropdown()
    {
        $list = \backend\modules\org\models\OrgPosition::find()
            ->orderBy(['name_th' => SORT_ASC])
            ->all();
        $list = ArrayHelper::map($list, 'id', 'name_th');
        return $list;
    }

    public function getPersonnelDropdown()
    {
        $list = \backend\modules\org\models\OrgPersonnel::find()
         ->where(['active' => 1])
       	 // ->andWhere(['not', ['user_id' => null]])
            ->orderBy(['firstname_th' => SORT_ASC])
            ->all();
        $list = ArrayHelper::map($list, 'user_id', 'fullnameTH');
        return $list;
    }


    public function getInParent($in_parent, $store_all_id)
    {
        $text = '';
        if (in_array($in_parent, $store_all_id)) {
            $models = OrgStructureItem::find()
                ->where(['parent_id' => $in_parent])
                ->all();
            $text .= $in_parent == 0 ? "<ul class='tree'>" : "<ul>";
            foreach ($models as $row) {
                $text .= "<li";
                if ($row->hide)
                    $text .= " class='thide'";
                $text .= "><div id=" . $row->id . ">";
                $text .= "<span class='first_name'>" . $row->name . "</span></div>";
                $text .= TreeManager::getInParent($row['id'], $store_all_id);
                $text .= "</li>";
            }
            $text .= "</ul>";
        }
        return $text;
    }

public static function getStructure(){
    return [
        'idAttribute' => 'id',
        'nameAttribute' => 'id',
        'iconAttribute' => 'icon',
        'iconTypeAttribute' => 'icon_type'
    ];
}
public function getBreadcrumbs(
		$depth = 1,
		$glue = ' &raquo; ',
		$currNodeCss = 'kv-crumb-active',
		$untitled = 'Untitled'
) {
	/**
	 * @var Tree $this
	 */
	if ($this->isNewRecord || empty($this)) {
		return $currNodeCss ? Html::tag('span', $untitled, ['class' => $currNodeCss]) : $untitled;
	}
	$depth = empty($depth) ? null : intval($depth);

	$module = TreeView::module();
	$nameAttribute = ArrayHelper::getValue($module->dataStructure, 'nameAttribute', 'name');
	$crumbNodes = $depth === null ? $this->parents()->all() : $this->parents($depth - 1)->all();
	$crumbNodes[] = $this;
	$i = 1;
	$len = count($crumbNodes);
	$crumbs = [];
	
	foreach ($crumbNodes as $node) {
		$name = $node->$nameAttribute;
		$text=$name;
		
		if ($i === $len && $currNodeCss) {
			$name = Html::tag('span', $name, ['class' => $currNodeCss]);

		}else{
			$text=explode("-",$name);
			$name=$text['0'];
		}

		$crumbs[] = $name;
		$i++;
	}
	return implode($glue, $crumbs);
}

}
