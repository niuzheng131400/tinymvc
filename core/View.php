<?php

namespace core;

class View
{
    protected string $defaultPath;

    protected string $controller;

    protected string $action;

    protected array $data = [];

    public function __construct(string $defaultPath, string $controller, string $action)
    {
        $this->defaultPath = $defaultPath;
        $this->controller = $controller;
        $this->action = $action;
    }

    public function assign($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }
    }

    public function render(string $path = null, array $data = [])
    {
        $this->data = $data ? array_merge($this->data, $data) : $this->data;
        extract($this->data);
        $file = $this->defaultPath . $this->controller . DIRECTORY_SEPARATOR . $this->action . '.' . CONFIG['app']['default_view_suffix'];
        file_exists($file) ? include $file : die('模板文件不存在');
    }
}