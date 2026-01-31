<?php
// 数据库配置文件 - 由项目初始化向导生成
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'cs');
define('DB_USER', 'root');
define('DB_PASS', '1234');

// 创建PDO连接
try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}
?>