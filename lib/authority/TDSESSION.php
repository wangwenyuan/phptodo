<?php
/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
session_start();

function TDSESSION($key = "", $val = " ")
{
    if ($key == null) {
        session_destroy();
    }
    if ($key == "" && $val == " ") {
        return $_SESSION;
    }
    if ($key != null && $key != "" && $val === null) {
        unset($_SESSION[$key]);
        return;
    }
    if ($key != "" && $key != null && $val == " ") {
        return $_SESSION[$key];
    }
    if ($key != "" && $key != null && $val != "" && $val != null) {
        $_SESSION[$key] = $val;
    }
}

function TDCOOKIE($key = "", $val = " ", $expire = "", $path = "", $domain = "")
{
    if ($key == null) {
        session_destroy();
    }
    if ($key == "" && $val == " ") {
        return $_COOKIE;
    }
    if ($key != null && $key != "" && $val === null) {
        setcookie($key, "", time() - 3600);
    }
    if ($key != "" && $key != null && $val == " ") {
        return $_COOKIE[$key];
    }
    if ($key != "" && $key != null && $val != "" && $val != null) {
        setcookie($key, $val, $expire, $path, $domain);
    }
}