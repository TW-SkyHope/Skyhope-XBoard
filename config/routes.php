<?php
require_once dirname(__DIR__, 1) . '/config/db.php';
require_once dirname(__DIR__, 1) . '/library/mysql.php';
try {
    $db = new MySQLiPDO([
        'host' => DB_HOST,
        'port' => DB_PORT,
        'dbname' => DB_NAME,
        'username' => DB_USER,
        'password' => DB_PASS
    ]);
    error_log("数据库连接成功");
} catch (Exception $e) {
    die("数据库连接失败: " . $e->getMessage());
}

$pathId = $db->findOne('setdates', ['name' => 'ID'], ['value1']);
if ($pathId != false) {
    $hashedPathId = hash('sha256', $pathId['value1']);
}else{
    $hashedPathId = 1;
}
$adminpath = $db->findOne('setdates', ['name' => 'ID'], ['value1']);
function detectDevice()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $mobileKeywords = array(
        'Mobile',
        'Android',
        'Silk/',
        'Kindle',
        'BlackBerry',
        'Opera Mini',
        'Opera Mobi',
        'iPhone',
        'iPad',
        'iPod',
        'webOS',
        'IEMobile',
        'Windows Phone'
    );

    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            return 'phone';
        }
    }

    return 'computer';
}

$state = detectDevice();

return [
    // 路由配置
    'routes' => [
        //前端
        '/index' => [
            'view' => 'frontend/computer/user/login.php'
        ],
        '/front/login' => [
            'view' => 'frontend/computer/user/login.php'
        ],
        '/front/loginpc' => [
            'view' => 'frontend/computer/user/logincp.php'
        ],
        '/panel/list' => [
            'view' => 'frontend/computer/user/list.php'
        ],
        '/panel/stats' => [
            'view' => 'frontend/computer/user/stats.php'
        ],
        '/panel/package' => [
            'view' => 'frontend/computer/user/package.php'
        ],
        '/panel/help' => [
            'view' => 'frontend/computer/user/help.php'
        ],
        '/panel/user' => [
            'view' => 'frontend/computer/user/user.php'
        ],
        '/install' => [
            'view' => 'frontend/install.php'
        ],
        '/admin' => [
            'view' => 'frontend/computer/admin/dashboard.php'
        ],
        //后端
        '/installdate' => [
            'view' => 'backend/installdate.php'
        ],
        "/backend/{$hashedPathId}/login_process" => [
            'view' => "backend/{$hashedPathId}/login_process.php"
        ],
        //资源文件
        '/admin1.css' => [
            'view' => 'frontend/src/css/admin1.css'
        ],
        '/zyb' => [
            'view' => 'zyb/index.php'
        ],
        '/src' => [
            'view' => 'frontend/computer/user/login.php'
        ],
        '/cs' => [
            'view' => 'frontend/cs.php'
        ],
    ],

    // 全局设置
    'settings' => [
        'base_path' => __DIR__ . '/../', // 基础路径
        'default_redirect' => '/index',   // 默认重定向
    ]
];