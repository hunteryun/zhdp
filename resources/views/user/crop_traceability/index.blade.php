 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body>
     <div class="layui-card">
         <div class="layui-card-body">
            <form class="layui-form">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <div class="layui-btn-container">
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-page">刷新页面</button> 
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-crop-traceability">刷新表格</button> 
                            <button type="button" class="layui-btn layui-btn-sm" id="add-crop-traceability">添加作物追溯</button> 
                            <button type="button" class="layui-btn layui-btn-sm" id="add-crop-traceability-event-log">添加作物事件</button> 
                            <button type="button" class="layui-btn layui-btn-sm" id="add-crop-traceability-batch">添加作物收获记录</button> 
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <select name="device_region_id" id="device_region_id" lay-search lay-filter="device_region_id">
                            <option value="" selected>区域:加载中...</option>
                        </select>
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
                    <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table lay-size="sm" id="crop_traceability" lay-filter="crop_traceability"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#crop_traceability'
                ,url: '{{url('api/user/crop_traceability')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'device_room.name', title: '房间', templet : function (d){
                        return d.device_room.name;
                    }}
                    ,{field: 'crop_class.name', title: '作物', templet : function (d){
                        return d.crop_class.name;
                    }}
                    ,{field: 'crop_variety', title: '作物品种'}
                    ,{field: 'number_of_plants', title: '种植数量'}
                    ,{field: 'start_time', title: '种植时间',}
                    ,{field: 'end_time', title: '结束时间',}
                    ,{field: 'status', title: '状态', templet : function (d){
                        return d.status == '0' ? '进行中' : '已完成';
                    }}
                    // ,{field: 'start_time', title: '种植时间', templet : function (d){
                    //     return d.device_room.name;
                    // }}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:180}
                ]]
            });
            table.on('tool(crop_traceability)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/user/crop_traceability")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('crop_traceability');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                } else if(obj.event === 'view'){
                    window.edit_crop_traceability_info = data;
                    layer.open({
                        type:2,
                        title:'查看作物追溯详情',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/crop_traceability/info")}}',
                        end:function(){
                            table.reload('crop_traceability');
                        }
                    });
                } else if(obj.event === 'edit'){
                    window.edit_crop_traceability_info = data;
                    layer.open({
                        type:2,
                        title:'修改作物追溯',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/crop_traceability/edit")}}',
                        end:function(){
                            table.reload('crop_traceability');
                        }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-crop-traceability').click(function(){
                table.reload('crop_traceability');
            });
            // 添加
            $('#add-crop-traceability').click(function(){
                layer.open({
                    type:2,
                    title:'添加作物追溯',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/crop_traceability/add")}}',
                    end:function(){
                        table.reload('crop_traceability');
                    }
                });
            });
            // 添加作物追溯事件
            $('#add-crop-traceability-event-log').click(function(){
                layer.open({
                    type:2,
                    title:'添加作物追溯事件',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/crop_traceability/crop_traceability_event_log/add")}}',
                    end:function(){
                        table.reload('crop_traceability');
                    }
                });
            });
            // crop-traceability-batch
            // 添加作物收获记录
            $('#add-crop-traceability-batch').click(function(){
                layer.open({
                    type:2,
                    title:'添加作物收获记录',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/crop_traceability/crop_traceability_batch/add")}}',
                    end:function(){
                        table.reload('crop_traceability');
                    }
                });
            });
            // 获取区域分类
            ajaxLoad3 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/device_region/all")}}',
                success: function(result){
                    layer.close(ajaxLoad3);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="" selected>区域分类:不限区域</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=device_region_id]').html(html);
                        form.render("select");
                    }
                }
            });
            //监听搜索
            form.on('submit(formSubmit)', function(data) {
                // 重载 table
                table.reload('crop_traceability',{
                    where: {
                        'device_region_id': data.field.device_region_id,
                    }
                });
                return false;
            });
     </script>
 </body>

 </html>