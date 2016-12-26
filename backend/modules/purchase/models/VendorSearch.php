<?php

namespace backend\modules\purchase\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\purchase\Models\Vendor;

/**
 * VendorSearch represents the model behind the search form about `backend\modules\purchase\Models\Vendor`.
 */
class VendorSearch extends Vendor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ct_code', 'log_del'], 'integer'],
            [['code', 'company', 'detail', 'address', 'tel', 'fax', 'email', 'contact_name', 'contact_position', 'term_payment', 'term_delivery', 'comment', 'vat', 'create_at', 'update_at', 'create_by'], 'safe'],
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
        $query = Vendor::find();

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
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
            'ct_code' => $this->ct_code,
            'log_del' => $this->log_del,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'contact_name', $this->contact_name])
            ->andFilterWhere(['like', 'contact_position', $this->contact_position])
            ->andFilterWhere(['like', 'term_payment', $this->term_payment])
            ->andFilterWhere(['like', 'term_delivery', $this->term_delivery])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'vat', $this->vat])
            ->andFilterWhere(['like', 'create_by', $this->create_by]);

        return $dataProvider;
    }
}
