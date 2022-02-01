<?php

/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
class TDVIEW
{

    private $param = array();

    public function assign($name, $val)
    {
        $this->param[$name] = $val;
    }

    public function display($path = "")
    {
        foreach ($this->param as $key => $val) {
            $$key = $val;
        }
        $path_arr = explode("/", trim($path));
        $module = TD_MODULE_NAME;
        $controller = TD_CONTROLLER_NAME;
        $action = TD_ACTION_NAME;
        if ($path != "") {
            if (count($path_arr) == 1) {
                $action = $path_arr[0];
            } else if (count($path_arr) == 2) {
                $controller = $path_arr[0];
                $action = $path_arr[1];
            } else if (count($path_arr) == 3) {
                $module = $path_arr[0];
                $controller = $path_arr[1];
                $action = $path_arr[2];
            }
        }
        $template_file = TDConfig::$app_path . TD_APP_NAME . "/" . $module . "/View/" . $controller . "/" . $action . ".php";
        if (file_exists($template_file)) {
            require_once $template_file;
        } else {
            echo "不存在模版文件：" . $template_file;
        }
    }
}