<?php

/*
 * 整形验证类
 */
require_once dirname(dirname(__FILE__)) . '/validatorHander.php';

class validatorInt {

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
     * 验证参数是否为整数
     */
    public static function validate($name, $option = array()) {
        //获取初始化数据
        list($attribute, $msg) = validatorHandler::getOption($name, $option);

        //进行数据校验
        //$result = filter_input(INPUT_POST, $name, FILTER_VALIDATE_INT);
        $result = is_int($_POST[$name]);
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
