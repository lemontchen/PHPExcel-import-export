<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 
 * @author 天呐
 *  导入导出管理
 */
class ImexController extends BaseController {

    /**
     * 报名信息导出
     */
    public function signupExport()
    {
        header("Content-Type: text/html;charset=utf-8");
        
        $savename = $event.'_'.$project.'_报名信息表('.date('Y-m-d').')';
        //加载类
        Vendor("PHPExcel.Excel#class");
        \Excel::export($signupList,$event_eight,$savename);
    }
    
    

    
    /**
     * 抽签：从后台导出报名信息，抽中以后，再从后台导入
     */
    public function signupDrawImport()
    {
        ignore_user_abort(true);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', 1048576000);
        $start_time = microtime(true);
        header("Content-Type: text/html;charset=utf-8");

        
        //获取报名信息
        $event_two = explode(',',$event_one);//字符串转成数组
        $event_three = array_filter($event_two);//过滤空数组
        //将一维数组转换成二维数组
        $event_four = array();
        foreach ($event_three as $k => $v) {
            $event_four[] = array('id' => $v);
        }
        //二维数组转一维数组
        $event_six = array();
        foreach ($event_five as $k => $v) {
            $event_six[] = $v['name'];
        }
        $field = 'id,eventid,projectid,number,'.$event_nine.',ordernumber,pay,paytime,money,sort,userid,addtime,status,codes';
        $event_seven = explode(',',$field);//字符串转成数组
        
        Vendor("PHPExcel.Excel#class");
        $data = \Excel::importDraw($event_seven);
        
        $count = count($data);
        $i = 0;
        //循环修改
        foreach ($data as $k => $v) {
            $res = M('')->where(array('id' => $v['id']))->setField('', $v['codes']);
            if ($res) {
                $i++;
            }
        }
        $msg =  '处理数据：' .$count. '条！成功数据：' .$i. '条！失败数据：' .($count - $i). '条！耗时：' .(microtime(true) - $start_time). '秒！';
        if ($data) {
            $this->success($msg, 'Admin/Imex/index');
        } else {
            $this->error('没有数据', 'Admin/Imex/index');
        }
    }
    
    /**
     * 
     * 凯撒日计数
     */
    function exceltime($days,$time=false)
    {
        if(is_numeric($days))
        {
            $jd = GregorianToJD(1, 1, 1970);
            $gregorian = JDToGregorian($jd+intval($days)-25569);
            $gregorian = strtotime($gregorian);
            //$gregorian = date("Y年m月d日",$gregorian);
            return $gregorian;
        }
        return $time;
    }
}