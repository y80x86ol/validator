<?php

/*
 * 请求验证类
 */
require_once dirname(dirname(__FILE__)) . '/validatorHander.php';

class validatorRequired {

    private $name;
    private $attribute;
    private $param;
    private $message;

    public function __construct($name, $attribute, $param, $message) {
        $this->name = $name;
        $this->attribute = $attribute;
        $this->param = $param;
        $this->message = $message;
    }

    public function run() {
        $option = array(
            'attribute' => $this->attribute,
            'msg' => $this->message,
        );

        $result = $this->validate($this->name, $option);
        if ($result) {
            echo $result;
            exit;
        }
    }

    /**
     * 验证参数是否为必须
     */
    public function validate($name, $option = array()) {
        //获取初始化数据
        list($attribute, $msg) = validatorHandler::getOption($name, $option);

        //进行数据校验
        if (!isset($_POST[$name])) {
            if ($msg) {
                $errorMsg = str_replace(':attribute', $attribute, $msg);
            } else {
                $errorMsg = '必须填写' . $attribute;
            }
        }
        return $errorMsg;
    }

}
