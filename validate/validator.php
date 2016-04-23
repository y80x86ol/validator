<?php

/*
 * 验证入口处理类
 */

class validator {

    public static function make($input, $rules, $messages) {
        //1、解析rules
        $newRules = self::resolveRules($rules);

        //2、合并input和rule
        $newInput = array();
        foreach ($input as $key => $item) {
            if (isset($newRules[$key])) {
                $rule = $newRules[$key];
            } else {
                $rule = '';
            }
            $newInput[] = array(
                'name' => $key,
                'attribute' => $item,
                'rule' => $rule
            );
        }

        //3、进行验证
        foreach ($newInput as $item) {
            foreach ($item['rule'] as $rule => $row) {
                $classValidator = 'validator' . ucfirst($rule);

                //动态加载，PHP5.3以下
                $validatorPath = dirname(__FILE__) . '/template/' . $classValidator . '.php';
                if (file_exists($validatorPath)) {
                    require_once $validatorPath;
                } else {
                    throw new Exception("不存在的验证文件");
                    //die("不存在的验证文件");
                }

                if (class_exists($classValidator)) {
                    $name = $item['name'];
                    $attribute = $item['attribute'];
                    $param = $row;
                    $msgName = $name . '.' . $rule;
                    $msg = isset($messages[$msgName]) ? $messages[$msgName] : '';

                    $validator = new $classValidator($name, $attribute, $param, $msg);
                    $validator->run();
                } else {
                    throw new Exception("不存在的验证类");
                    //die("不存在的验证类");
                }
            }
        }
    }

    /**
     * rule解析
     * @param type $rules
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
            $newRules[$name] = $param;
        }

        return $newRules;
    }

}
