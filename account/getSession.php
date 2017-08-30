<?php
/**
 * Created by PhpStorm.
 * User: xuechao.ma
 * Date: 2017/8/9
 * Time: 下午6:09
 */
session_start();
require_once(__DIR__ . "/../mysql/index.php");
require_once(__DIR__ . "/./session.php");
require_once(__DIR__ . "/../function/send_json.php");
date_default_timezone_set('PRC');
$userid = session::get('userid');
//$userid = $_SESSION['userid']['data'];
$send = new send();
$mysql = new Mysql();
$_GET['all_user'] = '0cc6d7d5388f687e4148ba62ccbd3885';
if (isset($_GET['get'])) {
    $userInfo = null;
    $key = $_GET['get'];
    if ($key == '0cc6d7d5388f687e4148ba62ccbd3885') {
        $user_query = $mysql->field("username,email,regdate")->where("id='$userid'")->limit(1)->select("user");
        if (count($user_query) > 0) {
            $userInfo = $user_query[0];
            $status = 1;
            $msg = 'success';
        } else {
            $status = 0;
            $msg = '未登录，请登录后操作！';
        }
    } else {
        $status = 2;
        $msg = '非法操作！';
    }

    $send->_sendJson(['userInfo' => $userInfo, 'status' => $status, 'msg' => $msg]);
}else if(isset($_GET['all_user'])){
    //获取全部用户
    $key = $_GET['all_user'];
    if($key == '0cc6d7d5388f687e4148ba62ccbd3885'){
        $all_user = $mysql->field('id,username')->where("is_delete=0")->select("user");
        if(count($all_user)>0){
            $status = 1;
            $msg = 'success';
        }else{
            $status = 2;
            $msg = '数据获取异常';
        }
        $send->_sendJson(['all_user'=>$all_user, 'status' => $status, 'msg' => $msg]);
    }
}