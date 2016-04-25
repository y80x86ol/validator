<?php

/*
 * 验证助手类
 */

class validatorHandler {

    /**
     * 简单option参数处理
     * @param string $name  验证名
     * @param array $option 验证名属性
     * @return array
     */
    public static function getOption($name, $option = array()) {
        //获取初始化数据
        $msg = isset($option['msg']) ? $option['msg'] : '';
        $attribute = isset($option['attribute']) ? $option['attribute'] : '';
        $attributeName = $attribute ? $attribute : $name;

        return array($attributeName, $msg);
    }

    /**
     * 获取错误消息
     * @param string $name  验证名
     * @param string $attribute 验证名属性
     * @param string $msg   错误消息
     * @param array $params 参数
     * @return string
     */
    public static function getMessage($name, $attribute, $msg, $params) {
        $option = array(
            'attribute' => $attribute,
            'msg' => $msg,
        );
        //获取转化后的别名和错误消息
        list($newAttribute, $newMsg) = self::getOption($name, $option);

        if ($newMsg) {
            $errorMsg = str_replace('{attribute}', $newAttribute, $newMsg);
            //正则匹配出需要替换的参数
            $msgParams = self::getMsgParams($msg);

            foreach ($msgParams as $item) {
                if (isset($params[$item])) {
                    $errorMsg = str_replace('{' . $item . '}', $params[$item], $errorMsg);
                }
            }
        } else {
            $errorMsg = $newAttribute . '返回错误';
        }

        return $errorMsg;
    }

    /**
     * 获取错误消息的可替换参数
     * @param string $msg   错误消息
     * @return array
     */
    private static function getMsgParams($msg) {
        $params = array();

        $regex = '{[\w]+}';
        if (preg_match_all($regex, $msg, $matchs)) {
            if (is_array($matchs) && isset($matchs[0])) {
                $params = $matchs[0];
            }
        }

        return $params;
    }

}
