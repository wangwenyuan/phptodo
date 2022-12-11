<?php

/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
function TDU($uri, $param = array())
{
    if (is_string($uri) && trim($uri) != "") {
        $uri_arr = explode("/", $uri);
        if (count($uri_arr) == 3) {
            $param[TDConfig::$todo_pre . "m"] = trim($uri_arr[0]);
            $param[TDConfig::$todo_pre . "c"] = trim($uri_arr[1]);
            $param[TDConfig::$todo_pre . "a"] = trim($uri_arr[2]);
        }
        if (count($uri_arr) == 2) {
            $param[TDConfig::$todo_pre . "c"] = trim($uri_arr[0]);
            $param[TDConfig::$todo_pre . "a"] = trim($uri_arr[1]);
        }
        if (count($uri_arr) == 1) {
            $param[TDConfig::$todo_pre . "a"] = trim($uri_arr[0]);
        }
    }
    if (is_array($uri)) {
        foreach ($uri as $key => $val) {
            $param[$key] = $val;
        }
    }
    $url = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $url_array = explode(".php", $url);
    $url = $url_array[0] . ".php";
    $paramar = "";
    foreach ($param as $key => $val) {
        if ($paramar == "") {
            $paramar = "?" . $key . "=" . $val;
        } else {
            $paramar = $paramar . "&" . $key . "=" . $val;
        }
    }
    $url = $url . $paramar;
    return $url;
}

function TDUU($uri, $param = array(), $entrance = "index.php")
{
    if (is_string($uri) && trim($uri) != "") {
        $uri_arr = explode("/", $uri);
        if (count($uri_arr) == 3) {
            $param[TDConfig::$todo_pre . "m"] = trim($uri_arr[0]);
            $param[TDConfig::$todo_pre . "c"] = trim($uri_arr[1]);
            $param[TDConfig::$todo_pre . "a"] = trim($uri_arr[2]);
        }
        if (count($uri_arr) == 2) {
            $param[TDConfig::$todo_pre . "c"] = trim($uri_arr[0]);
            $param[TDConfig::$todo_pre . "a"] = trim($uri_arr[1]);
        }
        if (count($uri_arr) == 1) {
            $param[TDConfig::$todo_pre . "a"] = trim($uri_arr[0]);
        }
    }
    if (is_array($uri)) {
        foreach ($uri as $key => $val) {
            $param[$key] = $val;
        }
    }
    $url = TD_URL . "/" . $entrance;
    $paramar = "";
    foreach ($param as $key => $val) {
        if ($paramar == "") {
            $paramar = "?" . $key . "=" . $val;
        } else {
            $paramar = $paramar . "&" . $key . "=" . $val;
        }
    }
    $url = $url . $paramar;
    return $url;
}

function TDI($parameter)
{
    $param = explode(".", $parameter);
    if ($param[0] == "get") {
        if (trim($param[1]) == "") {
            $arr = array();
            foreach ($_GET as $key => $val) {
                if ($key == TDConfig::$todo_pre . "m" || $key == TDConfig::$todo_pre . "c" || $key == TDConfig::$todo_pre . "a") {
                    $arr[$key] = $val;
                } else {
                    $arr[$key] = htmlspecialchars($val);
                }
            }
            return $arr;
        } else {
            if (isset($_GET[$param[1]])) {
                return htmlspecialchars($_GET[$param[1]]);
            } else {
                return "";
            }
        }
    }
    if ($param[0] == "post") {
        if (trim($param[1]) == "") {
            $arr = array();
            foreach ($_POST as $key => $val) {
                if ($key == TDConfig::$todo_pre . "m" || $key == TDConfig::$todo_pre . "c" || $key == TDConfig::$todo_pre . "a") {
                    $arr[$key] = $val;
                } else {
                    if (is_array($val)) {
                        $arr[$key] = $val;
                    } else {
                        $arr[$key] = htmlspecialchars($val);
                    }
                }
            }
            return $arr;
        } else {
            if (isset($_POST[$param[1]])) {
                if (is_array($_POST[$param[1]])) {
                    return $_POST[$param[1]];
                } else {
                    return htmlspecialchars($_POST[$param[1]]);
                }
            } else {
                return "";
            }
        }
    }
    if ($param[0] == "request") {
        if (trim($param[1]) == "") {
            $arr = array();
            foreach ($_REQUEST as $key => $val) {
                if ($key == TDConfig::$todo_pre . "m" || $key == TDConfig::$todo_pre . "c" || $key == TDConfig::$todo_pre . "a") {
                    $arr[$key] = $val;
                } else {
                    $arr[$key] = htmlspecialchars($val);
                }
            }
            return $arr;
        } else {
            if (isset($_REQUEST[$param[1]])) {
                return htmlspecialchars($_REQUEST[$param[1]]);
            } else {
                return "";
            }
        }
    }
}

function TDS($name, $val = " ")
{
    if ($name == null || $name == "") {
        return null;
    }
    $name = base64_encode($name);
    if ($val == " ") {
        if (file_exists(TDConfig::$todo_runtime_path . "cache/" . $name)) {
            $content = file_get_contents(TDConfig::$todo_runtime_path . "cache/" . $name);
            return unserialize($content);
        } else {
            return null;
        }
    } else {
        if ($val == null) {
            unlink(TDConfig::$todo_runtime_path . "cache/" . $name);
        } else {
            file_put_contents(TDConfig::$todo_runtime_path . "cache/" . $name, serialize($val));
        }
    }
}

function TDLOG($filename, $data)
{
    $dir = date("Y-m-d", time());
    if (! is_dir(TDConfig::$todo_runtime_path . "log/" . $dir)) {
        mkdir(TDConfig::$todo_runtime_path . "log/" . $dir . "/", 0777, true);
        chmod(TDConfig::$todo_runtime_path . "log/" . $dir . "/", 0777);
    }
    file_put_contents(TDConfig::$todo_runtime_path . "log/" . $dir . '/' . $filename, $data . '---------' . microtime() . '------' . date("Y-m-d H:i:s", time()) . PHP_EOL, FILE_APPEND);
}

function TDHTTP_POST($url, $data, $ssl = null)
{
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
                                                   // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

    if ($ssl != null) {
        $sslCertPath = $ssl["ssl_cert_path"];
        $sslKeyPath = $ssl["ssl_key_path"];
        curl_setopt($curl, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($curl, CURLOPT_SSLCERT, $sslCertPath);
        curl_setopt($curl, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($curl, CURLOPT_SSLKEY, $sslKeyPath);
    }

    $ret = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno' . curl_error($curl); // 捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    return $ret; // 返回数据
}

function TDHTTP_GET($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $ret = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Errno' . curl_error($ch); // 捕抓异常
    }
    curl_close($ch);
    return $ret;
}

function TDTRIM($data)
{
    if (is_array($data)) {
        $arr = array();
        foreach ($data as $k => $v) {
            $arr[trim($k)] = trim($v);
        }
        return $arr;
    } else {
        return trim($data);
    }
}

function TDCHECKPASSWORD($password)
{
    // 需要包含大小写数字特殊字符，且至少要8位
    return preg_match("/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[~!@#$%^&*_.]).{8,}/", $password);
}

function TDCHECKMOBILE($mobile)
{
    return strlen($mobile) == 11 && preg_match("/^((13[0-9]|14[0-9]|15[0-9]|16[0-9]|17[0-9]|18[0-9]|19[0-9])+\\d{8})$/", $mobile);
}

function TDCREATEPASSWORD($password, $salt = "PHPTODO")
{
    return md5(md5($salt) . $password . $salt);
}

function TDREDIRECT($url)
{
    if (! headers_sent()) {
        header('Location: ' . $url);
        exit();
    } else {
        $str = "<meta http-equiv='Refresh' content='URL=" . $url . "'>";
        exit($str);
    }
}

function TDSUCCESS($msg, $url = "")
{
    $arr = array();
    $arr["status"] = 1;
    $arr["info"] = $msg;
    $arr["url"] = $url;
    echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    exit();
}

function TDERROR($msg, $url = "")
{
    $arr = array();
    $arr["status"] = 0;
    $arr["info"] = $msg;
    $arr["url"] = $url;
    echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    exit();
}