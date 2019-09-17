 <!DOCTYPE html>
 <html>

 <head>
     @include('admin.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">区域名称</label>
                <div class="layui-input-inline">
                    <select id="device_region_id" name="device_region_id" lay-verify="required" lay-filter="device_region_id">
                        <option value="">加载区域中...</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">房间名称</label>
                <div class="layui-input-inline">
                    <select id="device_room_id" name="device_room_id" lay-verify="required">
                        <option value="">请先选择区域</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">产品名称</label>
                <div class="layui-input-inline">
                    <select id="product_id" name="product_id" lay-verify="required">
                        <option value="">加载产品中...</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">设备名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="设备名称">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">设备描述</label>
                <div class="layui-input-inline">
                    <textarea type="text" class="layui-textarea" name="desc" placeholder="设备描述"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" id="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
                    <button type="reset" id="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
     @include('admin.public.include_js')
     <script>
         //缓存区域与房间
         var device_region_list;
         //  获取房间列表
        ajaxLoad = layer.load(1, {
            shade: [0.8, '#393D49']
        });
         $.ajax({ 
            type: "GET",
            url: '{{url("api/admin/device_region/all")}}',
            success: function(result){
                layer.close(ajaxLoad);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } else {
                    device_region_list = result.data;
                    var html='<option value="">请选择区域</option>';
                    $.each(result.data,function(key,value){
                        html+="<option value='"+value.id+"'>"+value.name+"</option>";
                    });
                    $('select[name=device_region_id]').html(html);
                    form.render("select");
                }
            }
        });
        ajaxLoad1 = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "GET",
            url: '{{url("api/admin/product/all")}}',
            success: function(result){
                layer.close(ajaxLoad1);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } else {
                    var html='<option value="">请选择产品</option>';
                    $.each(result.data,function(key,value){
                        html+="<option value='"+value.id+"'>"+value.name+"</option>";
                    });
                    $('select[name=product_id]').html(html);
                    form.render("select");
                }
            }
        });
        // 监听区域选择
        form.on('select(device_region_id)', function(data){
            $.each(device_region_list,function(key,value){
                if(value.id == data.value){
                    var html='<option value="">请选择房间</option>';
                    $.each(device_region_list[key].device_room,function(k,v){
                        html+="<option value='"+v.id+"'>"+v.name+"</option>";
                    });
                    $('select[name=device_room_id]').html(html);
                    form.render("select");
                    return ;
                }
            });
        });   
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "POST",
                url: '{{url("api/admin/device")}}',
                data: {
                    'product_id': data.field.product_id,
                    'device_region_id': data.field.device_region_id,
                    'device_room_id': data.field.device_room_id,
                    'name': data.field.name,
                    'desc': data.field.desc,
                },
                success: function(result){
                    layer.close(formLoad);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index); //再执行关闭   
                    }
                }
            });
             return false;
         });
     </script>
 </body>

 </html>