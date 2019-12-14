<?php
class api_aes
{
    private static $aes_Key = "EqPEDFuJDRp7T8mdpauZF6FPWLrxieeJ";
    private static $aes_Method = "AES-128-ECB";
    private static $md5_Key = "uPP6287ZmsZg";
    private static $options = OPENSSL_RAW_DATA;

    static public function encrypt($str)
    {
        $data = openssl_encrypt($str,self::$aes_Method,self::$aes_Key,self::$options);
        return base64_encode($data);
    }

   static public function decrypt($str)
   {
       $result = openssl_decrypt(base64_decode($str),self::$aes_Method,self::$aes_Key,self::$options);
       return json_decode($result,true);
   }

   static public function md5_Encrypt($data)
   {
       return md5(json_encode($data).self::$md5_Key);
   }

}

