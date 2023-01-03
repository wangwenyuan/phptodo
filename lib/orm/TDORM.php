<?php

/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
function TDORM($table_name = "")
{
    return new TDORM($table_name);
}

class _TDORM
{

    private $table_name = "";

    private $where_sql = "";

    private $order_sql = "";

    private $field_sql = "*";

    private $limit_sql = "";

    private $add_sql = "";

    private $as_sql = "";

    private $join_sql_array = array();

    private $group_sql = "";

    private $sql = "";

    private $bind_value = array();

    public function __construct($table_name = "")
    {
        if ($table_name != "") {
            $this->table_name = TDConfig::$table_pre . $table_name;
        }
    }

    private function dot_to_line($key)
    {
        return str_replace(".", "_", $key);
    }

    public function table($table_name)
    {
        $this->table_name = TDConfig::$table_pre . $table_name;
        return $this;
    }

    public function where($where, $_bind_value = array())
    {
        if (is_array($where)) { // 说明是数组
            foreach ($where as $key => $val) {
                if (is_array($val)) {
                    if (strtolower($val[0]) == "eq" || $val[0] == "=") {
                        if ($this->where_sql == "") {
                            $this->where_sql = " where " . $key . " = :" . $this->dot_to_line($key) . "_where";
                        } else {
                            $this->where_sql = $this->where_sql . " and " . $key . " = :" . $this->dot_to_line($key) . "_where";
                        }
                        $this->bind_value[":" . $this->dot_to_line($key) . "_where"] = $val[1];
                    }
                    if (strtolower($val[0]) == "neq" || $val[0] == "!=" || $val[0] == "<>") {
                        if ($this->where_sql == "") {
                            $this->where_sql = " where " . $key . " != :" . $this->dot_to_line($key) . "_where";
                        } else {
                            $this->where_sql = $this->where_sql . " and " . $key . " != :" . $this->dot_to_line($key) . "_where";
                        }
                        $this->bind_value[":" . $this->dot_to_line($key) . "_where"] = $val[1];
                    }
                    if (strtolower($val[0]) == "gt" || $val[0] == ">") {
                        if ($this->where_sql == "") {
                            $this->where_sql = " where " . $key . " > :" . $this->dot_to_line($key) . "_where";
                        } else {
                            $this->where_sql = $this->where_sql . " and " . $key . " > :" . $this->dot_to_line($key) . "_where";
                        }
                        $this->bind_value[":" . $this->dot_to_line($key) . "_where"] = $val[1];
                    }
                    if (strtolower($val[0]) == "egt" || $val[0] == ">=") {
                        if ($this->where_sql == "") {
                            $this->where_sql = " where " . $key . " >= :" . $this->dot_to_line($key) . "_where";
                        } else {
                            $this->where_sql = $this->where_sql . " and " . $key . " >= :" . $this->dot_to_line($key) . "_where";
                        }
                        $this->bind_value[":" . $this->dot_to_line($key) . "_where"] = $val[1];
                    }
                    if (strtolower($val[0]) == "lt" || $val[0] == "<") {
                        if ($this->where_sql == "") {
                            $this->where_sql = " where " . $key . " < :" . $this->dot_to_line($key) . "_where";
                        } else {
                            $this->where_sql = $this->where_sql . " and " . $key . " < :" . $this->dot_to_line($key) . "_where";
                        }
                        $this->bind_value[":" . $this->dot_to_line($key) . "_where"] = $val[1];
                    }
                    if (strtolower($val[0]) == "elt" || $val[0] == "<=") {
                        if ($this->where_sql == "") {
                            $this->where_sql = " where " . $key . " <= :" . $this->dot_to_line($key) . "_where";
                        } else {
                            $this->where_sql = $this->where_sql . " and " . $key . " <= :" . $this->dot_to_line($key) . "_where";
                        }
                        $this->bind_value[":" . $this->dot_to_line($key) . "_where"] = $val[1];
                    }
                    if (strtolower($val[0]) == "like") {
                        if ($this->where_sql == "") {
                            $this->where_sql = " where " . $key . " like :" . $this->dot_to_line($key) . "_where";
                        } else {
                            $this->where_sql = $this->where_sql . " and " . $key . " like :" . $this->dot_to_line($key) . "_where";
                        }
                        $this->bind_value[":" . $this->dot_to_line($key) . "_where"] = $val[1];
                    }
                    if (strtolower($val[0]) == "between") {
                        if ($this->where_sql == "") {
                            $this->where_sql = " where " . $key . " between :" . $this->dot_to_line($key) . "_where_1 and :" . $this->dot_to_line($key) . "_where_2";
                        } else {
                            $this->where_sql = $this->where_sql . " and " . $key . " between :" . $this->dot_to_line($key) . "_where_1 and :" . $this->dot_to_line($key) . "_where_2";
                        }
                        $this->bind_value[":" . $this->dot_to_line($key) . "_where_1"] = $val[1][0];
                        $this->bind_value[":" . $this->dot_to_line($key) . "_where_2"] = $val[1][1];
                    }
                    if (strtolower($val[0]) == "not between") {
                        if ($this->where_sql == "") {
                            $this->where_sql = " where " . $key . " not between :" . $this->dot_to_line($key) . "_where_1 and :" . $this->dot_to_line($key) . "_where_2";
                        } else {
                            $this->where_sql = $this->where_sql . " and " . $key . " not between :" . $this->dot_to_line($key) . "_where_1 and :" . $this->dot_to_line($key) . "_where_2";
                        }
                        $this->bind_value[":" . $this->dot_to_line($key) . "_where_1"] = $val[1][0];
                        $this->bind_value[":" . $this->dot_to_line($key) . "_where_2"] = $val[1][1];
                    }
                    if (strtolower($val[0]) == "in") {
                        if (count($val[1]) > 0) {
                            if (count($val[1]) == 1) {
                                if ($this->where_sql == "") {
                                    $this->where_sql = " where " . $key . " = :" . $this->dot_to_line($key) . "_where";
                                } else {
                                    $this->where_sql = $this->where_sql . " and " . $key . " = :" . $this->dot_to_line($key) . "_where";
                                }
                                $this->bind_value[":" . $this->dot_to_line($key) . "_where"] = $val[1][0];
                            } else {
                                $_placeholder = ""; // 占位符
                                for ($i = 0; $i < count($val[1]); $i = $i + 1) {
                                    if ($_placeholder == "") {
                                        $_placeholder = ":" . $this->dot_to_line($key) . "_where_" . $i;
                                    } else {
                                        $_placeholder = $_placeholder . ", :" . $this->dot_to_line($key) . "_where_" . $i;
                                    }
                                    $this->bind_value[":" . $this->dot_to_line($key) . "_where_" . $i] = $val[1][$i];
                                }
                                if ($this->where_sql == "") {
                                    $this->where_sql = " where " . $key . " in (" . $_placeholder . ")";
                                } else {
                                    $this->where_sql = $this->where_sql . " and " . $key . " in (" . $_placeholder . ")";
                                }
                            }
                        }
                    }
                    if (strtolower($val[0]) == "not in") {
                        if (count($val[1]) > 0) {
                            if (count($val[1]) == 1) {
                                if ($this->where_sql == "") {
                                    $this->where_sql = " where " . $key . " != :" . $this->dot_to_line($key) . "_where";
                                } else {
                                    $this->where_sql = $this->where_sql . " and " . $key . " != :" . $this->dot_to_line($key) . "_where";
                                }
                                $this->bind_value[":" . $this->dot_to_line($key) . "_where"] = $val[1][0];
                            } else {
                                $_placeholder = ""; // 占位符
                                for ($i = 0; $i < count($val[1]); $i = $i + 1) {
                                    if ($_placeholder == "") {
                                        $_placeholder = ":" . $this->dot_to_line($key) . "_where_" . $i;
                                    } else {
                                        $_placeholder = $_placeholder . ", :" . $this->dot_to_line($key) . "_where_" . $i;
                                    }
                                    $this->bind_value[":" . $this->dot_to_line($key) . "_where_" . $i] = $val[1][$i];
                                }
                                if ($this->where_sql == "") {
                                    $this->where_sql = " where " . $key . " not in (" . $_placeholder . ")";
                                } else {
                                    $this->where_sql = $this->where_sql . " and " . $key . " not in (" . $_placeholder . ")";
                                }
                            }
                        }
                    }
                } else {
                    if (is_string($var)) {
                        if ($this->where_sql == "") {
                            $this->where_sql = " where " . $key . "='" . $val . "'";
                        } else {
                            $this->where_sql = $this->where_sql . " and " . $key . "='" . $val . "'";
                        }
                    } else {
                        if ($this->where_sql == "") {
                            $this->where_sql = " where " . $key . "=" . $val;
                        } else {
                            $this->where_sql = $this->where_sql . " and " . $key . "=" . $val;
                        }
                    }
                }
            }
        } else { // 说明是字符串
            if ($this->$where_sql == "") {
                $this->$where_sql = " where " . $where;
            } else {
                $this->$where_sql = $this->$where_sql . " and " . $where;
            }
            foreach ($_bind_value as $key => $val) {
                $this->bind_value[$key] = $val;
            }
        }
        return $this;
    }

    public function order($order_sql)
    {
        $this->order_sql = " order by " . $order_sql;
        return $this;
    }

    public function limit($limit_sql)
    {
        $this->limit_sql = " limit " . $limit_sql;
        return $this;
    }

    public function data($array)
    {
        $_fields_sql = "";
        $_values_sql = "";
        foreach ($array as $key => $val) {
            if ($_fields_sql == "") {
                $_fields_sql = " `" . $key . "`";
            } else {
                $_fields_sql = $_fields_sql . " , `" . $key . "`";
            }
            if ($_values_sql == "") {
                $_values_sql = " :" . $this->dot_to_line($key) . "_value";
                $this->bind_value[":" . $this->dot_to_line($key) . "_value"] = $val;
            } else {
                $_values_sql = $_values_sql . " , :" . $this->dot_to_line($key) . "_value";
                $this->bind_value[":" . $this->dot_to_line($key) . "_value"] = $val;
            }
        }
        $this->add_sql = " (" . $_fields_sql . ") values (" . $_values_sql . ")";
        return $this;
    }

    public function alias($as)
    {
        $this->as_sql = " as " . $as;
        return $this;
    }

    public function join($join_table, $on_sql, $join_type = "inner")
    {
        $join_table = TDConfig::$table_pre . $join_table;
        $_sql = " " . $join_type . " join " . $join_table . " " . $on_sql;
        array_push($this->join_sql_array, $_sql);
        return $this;
    }

    public function field($field_sql)
    {
        $this->field_sql = " " . $field_sql;
        return $this;
    }

    public function group($fields)
    {
        $this->group_sql = " group by " . $fields;
        return $this;
    }

    public function add()
    {
        $this->sql = "insert into `" . $this->table_name . "`" . $this->add_sql . ";";
        return $this;
    }

    public function save($data)
    {
        $_update_sql = "";
        foreach ($data as $key => $val) {
            if ($_update_sql == "") {
                $_update_sql = "`" . $key . "` = :" . $this->dot_to_line($key) . "_value";
                $this->bind_value[":" . $this->dot_to_line($key) . "_value"] = $val;
            } else {
                $_update_sql = $_update_sql . "," . "`" . $key . "` = :" . $this->dot_to_line($key) . "_value";
                $this->bind_value[":" . $this->dot_to_line($key) . "_value"] = $val;
            }
        }
        $this->sql = "update `" . $this->table_name . "` set " . $_update_sql . $this->where_sql . ";";
        return $this;
    }

    public function delete()
    {
        $this->sql = "delete from `" . $this->table_name . "`" . $this->where_sql . ";";
        return $this;
    }

    public function select()
    {
        $_join_sql = "";
        for ($i = 0; $i < count($this->join_sql_array); $i = $i + 1) {
            $_join_sql = $_join_sql . $this->join_sql_array[$i];
        }
        $this->sql = "select " . $this->field_sql . " from `" . $this->table_name . "`" . $this->as_sql . $_join_sql . $this->where_sql . $this->group_sql . $this->order_sql . $this->limit_sql . ";";
        return $this;
    }

    public function find()
    {
        $_join_sql = "";
        for ($i = 0; $i < count($this->join_sql_array); $i = $i + 1) {
            $_join_sql = $_join_sql . $this->join_sql_array[$i];
        }
        $this->sql = "select " . $this->field_sql . " from `" . $this->table_name . "`" . $this->as_sql . $_join_sql . $this->where_sql . $this->group_sql . $this->order_sql . " limit 1" . ";";
        return $this;
    }

    public function get_sql()
    {
        return $this->sql;
    }

    public function get_bind_value()
    {
        return $this->bind_value;
    }
}

global $TDORMHANDLE;
$TDORMHANDLE = null;

class TDORM
{

    private $table_name = "";

    private $_tdorm = null;

    public function __construct($table_name = "")
    {
        $this->table_name = $table_name;
        $this->_tdorm = new _TDORM($table_name);
        global $TDORMHANDLE;
        if ($TDORMHANDLE == null) {
            $TDORMHANDLE = new PDO("mysql:host=" . TDConfig::$db_host . ";port=" . TDConfig::$db_port . ";dbname=" . TDConfig::$db_name . ";charset=utf8", TDConfig::$db_username, TDConfig::$db_password);
        }
    }

    public function table($table_name)
    {
        $this->table_name = $table_name;
        $this->_tdorm->table($table_name);
        return $this;
    }

    public function where($where, $_bind_value = array())
    {
        $this->_tdorm->where($where, $_bind_value);
        return $this;
    }

    public function order($order_sql)
    {
        $this->_tdorm->order($order_sql);
        return $this;
    }

    public function limit($limit_sql)
    {
        $this->_tdorm->limit($limit_sql);
        return $this;
    }

    public function data($array)
    {
        include TDConfig::$todo_database_orm_path . $this->table_name . ".data.php";
        $array = $this->get_add_row_data($table_columns, $array);
        $this->_tdorm->data($array);
        return $this;
    }

    public function alias($as)
    {
        $this->_tdorm->alias($as);
        return $this;
    }

    public function join($join_table, $on_sql, $join_type = "inner")
    {
        $this->_tdorm->join($join_table, $on_sql, $join_type);
        return $this;
    }

    public function field($field_sql)
    {
        $this->_tdorm->field($field_sql);
        return $this;
    }

    public function group($fields)
    {
        $this->_tdorm->group($fields);
        return $this;
    }

    public function add()
    {
        $this->_tdorm->add();
        $sql = $this->_tdorm->get_sql();
        $bind_value = $this->_tdorm->get_bind_value();
        global $TDORMHANDLE;
        $stmt = $TDORMHANDLE->prepare($sql);
        foreach ($bind_value as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $ret = $stmt->execute();
        $stmt = null;
        if ($ret) {
            return $TDORMHANDLE->lastInsertId();
        } else {
            return false;
        }
    }

    public function save($data)
    {
        include TDConfig::$todo_database_orm_path . $this->table_name . ".data.php";
        $data = $this->get_edit_row_data($table_columns, $data);
        $this->_tdorm->save($data);
        $sql = $this->_tdorm->get_sql();
        $bind_value = $this->_tdorm->get_bind_value();
        global $TDORMHANDLE;
        $stmt = $TDORMHANDLE->prepare($sql);
        foreach ($bind_value as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $ret = $stmt->execute();
        if ($ret) {
            $row_count = $stmt->rowCount();
            $stmt = null;
            return $row_count;
        } else {
            $stmt = null;
            return false;
        }
    }

    public function delete()
    {
        $this->_tdorm->delete();
        $sql = $this->_tdorm->get_sql();
        $bind_value = $this->_tdorm->get_bind_value();
        global $TDORMHANDLE;
        $stmt = $TDORMHANDLE->prepare($sql);
        foreach ($bind_value as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $ret = $stmt->execute();
        if ($ret) {
            $row_count = $stmt->rowCount();
            $stmt = null;
            return $row_count;
        } else {
            $stmt = null;
            return false;
        }
    }

    public function select()
    {
        $this->_tdorm->select();
        $sql = $this->_tdorm->get_sql();
        $bind_value = $this->_tdorm->get_bind_value();
        global $TDORMHANDLE;
        $stmt = $TDORMHANDLE->prepare($sql);
        foreach ($bind_value as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $arr;
    }

    public function find()
    {
        $this->_tdorm->find();
        $sql = $this->_tdorm->get_sql();
        $bind_value = $this->_tdorm->get_bind_value();

        global $TDORMHANDLE;
        $stmt = $TDORMHANDLE->prepare($sql);
        foreach ($bind_value as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        if ($arr == null) {
            return null;
        } else if (count($arr) == 0) {
            return null;
        } else if (count($arr) > 0) {
            return $arr[0];
        } else {
            return null;
        }
    }

    public function count()
    {
        $info = $this->field("count(*) as tdcount")->find();
        if ($info == null) {
            return 0;
        }
        if (isset($info["tdcount"])) {
            return (int) $info["tdcount"];
        } else {
            return 0;
        }
    }

    public function getField($field)
    {
        $info = $this->field($field)->find();
        if ($info == null) {
            return null;
        }
        if (isset($info[$field])) {
            return $info[$field];
        } else {
            return null;
        }
    }

    public function query($sql)
    {
        global $TDORMHANDLE;
        $stmt = $TDORMHANDLE->prepare($sql);
        $stmt->execute();
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $arr;
    }

    public function execute($sql)
    {
        return $this->query($sql);
    }

    public function startTrans()
    {
        global $TDORMHANDLE;
        $TDORMHANDLE->beginTransaction();
    }

    public function commit()
    {
        global $TDORMHANDLE;
        $TDORMHANDLE->commit();
    }

    public function rollback()
    {
        global $TDORMHANDLE;
        $TDORMHANDLE->rollback();
    }

    private function get_add_row_data($table_columns, $data)
    {
        foreach ($data as $k => $v) {
            if (isset($table_columns[$k])) {
                if ($data[$k] !== null) {
                    $data_type = $table_columns[$k][0];
                    if (strpos($data_type, "int") === false && strpos($data_type, "decimal") === false && strpos($data_type, "float") === false && strpos($data_type, "double") === false) { // 说明是字符串类型
                        $table_columns[$k][1] = (string) $data[$k];
                    } else {
                        if (strpos($data_type, "int") !== false) {
                            $table_columns[$k][1] = (int) $data[$k];
                        }
                        if (strpos($data_type, "decimal") !== false) {
                            $table_columns[$k][1] = (float) $data[$k];
                        }
                        if (strpos($data_type, "float") !== false) {
                            $table_columns[$k][1] = (float) $data[$k];
                        }
                        if (strpos($data_type, "double") !== false) {
                            $table_columns[$k][1] = (double) $data[$k];
                        }
                    }
                }
            }
        }
        $ret_arr = array();
        foreach ($table_columns as $k => $v) {
            $ret_arr[$k] = $table_columns[$k][1];
        }
        return $ret_arr;
    }

    private function get_edit_row_data($table_columns, $data)
    {
        $ret_arr = array();
        foreach ($data as $k => $v) {
            if (isset($table_columns[$k])) {
                if ($data[$k] !== null) {
                    $data_type = $table_columns[$k][0];
                    if (strpos($data_type, "int") === false && strpos($data_type, "decimal") === false && strpos($data_type, "float") === false && strpos($data_type, "double") === false) { // 说明是字符串类型
                        $data[$k] = (string) $data[$k];
                    } else {
                        if (strpos($data_type, "int") !== false) {
                            $data[$k] = (int) $data[$k];
                        }
                        if (strpos($data_type, "decimal") !== false) {
                            $data[$k] = (float) $data[$k];
                        }
                        if (strpos($data_type, "float") !== false) {
                            $data[$k] = (float) $data[$k];
                        }
                        if (strpos($data_type, "double") !== false) {
                            $data[$k] = (double) $data[$k];
                        }
                    }
                }
                $ret_arr[$k] = $data[$k];
            }
        }
        return $ret_arr;
    }
}