<?php
/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
exit();
require_once 'PHPTODO.php';
/**
 * 该文件缺少权限验证，仅仅作为demo提供*
 */
$editor = new TDEDITOR();
if (TDI("get.action") == "config") {
    $editor->config();
} else if (TDI("get.action") == "uploadimage") {
    $editor->uploadimage();
}
