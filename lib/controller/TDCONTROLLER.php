<?php

class TDCONTROLLER
{

    // 模版加载
    private $view = null;

    public function __construct()
    {
        $this->view = new TDVIEW();
    }

    public function success($msg, $url = "")
    {
        TDSUCCESS($msg, $url);
    }

    public function error($msg, $url = "")
    {
        TDERROR($msg, $url);
    }

    public function assign($name, $val)
    {
        if ($this->view == null) {
            $this->view = new TDVIEW();
        }
        $this->view->assign($name, $val);
    }

    public function display($path = "")
    {
        if ($this->view == null) {
            $this->view = new TDVIEW();
        }
        $this->view->display($path);
    }

    public function page($total, $num)
    {
        return new TDPAGE($total, $num);
    }
}