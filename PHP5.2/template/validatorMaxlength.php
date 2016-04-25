<?php

/*
 * 最大长度验证类
 */
require_once dirname(dirname(__FILE__)) . '/validatorHander.php';

class validatorMaxlength {

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

        $maxlength = $this->param['maxlength'];
        $result = $this->validate($this->name, $this->value, $maxlength, $option);
        if ($result) {
            return $result;
        }
        return;
    }

    /**
     * 验证最大长度
     * @param type $name
     * @param type $maxlength
     * @param type $option
     * @return string
     */
    public function validate($name, $value, $maxlength, $option = array()) {
        //获取初始化数据
        list($attribute, $msg) = validatorHandler::getOption($name, $option);
        //进行数据校验
        $errorMsg = false;
        if (strlen($value) > $maxlength) {
            if ($msg) {
                //进行字符串替换
                $msg = str_replace(':attribute', $attribute, $msg);
                $errorMsg = str_replace(':maxlength', $maxlength, $msg);
            } else {
                //直接拼接
                $errorMsg = $attribute . '最大长度不能超过' . $maxlength;
            }
            return $errorMsg;
        }
    }

}
