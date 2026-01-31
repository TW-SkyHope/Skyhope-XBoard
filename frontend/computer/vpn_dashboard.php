<?php
session_start();
require_once dirname(__DIR__, 3) . '/config/db.php';
require_once dirname(__DIR__, 3) . '/library/mysql.php';

function verifySession() {
    if (!isset($_SESSION['auth']) || !is_array($_SESSION['auth'])) {
        return false;
    }

    $expectedToken = hash('sha256', 
        $_SESSION['auth']['username'] . 
        $_SERVER['HTTP_USER_AGENT']
    );

    if (!hash_equals($_SESSION['auth']['token'], $expectedToken)) {
        return false;
    }

    $db = new MySQLiPDO([
        'host' => DB_HOST,
        'port' => DB_PORT,
        'dbname' => DB_NAME,
        'username' => DB_USER,
        'password' => DB_PASS
    ]);

    $userExists = $db->count('user', ['name' => $_SESSION['auth']['username']]);
    return $userExists > 0;
}

if (!verifySession()) {
    session_unset();
    session_destroy();
    header('Location: /login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VPN 仪表盘</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e6f7ff;
            color: #333;
            min-height: 100vh;
            display: flex;
        }

        .dashboard {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 260px;
            padding: 20px;
        }

        .header {
            background-color: #ffffff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #d9f7ff;
        }

        .header h1 {
            font-size: 22px;
            color: #1890ff;
        }

        .content {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid #d9f7ff;
        }

        .card h2 {
            font-size: 18px;
            color: #1890ff;
            margin-bottom: 10px;
        }

        .card p {
            color: #595959;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <?php include dirname(__DIR__, 2) . '/component/sidebar.php'; ?>

    <div class="dashboard">
        <header class="header">
            <h1>VPN 仪表盘</h1>
        </header>

        <div class="content">
            <div class="card">
                <h2>欢迎回来！</h2>
                <p>您当前有 8 个在线隧道，总流量为 2.5 GB。</p>
            </div>

            <div class="card">
                <h2>订阅信息</h2>
                <p>当前订阅：高级版</p>
                <p>已使用流量：500 MB / 2000 MB</p>
            </div>

            <div class="card">
                <h2>系统公告</h2>
                <p>系统将在本周五凌晨进行维护，期间服务可能会短暂中断。</p>
            </div>
        </div>
    </div>
</body>

</html>