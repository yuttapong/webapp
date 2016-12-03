<?php
/**
 * Created by PhpStorm.
 * User: Noom
 * Date: 31-Jul-16
 * Time: 8:13 PM
 */
namespace backend\modules\recruitment\models;


class ResumeWorkflow implements \raoul2000\workflow\source\file\IWorkflowDefinitionProvider
{
    public function getDefinition()
    {
        return [
            'initialStatusId' => RcmAppForm::STATUS_APPLY,
            'status' => [
                RcmAppForm::STATUS_APPLY => [
                    'transition' => [RcmAppForm::STATUS_CANCELED, RcmAppForm::STATUS_PENDING]
                ],
                RcmAppForm::STATUS_PENDING => [
                    'transition' => [RcmAppForm::STATUS_CANCELED, RcmAppForm::STATUS_PASSED, RcmAppForm::STATUS_NOT_PASSED]
                ],
                RcmAppForm::STATUS_PASSED => [
                    'transition' => [RcmAppForm::STATUS_CANCELED, RcmAppForm::STATUS_NOT_PASSED, RcmAppForm::STATUS_APPLY]
                ],
                RcmAppForm::STATUS_NOT_PASSED => [
                    'transition' => [RcmAppForm::STATUS_CANCELED, RcmAppForm::STATUS_PASSED, RcmAppForm::STATUS_APPLY]
                ]
            ]
        ];
    }
}