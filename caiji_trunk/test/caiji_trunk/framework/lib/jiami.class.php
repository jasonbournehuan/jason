<?php
class jiami { 
     function en($key){ 
        $arrStr='?_M6<wEenu]"C9lQ2Yj}\'mK;8UyasVZ\=b`*hD45p[RH(or@Tx,%.f)ctqgN|F1:I~!>L-z{0^3/G#*BWk$PA&iO7JXdSv+';
		$pa= "";
		$arr=str_split($arrStr);
		$passwordarr=str_split($key);
		foreach($passwordarr as $pk=>$pv){
			foreach($arr as $k=>$v){
				if($v == $pv){
					$k = substr(strval($k+100),1,2);
					$pa .= $k;
				}
			}
		}
		return $pa;
     }

	 function de($key){ 
        $arrStr='?_M6<wEenu]"C9lQ2Yj}\'mK;8UyasVZ\=b`*hD45p[RH(or@Tx,%.f)ctqgN|F1:I~!>L-z{0^3/G#*BWk$PA&iO7JXdSv+';
		$pa= "";
		$arr=str_split($arrStr);
		$passwordarr=str_split($key, 2);
		foreach($passwordarr as $pk=>$pv){
			$pv = intval($pv);
			$pa .= $arr[$pv];
		}
		return $pa;
     }
}
?>