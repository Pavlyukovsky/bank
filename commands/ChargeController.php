<?php

namespace app\commands;

use app\services\CronService;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class ChargeController
 *
 * @package app\commands
 */
class ChargeController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex($message = 'hello world')
    {
        $cronService = new CronService();
        $cronService->process();

        return ExitCode::OK;
    }
}
