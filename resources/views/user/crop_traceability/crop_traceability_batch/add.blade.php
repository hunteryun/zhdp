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
                <label class="layui-form-label">收获数量</label>
                <div class="layui-input-block">
                    <input type="text" class="layui-input" name="harvest_quantity" lay-verify="required" autocomplete="off" placeholder="斤/株">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">收获时间</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="end_time" name="end_time" lay-verify="required" autocomplete="off" placeholder="收获时间">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">大棚状态</label>
                <div class="layui-input-inline">
                    <select id="status" name="status" lay-verify="required" lay-filter="status">
                        <option value="0">进行中</option>
                        <option value="1">收获完毕</option>
                    </select> 
                </div>
                <div class="layui-form-mid layui-word-aux">大鹏收获完毕后才可以添加下一季作物</div>
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
         //缓存区域与房间
         var device_region_list;
         //  获取房间列表
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
        //执行一个laydate实例
        var laydate = layui.laydate;
        laydate.render({
            elem: '#end_time' //指定元素
        });
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "POST",
                url: '{{url("api/user/crop_traceability/crop_traceability_batch")}}',
                data: {
                    'device_room_id': data.field.device_room_id,
                    'harvest_quantity': data.field.harvest_quantity,
                    'end_time': data.field.end_time,
                    'status': data.field.status,
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