<?php

namespace core;

class Controller
{
    protected View $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

}