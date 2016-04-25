<?php

/*
 * 整形验证类
 */
require_once dirname(dirname(__FILE__)) . '/validatorHander.php';
require_once dirname(__FILE__) . '/validatorInterface.php';

class validatorInt implements validatorInterface {

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
        $errorMsg = validatorHandler::getMessage($name, $attribute, self::defaultMsg($msg), $param);

        //进行验证
        $result = is_int($input[$name]);
        if (!$result) {
            return $errorMsg;
        }
        return false;
    }

    /**
     * 默认错误消息转换
     * @param string $msg
     * @return string
     */
    private static function defaultMsg($msg) {
        if (empty($msg)) {
            return '{attribute}必须为整数';
        }
        return $msg;
    }

}
