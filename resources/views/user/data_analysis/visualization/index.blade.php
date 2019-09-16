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
                        <select name="id" id="id" lay-search lay-filter="id">
                            <option value="" selected>设备:请先选择房间</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="product_id" id="product_id" lay-search>
                            <option value="" selected>产品类型:加载中...</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <button type="submit" id="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">搜索</button>
                            <button type="button" class="layui-btn" id="refresh-page">刷新</button> 
                        </div>
                    </div>
                </div>
            </form>
            <div class="layui-row">
                
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 获取作物分类
            ajaxLoad3 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/crop_class/top")}}',
                success: function(result){
                    layer.close(ajaxLoad3);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="" selected>作物分类:不限作物</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=pid]').html(html);
                        form.render("select");
                    }
                }
            });
            //监听搜索
            form.on('submit(formSubmit)', function(data) {
                // 重载 table
                table.reload('crop_class', {
                    where: {
                        'pid': data.field.pid,
                        'name': data.field.name,
                    }
                });
                return false;
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
            // 监听房间选择
            form.on('select(device_room_id)', function(data){
                ajaxLoad5 = layer.load(1, {
                    shade: [0.8, '#393D49']
                });
                $.ajax({ 
                    type: "GET",
                    url: '{{url("api/user/device/all")}}?device_room_id='+data.value,
                    success: function(result){
                        layer.close(ajaxLoad5);
                        if (result.code > 0) {
                            layer.msg(result.msg);
                        } else {
                            var html='<option value="" selected>设备:不限设备</option>';
                            $.each(result.data,function(key,value){
                                html+="<option value='"+value.id+"'>"+value.name+"</option>";
                            })
                            $('select[name=id]').html(html);
                            form.render("select");
                        }
                    }
                });
            });   
            //监听搜索
            form.on('submit(formSubmit)', function(data) {
                if(!data.field.device_region_id || !data.field.device_room_id){
                    layer.msg("请选择条件后进行查找");
                    return false;
                }
                ajaxLoad10 = layer.load(1, {
                    shade: [0.8, '#393D49']
                });
                $.ajax({ 
                    type: "POST",
                    url: '{{url("api/user/data_analysis/visualization")}}',
                    data: {
                        device_region_id: data.field.device_region_id,
                        device_room_id: data.field.device_room_id,
                        id: data.field.id,
                        product_id: data.field.product_id,
                    },
                    success: function(result){
                        console.log(result);
                        layer.close(ajaxLoad10);
                        if (result.code > 0) {
                            layer.msg(result.msg);
                        } else {
                            var data = result.data;
                            // 渲染
                        }
                    }
                });
                return false;
            });
     </script>
 </body>

 </html>