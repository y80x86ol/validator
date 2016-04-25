<?php

/*
 * 整形验证类
 */

namespace validator\template;

use validator\validatorHandler;

class validatorInt {

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

        $result = $this->validate($this->name, $this->value, $option);
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
    public static function validate($name, $value, $option = array()) {
        //获取转化后的别名和错误消息
        list($attribute, $msg) = validatorHandler::getOption($name, $option);

        //进行数据校验
        //$result = filter_input(INPUT_POST, $name, FILTER_VALIDATE_INT);
        $result = is_int($value);
        if (!$result) {
            if ($msg) {
                $errorMsg = str_replace(':attribute', $attribute, $msg);
            } else {
                $errorMsg = $attribute . '必须为整数';
            }
            return $errorMsg;
        }
    }

}
