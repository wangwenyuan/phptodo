<?php

/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
class TDPAGE
{

    // 总条数
    public $total = 0;

    // 每页条数
    public $listRows = 0;

    // 当前页码
    public $p = 1;

    // 起始条数
    public $firstRow = 0;

    // 总页数
    public $allPageNum = 0;

    public function __construct($total, $size, $param = array())
    {
        $this->total = $total;
        $this->listRows = $size;
        if(count($param) > 0){
            $this->p = (int) $param["p"];
        }else{
            $this->p = (int) $_GET["p"];
        }
        
        if ($this->p == 0 || $this->p == 1) {
            $this->p = 1;
        }
        $this->firstRow = (string) ($this->p - 1) * (string) $this->listRows;
        $this->allPageNum = ceil((string) $total / (string) $this->listRows);
    }
    
    public function show($param = array())
    {
        if(count($param) > 0){
            $arr = $param;
        }else{
            $arr = $_GET;
        }
        $html = "<span>共" . $this->allPageNum . "页，每页" . $this->listRows . "条，当前第" . $this->p . "页</span>";
        if ($this->p == 1) {
            $arr["p"] = ($this->p) + 1;
            if(count($param) > 0){
                $html = $html . "<span>首页</span><span>上一页</span><a href='" . TDUU($arr) . "' >下一页</a>";
            }else{
                $html = $html . "<span>首页</span><span>上一页</span><a href='" . TDU($arr) . "' >下一页</a>";
            }
            $arr["p"] = $this->allPageNum;
            if(count($param) > 0){
                $html = $html . "<a href='" . TDUU($arr) . "' >尾页</a>";
            }else{
                $html = $html . "<a href='" . TDU($arr) . "' >尾页</a>";
            }
        } else if ($this->p == $this->allPageNum) {
            $arr["p"] = 1;
            if(count($param) > 0){
                $html = $html . "<a href='" . TDUU($arr) . "'>首页</a>";
            }else{
                $html = $html . "<a href='" . TDU($arr) . "'>首页</a>";
            }
            $arr["p"] = $this->p - 1;
            if(count($param) > 0){
                $html = $html . "<a href='" . TDUU($arr) . "' >上一页</a><span>下一页</span><span>尾页</span>";
            }else{
                $html = $html . "<a href='" . TDU($arr) . "' >上一页</a><span>下一页</span><span>尾页</span>";
            }
        } else if ($this->p < 1) {
            $html = "";
        } else if ($this->p > $this->allPageNum) {
            $html = "";
        } else {
            if(count($param) > 0){
                $arr["p"] = 1;
                $html = $html . "<a href='" . TDUU($arr) . "' >首页</a>";
                $arr["p"] = $this->p - 1;
                $html = $html . "<a href='" . TDUU($arr) . "' >上一页</a>";
                $arr["p"] = $this->p + 1;
                $html = $html . "<a href='" . TDUU($arr) . "' >下一页</a>";
                $arr["p"] = $this->allPageNum;
                $html = $html . "<a href='" . TDUU($arr) . "' >尾页</a>";
            }else{
                $arr["p"] = 1;
                $html = $html . "<a href='" . TDU($arr) . "' >首页</a>";
                $arr["p"] = $this->p - 1;
                $html = $html . "<a href='" . TDU($arr) . "' >上一页</a>";
                $arr["p"] = $this->p + 1;
                $html = $html . "<a href='" . TDU($arr) . "' >下一页</a>";
                $arr["p"] = $this->allPageNum;
                $html = $html . "<a href='" . TDU($arr) . "' >尾页</a>";
            }
        }
        $gotopage = "<span>转到：<select onchange=\"self.location.href=this.options[this.selectedIndex].value\">";
        for ($i = 0; $i < $this->allPageNum; $i = $i + 1) {
            $arr["p"] = ($i + 1);
            $selected = "";
            if ($this->p == $i + 1) {
                $selected = "selected=\"selected\"";
            } else {
                $selected = "";
            }
            if(count($param) > 0){
                $gotopage = $gotopage . "<option " . $selected . " value=\"" . TDUU($arr) . "\">第 " . ($i + 1) . " 页</option>";
            }else{
                $gotopage = $gotopage . "<option " . $selected . " value=\"" . TDU($arr) . "\">第 " . ($i + 1) . " 页</option>";
            }
        }
        $gotopage = $gotopage . "</select></span>";

        if ($this->total <= $this->listRows) {
            return "";
        } else {
            return "<div>" . $html . $gotopage . "</div>";
        }
    }
}