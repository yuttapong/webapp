<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 21/6/2559
 * Time: 17:51
 */
use yii\bootstrap\Html;
use backend\assets\MapAsset;
MapAsset::register($this);
?>
<div class="place-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_formPlaceGoogle', [
        'model' => $model,
    ]) ?>

</div>

<?php
$gpJsLink= 'http://maps.googleapis.com/maps/api/js?' . http_build_query(
        array(
            'libraries' => 'places',
            'sensor' => 'false',
            'key' => Yii::$app->params['google-api-key'],
        ));
echo $this->registerJsFile($gpJsLink);
$options = '{"types":["establishment"],"componentRestrictions":{"country":"th"}}';
echo $this->registerJs("(function(){
        var input = document.getElementById('googleplaces-searchbox');
        var options = $options;
        searchbox = new google.maps.places.Autocomplete(input, options);
        setupListeners();
})();" , \yii\web\View::POS_END );

//'setupBounds('.$bound_bl.','.$bound_tr.');
?>

