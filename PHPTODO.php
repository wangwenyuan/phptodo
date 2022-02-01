<?php
/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
define(PHPTODO, true);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    define(TD_IS_POST, true);
    define(TD_IS_GET, false);
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    define(TD_IS_POST, false);
    define(TD_IS_GET, true);
}

define(TD_URL, $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST']);

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

    public static function header()
    {
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . TDConfig::$url . "resources/css/css.css\"/>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/js/jquery-1.12.4.min.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/js/jquery.slimscroll.min.js\"></script>";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . TDConfig::$url . "resources/css/pintuer.css\" />";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/js/jquery.cookie.js\"></script>";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . TDConfig::$url . "resources/css/zTreeStyle/zTreeStyle.css\" />";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/js/jquery.ztree.all.min.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/js/layer.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/js/http.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/js/drop.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/js/js.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/jedate/jquery.jedate.js\"></script>";
        echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"" . TDConfig::$url . "resources/jedate/skin/jedate.css\">";
        echo "<link href=\"" . TDConfig::$url . "resources/ui-c/form/form.css\" rel=\"stylesheet\" type=\"text/css\" />";
        echo "<link href=\"" . TDConfig::$url . "resources/ui-c/form/select.css\" rel=\"stylesheet\" type=\"text/css\" />";
        echo "<link href=\"" . TDConfig::$url . "resources/ui-c/form/radio.css\" rel=\"stylesheet\" type=\"text/css\" />";
        echo "<link href=\"" . TDConfig::$url . "resources/ui-c/form/checkbox.css\" rel=\"stylesheet\" type=\"text/css\" />";
        echo "<link href=\"" . TDConfig::$url . "resources/ui-c/form/open.css\" rel=\"stylesheet\" type=\"text/css\" />";
        echo "<script src=\"" . TDConfig::$url . "resources/ui-c/ui-c.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/ui-c/form/form.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/ui-c/form/select.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/ui-c/form/radio.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/ui-c/form/checkbox.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/ui-c/form/open.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/js/jquery-ui.min.js\"></script>";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . TDConfig::$url . "resources/css/jquery-ui.css\" />";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/editor/ueditor.config.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . TDConfig::$url . "resources/editor/ueditor.all.js\"></script>";
        echo "<script>
		function getObjectURL(file) {
		    var url = null;
		    if (window.createObjectURL != undefined) { // basic
		        url = window.createObjectURL(file);
		    } else if (window.URL != undefined) { // mozilla(firefox)
		        url = window.URL.createObjectURL(file);
		    } else if (window.webkitURL != undefined) { // webkit or chrome
		        url = window.webkitURL.createObjectURL(file);
		    }
		    return url;
		}
		</script>";
    }

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