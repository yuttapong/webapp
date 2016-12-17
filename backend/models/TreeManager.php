<?php

namespace backend\models;

use kartik\tree\models\Tree;
use Yii;
use yii\db\ActiveRecord;

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


/**
     * @var string the classname for the TreeQuery that implements the NestedSetQueryBehavior.
     * If not set this will default to `kartik    ree\models\TreeQuery`.
     */
    public static $treeQueryClass;
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
    public $nodeRemovalErrors = []; // change if you need to set your own TreeQuery
    /**
     * @var bool attribute to cache the `active` state before a model update. Defaults to `true`.
     */
    public $activeOrig = true;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_structure_item';
    }

    /**
     * @inheritdoc
     * @return TreeManagerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TreeManagerQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['root', 'lft', 'rgt', 'lvl', 'icon_type', 'active', 'selected', 'disabled', 'readonly', 'visible', 'collapsed', 'movable_u', 'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all'], 'integer'],
            //  [['lft', 'rgt', 'lvl', 'name'], 'required'],
            [['name'], 'string', 'max' => 60],
            [['icon'], 'string', 'max' => 255],
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
            'name' => 'Name',
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
            'user_id' => 'ผู้ใช้งาน',
            'position_id' => 'ตำแหน่งงาน',
        ];
    }


    /**
     * Note overriding isDisabled method is slightly different when
     * using the trait. It uses the alias.
     */


}
