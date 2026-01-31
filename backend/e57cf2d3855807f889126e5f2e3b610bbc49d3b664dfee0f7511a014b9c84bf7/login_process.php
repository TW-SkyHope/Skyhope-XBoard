<?php
header('Content-Type: text/plain');
require_once dirname(__DIR__, 2) . '/config/db.php';
require_once dirname(__DIR__, 2) . '/library/mysql.php';

// 验证请求方法
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('false');
}

// 过滤输入数据
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$type = 1;

if (!$username || !$password) {
    die('false');
}

// 数据库验证
$db = new MySQLiPDO([
    'host' => DB_HOST,
    'port' => DB_PORT,
    'dbname' => DB_NAME,
    'username' => DB_USER,
    'password' => DB_PASS
]);

$user = $db->findOne('user', ['name' => $username], ['password']);
if (!$user || !isset($user['password'])) {
    die('false');
}

// 密码验证
if (hash_equals($user['password'], $password)) {
    // 记录登录日志到userloglogin表
    $logData = [
        'username' => $username,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'time' => date('Y-m-d H:i:s'),
        'type' => $type,
    ];
    $db->insert('userlog1', $logData);
    echo 'true';
} else {
    echo 'false';
}