<?php

namespace backend\modules\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SysDocument;

/**
 * DocumentSearch represents the model behind the search form about `common\models\SysDocument`.
 */
class DocumentSearch extends SysDocument
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_id', 'document_status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'description', 'table_name'], 'safe'],
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
        $query = SysDocument::find();

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
            'document_id' => $this->document_id,
            'document_status' => $this->document_status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'table_name', $this->table_name]);

        return $dataProvider;
    }
}
