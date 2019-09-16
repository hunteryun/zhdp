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
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-device-region">刷新表格</button> 
                            <button type="button" class="layui-btn layui-btn-sm" id="add-device-region">添加设备</button> 
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
                        <select name="device_room_id" id="device_room_id" lay-search lay-filter="device_room_id">
                            <option value="" selected>房间:请先选择区域.</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="product_id" id="product_id" lay-search>
                            <option value="" selected>产品类型:加载中...</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                            <input type="text" name="name" autocomplete="off" placeholder="设备名称" class="layui-input">
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
                <table lay-size="sm" id="device" lay-filter="device"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#device'
                ,url: '{{url('api/user/device')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '设备名称'}
                    ,{field: 'token', title: 'TOKEN'}
                    ,{field: 'desc', title: '设备描述'}
                    ,{field: 'device_room_name', title: '设备房间', templet : function (d){
                        return d.device_room.name;
                    }}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:180}
                ]]
            });
            table.on('tool(device)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/user/device")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('device');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                } else if(obj.event === 'view'){
                    window.edit_device_info = data;
                    layer.open({
                        type:2,
                        title:'查看设备',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/device/device_field")}}',
                        end:function(){
                            table.reload('device');
                        }
                    });
                } else if(obj.event === 'edit'){
                    window.edit_device_info = data;
                    layer.open({
                        type:2,
                        title:'修改设备',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/device/edit")}}',
                        end:function(){
                            table.reload('device');
                        }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-device-region').click(function(){
                table.reload('device');
            });
            // 添加
            $('#add-device-region').click(function(){
                layer.open({
                    type:2,
                    title:'添加设备',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/device/add")}}',
                    end:function(){
                        table.reload('device');
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
            // 获取产品分类
            ajaxLoad6 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/product/all")}}',
                success: function(result){
                    layer.close(ajaxLoad6);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="" selected>产品分类:不限产品</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=product_id]').html(html);
                        form.render("select");
                    }
                }
            });
            // 监听区域选择
            form.on('select(device_region_id)', function(data){
                ajaxLoad5 = layer.load(1, {
                    shade: [0.8, '#393D49']
                });
                $.ajax({ 
                    type: "GET",
                    url: '{{url("api/user/device_room/all")}}?device_region_id='+data.value,
                    success: function(result){
                        layer.close(ajaxLoad5);
                        if (result.code > 0) {
                            layer.msg(result.msg);
                        } else {
                            var html='<option value="" selected>房间:不限房间</option>';
                            $.each(result.data,function(key,value){
                                html+="<option value='"+value.id+"'>"+value.name+"</option>";
                            })
                            $('select[name=device_room_id]').html(html);
                            form.render("select");
                        }
                    }
                });
            });   
            //监听搜索
            form.on('submit(formSubmit)', function(data) {
                // 重载 table
                table.reload('device',{
                    where: {
                        'device_region_id': data.field.device_region_id,
                        'device_room_id': data.field.device_room_id,
                        'product_id': data.field.product_id,
                        'name': data.field.name,
                    }
                });
                return false;
            });
     </script>
 </body>

 </html>