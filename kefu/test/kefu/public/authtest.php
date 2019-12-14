<?php

/*
 *
 * 接口登陆测试文件
 *
 */

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

    public function ToUrlParams($data)
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

// access key 和 access secret 可以从后台获取到

$data = ['access_key'=> 'af4u2it2xlfp', 'timestamp'=> time()];

$access_secret = "r311w9u96tddj748ires7jn92hc02spu";

$signature = new Signature();

$sign = $signature->doSignMd5($data, $access_secret);

$url_query = "./admin/login/auth?" . $signature->ToUrlParams($data) . "&sign=" . $sign;

echo $url_query;

// 生成后可以直接跳转即可
// 例如
// 使用时注意注释掉上面的echo 信息。 因为header前面不能用任何输出
header("Location: " . $url_query);

