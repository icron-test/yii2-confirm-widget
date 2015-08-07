<?php

namespace icron\confirm;

use yii\base\Action;
use yii\base\InvalidParamException;
use yii\web\Response;
use Yii;

class ConfirmAction extends Action
{
    const METHOD_SEND = 'send';
    const METHOD_CONFIRM = 'confirm';
    const STATUS_ERROR = 'error';
    const STATUS_SUCCESS = 'success';

    public function run($method, $destination, $code = null)
    {
        $result = ['status' => self::STATUS_ERROR, 'message' => ''];
        switch ($method) {
            case self::METHOD_SEND:
                if ($this->getConfirm()->send($destination)) {
                    $result['status'] = self::STATUS_SUCCESS;
                }
                break;

            case self::METHOD_CONFIRM:
                // TODO check code
                if ($this->getConfirm()->confirm($destination, $code)) {
                    $result['status'] = self::STATUS_SUCCESS;
                }
                break;

            default:
                $result['status'] = self::STATUS_ERROR;
                $result['message'] = 'Unknown method.';
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    /**
     * @return Confirm
     */
    protected function getConfirm()
    {
        return \Yii::$app->confirm;
    }
}