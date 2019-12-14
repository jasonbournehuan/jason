<?php

class cjhg99 extends base_model
{

   function __construct()
   {
       parent::__construct();
   }

   public function cj($url,$method = "common")
   {
       $cookie = '';
       $data = $datas = array();
       $result = $this->za->curlPost($url, array(), 3, 5, $cookie, array(), '', 1);//抓取网页内容
       $str = '/<tbody id="J-chart-content" class="chart table-guides">(.*?)<\/tbody>/is';
       $str2 = '/<tr[\s\S]*?>(.*?)<\/tr>/is';
       preg_match_all($str,$result,$dat_list);
       if(!empty($dat_list[1][0]))
       {
           preg_match_all($str2,$dat_list[1][0],$result_list);
          $data = $this->$method($result_list);
       }
       $result_data = array(
           "data" => array_reverse(array_slice($data,0,50,true),true),
           "yid" => 10
       );
    return $result_data;

}


  public function common($result)
  {
      $data = array();
      foreach($result[1] as $key => $value)
      {
          preg_match_all('/<td[\s\S]*?>(.*?)<\/td>/is',$value,$td_data);
          if(!empty($td_data[1]))
          {
              preg_match_all('/<span[\s\S]*?>(.*?)<\/span>/is',$td_data[1][4],$haoma);
              if(!empty($haoma[1][0]))
              {
                  $data[$td_data[1][1]] = array(
                      "haoma" => $haoma[1][0],
                      "time" =>$_SERVER['time']);
              }
          }
      }
      return $data;
  }

    public function x5($result)
    {
        $data = array();
        foreach($result[1] as $key => $value)
        {
            preg_match_all('/<td[\s\S]*?>(.*?)<\/td>/is',$value,$td_data);
            if(!empty($td_data[1]))
            {
                preg_match_all('/<span[\s\S]*?>(.*?)<\/span>/is',$td_data[1][4],$haoma);
                if(!empty($haoma[1][0]))
                {
                    $data[substr($td_data[1][1],0,8).substr($td_data[1][1],9,4)] = array(
                        "haoma" => $haoma[1][0],
                        "time" =>$_SERVER['time']);
                }
            }
        }
        return $data;
    }




}