<?php

namespace backend\modules\fix\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\fix\Models\Prin;

/**
 * PrinSearch represents the model behind the search form about `backend\modules\fix\Models\Prin`.
 */
class PrinSearch extends Prin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'user_order_id', 'create_at', 'create_by', 'site_id', 'project_id'], 'integer'],
            [['code', 'title', 'description'], 'safe'],
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
        $query = Prin::find();

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
            'type' => $this->type,
            'user_order_id' => $this->user_order_id,
            'create_at' => $this->create_at,
            'create_by' => $this->create_by,
            'site_id' => $this->site_id,
            'project_id' => $this->project_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
