<?php

namespace awfullot\utils;

/**
 * 数据处理助手类
 * @author awfullot <752605040@qq.com>
 */

class DataHelper
{

    /**
     * 对象数据转数组数据
     * @param $object  //对象数据
     * @return array
     */
    public function object2array($object): array
    {
        if(!is_object($object)) {
            return $object;
        }
        $array = array();
        foreach ($object as $key => $value) {
            $array[$key] = is_object($value) ? $this->object2array($value) : $value;
        }
        return $array;
    }

    /**
     * 将数组组装成XML格式
     * @param $params
     * @return bool|string
     */
    public static function data2Xml( $params )
    {
        if(!is_array($params)|| count($params) <= 0)
        {
            return false;
        }
        $xml = "<xml>";
        foreach ($params as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * 将xml转为array
     * @param $xml
     * @return false|mixed
     */
    public static function xml2Data($xml): bool
    {
        if(!$xml){
            return false;
        }
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /**
     * 仿ThinkPhP dump()函数，使得打印输出数据更加规范好看
     * @param $param
     * @param bool $echo
     * @param null $label
     * @param int $flags
     * @param false $IS_CLI
     * @return string|void
     */
    public static function dump($param, $echo = true, $label = null, $flags = ENT_SUBSTITUTE, $IS_CLI=false): string
    {
        $label = (null === $label) ? '' : rtrim($label) . ':';
        ob_start();
        var_dump($param);
        $output = ob_get_clean();
        $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
        if ($IS_CLI) {
            $output = PHP_EOL . $label . $output . PHP_EOL;
        } else {
            if (!extension_loaded('xdebug')) {
                $output = htmlspecialchars($output, $flags);
            }
            $output = '<pre>' . $label . $output . '</pre>';
        }
        if ($echo) {
            echo($output);
            return '';
        } else {
            return $output;
        }
    }
}