<?php

namespace backend\modules\org\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\org\models\OrgPosition;

/**
 * OrgPositionSearch represents the model behind the search form about `backend\modules\org\models\OrgPosition`.
 */
class OrgPositionSearch extends OrgPosition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'created_at', 'created_by'], 'integer'],
            [['level', 'salary'], 'number'],
            [['name_th', 'name_en'], 'safe'],
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
        $query = OrgPosition::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'parent_id' => $this->parent_id,
            'level' => $this->level,
            'salary' => $this->salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'name_th', $this->name_th])
            ->andFilterWhere(['like', 'name_en', $this->name_en]);
 

        return $dataProvider;
    }
}
