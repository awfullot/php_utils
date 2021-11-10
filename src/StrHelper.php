<?php

/**
 * 字符处理助手类
 * @author awfullot <752605040@qq.com>
 */

namespace awfullot\utils;


class StrHelper
{
    /**
     * 生成唯一数字
     * @return string eg: YYYYMMDDHHIISSNNNNNNNNCC 24位
     */
    public static function uniqueNum()
    {
        //格式主体（YYYYMMDDHHIISSNNNNNNNN）
        $main = date('YmdHis') . rand(10000000, 99999999);
        $len = strlen($main);
        $sum = 0;
        for ($i = 0; $i < $len; $i++) {
            $sum += (int)(substr($main, $i, 1));
        }
        $str = $main . str_pad((100 - $sum % 100) % 100, 2, '0', STR_PAD_LEFT);
        return $str;
    }

    /**
     * 给手机中间四位加*号
     *
     * @param string $str 手机号
     * @return string
     */
    public static function asteriskMobile($str)
    {
        return substr($str, 0, 3) . '*****' . substr($str, 8, strlen($str));
    }

    /**
     * 给身份证中间四位加*号
     *
     * @param string $idcard 身份证号
     * @return string
     */
    public function asteriskIdcard($idcard)
    {         
        return strlen($idcard) == 15 ? substr_replace($idcard, "****", 8, 5) : (strlen($idcard) == 18 ? substr_replace($idcard, "****", 8, 7) : "");
    }

    /**
     * 给真实姓名第一个字加*号
     *
     * @param string $realname 真实姓名
     * @return string
     */
    public static function asteriskRealname($realname){      
        return "*" . mb_substr($realname, 1);
    }

    /**
     * 生成唯一的 guid
     * @return string  eg: 08178533-5ca4-6194-5745-607197a47faa
     */
    public static function guid()
    {
        if (function_exists('com_create_guid')) {
            return trim(com_create_guid(), '{}');
        } else {
            mt_srand((double)microtime() * 1000000);
            $charid = md5(uniqid(rand(), true));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12);
            return $uuid;
        }
    }

    /**
     * 随机字长度的随机字符串
     * @param int $length 长度
     * @param string $type 类型
     * @return string 随机字符串
     */
    public static function random($length = 6, $type = 'string')
    {
        $config = array(
            'number' => '1234567890',
            'letter' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'string' => 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
            'all' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        );
        if (!isset($config[$type]))
            $type = 'string';
        $string = $config[$type];
        $code = '';
        $strlen = strlen($string) - 1;
        for ($i = 0; $i < $length; $i++) {
            $code .= $string{mt_rand(0, $strlen)};
        }
        return $code;
    }

    /**
     * 富文本数据转换文本
     *
     * @param string $content 富文本数据
     * @return string 不包含标签的文本
     */
    public static function formatRichtext($content = '')
    {
        //把一些预定义的 HTML 实体转换为字符
        $formatData_01 = htmlspecialchars_decode($content);
        //函数剥去字符串中的 HTML、XML 以及 PHP 的标签,获取纯文本内容
        $formatData_02 = strip_tags($formatData_01);
        return $formatData_02;
    }

    /**
     * 字符串截取
     *
     * @param string $string 欲截取的字符串
     * @param int $sublen 截取的长度
     * @param int $start 从第几个字节截取
     * @param string $suffix 拼接的后缀
     * @param string $code 字符编码
     * @return string
     */
    public static function cutstr($string, $sublen, $start = 0, $suffix = '..', $code = 'UTF-8')
    {
        if ($code == 'UTF-8') {
            $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
            preg_match_all($pa, $string, $t_string);
            if (count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen)) . $suffix;
            return join('', array_slice($t_string[0], $start, $sublen));
        } else {
            $start = $start * 2;
            $sublen = $sublen * 2;
            $strlen = strlen($string);
            $tmpstr = '';
            for ($i = 0; $i < $strlen; $i++) {
                if ($i >= $start && $i < ($start + $sublen)) {
                    if (ord(substr($string, $i, 1)) > 129) {
                        $tmpstr .= substr($string, $i, 2);
                    } else {
                        $tmpstr .= substr($string, $i, 1);
                    }
                }
                if (ord(substr($string, $i, 1)) > 129) $i++;
            }
            if (strlen($tmpstr) < $strlen) $tmpstr .= "";
            return $tmpstr;
        }
    }
}