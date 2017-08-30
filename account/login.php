<?php
/**
 * Created by PhpStorm.
 * User: xuechao.ma
 * Date: 2017/8/8
 * Time: 下午6:36
 */
session_start();
$lifeTime = 24 * 3600*30;//一个月

require_once(__DIR__."/../mysql/index.php");
require_once(__DIR__."/./session.php");
require_once(__DIR__."/../function/send_json.php");
$mysql = new Mysql();
$send = new send();

//登录
$data = $_POST['data'];
$username = htmlspecialchars($data['username']);
$password = MD5($data['password']);

//$password = $_POST['password'];
//$username = 'xuechao.ma';
//$password = '123456';
//echo $password;
//检测用户名及密码是否正确
$status = 0;
$msg = 0;
$check_query = $mysql->field('id')->where("`username`='$username' and `password`='$password'")->limit(1)->select('user');
if(count($check_query)==1) {
    //登录成功
    session::set('userid',$check_query[0]['id'],$lifeTime);
    session::set('username',$username,$lifeTime);
    $status =1;
    $msg = 'success';
}else{
    $msg ='该用户不存在';
}
$send->_sendJson(['status'=>$status,'msg'=>$msg])


?>