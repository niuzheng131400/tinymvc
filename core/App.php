<?php

namespace core;

class App
{
    public static function run()
    {
        //启动会话
        session_start();
        // 加载公共函数库
        require __DIR__ . DIRECTORY_SEPARATOR . 'common.php';
        //设置常量
        static::setConst();
        //注册类的自动加载器
        spl_autoload_register([__CLASS__, 'autoload']);
        //路由解析
        [$controller, $action, $params] = Router::parse();
        //view实例
        $path = APP_PATH . DIRECTORY_SEPARATOR . APP_NAME . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;
        $view = new View($path, $controller, $action);
        //实例化控制器
        $controller = 'app\\' . APP_NAME . '\\controller' . DIRECTORY_SEPARATOR . ucfirst($controller) . 'Controller';
        $controller = new $controller($view);
        echo call_user_func_array([$controller, $action], $params);
    }

    private static function setConst()
    {
        //框架核心代码库
        define('CORE_PATH', __DIR__);
        //项目根路径
        define('ROOT_PATH', dirname(__DIR__));
        //应用根路径
        define('APP_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'app');
        //配置文件
        $defaultConfig = ROOT_PATH . DIRECTORY_SEPARATOR . 'config.php';
        $appConfig = APP_PATH . DIRECTORY_SEPARATOR . 'config.php';
        define('CONFIG', require file_exists($appConfig) ? $appConfig : $defaultConfig);
        ini_set('display_errors', CONFIG['app']['debug'] ? 'Off' : 'On');
    }

    private static function autoload($class)
    {
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        file_exists($file) ? require $file : die('class does not exist');
    }

}