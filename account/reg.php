<?php
/**
 * Created by PhpStorm.
 * User: xuechao.ma
 * Date: 2017/8/8
 * Time: 下午6:39
 */
session_start();
error_reporting(E_ALL);
require_once(__DIR__ . "/../mysql/index.php");

require_once(__DIR__ . "/../function/send_json.php");
date_default_timezone_set('PRC');
//if(!isset($_POST['submit'])){
//    exit('非法访问!');
//}

$data = $_POST['data'];
$username = htmlspecialchars($data['username']);
$password = $data['password'];
$email = $data['email'];
$type = $data['type'];
$msg = 0;
$status = 0;
//注册信息判断
if (!preg_match('/^[\w\x80-\xff]{2,15}$/', $username)) {
    $msg = '错误：用户名应该为字母、数字、英文组合'.$username;
} else if (strlen($password) < 6) {
    $msg = '错误：请输入大于6位数的密码 。';
//} else if (!preg_match('/^w+([-+.]w+)*@w+([-.]w+)*.w+([-.]w+)*$/', $email)) {
//    $msg = '错误：电子邮箱格式错误。';

} else {
    //检测用户名是否已经存在
    $mysql = new Mysql();
    $check_query = $mysql->_doQuery("select id from user where username='$username' limit 1");
    if (count($check_query) == 1) {
        $msg = '错误：用户名 ' . $username . ' 已存在。';
    } else {
        //写入数据
        $password = MD5($password);
        $data['password'] = $password;
        $regdate = time();
        $insert_result = $mysql->insert('user', $data);
        if ($insert_result==1) {
//            '用户注册成功!';
            $status = 1;
            $check_id = $mysql->where("`username`='$username'")->select('user');
            $_SESSION['userid'] = $check_id[0]['id'];
        }
    }
}
$send = new send();
$send->_sendJson(['msg' => $msg, 'status' => $status,'insert_result'=>$insert_result,'check_id'=>$check_id])
?>