<?php

/**
 * ToDo:验证所传参数进行验证
 */
header("Content-type: text/html; charset=utf-8");
require dirname(dirname(__FILE__)) . '/validator.php';

function single($name, $value) {
    //进行一堆验证
    return false;
}

$_POST['test_name'] = '2123123';
$_POST['test_name1'] = 'bbb';


$input = $_POST;
$rules = array(
    'test_name' => 'int|required|maxlength;maxlength=3|callback;callback=single|compare;name=test_name1',
    'sex' => 'required',
);
$labels = array(
    'test_name' => '用户名',
    'sex' => '性别'
);
$messages = array(
    //'test_name.int' => "用户名必须为整数",
    'test_name.maxlength' => '用户名长度最大为{maxlength}',
    'test_name.callback' => '我是测试回调',
);
validator::make($input, $rules, $labels, $messages);

if (validator::fails()) {
    $errors = validator::errors();
    print_r($errors);

    $first_error = validator::first();
    print_r($first_error);

    $get_error = validator::get('test_name');
    print_r($get_error);

    $has_error = validator::has('test_name');
    var_dump($has_error);

    die('出现了错误');
}

echo '所有数据验证通过';
