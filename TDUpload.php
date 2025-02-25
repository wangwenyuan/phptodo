<?php
/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
exit();
require_once __DIR__ . '/PHPTODO.php';
/**
 * 该文件缺少权限验证，仅仅作为demo提供*
 */
$upload = new TDUPLOAD();
$upload->maxSize = TDConfig::$upload["maxSize"];
$upload->exts = TDConfig::$upload["exts"];
$upload->rootPath = TDConfig::$upload["rootPath"];
$info = $upload->uploadOne($_FILES['imgFile']);
if (! $info) {
    var_dump($upload->getError());
    exit();
} else {
    $_info = array();
    $_info["state"] = "SUCCESS";
    $_info["url"] = TDConfig::$upload["rootPath"] . $info["savepath"] . $info["savename"];
    $_info["title"] = $info["savename"];
    $_info["original"] = $info["name"];
    $_info["type"] = "." . $info["ext"];
    $_info["size"] = $info["size"];
    echo json_encode($_info, JSON_UNESCAPED_UNICODE);
}