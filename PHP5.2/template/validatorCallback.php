<?php

/*
 * 回调函数验证类
 */
require_once dirname(dirname(__FILE__)) . '/validatorHander.php';

class validatorCallback {

    private $name;
    private $value;
    private $attribute;
    private $param;
    private $message;

    /**
     * 获取初始化数据
     * @param string $name  参数名
     * @param string $attribute 别名
     * @param array $param  参数数组
     * @param string $message   错误消息
     */
    public function __construct($name, $value, $attribute, $param, $message) {
        $this->name = $name;
        $this->value = $value;
        $this->attribute = $attribute;
        $this->param = $param;
        $this->message = $message;
    }

    /**
     * 执行验证
     */
    public function run() {
        $option = array(
            'attribute' => $this->attribute,
            'msg' => $this->message,
        );

        $result = $this->validate($this->name, $this->value, $this->param['callback'], $option);
        if ($result) {
            return $result;
        }
        return;
    }

    /**
     * 验证参数是否为整数
     * 
     * @param string $name  参数名
     * @param array $option 参数
     * @return string
     */
    public static function validate($name, $value, $callback, $option = array()) {
        //获取转化后的别名和错误消息
        list($attribute, $msg) = validatorHandler::getOption($name, $option);

        //执行回调函数
        $callcackResult = call_user_func($callback, $name, $value);

        //进行数据校验
        $errorMsg = false;
        if (!$callcackResult) {
            if ($msg) {
                $errorMsg = str_replace(':attribute', $attribute, $msg);
            } else {
                $errorMsg = $attribute . '返回失败';
            }
            return $errorMsg;
        }
    }

}
