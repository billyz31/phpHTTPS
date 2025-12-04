<?php

use Workerman\Worker;
use Workerman\WebServer;
require_once __DIR__ . '/Workerman/Autoloader.php';
require_once __DIR__ . '/../app/lib/socket.php';
// 面板端口
$req_data = array('command'=>'access_ip','data'=>'');
$res = \Socket::request(json_encode($req_data));
$res = json_decode($res,true);
if(!isset($res['AccessToken'])){
        for($i=0;$i<10;$i++){
                sleep(1);
                $res = \Socket::request(json_encode($req_data));
                $res = json_decode($res,true);
                if(isset($res['AccessToken'])){
                        break;
                }
                $i++;
        }
}
$port = isset($res['PanelPort'])?(int)$res['PanelPort']:0;
$port = $port ? $port : '9080';

// SSL Config
$context = array();
if (file_exists('/www/ssl/xp_panel.crt') && file_exists('/www/ssl/xp_panel.key')) {
    $context = array(
        'ssl' => array(
            'local_cert'  => '/www/ssl/xp_panel.crt',
            'local_pk'    => '/www/ssl/xp_panel.key',
            'verify_peer' => false,
            'verify_peer_name' => false,
        )
    );
}

// 这里监听9080端口，如果要监听80端口，需要root权限，并且端口没有被其它程序占用    
$webserver = new WebServer('http://0.0.0.0:'.$port, $context);

if (!empty($context)) {
    $webserver->transport = 'ssl';
}

// 类似nginx配置中的root选项，添加域名与网站根目录的关联，可设置多个域名多个目录   
$webserver->addRoot('phpstudy.php.com', __DIR__ . '/../../');
// 设置开启多少进程
$cpucore = 1;
if(file_exists('cpucore')){
        $cpucore = (int)file_get_contents('cpucore');
        $cpucore = $cpucore > 0 ? $cpucore : 1;
}
$webserver->count = 2*$cpucore;
$webserver->server_set = $res;
Worker::runAll();
