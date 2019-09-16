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
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-pest-warning">刷新表格</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
                </script>
                <table lay-size="sm" id="pest_warning_log" lay-filter="pest_warning_log"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#pest_warning_log'
                ,url: '{{url('api/user/pest_warning/pest_warning_log')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'title', title: '预警名称', templet : function (d){
                        return d.pest_warning.title
                    }}
                    ,{field: 'type', title: '预警类型', templet : function (d){
                        if(d.pest_warning.type == 0){
                            return "病虫害预警";
                        }else{
                            return "天气预警"
                        }
                    }}
                    ,{field: 'start_time', title: '开始时间', templet : function (d){
                        return d.pest_warning.start_time
                    }}
                    ,{field: 'end_time', title: '结束时间', templet : function (d){
                        return d.pest_warning.end_time
                    }}
                    ,{field: 'warning', title: '预警信息', templet : function (d){
                        return d.pest_warning.warning
                    }}
                    ,{field: 'content', title: '防治措施', templet : function (d){
                        return d.pest_warning.content
                    }}
                    ,{field: 'status', title: '状态', templet : function (d){
                        if(d.status == 0){
                            return "未读";
                        }else{
                            return "已读";
                        }
                    }}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:80}
                ]]
            });
            table.on('tool(pest_warning_log)', function(obj){
                var data = obj.data;
                if(obj.event === 'view'){
                    ajaxLoad2 = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    $.ajax({ 
                        type: "GET",
                        url: '{{url("api/user/pest_warning/pest_warning_log")}}/'+ data.id,
                        success: function(result){
                            layer.close(ajaxLoad2);
                            var resData = result.data;
                            layer.open({
                                title: resData.pest_warning.title,
                                content: "<p>预警信息:"+resData.pest_warning.warning+"</p><p>防治措施:"+resData.pest_warning.content+"</p>",
                                yes: function(index, layero){
                                    layer.close(index); //如果设定了yes回调，需进行手工关闭
                                    table.reload('pest_warning_log');
                                    return false; 
                                },
                                cancel: function(index, layero){ 
                                    layer.close(index);
                                    table.reload('pest_warning_log');
                                    return false; 
                                }    
                            });
                        }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-pest-warning').click(function(){
                table.reload('pest_warning_log');
            });
     </script>
 </body>

 </html>