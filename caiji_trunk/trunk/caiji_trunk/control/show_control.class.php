<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'control/common_control.class.php';

class show_control extends common_control {

	function __construct() {
		parent::__construct();


	}
    private $type = array(
        "10001"=>"北京赛车",
        "10002"=>"广东快乐十分",
        "10003"=>"广东11选5",
        "10004"=>"台湾宾果快乐8",
        "10005"=>"江苏快三",
        "10007"=>"重庆时时彩",
        "10008"=>"六合彩",
        "10009"=>"福彩双色球",
        "10010"=>"福彩3D",
        "10011"=>"福彩大乐透",
        "10012"=>"天津时时彩",
        "10013"=>"新疆时时彩",
        "10017"=>"湖北快三",
        "10018"=>"北京快三",
        "10019"=>"安徽快三",
        "10021"=>"幸运飞艇",
        "10023"=>"幸运农场",
        "10025"=>"幸运28",
        "10026"=>"江苏11选5",
        "10027"=>"江西11选5",
        "10028"=>"上海11选5",
        "10029"=>"山东11选5",
        "9999"=>"河内5分彩",
    );
	private $number = array(
	    "10"  => 10,
	    "15"  => 15,
	    "30"  => 30,
	    "50"  => 50,
	    "100"  => 100,
	    "5000"  => 5000,
    );
	//获得子端递交的数据进行存储和判断
	public function on_show(){
        // $result  =  $this->open->get("open-id-7713");
        if(!empty($_POST['number']))
        {
            $number = $_POST['number'];
        }else{
            $number = 15;
        }
        if(!empty($_POST['type']) && $_POST['type']!='')
        {
            $typeid = $_POST['type'];
            $result  =  $this->open->index_fetch(array(
                "typeid" => $typeid
            ),array("add_time" => 0),0,$number);
        }else
        {
            $result  =  $this->open->index_fetch("",array("add_time" => 0),0,$number);
        }

//               $this->assign("test",213213);
//               $this->view->display("show.htm");

        echo   '  
  
<style>
    .waterCon {
        padding-left: 50px;
    }
    .water-date > span {
        font-size: 14px;
        font-weight: bold; 
    }
    .content-bottom {
        padding: 30px 0 30px 0;
        min-width: 1000px;
        width: 1000px;
    }
    .bot-table {
        border-radius: 4px;
        overflow: hidden;
        width: 100%;
        color: #fff;
        font-size: 14px;
        text-align: center;
    }
    .bot-table thead {
        line-height: 32px;
        background-color: green;
    }
    .bot-table tbody tr {
        line-height: 48px;
    }
    .bot-table tbody tr.odd {
        background-color: #333;
    }
    .bot-table tbody tr.even {
        background-color: #4d4d4d;
    }
    .bot-table > tbody > tr > th:nth-child(2) {
        line-height: 22px;
    }
    .block {
        width: 1000px;
        text-align: center;
        margin-top: 20px;
    }
  .el-date-editor.el-input {
        width: 195px;
    }
</style>  
    <form  method="post" action=""   >
     <div class="water-date">
            <span>类别：</span>
            <select name="type" >';
              foreach($this->type as $key => $value)
              {
                  if(!empty($typeid) &&  $key == $typeid )
                  {
                      echo    '<option selected value="'.$key.'">'.$value.'</option> ';
                  }else{
                      echo    '<option  value="'.$key.'">'.$value.'</option> ';
                  }

              }
            echo  '</select>
           <select name="number" >';
              foreach($this->number as $key => $value  )
              {
                  if(!empty($number) && $number == $key)
                  {
                      echo   '<option value="'.$key.'" selected>'.$key.'</option> ';
                  }else
                  {
                      echo   '<option value="'.$key.'" >'.$key.'</option> ';
                  }

              }

            echo  '</select>
            <input type="submit" value="查询" />
        </div>
        </form>
    <div class="waterCon">
      
        <div class="content-bottom">
            <table class="bot-table" cellpadding="0" cellspacing="0">
                <thead v-if="info_list != \'\'">
                <tr>
                    <th width="176">彩种</th> <th width="176">期号</th><th width="176">时间</th><th width="176">开奖号码</th> 
                </tr>
                 ';
             foreach ($result  as $key => $value)
            {
              echo ' <tr> <th width="176">'. $this->type[$value['typeid']] .'</th> <th width="176">'. $value['qi'] .'</th><th width="176">'. date("Y-m-d H:i:s",$value['add_time']) .'</th><th width="176">'. $value['code'] .'</th> </tr>';
            }

            echo  '
                
                </thead>
                   
                </tbody>
            </table>
        
        </div> 
    </div> 
 ';






	}
}
?>