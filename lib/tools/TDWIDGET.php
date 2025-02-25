<?php

/*
 * PHPTODO
 * Copyright (c) 2022 http://phptodo.cn All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: wangwenyuan <827287829@qq.com>
 */
class TDWIDGET
{

    static function text($name, $value,  $placeholder = '')
    {
        $html = "<div class=\"ui-c-element\"><input type=\"text\" class=\"ui-c-input\" name=\"" . $name . "\" value=\"" . $value . "\" id=\"" . $name . "\"  placeholder=\"".$placeholder."\" /></div>";
        return $html;
    }

    static function password($name, $value,  $placeholder = '')
    {
        $html = "<div class=\"ui-c-element\"><input type=\"password\" class=\"ui-c-input\" name=\"" . $name . "\" value=\"" . $value . "\" id=\"" . $name . "\"  placeholder=\"".$placeholder."\" /></div>";
        return $html;
    }

    static function textarea($name, $value)
    {
        $html = "<div class=\"ui-c-element\"><textarea name=\"" . $name . "\" id=\"" . $name . "\" class=\"input_textarea\">" . $value . "</textarea></div>";
        return $html;
    }

    static function date($name, $value,  $placeholder = '')
    {
        $html = "<input type=\"text\" class=\"ui-c-input\" style=\"width:225px;\" name=\"" . $name . "\" value=\"" . $value . "\" id=\"" . $name . "\"  placeholder=\"".$placeholder."\" />";
        $html = $html . "<script>\r\n" . "    	    $(\"#" . $name . "\").jeDate({\r\n" . "                multiPane:true,\r\n" . "                onClose:false,\r\n" . "                minDate: \"1900-01-01 00:00:00\", //\r\n" . "                maxDate: \"2099-12-31 23:59:59\", //\r\n" . "                format: \"YYYY-MM-DD hh:mm:ss\"\r\n" . "            });\r\n" . "    	</script>";
        return $html;
    }

    static function upload($name, $value)
    {
        $html = "<input type=\"file\" id=\"" . $name . "_phptodo_upload_file\" accept=\"image/*\" multiple style=\"display:none\" />";
        if ($value == "") {
            $html = $html . "<div id=\"" . $name . "_phptodo_upload_file_outerbox\" onclick=\"$('#" . $name . "_phptodo_upload_file').click()\" style=\"width: 100px; height:100px; background: center center no-repeat; background-size: cover; background-image: url(" . TDConfig::$phptodo_url . "resources/images/upload.jpg);\">";
        } else {
            $html = $html . "<div id=\"" . $name . "_phptodo_upload_file_outerbox\" onclick=\"$('#" . $name . "_phptodo_upload_file').click()\" style=\"width: 100px; height:100px; background: center center no-repeat; background-size: cover; background-image: url(" . $value . ");\">";
        }
        $html = $html . "<input type=\"hidden\" name=\"" . $name . "\" id=\"" . $name . "\" value=\"" . $value . "\" />";
        $html = $html . "</div>";
        $html = $html . "<script>
	$(\"#" . $name . "_phptodo_upload_file\").change(function () {
		//创建FormData对象
		var data =new FormData();
		//为FormData对象添加数据
		$.each($('#" . $name . "_phptodo_upload_file')[0].files, function(i, file) {
			data.append('imgFile', file);
		});
	    var objUrl = getObjectURL(this.files[0]);
	    if (objUrl) {
			$.ajax({
				url:\"" . TDConfig::$upload_url . "\",
				type:'post',
				data:data,
				dataType: \"json\",
				cache: false,
				contentType: false,
				processData: false,
				success:function(data){
					$('#" . $name . "').val(data.url);
					$('#" . $name . "_phptodo_upload_file_outerbox').css({'background-image':'url('+data.url+')'});
				},
				error:function(){
					alert('上传出错');
				}
			});
	    }else {
	        alert(\"没有获取到要上传的文件信息\");
	    }
	});
	</script>";
        return $html;
    }

    static function editor($name, $value)
    {
        $html = "<script id=\"" . $name . "\" name=\"" . $name . "\" type=\"text/plain\">\n" . $value . "\n</script>\n";
        $html = $html . "<script type=\"text/javascript\">\nvar ue_" . $name . " = UE.getEditor(\"" . $name . "\", {\n    serverUrl: \"" . TDConfig::$editor_controller . "\"\n});\n</script>";
        return $html;
    }

    static function select($name, $value, $option_map)
    {
        $html = "<div class=\"ui-c-element\"><select class=\"ui-c-select\" id=\"" . $name . "\" name=\"" . $name . "\">";
        foreach ($option_map as $key => $val) {
            if ($key == $value) {
                $html = $html . "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>";
            } else {
                $html = $html . "<option value=\"" . $key . "\">" . $val . "</option>";
            }
        }
        $html = $html . "</select></div>";
        return $html;
    }

    static function date_part($name, $start_datetime, $end_datetime)
    {
        $html = "<input type=\"text\" class=\"ui-c-input\" style=\"width:200px;\" name=\"" . $name . "_1\" value=\"" . $start_datetime . "\" id=\"" . $name . "_1\"  placeholder=\"开始时间\" />-";
        $html = $html . "<input type=\"text\" class=\"ui-c-input\" style=\"width:200px;\" name=\"" . $name . "_2\" value=\"" . $end_datetime . "\" id=\"" . $name . "_2\" placeholder=\"结束时间\" />";
        $html = $html . "<script>\r\n" . "    	    $(\"#" . $name . "_1\").jeDate({\r\n" . "                multiPane:true,\r\n" . "                onClose:false,\r\n" . "                minDate: \"1900-01-01 00:00:00\", //最小日期\r\n" . "                maxDate: \"2099-12-31 23:59:59\", //最大日期\r\n" . "                format: \"YYYY-MM-DD hh:mm:ss\"\r\n" . "            });\r\n" . "            $(\"#" . $name . "_2\").jeDate({\r\n" . "                multiPane:true,\r\n" . "                onClose:false,\r\n" . "                minDate: \"1900-01-01 00:00:00\", //最小日期\r\n" . "                maxDate: \"2099-12-31 23:59:59\", //最大日期\r\n" . "                format: \"YYYY-MM-DD hh:mm:ss\"\r\n" . "            });\r\n" . "    	</script>";
        return $html;
    }

    static function address($province_id, $province_id_val, $city_id, $city_id_val, $area_id, $area_id_val)
    {
        $html = "省份：<select name=\"" . $province_id . "\" id=\"" . $province_id . "\" class=\"input_select\"></select> &nbsp;&nbsp; 城市：<select name=\"" . $city_id . "\" id=\"" . $city_id . "\" class=\"input_select\"></select> &nbsp;&nbsp; 区县：<select name=\"" . $area_id . "\" id=\"" . $area_id . "\" class=\"input_select\"></select>";
        $html = $html . "<script>";
        $html = $html . "phptodo.address.init(\"" . $province_id . "\", \"" . $province_id_val . "\", \"" . $city_id . "\", \"" . $city_id_val . "\", \"" . $area_id . "\", \"" . $area_id_val . "\");";
        $html = $html . "</script>";
        return $html;
    }
    
    // 多选框
    static function checkbox($name, $arr, $val = array())
    {
        $html = '';
        for( $i = 0; $i < count($arr); $i = $i + 1 ){
            $v = $arr[$i];
            if (in_array($v, $val)) {
                $html = $html . '<input class="ui-c-checkbox" type="checkbox" name="'.$name.'[]" title="'.$v.'" checked="checked">';
            } else {
                $html = $html . '<input class="ui-c-checkbox" type="checkbox" name="'.$name.'[]" title="'.$v.'">';
            }
        }
        return $html;
    }
}