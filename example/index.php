<?php

/**
 * ToDo:验证所传参数进行验证
 */
header("Content-type: text/html; charset=utf-8");

use validator\validator;

$_POST['test_name'] = 2;


$input = $_POST;
$rules = array(
    'test_name' => 'required|maxlength;maxlength=3|int',
    'age' => 'maxlength;maxlength=2|required',
    'sex' => 'required'
);
$labels = array(
    'test_name' => '用户名',
    'sex' => '性别'
);
$messages = array(
    'test_name.required' => "必须填写用户名",
    'test_name.maxlength' => '用户名长度最大为:maxlength',
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
