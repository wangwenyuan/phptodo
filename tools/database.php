<?php
/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
require_once dirname(__DIR__) . "/TDConfig.php";
require_once dirname(__DIR__) . "/lib/orm/TDORM.php";
$sql = "SELECT table_name from information_schema.`TABLES` where TABLE_SCHEMA = '" . TDConfig::$db_name . "';";
$list = TDORM()->query($sql);
file_put_contents(TDConfig::$todo_database_orm_path . "_init.php", "<?php" . PHP_EOL);
for ($i = 0; $i < count($list); $i = $i + 1) {
    $table_name = $list[$i]["table_name"];
    $table_name = str_replace(TDConfig::$table_pre, "", $table_name);
    $class_content_before = "<?php" . PHP_EOL . "class " . strtoupper($table_name) . "{" . PHP_EOL;
    $class_content = '	public static $_table_name = "' . $table_name . '";' . PHP_EOL;
    $class_content_after = "};";
    $sql = "SELECT * FROM information_schema.columns where table_schema = '" . TDConfig::$db_name . "' and table_name = '" . TDConfig::$table_pre . $table_name . "'";
    $column_list = TDORM()->query($sql);
    for ($n = 0; $n < count($column_list); $n = $n + 1) {
        foreach ($column_list[$n] as $key => $val) {
            $key = strtolower($key);
            $column_list[$n][$key] = $val;
        }
    }

    for ($n = 0; $n < count($column_list); $n = $n + 1) {
        $class_content = $class_content . '	public static $' . $column_list[$n]["column_name"] . ' = "' . $column_list[$n]["column_name"] . '";' . PHP_EOL;
    }

    $file_content_before = "<?php" . PHP_EOL . "$" . "table_columns = array(" . PHP_EOL;
    $file_content = "";
    $file_content_after = ");";
    $column_data_types = array();
    for ($n = 0; $n < count($column_list); $n = $n + 1) {
        if ($column_list[$n]["extra"] == "auto_increment") {
            continue;
        }
        $data_type = $column_list[$n]["data_type"];
        if (strpos($data_type, "int") === false && strpos($data_type, "decimal") === false && strpos($data_type, "float") === false && strpos($data_type, "double") === false) { // 说明是字符串类型
            if ($column_list[$n]["column_default"] == null) {
                $file_content = $file_content . "    " . '"' . $column_list[$n]["column_name"] . '" => array("' . $data_type . '", "")';
            } else {
                $file_content = $file_content . "    " . '"' . $column_list[$n]["column_name"] . '" => array("' . $data_type . '", "' . $column_list[$n]["column_default"] . '")';
            }
        } else {
            if ($column_list[$n]["column_default"] == null) {
                $file_content = $file_content . "    " . '"' . $column_list[$n]["column_name"] . '" => array("' . $data_type . '", 0)';
            } else {
                $file_content = $file_content . "    " . '"' . $column_list[$n]["column_name"] . '" => array("' . $data_type . '", ' . $column_list[$n]["column_default"] . ')';
            }
        }
        $column_data_types[$column_list[$n]["column_name"]] = $data_type;
        if ($n < count($column_list) - 1) {
            $file_content = $file_content . "," . PHP_EOL;
        } else {
            $file_content = $file_content . PHP_EOL;
        }
    }
    $class_file_content = $class_content_before . $class_content . $class_content_after;
    $data_file_content = $file_content_before . $file_content . $file_content_after;
    file_put_contents(TDConfig::$todo_database_orm_path . $table_name . ".columns.php", $class_file_content);
    file_put_contents(TDConfig::$todo_database_orm_path . $table_name . ".data.php", $data_file_content);
    file_put_contents(TDConfig::$todo_database_orm_path . "_init.php", 'require_once __DIR__ . "/' . $table_name . '.columns.php";' . PHP_EOL, FILE_APPEND);
}

function writeSqlFile($dirPath)
{
    $sql = "SELECT table_name from information_schema.`TABLES` where TABLE_SCHEMA = '" . TDConfig::$db_name . "';";
    $list = TDORM()->query($sql);
    for ($i = 0; $i < count($list); $i = $i + 1) {
        $table_name = $list[$i]["table_name"];
        $table_name = str_replace(TDConfig::$table_pre, "", $table_name);

        $sql = "show create table " . TDConfig::$table_pre . $table_name;
        $table_list = TDORM()->query($sql);
        for ($m = 0; $m < count($table_list); $m = $m + 1) {
            $sql = $table_list[$m]["Create Table"];
            // T.coverFile(save_path + table_name + ".sql", create_table_sql);
            // writeSqlFile(table_name, create_table_sql);
            $database_sql = "";
            $install_sql = "";
            $strings = explode("\n", $sql);
            for ($n = 0; $n < count($strings); $n = $n + 1) {
                $string = $strings[$n];
                if (strpos($string, "ENGINE=InnoDB") !== false) {
                    if (strpos($string, "COMMENT=") !== false || strpos($string, "COMMENT =") !== false) {
                        $strings2 = explode("COMMENT", $string);
                        $database_sql = $database_sql . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT" . $strings2[1];
                    } else {
                        $database_sql = $database_sql . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                    }
                    $install_sql = $install_sql . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                } else {
                    if (strpos($string, "COMMENT") !== false && (! (strpos($string, "COMMENT=") !== false) || ! (strpos($string, "COMMENT =") !== false))) {
                        $database_sql = $database_sql . $string . "\n";
                        $_sStrings = explode("COMMENT", $string);
                        $install_sql = $install_sql . $_sStrings[0] . ",\n";
                    } else {
                        $database_sql = $database_sql . $string . "\n";
                        $install_sql = $install_sql . $string . "\n";
                    }
                }
            }
            file_put_contents($dirPath . "/" . $table_name . ".sql", $install_sql);
        }
    }
}