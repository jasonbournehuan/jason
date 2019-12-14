<?php
class cjsina extends base_model{
	
	function __construct() {
		parent::__construct();
	}

    public function cj($url,$type) {
        $cookie = '';
        $data = $datas = array();
        $info = $this->za->curlPost($url, array(), 3, 5, $cookie, array(), '', 1);//抓取网页内容
        $info = str_replace(array('try{code(', ');}catch(e){};'), '', $info);
        $datas = json_decode($info,TRUE);
        if(!empty($datas['result']) and $datas['result']['status']['code'] == 0){
            switch ($type){
                case "dlt":
                    $data = $this->dlt($datas);
                    break;
                case "fc3d":
                    $data = $this->fc3d($datas);
                    break;
                case "ssq":
                    $data = $this->ssq($datas);
                    break;
            }
        }
        $datas = array(
            'data' => array_slice($data,0,50,true),
            'yid' => 6,
        );
        return $datas;
	}

    //大乐透
	private function dlt($datas){
        $data = array();
        foreach($datas['result']['data'] as $k => $v){
            //循环每个数据块再用正则取出对应数据组成统一的数据格式
            $code = explode(",", $v['red_result']);
            foreach($code as $haoma_k => $haoma_v){
                $code[$haoma_k] = intval($haoma_v);
            }
            $code1 = explode(",", $v['blue_result']);
            foreach($code1 as $haoma_k => $haoma_v){
                $code[] = intval($haoma_v);
            }
            $new_code = implode(",", $code);
            $data['20'.$v['issue_no']] = array(
                'haoma' => $new_code,//开奖号码最后两位为蓝色球
                'time' => strtotime($v['opentime']),
            );
        }
        return $data;
    }

    //福彩3D
    private function fc3d($datas){
        $data = array();
        foreach($datas['result']['data'] as $k => $v){
            //循环每个数据块再用正则取出对应数据组成统一的数据格式
            $code = explode(",", $v['open_result']);
            foreach($code as $haoma_k => $haoma_v){
                $code[$haoma_k] = intval($haoma_v);
            }
            $new_code = implode(",", $code);
            $data[$v['issue_no']] = array(
                'haoma' => $new_code,
                'time' => strtotime($v['opentime']),
            );
        }
        return $data;
    }

    //双色球
    private function ssq($datas){
        $data = array();
        foreach($datas['result']['data'] as $k => $v){
            //循环每个数据块再用正则取出对应数据组成统一的数据格式
            $code = explode(",", $v['red_result']);
            foreach($code as $haoma_k => $haoma_v){
                $code[$haoma_k] = intval($haoma_v);
            }
            $code[] = intval($v['blue_result']);
            $new_code = implode(",", $code);
            $data[$v['issue_no']] = array(
                'haoma' => $new_code,//开奖号码最后一位为蓝色球
                'time' => strtotime($v['opentime']),
            );
        }
        return $data;
    }
}
?>