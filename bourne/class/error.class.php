<?php
//同一错误代码
class error{
	public function code($code){
		//除了成功返回status为1外，其他总共4位数字，1开头表示数据错误，2开头表示递交的信息错误，3开头表示接口程序错误，4开头表示接口超时
		//第2位数字表示接口类型，1为系统信息，2为用户类接口，3为资金类接口，4为游戏类接口，5为日志类接口，6为报表类接口
		//第3-4位数字表示错误信息
		$error_code = array(
			//一类错误
			'success' => array('status' => 1, 'money' => 0),
			'no_authority' => array('status' => 1101, 'msg' => '没有权限'),
			'pid_error' => array('status' => 1102, 'msg' => 'PID错误，平台不存在'),
			'gid_error' => array('status' => 1103, 'msg' => 'GID错误，游戏不存在'),
			'api_secret_error' => array('status' => 1104, 'msg' => 'api_secret错误'),
			'ip_error' => array('status' => 1105, 'msg' => '您的IP没有权限访问该接口'),
			'data_num_error' => array('status' => 1106, 'msg' => '请求数据数量错误，数量范围为1-1000'),
            'api_key_error' => array('status' => 1107, 'msg' => 'api_key错误'),
            'api_method_error' => array('status' => 1108, 'msg' => '方法不存在'),

			'user_nothing' => array('status' => 1201, 'msg' => '用户不存在'),
			'user_frozen' => array('status' => 1202, 'msg' => '用户被冻结'),
			'user_outlogin_error' => array('status' => 1203, 'msg' => '用户退出失败'),
			'user_outlogin_now' => array('status' => 1204, 'msg' => '用户已退出'),
			'user_notlogin_error' => array('status' => 1206, 'msg' => '用户未登录过'),

			'in_money_number_error' => array('status' => 1301, 'msg' => '转入金额必须大于0'),
			'out_money_number_error' => array('status' => 1302, 'msg' => '转出金额必须大于0'),
			'in_out_money_number_error' => array('status' => 1303, 'msg' => '转入转出金额必须大于0'),

			'game_nothingness' => array('status' => 1401, 'msg' => '游戏不存在'),
			'platform_nothingness' => array('status' => 1402, 'msg' => '平台不存在'),
			//二类错误
			'user_empty' => array('status' => 2101, 'msg' => '用户信息不能为空'),
			'site_empty' => array('status' => 2102, 'msg' => '网站ID不能为空'),
			'ip_no' => array('status' => 2103, 'msg' => 'IP未授权'),
			'time_format_error' => array('status' => 2104, 'msg' => '时间格式错误'),
			'parameters_error' => array('status' => 2105, 'msg' => '参数错误'),
			'time_range_error' => array('status' => 2106, 'msg' => '时间范围错误'),
			'uid_error' => array('status' => 2107, 'msg' => 'uid不能为空'),
			'uid_int_error' => array('status' => 2108, 'msg' => 'uid要为整数,不能超过11位数'),

			'order_id_error' => array('status' => 2301, 'msg' => '订单号错误'),
			'user_money_insufficient' => array('status' => 2302, 'msg' => '用户余额不足'),
			'money_not_integer' => array('status' => 2303, 'msg' => '操作金额必须为整数'),
			'amount_four_decimal' => array('status' => 2304, 'msg' => '操作金额最多四位小数'),
			'amount_mix' => array('status' => 2304, 'msg' => '操作金额不能小于1'),

			'no_game_id_error' => array('status' => 2401, 'msg' => '未递交游戏ID'),
			'no_shiwan_error' => array('status' => 2402, 'msg' => '该游戏不支持试玩'),

			//三类错误
			'reg_user_error' => array('status' => 3201, 'msg' => '账户开户失败'),
			'login_user_error' => array('status' => 3202, 'msg' => '账户登录失败'),
			'check_user_error' => array('status' => 3202, 'msg' => '账户查询失败'),

			'in_money_error' => array('status' => 3301, 'msg' => '转入资金失败'),
			'out_money_error' => array('status' => 3302, 'msg' => '转出资金失败'),
			'in_out_money_error' => array('status' => 3303, 'msg' => '平台资金操作失败'),
			'no_in_out_money_error' => array('status' => 3304, 'msg' => '转账方式不存在'),
			'in_out_money_progressive' => array('status' => 3305, 'msg' => '转账正在处理中'),
			'in_money_insufficient_balance' => array('status' => 3306, 'msg' => '平台资金不足'),

			'platform_maintain' => array('status' => 3401, 'msg' => '平台维护中'),
			'platform_error' => array('status' => 3402, 'msg' => '平台系统出错'),
			'game_maintain' => array('status' => 3403, 'msg' => '游戏维护中'),
			'platform_change_game_error' => array('status' => 3403, 'msg' => '平台结算中，转换游戏失败'),
			'platform_change_money_error' => array('status' => 3404, 'msg' => '平台结算中，转换金额失败'),
			//四类错误
			'time_out' => array('status' => 4000, 'msg' => '超时'),
			'transfer_time_out' => array('status' => 4301, 'msg' => '查询转账记录超时'),
			'get_user_money_out' => array('status' => 4302, 'msg' => '查询用户余额超时'),

			'demo_time_out' => array('status' => 4401, 'msg' => '申请试玩超时'),
			'get_game_time_out' => array('status' => 4402, 'msg' => '获取游戏超时'),
			'get_game_category_time_out' => array('status' => 4403, 'msg' => '获取游戏分类超时'),
			'in_money_login_time_out' => array('status' => 4404, 'msg' => '转入资金并登陆超时'),
			'out_money_login_time_out' => array('status' => 4405, 'msg' => '转出资金并登出超时'),

			'get_log_time_out' => array('status' => 4501, 'msg' => '获取日志超时'),
		);
        $error_code[$code] = isset($error_code[$code]) ? $error_code[$code] : array('status'=>9999,'msg'=>'not fount error');
		return $error_code[$code];
	}
}
?>