<?php

namespace backend\modules\api;

use Yii;
use yii\base\Module;

/**
 * api module definition class
 */
class ModuleAPI extends Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        //https://www.yiiframework.com/doc/guide/2.0/en/rest-authentication
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
    }
}
