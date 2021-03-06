 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">区域名称</label>
                <div class="layui-input-inline">
                    <select id="device_region_id" name="device_region_id" lay-verify="required">
                        <option value="">加载区域中...</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">作物种类</label>
                <div class="layui-input-inline">
                    <select id="crop_class_parent_id" name="crop_class_parent_id" lay-verify="required" lay-filter="crop_class_parent_id">
                        <option value="">作物种类加载中...</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">作物名称</label>
                <div class="layui-input-inline">
                    <select id="crop_class_id" name="crop_class_id" lay-verify="required">
                        <option value="">请选择作物种类</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">房间名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="房间名称">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">房间描述</label>
                <div class="layui-input-inline">
                    <textarea type="text" class="layui-textarea" name="desc" placeholder="房间描述"></textarea>
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
     @include('user.public.include_js')
     <script>
        //  获取区域列表
        ajaxLoad = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "GET",
            url: '{{url("api/user/device_region/all")}}',
            success: function(result){
                layer.close(ajaxLoad);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } else {
                    var html='<option value="">请选择区域</option>';
                    $.each(result.data,function(key,value){
                        html+="<option value='"+value.id+"'>"+value.name+"</option>";
                    })
                    $('select[name=device_region_id]').html(html);
                    form.render("select");
                }
            }
        });
        //  获取顶级种植作物列表
        ajaxLoad1 = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "GET",
            url: '{{url("api/user/crop_class/top")}}',
            success: function(result){
                layer.close(ajaxLoad1);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } else {
                    var html='<option value="">请选择种植作物</option>';
                    $.each(result.data,function(key,value){
                        html+="<option value='"+value.id+"'>"+value.name+"</option>";
                    })
                    $('select[name=crop_class_parent_id]').html(html);
                    form.render("select");
                }
            }
        });
        // 获取分类下的种植作物
        form.on('select(crop_class_parent_id)', function(data){
            //  获取种植种类列表
            ajaxLoad2 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/crop_class/top")}}/' + data.value,
                success: function(result){
                    layer.close(ajaxLoad2);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="">请选择种植作物</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=crop_class_id]').html(html);
                        form.render("select");
                    }
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
                url: '{{url("api/user/device_room")}}',
                data: {
                    'device_region_id': data.field.device_region_id,
                    'crop_class_id': data.field.crop_class_id,
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