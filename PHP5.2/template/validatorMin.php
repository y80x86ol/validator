<?php

/*
 * 最大长度验证类
 */
require_once dirname(dirname(__FILE__)) . '/validatorHandle.php';
require_once dirname(__FILE__) . '/validatorInterface.php';

class validatorMin implements validatorInterface {

    /**
     * 执行验证
     * @param array $input  所有验证
     * @param string $name  验证名
     * @param string $attribute 验证属性
     * @param array $param  参数
     * @param string $msg   错误消息
     * @return bool|string
     */
    public static function run($input, $name, $attribute, $param, $msg) {
        //获取错误消息
        $errorMsg = validatorHandle::getMessage($name, $attribute, self::defaultMsg($msg), $param);

        if (!isset($param['min'])) {
            die('min规则必须传递参数min');
        }
        //进行验证
        if (!in_array($input[$name], $param['min'])) {
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
            return '{attribute}最小长度为{min}';
        }
        return $msg;
    }

}
