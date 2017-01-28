<?php
namespace backend\modules\purchase\widgets\documentapprove;

use common\siricenter\thaiformatter\ThaiDate;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Created by Yuttapong Napikun
 * Email : yuttaponk@gmail.com
 * Date: 17/1/2017
 * Time: 14:04
 */
class DocumentApprove extends \yii\base\Widget
{
    const TYPE_ADD = 1;
    const TYPE_APPROVE = 2;

    public $url;

    public $model;
    public $attribute;
    public $type;

    public $users = [];
    public $approved = [];
    public $options = [];
    public $dataStatus = [];
    public $currentLogin = null;

    //สถาะเอกสารที่อนุญาตให้แสดงฟอร์มอนมัติ
    public $statusCanApprove;


    public $icon = [
        'pending' => '&#128591;',
        'approved' => '&#128526;',
        'rejected' => '&#128586; ',
    ];

    public $bgColor = [
        'pending' => '',
        'approved' => '#b6ffc9',
        'rejected' => '#ffaab1; ',
    ];


    private $_dataStatus = [];
    private $_statusItem = [];


    public function init()
    {
        $this->url = Url::to($this->url);
        if (empty($this->dataStatus)) {
            $this->dataStatus = [
                'rejected' => 'rejected',
                'approved' => 'approved'
            ];
        }

        if (empty($this->statusCanApprove)) {
            $this->statusCanApprove = ['pending', 'processing'];
        }


        if (empty($this->type)) {
            $this->type = self::TYPE_ADD;
        }

        $this->_statusItem = [
            $this->dataStatus['rejected'] => 'ไม่อนุมัติ',
            $this->dataStatus['approved'] => 'อนุมัติ',
        ];


    }

    public function run()
    {
        $view = $this->getView();
        DocumentApproveAsset::register($view);
        if ($this->type == self::TYPE_ADD) {
            return $this->formAdd();
        }
        if ($this->type == self::TYPE_APPROVE) {
            return $this->formApprove();
        }

    }

    private function formAdd()
    {
        $html = '';
        if (!empty($this->users)) {
            foreach ($this->users as $key => $user) {
                $id = isset($user['id']) ? $user['id'] : null;
                $user_id = isset($user['user_id']) ? $user['user_id'] : null;
                $approve_status = isset($user['approve_status']) ? $user['approve_status'] : null;
                $approve_date = isset($user['approve_date']) ? $user['approve_date'] : null;
                $item = '';


                $signSeq = 'อนุมัติ ' . ($key + 1);
                $signText = '<span class="text-status-pending">Waiting</span>';
                $signDate = '';
                $bgColor = '';
                $classBg = 'bg-pending';

                // status :: approved
                if (in_array($id, $this->approved) && $approve_status == $this->dataStatus['approved']) {
                    $signText = Html::tag('div', $this->icon['approved'] . $this->_statusItem['approved'], ['class' => 'text-approved']);
                    $signDate = ThaiDate::widget([
                        'timestamp' => $approve_date,
                        'showTime' => false,
                        'type' => ThaiDate::TYPE_MEDIUM
                    ]);
                    $bgColor = $this->bgColor['approved'];
                    $classBg = 'bg-approved';
                }

                // status :: rejected
                if (in_array($id, $this->approved) && $approve_status == $this->dataStatus['rejected']) {
                    $signText = Html::tag('div', $this->icon['rejected'] . $this->_statusItem['rejected'], ['class' => 'text-rejected']);
                    $signDate = ThaiDate::widget([
                        'timestamp' => $approve_date,
                        'showTime' => false,
                        'type' => ThaiDate::TYPE_MEDIUM
                    ]);
                    $bgColor = $this->bgColor['rejected'];
                    $classBg = 'bg-rejected';
                }


                // input
                $item .= Html::activeInput('hidden', $this->model, "{$this->attribute}[$key][id]", ['value' => $id]);
                $item .= Html::activeInput('hidden', $this->model, "{$this->attribute}[$key][seq]", ['value' => $key + 1]);
                $item .= Html::activeInput('hidden', $this->model, "{$this->attribute}[$key][user_id]", ['value' => $user_id]);
                $item .= Html::activeInput('hidden', $this->model, "{$this->attribute}[$key][name]", ['value' => $user['name']]);
                $item .= Html::activeInput('hidden', $this->model, "{$this->attribute}[$key][position]", ['value' => $user['position']]);
                $item .= Html::activeInput('hidden', $this->model, "{$this->attribute}[$key][approve_date]", ['value' => $approve_date]);
                $item .= Html::activeInput('hidden', $this->model, "{$this->attribute}[$key][approve_status]", ['value' => $approve_status]);

                // text
                $item .= Html::beginTag('div', ['class' => 'item']);

                $item .= Html::tag('div', $signText);
                $item .= Html::tag('div', null, ['class' => 'line-dashed']);
                $item .= Html::beginTag('p');
                $item .= Html::tag('div', $user['name'], ['class' => 'name']);
                $item .= Html::tag('div', '(' . $user['position'] . ')', ['class' => 'position']);
                $item .= Html::tag('div', $signDate, ['class' => 'date']);
                $item .= Html::tag('div', $signSeq, ['class' => 'seq']);
                $item .= Html::endTag('p');
                $item .= Html::endTag('div');
                $html .= Html::tag('div', $item, ['class' => 'list-approve', 'align' => 'center']);
            }
        }

        return Html::tag('div', $html, $this->options);
    }

    private function formApprove()
    {
        $html = '';
        if (!empty($this->users)) {

            foreach ($this->users as $key => $user) {
                $seq = $key + 1;
                $id = isset($user['id']) ? $user['id'] : null;
                $approve_status = isset($user['approve_status']) ? $user['approve_status'] : null;
                $approve_date = isset($user['approve_date']) ? $user['approve_date'] : null;
                $item = '';
                $remark = isset($user['comment']) ? $user['comment'] : null;

                $signText = '<span class="text-status-pending">Waiting</span>';
                $signDate = '';
                $bgColor = '';
                $classBg = 'bg-pending';

                // status :: approved
                if (in_array($user['id'], $this->approved) && $approve_status == $this->dataStatus['approved']) {
                    $signText = Html::tag('div', $this->icon['approved'] . $this->_statusItem['approved'], ['class' => 'text-approved']);
                    $signDate = ThaiDate::widget([
                        'timestamp' => $approve_date,
                        'showTime' => false,
                        'type' => ThaiDate::TYPE_MEDIUM
                    ]);
                    $bgColor = $this->bgColor['approved'];
                    $classBg = 'bg-approved';
                }

                // status :: rejected
                if (in_array($user['id'], $this->approved) && $approve_status == $this->dataStatus['rejected']) {
                    $signText = Html::tag('div', $this->icon['rejected'] . $this->_statusItem['rejected'], ['class' => 'text-rejected']);
                    $signDate = ThaiDate::widget([
                        'timestamp' => $approve_date,
                        'showTime' => false,
                        'type' => ThaiDate::TYPE_MEDIUM
                    ]);
                    $bgColor = $this->bgColor['rejected'];
                    $classBg = 'bg-rejected';
                }


                $item .= Html::beginTag('div', [
                    'class' => 'item ' . $classBg,
                    // 'style'=>'background-color:'.$bgColor
                ]);
                $item .= Html::tag('div', $signText);
                $item .= Html::tag('div', null, ['class' => 'line-dashed']);
                $item .= Html::beginTag('p');
                $item .= Html::tag('div', $user['name'], ['class' => 'name']);
                $item .= Html::tag('div', '(' . $user['position'] . ')', ['class' => 'position']);
                $item .= Html::tag('div', $signDate, ['class' => 'date']);
                $item .= Html::tag('div', 'อนุมัติ ' . ($key + 1), ['class' => 'seq badge']);
                if ($remark != '') {
                    $item .= Html::tag('div', 'หมายเหตุ: ' . $remark, ['class' => 'text-info']);
                }


                if ($this->type == self::TYPE_APPROVE && ($user['user_id'] == $this->currentLogin)) {
                    if ($approve_status == $this->dataStatus['pending'] && in_array($this->model->approve_status, $this->statusCanApprove)) {
                        $item .= Html::beginForm($this->url, 'post', ['id' => 'form-approve-' . $key]);
                        $item .= Html::hiddenInput("approver[{$key}][id]", $id);
                        $item .= Html::hiddenInput("approver[{$key}][document]", $this->model->id);
                        $item .= Html::hiddenInput("approver[{$key}][user_id]", $user['user_id']);
                        $item .= Html::hiddenInput("approver[{$key}][url]", $this->url);
                        $item .= Html::hiddenInput("approver[{$key}][seq]", $seq);
                        $item .= Html::hiddenInput("approver[{$key}][position]", $user['position']);
                        $item .= Html::hiddenInput("approver[{$key}][name]", $user['name']);
                        $item .= Html::radioList("approver[{$key}][status]", $approve_status, $this->_statusItem);
                        $item .= Html::tag('div',
                            Html::textInput("approver[{$key}][remark]", $remark, [
                                'class' => 'form-control',
                                'placeholder' => 'หมายเหตุ...',
                            ])
                        );
                        $item .= Html::tag('div', Html::button('Save', [
                            'class' => 'btn btn-xs btn-primary btn-block noomy-btn-approve',
                            'data-key' => $key
                        ]));
                        $item .= Html::endForm('div');

                    }
                }
                $item .= Html::endTag('p');
                $item .= Html::endTag('div');
                $html .= Html::tag('div', $item, ['class' => 'list-approve', 'align' => 'center']);
            }
        }


        return Html::tag('div', $html, $this->options);
    }

    public function registerClientScript()
    {
        $view = $this->getView();
    }


}