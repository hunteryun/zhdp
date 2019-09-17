 <!DOCTYPE html>
 <html>

 <head>
     @include('admin.public.include_head')
 </head>

 <body>
     <div class="layui-card">
         <div class="layui-card-body">
            <form class="layui-form">
                 <div class="layui-form-item">
                    <div class="layui-inline">
                        <div class="layui-btn-container">
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-page">刷新页面</button> 
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-pest-warning">刷新表格</button> 
                            <button type="button" class="layui-btn layui-btn-sm" id="add-pest-warning">添加病虫害天气预警</button>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <select name="type" id="type" lay-search lay-filter="type">
                            <option value="" selected>预警类型:不限</option>
                            <option value="0" >预警类型:病虫害预警</option>
                            <option value="1" >预警类型:天气预警</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <input type="text" name="title" autocomplete="off" placeholder="预警名称" class="layui-input">
                    </div>
                    <div class="layui-inline">
                        <input type="text" name="warning" autocomplete="off" placeholder="预警信息" class="layui-input">
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                        <button type="submit" id="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">搜索</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table lay-size="sm" id="pest_warning" lay-filter="pest_warning"></table>
            </div>
         </div>
     </div>
     @include('admin.public.include_js')
     <script>
            table.render({
                elem: '#pest_warning'
                ,url: '{{url('api/admin/pest_warning')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'title', title: '预警名称'}
                    ,{field: 'type', title: '预警类型', templet : function (d){
                        if(d.type == 0){
                            return "病虫害预警";
                        }else{
                            return "天气预警"
                        }
                    }}
                    ,{field: 'start_time', title: '开始时间'}
                    ,{field: 'end_time', title: '结束时间'}
                    ,{field: 'warning', title: '预警信息'}
                    ,{field: 'content', title: '防治措施'}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:150}
                ]]
            });
            table.on('tool(pest_warning)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/admin/pest_warning")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('pest_warning');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                } else if(obj.event === 'edit'){
                    window.edit_pest_warning_info = data;
                    layer.open({
                        type:2,
                        title:'修改设备病虫害天气预警',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("admin/pest_warning/edit")}}',
                        end:function(){
                            table.reload('pest_warning');
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
                table.reload('pest_warning');
            });
            // 添加设备
            $('#add-pest-warning').click(function(){
                layer.open({
                    type:2,
                    title:'添加设备病虫害天气预警',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("admin/pest_warning/add")}}',
                    end:function(){
                        table.reload('pest_warning');
                    }
                });
            });
            //监听搜索
            form.on('submit(formSubmit)', function(data) {
                // 重载 table
                table.reload('pest_warning',{
                    where: {
                        'type': data.field.type,
                        'title': data.field.title,
                        'warning': data.field.warning,
                    }
                });
                return false;
            });
     </script>
 </body>

 </html>