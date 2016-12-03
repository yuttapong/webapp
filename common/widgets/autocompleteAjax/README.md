yii2-autocomplete-ajax
===================

This is the AutocompleteAjax widget and a Yii 2 enhanced wrapper for the [Autocomplete | jQuery UI](https://jqueryui.com/autocomplete/). A simple way to search model id of the attributes model.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either add

```
"require": {
    "keygenqt/yii2-autocomplete-ajax": "*"
}
```

of your `composer.json` file.

## Latest Release

The latest version of the module is v0.5.0 `BETA`.

## Usage

View:

```php
use keygenqt\autocompleteAjax\AutocompleteAjax;

// Normal select with ActiveForm & model
<?= $form->field($model, 'user_id')->widget(AutocompleteAjax::classname(), [
    'multiple' => false,
    'url' => ['ajax/search-user'],
    'options' => ['placeholder' => 'Find by user email or user id.']
]) ?>
```

Controller:

```php
class AjaxController extends Controller
{
    public function actionSearchUser($term)
    {
        if (Yii::$app->request->isAjax) {

            $results = [];

            if (is_numeric($term)) {
                /** @var Tag $model */
                $model = Tag::findOne(['id' => $term]);
                
                if ($model) {
                    $results[] = [
                        'id' => $model['id'],
                        'label' => $model['email'] . ' (model id: ' . $model['id'] . ')',
                    ];
                }
            } else {

                $q = addslashes($term);

                foreach(Tag::find()->where("(`email` like '%{$q}%')")->all() as $model) {
                    $results[] = [
                        'id' => $model['id'],
                        'label' => $model['email'] . ' (model id: ' . $model['id'] . ')',
                    ];
                }
            }

            echo Json::encode($results);
        }
    }
}
```

## License

**yii2-autocomplete-ajax** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.