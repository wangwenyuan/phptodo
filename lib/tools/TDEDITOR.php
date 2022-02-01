<?php

/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
class TDEDITOR
{

    public function __construct()
    {}

    public function config()
    {
        if (TDI("get.action") == "config") {
            $config_file = dirname(dirname(__DIR__)) . "/resources/json/editor_config.json";
            $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents($config_file)), true);
            echo json_encode($CONFIG);
        }
    }

    public function uploadimage()
    {
        if (TDI("get.action") == "uploadimage") {
            $upload = new TDUPLOAD();
            $upload->maxSize = TDConfig::$upload["maxSize"];
            $upload->exts = TDConfig::$upload["exts"];
            $upload->rootPath = TDConfig::$upload["rootPath"];
            $info = $upload->uploadOne($_FILES['upfile']);
            if (! $info) {
                var_dump($upload->getError());
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
        }
    }
}