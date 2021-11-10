<?php

namespace awfullot\utils;

/**
 * 数组助手类
 * @author awfullot <752605040@qq.com>
 */
class ArrayHelper
{

    /**
     * 二维数组去重
     *
     * @param array $arr 数组
     * @param string $key 字段
     *
     * @return array
     */
    static public function arrayMultiUnique(array $arr, string $key = 'id'): array
    {
        $res = [];

        foreach ($arr as $value) {
            if (!isset($res[$value[$key]])) {
                $res[$value[$key]] = $value;
            }
        }

        return array_values($res);
    }
}