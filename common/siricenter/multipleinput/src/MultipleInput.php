<?php

/**
 * @link https://github.com/unclead/yii2-multiple-input
 * @copyright Copyright (c) 2014 unclead
 * @license https://github.com/unclead/yii2-multiple-input/blob/master/LICENSE.md
 */

namespace common\siricenter\multipleinput\src;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\InputWidget;
use yii\db\ActiveRecordInterface;
/*
use unclead\multipleinput\renderers\TableRenderer;
use unclead\multipleinput\renderers\RendererInterface;
*/
use common\siricenter\multipleinput\src\renderers\TableRenderer;
use common\siricenter\multipleinput\src\renderers\RendererInterface;

/**
 * Widget for rendering multiple input for an attribute of model.
 *
 * @author Eugene Tupikov <unclead.nsk@gmail.com>
 */
class MultipleInput extends InputWidget
{
    const POS_HEADER = RendererInterface::POS_HEADER;
    const POS_ROW = RendererInterface::POS_ROW;
    const POS_FOOTER = RendererInterface::POS_FOOTER;

    /**
     * @var ActiveRecordInterface[]|array[] input data
     */
    public $data = null;

    /**
     * @var array columns configuration
     */
    public $columns = [];

    /**
     * @var integer maximum number of rows
     */
    public $max;

    /**
     * @var array client-side attribute options, e.g. enableAjaxValidation. You may use this property in case when
     * you use widget without a model, since in this case widget is not able to detect client-side options
     * automatically.
     */
    public $attributeOptions = [];

    /**
     * @var array the HTML options for the `remove` button
     */
    public $removeButtonOptions;

    /**
     * @var array the HTML options for the `add` button
     */
    public $addButtonOptions;

    /**
     * @var bool whether to allow the empty list
     */
    public $allowEmptyList = false;

    /**
     * @var bool whether to guess column title in case if there is no definition of columns
     */
    public $enableGuessTitle = false;

    /**
     * @var int minimum number of rows
     */
    public $min;

    /**
     * @var string|array position of add button.
     */
    public $addButtonPosition;

    /**
     * @var array|\Closure the HTML attributes for the table body rows. This can be either an array
     * specifying the common HTML attributes for all body rows, or an anonymous function that
     * returns an array of the HTML attributes. It should have the following signature:
     *
     * ```php
     * function ($model, $index, $context)
     * ```
     *
     * - `$model`: the current data model being rendered
     * - `$index`: the zero-based index of the data model in the model array
     * - `$context`: the MultipleInput widget object
     *
     */
    public $rowOptions = [];

    /**
     * @var string the name of column class. You can specify your own class to extend base functionality.
     * Defaults to `unclead\multipleinput\MultipleInputColumn`
     */
    public $columnClass;

    /**
     * @var string the name of renderer class. Defaults to `unclead\multipleinput\renderers\TableRenderer`.
     * @since 1.4
     */
    public $rendererClass;

    /**
     * @var bool whether the widget is embedded or not.
     * @internal this property is used for internal purposes. Do not use it in your code.
     */
    public $isEmbedded;

    /**
     * @var ActiveForm an instance of ActiveForm which you have to pass in case of using client validation
     * @since 2.1
     */
    public $form;

    /**
     * Initialization.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if ($this->form !== null && !$this->form instanceof ActiveForm) {
            throw new InvalidConfigException('Property "form" must be an instance of yii\widgets\ActiveForm');
        }

        $this->guessColumns();
        $this->initData();

        parent::init();
    }

    /**
     * Initializes data.
     */
    protected function initData()
    {
        if ($this->data !== null) {
            return;
        }

        if ($this->value !== null) {
            $this->data = $this->value;
            return;
        }

        if ($this->model instanceof Model) {
            $data = $this->model->hasProperty($this->attribute)
                ? ArrayHelper::getValue($this->model, $this->attribute, [])
                : [];

            foreach ((array)$data as $index => $value) {
                $this->data[$index] = $value;
            }
        }
    }

    /**
     * This function tries to guess the columns to show from the given data
     * if [[columns]] are not explicitly specified.
     */
    protected function guessColumns()
    {
        if (empty($this->columns)) {
            $column = [
                'name' => $this->hasModel() ? $this->attribute : $this->name,
                'type' => MultipleInputColumn::TYPE_TEXT_INPUT
            ];

            if ($this->enableGuessTitle && $this->hasModel()) {
                $column['title'] = $this->model->getAttributeLabel($this->attribute);
            }
            $this->columns[] = $column;
        }
    }

    /**
     * Run widget.
     */
    public function run()
    {
        return $this->createRenderer()->render();
    }

    /**
     * @return TableRenderer
     */
    private function createRenderer()
    {
        $config = [
            'id' => $this->options['id'],
            'columns' => $this->columns,
            'min' => $this->min,
            'max' => $this->max,
            'attributeOptions' => $this->attributeOptions,
            'data' => $this->data,
            'columnClass' => $this->columnClass !== null ? $this->columnClass : MultipleInputColumn::className(),
            'allowEmptyList' => $this->allowEmptyList,
            'addButtonPosition' => $this->addButtonPosition,
            'rowOptions' => $this->rowOptions,
            'context' => $this,
            'form' => $this->form
        ];

        if ($this->removeButtonOptions !== null) {
            $config['removeButtonOptions'] = $this->removeButtonOptions;
        }

        if ($this->addButtonOptions !== null) {
            $config['addButtonOptions'] = $this->addButtonOptions;
        }

        $config['class'] = $this->rendererClass ?: TableRenderer::className();

        return Yii::createObject($config);
    }
}