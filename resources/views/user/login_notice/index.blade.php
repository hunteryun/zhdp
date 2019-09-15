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
                    <button type="button" class="layui-btn layui-btn-sm" id="add-login_notice">添加登陆通知</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table lay-size="sm" id="login_notice" lay-filter="login_notice"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#login_notice'
                ,url: '{{url('api/user/login_notice')}}' 
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
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:180}
                ]]
            });
            table.on('tool(login_notice)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/user/login_notice")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('login_notice');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                } else if(obj.event === 'view'){
                    window.login_notice_info = data;
                    layer.open({
                        type:2,
                        title:'登陆通知详情',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/login_notice/info")}}',
                    });
                } else if(obj.event === 'edit'){
                    window.edit_login_notice_info = data;
                    layer.open({
                        type:2,
                        title:'修改登陆通知',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/login_notice/edit")}}',
                        end:function(){
                            table.reload('login_notice');
                        }
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
            // 添加
            $('#add-login_notice').click(function(){
                layer.open({
                    type:2,
                    title:'添加登陆通知',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/login_notice/add")}}',
                    end:function(){
                        table.reload('login_notice');
                    }
                });
            });
     </script>
 </body>

 </html>