<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 检查是否已登录
if (isset($_SESSION['auth']) && isset($_SESSION['auth']['token'])) {
    $expectedToken = hash('sha256', 
        $_SESSION['auth']['username'] . 
        $_SESSION['auth']['token'] . 
        $_SERVER['HTTP_USER_AGENT']
    );
    
    if (hash_equals($_SESSION['auth']['token'], $expectedToken)) {
        echo $this->renderLoginMessage(
            '检测到您已登录',
            '正在跳转至仪表盘页面...',
            'success'
        );
        header("refresh:1;url=dashboard.php");
        exit;
    }
}

require_once dirname(__DIR__, 3) . '/config/db.php';
require_once dirname(__DIR__, 3) . '/library/mysql.php';

// 获取动态路径ID
$db = new MySQLiPDO([
    'host' => DB_HOST,
    'port' => DB_PORT,
    'dbname' => DB_NAME,
    'username' => DB_USER,
    'password' => DB_PASS
]);

$pathId = $db->findOne('setdates', ['name' => 'ID'], ['value1']);
if (!$pathId || !isset($pathId['value1'])) {
    die("系统配置错误");
}

$hashedPathId = hash('sha256', $pathId['value1']);
$protocol = (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://');
$host = $_SERVER['HTTP_HOST'];
$loginUrl = $protocol . $host . "/{$hashedPathId}/login_process";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    
    if ($username && $password) {
        $hashedPassword = hash('sha256', $password);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $loginUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'username' => $username,
            'password' => $hashedPassword
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        if ($response === 'true') {
            $_SESSION['auth'] = [
                'username' => $username,
                'token' => hash('sha256', $username . $hashedPassword . $_SERVER['HTTP_USER_AGENT'])
            ];
            session_regenerate_id(true);
            
            echo renderLoginMessage(
                '登录成功',
                '正在跳转至仪表盘页面...',
                'success'
            );
            header("refresh:0.5;url=dashboard.php");
            exit;
        } else {
            echo renderLoginMessage(
                '登录失败',
                '用户名或密码错误，或账号不存在',
                'error'
            );
            header("refresh:0.5;url=/front/login");
            exit;
        }
    }
}

// 渲染登录状态消息的函数
function renderLoginMessage($title, $message, $type) {
    $color = $type === 'success' ? '#1a237e' : '#d32f2f';
    return <<<HTML
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录状态</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .status-card {
            width: 500px;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }
        .status-icon {
            font-size: 60px;
            color: $color;
            margin-bottom: 20px;
        }
        .status-title {
            font-size: 24px;
            color: $color;
            margin-bottom: 15px;
        }
        .status-message {
            font-size: 16px;
            color: #757575;
            margin-bottom: 30px;
        }
        .loading-bar {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            overflow: hidden;
        }
        .loading-progress {
            height: 100%;
            width: 100%;
            background: $color;
            animation: progress 0.5s linear;
        }
        @keyframes progress {
            from { width: 0; }
            to { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="status-card">
        <div class="status-icon">  
            <i class="fas fa-<?php $type === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
        </div>
        <h1 class="status-title">$title</h1>
        <p class="status-message">$message</p>
        <div class="loading-bar">
            <div class="loading-progress"></div>
        </div>
    </div>
</body>
</html>
HTML;
}
?>