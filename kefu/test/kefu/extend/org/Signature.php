<?php
/**
 * Created by PhpStorm.
 * User: huangping
 * Date: 2019/3/6
 * Time: 8:00 PM
 */

namespace org;
class Signature
{
    public function doSignMd5($data, $key = '')
    {
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string = self::ToUrlParams($data);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $key;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    protected function ToUrlParams($data)
    {
        $buff = "";
        foreach ($data as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }
}