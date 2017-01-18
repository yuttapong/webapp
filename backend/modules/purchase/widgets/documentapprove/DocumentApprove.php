<?php
namespace backend\modules\purchase\widgets\documentapprove;

use common\siricenter\thaiformatter\ThaiDate;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/**
 * Created by Yuttapong Napikun
 * Email : yuttaponk@gmail.com
 * Date: 17/1/2017
 * Time: 14:04
 */
class DocumentApprove extends \yii\base\Widget
{
    const TYPE_VIEW = 1;
    const  TYPE_APPROVE = 2;

    public $url;
    public $textStatus = [
        'active' => '&#10003;',
        'inactive' => '&#9632;'
    ];

    public  $type;

    public $users = [];
    public $approved = [];
    public $options = [];
    public $dataStatus = [];
    public $currentLogin = null;

    public $icons = [
        'pending' => '&#128591;',
        'success' => '&#128526;',
        'cancel' => '&#128586; ',
    ];


    public function init()
    {
        $this->approved = [184];
        if (empty($this->dataStatus)) {
            $this->dataStatus = [ -1 => 'ไม่อนุมัติ', 1 => 'อนุมัติ'];
        }

        if( empty($this->type)) {
            $this->type = self::TYPE_VIEW;
        }
    }


    private function loadUser()
    {
        $html = '';
        if (!empty($this->users)) {
            $li = [];
            foreach ($this->users as $key => $user) {
                $item = '';
                $remark = '';
                if (!in_array($user['id'], $this->approved)) {
                    $isApprove = false;
                    $signText = Html::a($this->icons['pending'] . ' คลิกที่นี่..เพื่ออนุมัติ', $this->url, [
                        'id' => 'list-approve-link-' . $key,
                        'data-user' => $user['id'],
                        'data-seq' => $key + 1,
                        'class' => 'noomy-link-approve',
                        'data-toggle' => 'modal',
                        'data-target' => '#list-approve-modal',
                    ]);
                    $signText = '<span class="text-status-pending">รออนุมัติ</span>';
                    $signDate = '';
                } else {
                    $isApprove = true;
                    $signText = $this->icons['success'] . ' Approved';
                    $signDate = ThaiDate::widget([
                        'timestamp' => time(),
                        'showTime' => false,
                        'type' => ThaiDate::TYPE_MEDIUM
                    ]);
                }
                $item .= Html::tag('div', $signText);
                $item .= Html::tag('div', null, ['class' => 'line-dashed']);
                $item .= Html::beginTag('p');
                $item .= Html::tag('div', $user['name']);
                $item .= Html::tag('div', '('.$user['position'].')');
                $item .= Html::tag('div', $signDate);
                $item .= Html::tag('div', 'อนุมัติ ' . ($key + 1), ['class' => 'badge']);

                if($this->type == self::TYPE_APPROVE && $user['id'] == $this->currentLogin) {
                    if($isApprove === false) {
                        $item .= Html::beginTag('div',['class' => 'well']);
                        $item .= Html::hiddenInput("approver[$key][id]", $user['id']);
                        $item .= Html::radioList("approver[$key][status]", null,  $this->dataStatus);
                        $item .= Html::tag('div',
                            Html::textarea("approver[$key][remark]", $remark, [
                                'class' => 'form-control',
                                'placeholder' => 'หมายเหตุ...',
                            ])
                        );
                        $item .= Html::tag('div', Html::button('Save', [
                            'class' => 'btn btn-xs btn-primary btn-block noomy-btn-approve',
                            'data-key' => $key
                        ]));
                        $item .= Html::endTag('div');
                    }
                }

                $item .= Html::endTag('p');
                $li[] = $item;
            }

            $modal = Modal::widget([
                'id' => 'list-approve-modal',
            ]);
            $modal .= 'noom';
            $html .= Html::ul($li, [
                'encode' => false,
                'class' => 'list-approve'
            ]);
        }

        return Html::tag('div', $html . $modal, $this->options);
    }

    public function run()
    {
        $view = $this->getView();
        DocumentApproveAsset::register($view);
        return $this->loadUser();

    }


    public function registerClientScript()
    {
        $view = $this->getView();
    }


}