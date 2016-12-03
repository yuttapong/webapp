<?php

namespace backend\modules\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SysMenu;

/**
 * SysMenuSearch represents the model behind the search form about `common\models\SysMenu`.
 */
class SysMenuSearch extends SysMenu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'module_id', 'parent', 'order', 'table_id', 'table_key', 'created_at', 'created_by'], 'integer'],
            [['name', 'route', 'data', 'url'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SysMenu::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => [
                'module_id' => SORT_DESC,
                'is_header' => SORT_DESC,
                'id' => SORT_ASC,
            ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'module_id' => $this->module_id,
            'parent' => $this->parent,
            'order' => $this->order,
            'table_id' => $this->table_id,
            'table_key' => $this->table_key,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'data', $this->data])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
