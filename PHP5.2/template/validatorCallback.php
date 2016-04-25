<?php

/*
 * 回调函数验证类
 */
require_once dirname(dirname(__FILE__)) . '/validatorHander.php';
require_once dirname(__FILE__) . '/validatorInterface.php';

class validatorCallback implements validatorInterface {

    /**
     * 执行验证
     * @param array $input  所有验证
     * @param string $name  验证名
     * @param string $attribute 验证属性
     * @param array $param  参数
     * @param string $msg   错误消息
     * @return type
     */
    public static function run($input, $name, $attribute, $param, $msg) {
        //获取错误消息
        $errorMsg = validatorHandler::getMessage($name, $attribute, $msg, $param);

        //执行回调函数
        $callcackResult = call_user_func($param['callback'], $name, $input[$name]);

        //进行验证
        if (!$callcackResult) {
            return $errorMsg;
        }
        return false;
    }

}
