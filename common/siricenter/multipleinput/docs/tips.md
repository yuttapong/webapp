#Tips and tricks

 - [How to customize buttons](#how-to-customize-buttons)
 - [Work with empty list](#work-with-empty-list)
 - [Guess column title](#guess-column-title)
 - [Ajax loading of a widget](#ajax-loading)
 - [Use of a widget's placeholder](#using-placeholder)
 - [Custom index of the row](#custom-index)
 - [Embedded MultipleInput widget](#embedded)
 - [Client validation](#client-validation)

##How to customize buttons

You can customize `add` and `remove` buttons via `addButtonOptions` and `removeButtonOptions`. Here is the simple example
how you can use those options:

```php

    echo $form->field($model, 'emails')->widget(MultipleInput::className(), [
        'max' => 5,
        'addButtonOptions' => [
            'class' => 'btn btn-success',
            'label' => 'add' // also you can use html code
        ],
        'removeButtonOptions' => [
            'label' => 'remove'
        ]
    ])
    ->label(false);

```

##Work with an empty list

In some cases you need to have the ability to delete all rows in the list. For this purpose you can use option `allowEmptyList` like in the example below:

```php

    echo $form->field($model, 'emails')->widget(MultipleInput::className(), [
        'max' => 5,
        'allowEmptyList' => true
    ])
    ->label(false);

```

Also you can set `0` in `min` option if you don't need first blank row when data is empty.

##Guess column title

Sometimes you can use the widget without defining columns but you want to have the column header of the table.
In this case you can use `enableGuessTitle` option like in the example below:

```php

    echo $form->field($model, 'emails')->widget(MultipleInput::className(), [
        'max' => 5,
        'allowEmptyList' => true,
        'enableGuessTitle' => true
    ])
    ->label(false);

```

##Ajax loading of a widget <a id="ajax-loading"></a>

Assume you want to load a widget via ajax and then show it inside modal window. In this case you MUST:

- Ensure that you specified ID of widget otherwise the widget will get random ID and it can be the same as id of others elements on the page.
- Ensure that you use the widget inside ActiveForm because it works incorrectly in this case.

You can fina an example of usage in a discussion of [issue](https://github.com/unclead/yii2-multiple-input/issues/58)

##Use of a widget's placeholder <a id="using-placeholder"></a>

You can use a placeholder `{multiple_index}` in a widget configuration, e.g. for implementation of dependent drop down lists.

```php
    <?= $form->field($model, 'field')->widget(MultipleInput::className(), [
            'id' => 'my_id',
            'allowEmptyList' => false,
            'rowOptions' => [
                'id' => 'row{multiple_index_my_id}',
            ],
            'columns' => [
                [
                    'name'  => 'category',
                    'type'  => 'dropDownList',
                    'title' => 'Category',
                    'defaultValue' => '1',
                    'items' => [
                        '1' => 'Test 1',
                        '2' => 'Test 2',
                        '3' => 'Test 3',
                        '4' => 'Test 4',
                    ],
                    'options' => [
                        'onchange' => <<< JS
$.post("list?id=" + $(this).val(), function(data){
    console.log(data);
    $("select#subcat-{multiple_index_my_id}").html(data);
});
JS
                    ],
                ],
                [
                    'name'  => 'subcategory',
                    'type'  => 'dropDownList',
                    'title' => 'Subcategory',
                    'items' => [],
                    'options'=> [
                        'id' => 'subcat-{multiple_index_my_id}'
                    ],
                ],
            ]
    ]);
    ?>
```

**Important** Ensure that you added ID of widget to a base placeholder `multiple_index`

##Custom index of the row <a id="custom-index"></a>

Assume that you want to set specific index for each row. In this case you can pass the `data` attribute as associative array
as in the example below:

```php
    <?= $form->field($model, 'field')->widget(MultipleInput::className(), [
            'allowEmptyList' => false,
            'data' => [
                3 => [
                    'day'       => '27.02.2015',
                    'user_id'   => 31,
                    'priority'  => 1,
                    'enable'    => 1
                ],

                'some-key' => [
                    'day'       => '27.02.2015',
                    'user_id'   => 33,
                    'priority'  => 2,
                    'enable'    => 0
                ],
            ]

    ...

```


##Embedded MultipleInput widget <a id="embedded"></a>

You can use nested `MultipleInput` as in the example below:

```
echo MultipleInput::widget([
    'model' => $model,
    'attribute' => 'questions',
    'attributeOptions' => $commonAttributeOptions,
    'columns' => [
        [
            'name' => 'question',
            'type' => 'textarea',
        ],
        [
            'name' => 'answers',
            'type'  => MultipleInput::class,
            'options' => [
                'attributeOptions' => $commonAttributeOptions,
                'columns' => [
                    [
                        'name' => 'right',
                        'type' => MultipleInputColumn::TYPE_CHECKBOX
                    ],
                    [
                        'name' => 'answer'
                    ]
                ]
            ]
        ]
    ],
]);
```

But in this case you have to pass `attributeOptions` to the widget otherwise you will not be able to use ajax or client side validation of data.

### Client validation

Apart of ajax validation you can use client validation but in this case you MUST set property `form`.
Also ensure that you set `enableClientValidation` to `true` value in property `attributeOptions`. If you want to use client validation
for particular column you can use `attributeOptions` property for this column. An example of using client validation is listed below:

```php
<?= TabularInput::widget([
    'models' => $models,
    'form' => $form,
    'attributeOptions' => [
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnChange' => false,
        'validateOnSubmit' => true,
        'validateOnBlur' => false,
    ],
    'columns' => [
        [
            'name' => 'id',
            'type' => TabularColumn::TYPE_HIDDEN_INPUT
        ],
        [
            'name' => 'title',
            'title' => 'Title',
            'type' => TabularColumn::TYPE_TEXT_INPUT,
            'attributeOptions' => [
                'enableClientValidation' => true,
                'validateOnChange' => true,
            ],
            'enableError' => true
        ],
        [
            'name' => 'description',
            'title' => 'Description',
        ],
    ],
]) ?>

```

In the example above we use client validation for column `title` and ajax validation for column `description`.
As you can noticed we also enabled `validateOnChange` for column `title` thus you can use all client-side options from the `ActiveField` class.


