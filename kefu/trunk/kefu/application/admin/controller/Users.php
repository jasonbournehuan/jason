<?php
namespace app\admin\controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Users extends Base
{
    private $map;
    public function _initialize()
    {
        parent::_initialize();
        if($this->get_uid() > 1){
            $this->map = ['group_id' => $this->get_group_id()];
        }

    }
    // 客服列表
    public function index()
    {
        if(request()->isAjax()){
            $map = [];
            if($this->get_uid() > 1){
                $map['admin_id'] = $this->get_uid();
            }
            $user_name = input('searchText');
            $paginate = input('pageSize');
            if(!empty($user_name))
            {
                $result = db('users')->where($map)->where('user_name','like','%'.$user_name.'%' )->order('id', 'asc')->select();

            }else{
                $result = db('users')->where($map)->where($this->map)->order('id', 'asc')->paginate($paginate)->all();
            }

            foreach($result as $key=>$vo){
                // 优化显示头像
                $result[$key]['user_avatar'] = '<img src="' . $vo['user_avatar'] . '" width="40px" height="40px">';

                // 优化显示状态
                if(1 == $vo['status']){
                    $result[$key]['status'] = '<span class="label label-primary">启用</span>';
                }else{
                    $result[$key]['status'] = '<span class="label label-danger">禁用</span>';
                }

                // 查询分组
                $result[$key]['group'] = '-';
                $groups = db('groups')->field('name')->where('id', $vo['group_id'])->find();
                if(!empty($groups)){
                    $result[$key]['group'] = $groups['name'];
                }

                // 优化显示在线状态
                /*if(1 == $vo['online']){
                    $result[$key]['online'] = '<span class="label label-primary">在线</span>';
                }else{
                    $result[$key]['online'] = '<span class="label label-danger">离线</span>';
                }*/

                // 生成操作按钮
                $result[$key]['operate'] = $this->makeBtn($vo['id']);
            }

            $return['total'] = db('users')->where($map)->count();  //总数据
            $return['rows'] = $result;

            return json($return);

        }

        return $this->fetch();
    }

    // 添加客服
    public function addUser()
    {
        if(request()->isPost()){

            $param = input('post.');
            unset($param['file']); // 删除layui头像上传隐藏字段
            // 检测头像
            if(empty($param['user_avatar'])){
                return json(['code' => -1, 'data' => '', 'msg' => '请上传头像']);
            }

            if($this->get_uid() > 1){
                $param['group_id'] = $this->get_group_id();
            }

            $param['admin_id'] = $this->get_uid();
            $has = db('users')->field('id')->where('user_name', $param['user_name'])->find();
            if(!empty($has)){
                return json(['code' => -2, 'data' => '', 'msg' => '该客服已经存在,请改用其他名字']);
            }
            if(!empty($param['group_id'])){
                $count = db('users')->where('group_id', $param['group_id'])->count();
                $kf_size = db('groups')->where('id', $param['group_id'])->value('kf_size');
                if($count >= $kf_size){
                    return json(['code' => -2, 'data' => '', 'msg' => '您的客服数过多，如需添加请联系管理员']);
                }
            }

            $param['user_pwd'] = md5($param['user_pwd'] . config('salt'));
            $param['online'] = 2; // 离线状态

            try{
                db('users')->insert($param);
            }catch(\Exception $e){
                return json(['code' => -3, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '添加客服成功']);
        }

        $groups = db('groups')->select();

        $this->assign([
            'status' => config('kf_status'),
            'groups' => $groups
        ]);

        return $this->fetch();
    }

    // 编辑客服
    public function editUser()
    {
        if(request()->isAjax()){

            $param = input('post.');
            unset($param['file']); // 删除layui头像上传隐藏字段

            // 检测用户修改的用户名是否重复
            $has = db('users')->where($this->map)->where('user_name', $param['user_name'])->where('id', '<>', $param['id'])->find();
            if(!empty($has)){
                return json(['code' => -1, 'data' => '', 'msg' => '该客服已经存在']);
            }

            // 修改用户头像
            if(empty($param['user_avatar'])){
                unset($param['user_avatar']);
            }

            // 修改用户密码
            if(empty($param['user_pwd'])){
                unset($param['user_pwd']);
            }else{
                $param['user_pwd'] = md5($param['user_pwd'] . config('salt'));
            }

            try{
                db('users')->where($this->map)->where('id', $param['id'])->update($param);
            }catch(\Exception $e){
                return json(['code' => -2, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '编辑客服成功']);
        }

        $id = input('param.id/d');
        $info = db('users')->where('id', $id)->find();

        $this->assign([
            'info' => $info,
            'status' => config('kf_status'),
            'groups' => db('groups')->select()
        ]);
        return $this->fetch();
    }

    // 删除客服
    public function delUser()
    {
        if(request()->isAjax()){
            $id = input('param.id/d');

            try{
                db('users')->where($this->map)->where('id', $id)->delete();
            }catch(\Exception $e){
                return json(['code' => -1, 'data' => '', 'msg' => $e->getMessage()]);
            }

            return json(['code' => 1, 'data' => '', 'msg' => '删除客服成功']);
        }
    }

    // 上传客服头像
    public function upAvatar()
    {
        if(request()->isAjax()) {

            $file = request()->file('file');
            if (!empty($file)) {
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    $src = '/uploads' . '/' . date('Ymd') . '/' . $info->getFilename();
                    return json(['code' => 0, 'data' => ['src' => $src], 'msg' => 'ok']);
                } else {
                    // 上传失败获取错误信息
                    return json(['code' => -1, 'data' => '', 'msg' => $file->getError()]);
                }
            }
        }
    }

    // 点赞
    public function praise()
    {
        if(request()->isAjax()){

            // 所有的客服
            $users = db('users')->where($this->map)->field('id,user_name')->select();
            $userArr = [];
            $kfs = [];
            foreach($users as $key=>$vo){

                $kfs[] = $vo['id'];

                $userArr[$vo['id']]['user_id'] = $vo['id'];
                $userArr[$vo['id']]['user_name'] = $vo['user_name'];
                $userArr[$vo['id']]['star0'] = 0; // 未评价
                $userArr[$vo['id']]['star1'] = 0; // 非常不满意
                $userArr[$vo['id']]['star2'] = 0; // 不满意
                $userArr[$vo['id']]['star3'] = 0; // 一般
                $userArr[$vo['id']]['star4'] = 0; // 满意
                $userArr[$vo['id']]['star5'] = 0; // 非常满意
            }

            $start = input('param.start', date('Y-m') . '-01');
            $end = input('param.end', date('Y-m-d'));

            $result = db('praise')->where('kf_id', 'in', $kfs)->where('add_time', '>=', $start)->where('add_time', '<=', $end . ' 23:59:59')->select();
            foreach($result as $key=>$vo) {
                if(isset($userArr[$vo['kf_id']])) {

                    switch ($vo['star']) {
                        case 0:
                            $userArr[$vo['kf_id']]['star0'] += 1;
                            break;
                        case 1:
                            $userArr[$vo['kf_id']]['star1'] += 1;
                            break;
                        case 2:
                            $userArr[$vo['kf_id']]['star2'] += 1;
                            break;
                        case 3:
                            $userArr[$vo['kf_id']]['star3'] += 1;
                            break;
                        case 4:
                            $userArr[$vo['kf_id']]['star4'] += 1;
                            break;
                        case 5:
                            $userArr[$vo['kf_id']]['star5'] += 1;
                            break;
                    }
                }
            }

            $returnUser = [];
            foreach($userArr as $vo) {
                $total = $vo['star5'] + $vo['star4'] + $vo['star3'] + $vo['star2'] + $vo['star1'];
                if(0 == $total) {
                    $vo['percent'] = '0%';
                }else {
                    $vo['percent'] = round(($vo['star5'] + $vo['star4']) / $total * 100, 2) . '%';
                }

                $returnUser[] = $vo;
            }

            $return['total'] = count($userArr);  //总数据
            $return['rows'] = $returnUser;

            return json($return);

        }

        $this->assign([
            'start' => date('Y-m') . '-01',
            'end' => date('Y-m-d')
        ]);

        return $this->fetch();
    }

    // 点赞
    public function export()
    {
        // 所有的客服
        $users = db('users')->where($this->map)->field('id,user_name')->select();
        $userArr = [];
        $kfs = [];
        foreach($users as $key=>$vo){

            $kfs[] = $vo['id'];

            $userArr[$vo['id']]['user_id'] = $vo['id'];
            $userArr[$vo['id']]['user_name'] = $vo['user_name'];
            $userArr[$vo['id']]['star0'] = 0; // 未评价
            $userArr[$vo['id']]['star1'] = 0; // 非常不满意
            $userArr[$vo['id']]['star2'] = 0; // 不满意
            $userArr[$vo['id']]['star3'] = 0; // 一般
            $userArr[$vo['id']]['star4'] = 0; // 满意
            $userArr[$vo['id']]['star5'] = 0; // 非常满意
        }

        $start = input('param.start', date('Y-m') . '-01');
        $end = input('param.end', date('Y-m-d'));

        $result = db('praise')->where('kf_id', 'in', $kfs)->where('add_time', '>=', $start)->where('add_time', '<=', $end . ' 23:59:59')->select();
        foreach($result as $key=>$vo) {
            if(isset($userArr[$vo['kf_id']])) {

                switch ($vo['star']) {
                    case 0:
                        $userArr[$vo['kf_id']]['star0'] += 1;
                        break;
                    case 1:
                        $userArr[$vo['kf_id']]['star1'] += 1;
                        break;
                    case 2:
                        $userArr[$vo['kf_id']]['star2'] += 1;
                        break;
                    case 3:
                        $userArr[$vo['kf_id']]['star3'] += 1;
                        break;
                    case 4:
                        $userArr[$vo['kf_id']]['star4'] += 1;
                        break;
                    case 5:
                        $userArr[$vo['kf_id']]['star5'] += 1;
                        break;
                }
            }
        }

        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', '客服名称')
            ->setCellValue('B1', '未评估')
            ->setCellValue('C1', '非常满意')
            ->setCellValue('D1', '满意')
            ->setCellValue('E1', '一般')
            ->setCellValue('F1', '不满意')
            ->setCellValue('G1', '非常不满意')
            ->setCellValue('H1', '满意率');

        $i = 2;
        foreach($userArr as $vo) {

            $total = $vo['star5'] + $vo['star4'] + $vo['star3'] + $vo['star2'] + $vo['star1'];
            if(0 == $total) {
                $percent = '0%';
            }else {
                $percent = round($vo['star5'] / $total * 100, 2) . '%';
            }

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $vo['user_name'])
                ->setCellValue('B' . $i, $vo['star0'])
                ->setCellValue('C' . $i, $vo['star5'])
                ->setCellValue('D' . $i, $vo['star4'])
                ->setCellValue('E' . $i, $vo['star3'])
                ->setCellValue('F' . $i, $vo['star2'])
                ->setCellValue('G' . $i, $vo['star1'])
                ->setCellValue('H' . $i, $percent);

            $i++;
        }

        $title = $start . '--' . $end;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '-single.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    // 总体客服分析
    public function praiseAll()
    {
        if(request()->isAjax()){

            $start = input('param.start', date('Y-m') . '-01');
            $end = input('param.end', date('Y-m-d'));
            $base = [
                0 => ['title' => '未评估', 'star_total' => 0, 'percent' => '0%'],
                1 => ['title' => '非常不满意', 'star_total' => 0, 'percent' => '0%'],
                2 => ['title' => '不满意', 'star_total' => 0, 'percent' => '0%'],
                3 => ['title' => '一般', 'star_total' => 0, 'percent' => '0%'],
                4 => ['title' => '满意', 'star_total' => 0, 'percent' => '0%'],
                5 => ['title' => '非常满意', 'star_total' => 0, 'percent' => '0%']
            ];

            $users = db('users')->where($this->map)->field('id,user_name')->select();
            $kfs = [];
            foreach($users as $key=>$vo){
                $kfs[] = $vo['id'];
            }

            $result = db('praise')->where('kf_id', 'in', $kfs)->field('count(*) as star_total, star')->where('add_time', '>=', $start)
                ->where('add_time', '<=', $end . ' 23:59:59')
                ->group('star')->order('star desc')->select();

            $total = 0;
            foreach($result as $key => $vo) {
                if(array_key_exists($vo['star'], $base)) {
                    $base[$vo['star']]['star_total'] = $vo['star_total'];
                }

                $total += $vo['star'];
            }

            foreach($base as $key => $vo) {
                if(0 != $total) {
                    $base[$key]['percent'] = round($vo['star_total'] / $total * 100, 2) . '%';
                }
            }

            $return['total'] = 5;  //总数据
            $return['rows'] = $base;

            return json($return);

        }

        $this->assign([
            'start' => date('Y-m') . '-01',
            'end' => date('Y-m-d')
        ]);

        return $this->fetch();
    }

    // 导出总体分析
    public function exportall()
    {
        $start = input('param.start', date('Y-m') . '-01');
        $end = input('param.end', date('Y-m-d'));
        $base = [
            0 => ['title' => '未评估', 'star_total' => 0, 'percent' => '0%'],
            1 => ['title' => '非常不满意', 'star_total' => 0, 'percent' => '0%'],
            2 => ['title' => '不满意', 'star_total' => 0, 'percent' => '0%'],
            3 => ['title' => '一般', 'star_total' => 0, 'percent' => '0%'],
            4 => ['title' => '满意', 'star_total' => 0, 'percent' => '0%'],
            5 => ['title' => '非常满意', 'star_total' => 0, 'percent' => '0%']
        ];

        $users = db('users')->where($this->map)->field('id,user_name')->select();
        $kfs = [];
        foreach($users as $key=>$vo){
            $kfs[] = $vo['id'];
        }

        $result = db('praise')->where('kf_id', 'in', $kfs)->field('count(*) as star_total, star')->where('add_time', '>=', $start)
            ->where('add_time', '<=', $end . ' 23:59:59')
            ->group('star')->order('star desc')->select();

        $total = 0;
        foreach($result as $key => $vo) {
            if(array_key_exists($vo['star'], $base)) {
                $base[$vo['star']]['star_total'] = $vo['star_total'];
            }

            $total += $vo['star'];
        }

        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', '服务质量类型')
            ->setCellValue('B1', '对话量')
            ->setCellValue('C1', '所占比例');

        $i = 2;
        foreach($base as $key => $vo) {
            if(0 != $total) {
                $percent = round($vo['star_total'] / $total * 100, 2) . '%';
            }

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $vo['title'])
                ->setCellValue('B' . $i, $vo['star_total'])
                ->setCellValue('C' . $i, isset($percent) ?  $percent : "");

            $i++;
        }

        $title = $start . '--' . $end;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '-all.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    // 生成按钮
    private function makeBtn($id)
    {
        $operate = '<a href="' . url('users/edituser', ['id' => $id]) . '">';
        $operate .= '<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-paste"></i> 编辑</button></a> ';

        $operate .= '<a href="javascript:userDel(' . $id . ')"><button type="button" class="btn btn-danger btn-sm">';
        $operate .= '<i class="fa fa-trash-o"></i> 删除</button></a> ';

        //$operate .= '<a href="javascript:;">';
        //$operate .= '<button type="button" class="btn btn-info btn-sm"><i class="fa fa-institution"></i> 详情</button></a>';

        return $operate;
    }
}