<?php
namespace backend\components;

use yii\base\BootstrapInterface;

/**
 * Class ModuleBootstrap
 *
 * @package app\extensions
 */
class ModuleBootstrap implements BootstrapInterface
{
    /**
     * @param \yii\base\Application $oApplication
     */
    public function bootstrap($oApplication)
    {
        $aModuleList = $oApplication->getModules();

        foreach ($aModuleList as $sKey => $aModule) {
            if (is_array($aModule) && strpos($aModule['class'], 'backend\modules') === 0) {
                $sFilePathConfig = FILE_PATH_ROOT . DS . 'modules' . DS . $sKey . DS . 'config' . DS . '_routes.php';

                if (file_exists($sFilePathConfig)) {
                    $oApplication->getUrlManager()->addRules(require($sFilePathConfig));
                }
            }
        }
    }
}