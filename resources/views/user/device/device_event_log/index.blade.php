 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body class="layui-layout-body">
     <div class="layui-card">
         <div class="layui-card-body">
            <div class="layui-row">
                <div class="layui-btn-container">
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-page">刷新页面</button> 
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-device_event_log-event">刷新表格</button> 
                </div>
            </div>
            <div class="layui-row">
                <table lay-size="sm" id="device_event_log" lay-filter="device_event_log"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#device_event_log'
                ,url: '{{url('api/user/device/device_event_log')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '设备事件日志名称'}
                    ,{field: 'desc', title: '事件描述'}
                    ,{field: 'type', title: '设备事件日志类型', templet : function (d){
                        if(d.type == 0){
                            return "低于阈值";
                        }
                        if(d.type == 1){
                            return "等于阈值";
                        }
                        if(d.type == 2){
                            return "高于阈值";
                        }
                    }}
                    ,{field: 'device.name', title: '触发设备', templet : function (d){
                        return d.device.name;
                    }}
                    ,{field: 'device_field.name', title: '触发字段', templet : function (d){
                        return d.device_field.name;
                    }}
                    ,{field: 'value', title: '触发阈值'}
                    ,{field: 'log_value', title: '记录值'}
                    ,{field: 'associated_device.name', title: '响应设备', templet : function (d){
                        return d.associated_device.name;
                    }}
                    ,{field: 'associated_device_field.name', title: '响应字段', templet : function (d){
                        return d.associated_device_field.name;
                    }}
                    ,{field: 'operation_type', title: '触发操作', templet : function (d){
                        return d.operation_type == 1? '开': '关';
                    }}
                ]]
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-device_event_log-event').click(function(){
                table.reload('device_event_log');
            });
     </script>
 </body>

 </html>