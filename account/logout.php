<?php
/**
 * Created by PhpStorm.
 * User: xuechao.ma
 * Date: 2017/8/10
 * Time: 下午3:31
 */
session_start();
require_once(__DIR__."/../mysql/index.php");
require_once(__DIR__."/./session.php");
require_once(__DIR__."/../function/send_json.php");
date_default_timezone_set('PRC');
$mysql = new Mysql();
$send = new send();

//注销登录
$logout =0;
if($_GET['action'] == "logout"){
    session::clear('userid');
//    unset($_SESSION['userid']);
//    unset($_SESSION['username']);
    $logout = 1;
    $msg = '注销成功';
}
$send->_sendJson(['logout'=>$logout]);
