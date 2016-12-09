<?php
namespace backend\modules\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * CustomerSearch represents the model behind the search form about `backend\modules\crm\models\Customer`.
 */
class CustomerSearch extends Customer

{

    public function rules()
    {
        return [
            [['id', 'age'], 'integer'],
            [['prefixname', 'firstname', 'lastname', 'birthday', 'mobile', 'email', 'tel'], 'safe'],

        ];
    }


    public function scenarios()

    {

        // bypass scenarios() implementation in the parent class

        return Model::scenarios();

    }

    public function search($params)

    {

        $query = Customer::find();
        $query->limit(15);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,


        ]);
        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
            'attributes' => [
                'id' => [
                    'default' => SORT_DESC,
                ],
                'datetime',
                'created_at',
                'fullname' => [
                    'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                    'label' => 'Full Name',
                    'default' => SORT_ASC
                ],
            ]
        ]);

        $query->where(['active' => Customer::STATUS_ACTIVE]);

        // ถ้าดูไม่ได้ทุกทายการ
        /*
        if (!Yii::$app->user->can('/crm/customer/all')) {

            //
            if (Yii::$app->user->can('/crm/customer/mylead')) {

            } else {
                $query->andFilterWhere(['created_by' => Yii::$app->user->id]);
            }
        }
        */


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;

        }

        $query->andFilterWhere([
            'id' => $this->id,
            'birthday' => $this->birthday,
            'age' => $this->age,
        ]);


        $query->andFilterWhere(['like', 'prefixname', $this->prefixname])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'tel', $this->tel]);


        return $dataProvider;

    }

  
    public function searchOnlyParamsForAllRole($params)

    {

        $query = Customer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,


        ]);
        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
            'attributes' => [
                'id' => [
                    'default' => SORT_DESC,
                ],
                'datetime',
                'created_at',
                'fullname' => [
                    'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                    'label' => 'Full Name',
                    'default' => SORT_ASC
                ],
            ]
        ]);

        $query->where(['active' => Customer::STATUS_ACTIVE]);

        // ถ้าดูไม่ได้ทุกทายการ
        /*
        if (!Yii::$app->user->can('/crm/customer/all')) {

            //
            if (Yii::$app->user->can('/crm/customer/mylead')) {

            } else {
                $query->andFilterWhere(['created_by' => Yii::$app->user->id]);
            }
        }
        */


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;

        }

        $query->andFilterWhere([
            'id' => $this->id,
            'birthday' => $this->birthday,
            'age' => $this->age,
        ]);


        $query->andFilterWhere(['like', 'prefixname', $this->prefixname])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'tel', $this->tel]);


        return $dataProvider;

    }


}
