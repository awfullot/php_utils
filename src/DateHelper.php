<?php

namespace awfullot\utils;

/**
 * 日期助手类
 * @author awfullot <752605040@qq.com>
 */
class DateHelper
{

    /**
     * 格式化UNIX时间戳为人易读的字符串
     *
     * @param int $remote 时间戳
     * @param mixed $local 本地时间
     * @return string
     */
    public static function humanen($remote, $local = null)
    {
        $timediff = (is_null($local) || $local ? time() : $local) - $remote;
        $chunks = array(
            array(60 * 60 * 24 * 365, '年'),
            array(60 * 60 * 24 * 30, '月'),
            array(60 * 60 * 24 * 7, '周'),
            array(60 * 60 * 24, '天'),
            array(60 * 60, '小时'),
            array(60, '分钟'),
            array(1, '秒')
        );
        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            if (($count = floor($timediff / $seconds)) != 0) {
                break;
            }
        }
        return "{$count}{$name}前";
    }

    /**
     * 计算星座
     *
     * @param string $month 月份
     * @param string $day 日期
     * @return string
     */
    public function zodiac($month, $day)
    {
        // 检查参数有效性
        if ($month < 1 || $month > 12 || $day < 1 || $day > 31)
            return (false);
        // 星座名称以及开始日期
        $signs = array(
            array("20" => "水瓶座"),
            array("19" => "双鱼座"),
            array("21" => "白羊座"),
            array("20" => "金牛座"),
            array("21" => "双子座"),
            array("22" => "巨蟹座"),
            array("23" => "狮子座"),
            array("23" => "处女座"),
            array("23" => "天秤座"),
            array("24" => "天蝎座"),
            array("22" => "射手座"),
            array("22" => "摩羯座")
        );
        list($sign_start, $sign_name) = each($signs[(int)$month - 1]);
        if ($day < $sign_start)
            list($sign_start, $sign_name) = each($signs[($month - 2 < 0) ? $month = 11 : $month -= 2]);
        return $sign_name;
    }

    /**
     * 月份格式化
     *
     * @param int $m 月份
     * @param int $type 类型
     * @return string
     */
    public static function formatMonth($m, $type = 0)
    {
        if (($m < 1 || $m > 12) || ($type < 0 || $type > 2)) {
            return '';
        }
        $month = array(
            array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
            array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'),
            array('', '一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月')
        );
        return $month[$type][$m];
    }
}