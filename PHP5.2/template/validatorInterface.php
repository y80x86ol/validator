<?php

/*
 * 验证接口类
 */

interface validatorInterface {

    public static function run($input, $name, $attribute, $param, $msg);
}
