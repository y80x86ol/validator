<?php

/**
 * 目前只能验证post的form表单数据
 */
header("Content-type: text/html; charset=utf-8");
require dirname(__FILE__) . '/validate/validator.php';
$_POST['test_name'] = 45;


$input = array(
    'test_name' => '用户名'
);
$rules = array(
    'test_name' => 'required|maxlength;maxlength=2|int'
);
$messages = array(
    'test_name.required' => "必须填写用户名",
    'test_name.maxlength' => '用户名长度最大为:maxlength',
);
validator::make($input, $rules, $messages);

echo '所有数据验证通过';