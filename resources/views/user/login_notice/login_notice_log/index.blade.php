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
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-login_notice_log">刷新表格</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
                </script>
                <table lay-size="sm" id="login_notice_log" lay-filter="login_notice_log"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#login_notice_log'
                ,url: '{{url('api/user/login_notice/login_notice_log')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'title', title: '通知标题', templet : function (d){
                        return d.login_notice.title;
                    }}
                    ,{field: 'type', title: '通知类型', templet : function (d){
                        if(d.login_notice.type == 1){
                            return "只显示一次";
                        }else{
                            return "每天显示";
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
            table.on('tool(login_notice_log)', function(obj){
                var data = obj.data;
                if(obj.event === 'view'){
                    window.login_notice_log_info = data;
                    layer.open({
                        type:2,
                        title:'登陆通知详情',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/login_notice/login_notice_log/info")}}',
                        end:function(){
                            table.reload('login_notice_log');
                        }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-login_notice_log').click(function(){
                table.reload('login_notice_log');
            });
     </script>
 </body>

 </html>