<?php

/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
class TDConfig
{

    // mysql表示系统使用的是mysql数据库，sqlite表示使用的是sqlite数据库。
    public static $db_type = "mysql";

    public static $db_host = "";

    public static $db_port = "3306";

    public static $db_name = "";

    public static $db_username = "";

    public static $db_password = "";

    public static $table_pre = "";

    // 如果使用的是sqlite数据库，此处填写数据库文件地址，如果是其他数据库请留空
    public static $sqlite_db = "";

    // phptodo中表示模块、控制器、方法的参数的前缀
    public static $todo_pre = "";

    // phptodo中控制器名称的后缀，可以和其他框架的后缀做区别，防止出现类重复定义的情况
    public static $controller_suffix = "TDController";

    // phptodo对数据库的映射文件的存储目录
    public static $todo_database_orm_path = __DIR__ . "/lib/orm/database/";

    // phptodo的runtime存储目录
    public static $todo_runtime_path = __DIR__ . "/runtime/";

    // phptodo应用中的菜单配置项，一般留空即可，在具体项目中配置
    public static $menu = array();

    // phptodo应用的根路径
    public static $app_path = "/";

    public static $upload = array(
        "maxSize" => 5048576,
        "exts" => array(
            'jpg',
            'gif',
            'png',
            'jpeg',
            'xlsx',
            'xls'
        ),
        "rootPath" => "./Uploads/" // 图片保存的根目录
    );

    // phptodo的根目录
    public static $phptodo_url = TD_URL . "/phptodo/";

    // 编辑器对应的控制器链接
    public static $editor_controller = TD_URL . "/phptodo/TDEditor.php";

    // 全局配置
    public static $config = array();

    // 上传的提交链接
    public static $upload_url = TD_URL . "/phptodo/TDUpload.php";
}