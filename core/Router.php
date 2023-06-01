<?php

namespace core;

class Router
{
    public static function parse()
    {
        $controller = CONFIG['app']['default_controller'];
        $action = CONFIG['app']['default_action'];
        $params = [];
        if (array_key_exists('PATH_INFO', $_SERVER) &&
            $_SERVER['PATH_INFO'] != '/') {
            $pathInfo = array_values(array_filter(explode('/', $_SERVER['PATH_INFO'])));
            if (count($pathInfo) >= 2) {
                $controller = array_shift($pathInfo);
                $action = array_shift($pathInfo);
                $params = $pathInfo;
            } else {
                $controller = array_shift($pathInfo);
            }
        }
        return [$controller, $action, $params];
    }
}