<?php
declare(strict_types=1);

// 加载独立配置
$cacheConfig = require __DIR__ . '/config/route_cache.php';

// 路由缓存初始化
if ($cacheConfig['enable_route_cache']) {
    static $cachedRoutes = null;
    static $cachedSettings = null;
    
    if ($cachedRoutes === null) {
        $routeConfig = require __DIR__ . '/config/routes.php';
        $cachedSettings = $routeConfig['settings'];
        
        // 预处理路由信息
        $cachedRoutes = [];
        foreach ($routeConfig['routes'] as $route => $config) {
            $cachedRoutes[$route] = [
                'view' => $config['view'],
                'is_dynamic' => strpos($route, '{') !== false,
                'pattern' => $route === '/' ? '/^\/$/' : '#^' . 
                    str_replace(['\{[^}]+\}', '/'], ['([^/]+)', '\/'], $route) . '$#'
            ];
        }
    }
} else {
    $routeConfig = require __DIR__ . '/config/routes.php';
    $cachedSettings = $routeConfig['settings'];
    $cachedRoutes = $routeConfig['routes'];
}

// 请求解析
$requestUri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// 根路径重定向
if ($requestUri === '/') {
    header("Location: " . ($cacheConfig['default_redirect'] ?? $cachedSettings['default_redirect']));
    exit;
}



// 路由匹配
$matchedRoute = null;
$matches = [];

// 静态路由优先匹配
if (isset($cachedRoutes[$requestUri])) {
    $matchedRoute = $cachedRoutes[$requestUri];
} 
// 动态路由匹配
else {
    foreach ($cachedRoutes as $route => $config) {
        if ($config['is_dynamic'] && preg_match($config['pattern'], $requestUri, $matches)) {
            array_shift($matches);
            $matchedRoute = $config;
            break;
        }
    }
}

// 处理匹配结果
if ($matchedRoute) {
    // 准备视图数据
    $data = [
        'params' => $matches,
        'query' => $requestMethod === 'GET' ? $_GET : [],
        'post' => $requestMethod === 'POST' ? $_POST : [],
        'method' => $requestMethod
    ];
    
    // 渲染视图
    extract($data, EXTR_SKIP);
    include $matchedRoute['view'];
    exit;
}

// 404处理
http_response_code(404);
exit('404 - Page not found');