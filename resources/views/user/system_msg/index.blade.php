 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body>
     <div class="layui-card">
         <div class="layui-card-body">
            <div class="layui-row">
                <div class="layui-btn-container">
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-page">刷新页面</button> 
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-system_msg">刷新表格</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
                </script>
                <table lay-size="sm" id="system_msg" lay-filter="system_msg"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#system_msg'
                ,url: '{{url('api/user/system_msg')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'title', title: '通知标题', templet : function (d){
                        return d.title;
                    }}
                    ,{field: 'type', title: '通知类型', templet : function (d){
                        if(d.type == 0){
                            return "天气预警";
                        }else if(d.type == 1){
                            return "病虫害预警";
                        }if(d.type == 2){
                            return "设备预警";
                        }if(d.type == 3){
                            return "文章被回复";
                        }
                    }}
                    ,{field: 'status', title: '查看状态', templet : function (d){
                        if(d.status == 1){
                            return "已读";
                        }else{
                            return "未读";
                        }
                    }}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:80}
                ]]
            });
            table.on('tool(system_msg)', function(obj){
                var data = obj.data;
                if(obj.event === 'view'){
                    window.system_msg_info = data;
                    layer.open({
                        type:2,
                        title:'系统通知详情',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/system_msg/info")}}',
                        end:function(){
                            table.reload('system_msg');
                        }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-system_msg').click(function(){
                table.reload('system_msg');
            });
     </script>
 </body>

 </html>