<?php

/*
 * 验证助手类
 */

namespace validator;

class validatorHandler {

    /**
     * 简单option参数处理
     * @param type $name
     * @param type $option
     * @return type
     */
    public static function getOption($name, $option = array()) {
        //获取初始化数据
        $msg = isset($option['msg']) ? $option['msg'] : '';
        $attribute = isset($option['attribute']) ? $option['attribute'] : '';
        $attributeName = $attribute ? $attribute : $name;

        return array($attributeName, $msg);
    }

}
