<?php
class cjttc extends base_model{
	
	function __construct() {
		parent::__construct();
	}

    public function cj($url,$type) {
		$data = array();
        $cookie = '';
        $data = $datas = array();
        $info = $this->za->curlPost($url, array(), 3, 5, $cookie, array(), '', 1);//抓取网页内容
        $datas = json_decode($info,TRUE);
        //print_r($datas);exit;
        if(isset($datas['returnCode']) and $datas['returnCode'] == 0 and !empty($datas['returnData']['rows']['dataTD'])){
            switch($type){
                case "common":
                    $data = $this->common($datas);
                    break;
                case "lhc":
                    $data = $this->lhc($datas);
                    break;
            }
        }
		$datas = array(
			'data' => array_slice($data,0,50,true),
			'yid' => 7,
		);
		return $datas;
	}  

	//通用采集规则
	private function common($datas){
        $data = array();
        foreach($datas['returnData']['rows']['dataTD'] as $k => $v){
            //循环每个数据块再用正则取出对应数据组成统一的数据格式
            $code = explode(",", $v['kjnumber']);
            foreach($code as $haoma_k => $haoma_v){
                $code[$haoma_k] = intval($haoma_v);
            }
            $new_code = implode(",", $code);
            $open_time = strtotime(date("Y", $_SERVER['time']).'-'.$v['kjtime'].':00');
            if($open_time > $_SERVER['time']){
                $open_time = strtotime(intval(date("Y", $_SERVER['time'])-1).'-'.$v['kjtime'].':00');
            }
            $data[$v['qishu']] = array(
                'haoma' => $new_code,//开奖号码最后一位为特码
                'time' => $open_time,
            );
        }
        return $data;
    }

    //六合彩
    private function lhc($datas){
        $data = array();
        foreach($datas['returnData']['rows']['dataTD'] as $k => $v){
            //循环每个数据块再用正则取出对应数据组成统一的数据格式
            $code = explode(",", $v['kjnumber']['number']);
            foreach($code as $haoma_k => $haoma_v){
                $code[$haoma_k] = intval($haoma_v);
            }
            $new_code = implode(",", $code);
            $open_time = strtotime(date("Y", $_SERVER['time']).'-'.$v['kjtime'].':00');
            if($open_time > $_SERVER['time']){
                $open_time = strtotime(intval(date("Y", $_SERVER['time'])-1).'-'.$v['kjtime'].':00');
            }
            $data[$v['qishu']] = array(
                'haoma' => $new_code,//开奖号码最后一位为特码
                'time' => $open_time,
            );
        }
        return $data;
    }
}
?>