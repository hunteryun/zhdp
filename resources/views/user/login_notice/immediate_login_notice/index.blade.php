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
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-login_notice">刷新表格</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
                </script>
                <table lay-size="sm" id="login_notice" lay-filter="login_notice"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#login_notice'
                ,url: '{{url('api/user/login_notice/immediate_login_notice')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'title', title: '通知标题'}
                    ,{field: 'type', title: '通知类型', templet : function (d){
                        if(d.type == 1){
                            return "只显示一次";
                        }else{
                            return "每天显示";
                        }
                    }}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:80}
                ]]
            });
            table.on('tool(login_notice)', function(obj){
                var data = obj.data;
                if(obj.event === 'view'){
                    window.login_notice_info = data;
                    layer.open({
                        type:2,
                        title:'登陆通知详情',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/login_notice/immediate_login_notice/info")}}',
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-login_notice').click(function(){
                table.reload('login_notice');
            });
     </script>
 </body>

 </html>