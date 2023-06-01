<?php

namespace app\index\controller;

class IndexController extends BaseController
{
    public function index()
    {
        $this->view->assign('test', 'aa');
        $this->view->render();
    }
}