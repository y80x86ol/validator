<?php

/**
 * 验证处理类
 * 
 * 可以进行POST、GET、REQUEST、自定义变量验证
 * 
 * @author Ken <695093513@qq.com>
 * @version 0.1
 */
class validator {

    public static $errors = array();

    /**
     * 进行验证
     * @param array $input
     * @param array $rules
     * @param array $messages
     */
    /**
     * 进行验证
     * @param array $input
     * @param array $rules
     * @param array $labels
     * @param array $messages
     */
    public static function make($input, $rules, $labels = array(), $messages = array()) {
        //1、解析rules
        $newRules = self::resolveRules($rules);

        //2、合并labels和rule
        foreach ($newRules as $key => $value) {
            if (isset($labels[$value['name']])) {
                $newRules[$key]['attribute'] = $labels[$value['name']];
            } else {
                $newRules[$key]['attribute'] = '';
            }
        }

        //3、校验rule是否存在并进行验证
        foreach ($newRules as $item) {
            foreach ($item['rule'] as $rule => $row) {
                $classValidator = 'validator' . ucfirst($rule);

                //动态加载，PHP5.3以下
                $validatorPath = dirname(__FILE__) . '/template/' . $classValidator . '.php';
                if (file_exists($validatorPath)) {
                    require_once $validatorPath;
                } else {
                    die("不存在的验证文件");
                }

                if (class_exists($classValidator)) {
                    $name = $item['name'];
                    $attribute = $item['attribute'];
                    $param = $row;
                    $msgName = $name . '.' . $rule;
                    $msg = isset($messages[$msgName]) ? $messages[$msgName] : '';

                    //PHP5.3以上才支持$class::$function的写法，所以这里采用call_user_func
                    //$result = $classValidator::run($input, $name, $attribute, $param, $msg);
                    $result = call_user_func(array($classValidator, 'run'), $input, $name, $attribute, $param, $msg);
                    if ($result) {
                        self::$errors[$name][] = $result;
                    }
                } else {
                    die("不存在的验证类");
                }
            }
        }
    }

    /**
     * 获取所有错误消息
     * @return type
     */
    public static function errors() {
        if (self::$errors) {
            return self::$errors;
        }
        return false;
    }

    /**
     * 获取单个错误消息
     * @param string $name
     * @return type
     */
    public static function get($name) {
        if (isset(self::$errors[$name])) {
            return self::$errors[$name];
        }
        return false;
    }

    /**
     * 获取第一个错误
     * @return type
     */
    public static function first() {
        if (self::$errors) {
            $firstError = reset(self::$errors);
            return $firstError[0];
        }
        return false;
    }

    /**
     * 判断某个参数是否具有错误
     * @param type $name
     * @return boolean
     */
    public static function has($name) {
        if (isset(self::$errors[$name])) {
            return true;
        }
        return false;
    }

    /**
     * 判断验证是否成功
     */
    public static function fails() {
        if (self::$errors) {
            return true;
        }
        return false;
    }

    /**
     * rule解析
     * @param array $rules 规则数组
     * @return array
     */
    private static function resolveRules($rules) {
        $newRules = array();
        foreach ($rules as $name => $item) {
            $param = array();
            $ruleArry = explode('|', $item);

            //循环处理rule
            foreach ($ruleArry as $row) {
                $newRow = explode(';', $row);
                if (count($newRow) > 1) {
                    //当数组大于1的时候，第一个值为rule名字，后面的为参数名字
                    $top = array_shift($newRow);
                    $param[$top] = array();
                    //循环处理参数
                    foreach ($newRow as $value) {
                        $keyValue = explode('=', $value);
                        if (empty($keyValue[0]) || empty($keyValue[1])) {
                            die('参数错误');
                        }
                        $param[$top][$keyValue[0]] = $keyValue[1];
                    }
                } else {
                    //只有一个值的时候，说明没有参数
                    $param[$row] = array();
                }
            }
            //重写组装为新数组
            $newRules[] = array(
                'name' => $name,
                'rule' => $param
            );
        }

        return $newRules;
    }

}
