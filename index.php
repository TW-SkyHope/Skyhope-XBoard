<?php
// 获取请求的URI
$requestUri = $_SERVER['REQUEST_URI'];

// 去除查询字符串（如?foo=bar）
$requestUri = strtok($requestUri, '?');

if ($requestUri === '/') {
    header("Location: /index");
    exit;
}
// 定义路由表
$routes = [
    #替换
    '/index' => 'mainpage',
    '/login' => 'login',
    '/list' => 'vpnlist',
    '/stats' => 'vpntongji',
    '/package' => 'vpnpackage',
    '/help' => 'vpnhelp',
    '/admin/index' => 'admin',
    '/admin/user' => 'aduser',
    '/admin/shop' => 'adshop',
    '/install'=>'install',
    '/zyb'=>'zyb',
    '/src' => 'src' ,// 动态路由示例
];

// 匹配路由

foreach ($routes as $route => $controller) {
    // 将动态路由（如{id}）转换为正则表达式
    $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);
    $pattern = "#^$pattern$#";

    if (preg_match($pattern, $requestUri, $matches)) {
        // 提取动态参数
        array_shift($matches); // 移除完整匹配项
        call_user_func_array($controller, $matches); // 调用控制器并传递参数
        exit;
    }
}

// 如果没有匹配的路由，返回404
header("HTTP/1.0 404 Not Found");
echo '404 - Page not found';

// 示例控制器函数
function mainpage() {
    // 加载并输出 home.php 文件
    renderView('Frontend/dashboard.php');
}


function install() {
    // 加载并输出 home.php 文件
    renderView('install/install.php');
}

function login() {
    // 加载并输出 contact.php 文件
    renderView('Frontend/login.php');
}

function zyb() {
    // 加载并输出 contact.php 文件
    renderView('zyb/index.php');
}


function vpnlist(){
    renderView('Frontend/list.php');
}

function vpnpackage() {
    // 加载并输出 home.php 文件
    renderView('Frontend/package.php');
}

function vpntongji() {
    // 加载并输出 home.php 文件
    renderView('Frontend/stats.php');
}

function vpnhelp() {
    // 加载并输出 home.php 文件
    renderView('Frontend/help.php');
}

function admin() {
    // 加载并输出 home.php 文件
    renderView('admin/index.php');
}

function aduser() {
    // 加载并输出 home.php 文件
    renderView('admin/user.php');
}

function adshop() {
    // 加载并输出 home.php 文件
    renderView('admin/shop.php');
}
function src() {
    // 加载并输出 home.php 文件
    renderView('src/');
}
/**
 * 渲染视图文件
 * @param string $viewFile 视图文件名
 * @param array $data 传递给视图的数据
 */
function renderView($viewFile, $data = []) {
    // 提取数据为变量
    extract($data);

    // 加载视图文件
    if (file_exists($viewFile)) {
        include $viewFile;
    } else {
        echo "Error: View file '$viewFile' not found.";
    }
}
?>