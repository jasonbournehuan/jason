<?php
class cjsdlnx extends base_model{

    function __construct()
    {
        parent::__construct();
    }


    public function cj($url,$method = "common")
    {
        $cookie = '';
        $data = $result_data  = array();
        $curl_data  = $this->za->curlPost($url, array(), 3, 5, $cookie, array(), '', 1);
        $curl_data = json_decode($curl_data,true);
        if(!empty($curl_data['list']))
        {
                    $data = $this->$method($curl_data['list']);
        }
       $result_data  = array(
           'data' => array_slice($data,0,50,true),
           'yid'  => 8,
       );
        return $result_data;
    }

    public function common($result)
    {
        $data = array();
        foreach($result as $key => $value)
        {
            $data[json_encode($value['period'])]  = array(
                'haoma' => $value['result'],
                'time' => strtotime($value['date']),
            );
        }
        return $data;
    }

    public function gdkl($result)
    {
        $data = array();

        foreach($result as $key => $value)
        {
            $data[substr($value['period'],0,8).sprintf('%03d',substr($value['period'],-2,9))]  = array(
                'haoma' => $value['result'],
                'time' => strtotime($value['date']),
            );
        }
        return $data;
    }




}



?>