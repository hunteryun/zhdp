<!DOCTYPE html>
 <html>

 <head>
     @include('admin.public.include_head')
 </head>

 <body class="layui-layout-body" style="padding: 20px; background-color: #F2F2F2;overflow-y: scroll;">

     <div class="layui-card">
        <div class="layui-card-header">设备字段</div>
         <div class="layui-card-body">
            <div class="layui-row">
                <table lay-size="sm" id="device_field" lay-filter="device_field"></table>
            </div>
         </div>
     </div>
     <div class="layui-card">
        <div class="layui-card-header">请求案例</div>
         <div class="layui-card-body">
            <pre class="layui-code" id="request-case-code">
//code...
            </pre>      
         </div>
     </div>
     <div class="layui-card">
        <div class="layui-card-header">返回案例</div>
         <div class="layui-card-body">
            <pre class="layui-code" id="return-case-code">
{
    code: 0,
    msg: '更新成功'
}
            </pre>      
         </div>
     </div>
     @include('admin.public.include_js')
     <script>
         var device_id = window.parent.edit_device_info.id;
            table.render({
                elem: '#device_field'
                ,url: '{{url('api/admin/device/device_field/all')}}?device_id='+device_id
                ,page: false 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '名称'}
                    ,{field: 'field', title: '标识符'}
                    ,{field: 'field_type.name', title: '字段类型', templet : function (d){
                        return d.field_type.name;
                    }}
                    ,{field: 'field_type_length', title: '长度'}
                    ,{field: 'value', title: '值'}
                    ,{field: 'common_field', title: '公共字段'}
                    ,{field: 'common_field_sort', title: '公共字段排序'}
                    ,{field: 'desc', title: '描述'}
                ]]
                ,done : function(request){
                    var data = request.data;
                    var text = "// 请求网址\r\n// {{url('api/admin/device/')}}/" + window.parent.edit_device_info.token + " // 更新标识TOKEN,用于更新指定设备, 必填！";
                        text += "\r\n{\r\n";
                        // text += "&nbsp;&nbsp;&nbsp;&nbsp;token:" + window.parent.edit_device_info.token + ", // 更新标识TOKEN,用于更新指定设备, 必填！ \r\n";
                        text += "&nbsp;&nbsp;&nbsp;&nbsp;data:{\r\n";
                    for(var i in data){
                        text += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{\r\n";
                        text += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;field:" + data[i].field + ", // 待更新的字段\r\n";
                        text += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;value:" + data[i].value + ", // 待更新的值\r\n";
                        text += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;},\r\n";
                    }
                    text += "&nbsp;&nbsp;&nbsp;&nbsp;}\r\n";
                    text += "}";
                    $('#request-case-code').html(text);
                    layui.code({
                        title: 'NotePad++'
                        ,skin: 'notepad' //如果要默认风格，不用设定该key。
                        ,about: false
                    });
                }
            });
     </script>
 </body>

 </html>