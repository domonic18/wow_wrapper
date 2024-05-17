<?php

if (version_compare(PHP_VERSION, '5.4.0') < 0) {
    die('[My PHP version('.PHP_VERSION.')] << [APP PHP version(5.4.0)]');
}

require_once ROOT.'api'.DS.'Autoload.php';

Autoload::register(ROOT);

$get = isset($_GET['_url']) ? $_GET['_url'] : false;

\App::$key = 'ffc312f882fbeeb51504483ee8c691a2';

$api = \App::__Init();
// 创建路由规则和对应处理方法的关联数组
$routes = [
    'CharInfo' => 'getCharInfo',
    'CharItem' => 'getCharItem',
    'online_player' => 'getOnlinePlayers',
    'count_online' => 'getCountOnline',
    'recent_ban_list' => 'getRecentBanlist',
    'hardcore_fail' => 'getHardcore_Fail',
    'hardcore_completed_60' => ['method' => 'getHardcore_Completed', 'param' => 60],
    'hardcore_completed_70' => ['method' => 'getHardcore_Completed', 'param' => 70],
    'hardcore_completed_80' => ['method' => 'getHardcore_Completed', 'param' => 80],
    'hardcore_incompleted' => 'getHardcore_Incomplete',
    'top_achievement' => 'getTopAchievementPlayers',
    'recent_achieve' => 'getRecentAchievements',
    'top_honor' => 'getTopHonorPlayers',
    'top_gold' => 'getTopGoldPlayers',
    'top_playtime' => 'getTopPlaytimePlayers',
    'top_mount' => 'getTopMountPlayers'
];

// 检查路由规则并调用相应的处理方法
if (isset($routes[$get])) {
    $route = $routes[$get];

    // 判断路由配置是否包含参数
    if (is_array($route) && isset($route['method'])) {
        $method = $route['method'];
        $param = $route['param'] ?? null;
        $api->$method($param); // 调用方法并传递参数
    } else {
        $api->$route();
    }
} else {
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    exit();
}



