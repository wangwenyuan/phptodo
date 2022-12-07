<?php
/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
error_reporting(E_ALL & ~ E_NOTICE & ~ E_WARNING);
define(PHPTODO, true);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    define(TD_IS_POST, true);
    define(TD_IS_GET, false);
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    define(TD_IS_POST, false);
    define(TD_IS_GET, true);
}

$php_self = $_SERVER["PHP_SELF"];
$php_self_arr = explode("/", $php_self);
$TD_ROOT = "";
for ($i = 0; $i < count($php_self_arr) - 1; $i = $i + 1) {
    if ($php_self_arr[$i] == "") {
        continue;
    }
    $TD_ROOT = $TD_ROOT . "/" . $php_self_arr[$i];
}
define(TD_ROOT, $TD_ROOT);

if ($_SERVER["SERVER_PORT"] == 80 || $_SERVER["SERVER_PORT"] == 443) {
    define(TD_URL, $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . TD_ROOT);
} else {
    define(TD_URL, $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . ":" . $_SERVER["SERVER_PORT"] . TD_ROOT);
}

require_once __DIR__ . "/TDConfig.php";
require_once __DIR__ . "/lib/orm/TDORM.php";
if (file_exists(TDConfig::$todo_database_orm_path . "_init.php")) {
    require_once TDConfig::$todo_database_orm_path . "_init.php";
}
require_once __DIR__ . "/lib/authority/TDSESSION.php";
require_once __DIR__ . "/lib/tools/TDTOOLS.php";
require_once __DIR__ . "/lib/tools/TDPAGE.php";
require_once __DIR__ . "/lib/tools/TDVERIFY.php";
require_once __DIR__ . "/lib/tools/TDUPLOAD.php";
require_once __DIR__ . "/lib/tools/TDEDITOR.php";
require_once __DIR__ . "/lib/tools/TDWIDGET.php";
require_once __DIR__ . "/lib/tools/TDVIEW.php";
require_once __DIR__ . "/lib/controller/TDCONTROLLER.php";

class PHPTODO
{

    public static function run($app = "")
    {
        $module = TDI("get." . TDConfig::$todo_pre . "m");
        $controller = TDI("get." . TDConfig::$todo_pre . "c");
        $action = TDI("get." . TDConfig::$todo_pre . "a");
        if ($module == "") {
            $module = "Index";
        }
        if ($controller == "") {
            $controller = "Index";
        }
        if ($action == "") {
            $action = "index";
        }

        define(TD_APP_NAME, $app);
        define(TD_MODULE_NAME, $module);
        define(TD_CONTROLLER_NAME, $controller);
        define(TD_ACTION_NAME, $action);

        $file = "";
        if ($app != "") {
            $file = TDConfig::$app_path . $app . "/" . $module . "/Controller/" . $controller . TDConfig::$controller_suffix . ".php";
        } else {
            $file = TDConfig::$app_path . $module . "/Controller/" . $controller . TDConfig::$controller_suffix . ".php";
        }
        if (file_exists($file)) {
            require_once $file;
            if (class_exists($controller . TDConfig::$controller_suffix, false)) {
                $controller_class_name = $controller . TDConfig::$controller_suffix;
                $controller_object = new $controller_class_name();
                if (method_exists($controller_object, "_td_init")) {
                    $controller_object->_td_init();
                }
                if (method_exists($controller_object, $action)) {
                    $controller_object->$action();
                } else {
                    echo "\"" . $controller . TDConfig::$controller_suffix . "\"类中不存在\"" . $action . "\"方法";
                }
            } else {
                echo "不存在\"" . $controller . TDConfig::$controller_suffix . "\"类";
            }
        } else {
            echo "不存在控制器\"" . $controller . TDConfig::$controller_suffix . "\"";
        }
    }
}