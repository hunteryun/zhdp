 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
        <div class="layui-form-item">
                <label class="layui-form-label">作物品种</label>
                <div class="layui-input-block">
                    <input type="text" class="layui-input" name="crop_variety" lay-verify="required" autocomplete="off" placeholder="作物品种">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">种植数量</label>
                <div class="layui-input-block">
                    <input type="text" class="layui-input" name="number_of_plants" lay-verify="required" autocomplete="off" placeholder="种植数量">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">种植时间</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="start_time" name="start_time" lay-verify="required" autocomplete="off" placeholder="种植时间">
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
        //  获取父页面传过来的值
        var crop_traceability_info =  window.parent.edit_crop_traceability_info;
        $('input[name="crop_variety"]').val(crop_traceability_info.crop_variety);
        $('input[name="number_of_plants"]').val(crop_traceability_info.number_of_plants);
        // 
        var laydate = layui.laydate;
        laydate.render({ 
            elem: '#start_time'
            ,value: crop_traceability_info.start_time //必须遵循format参数设定的格式
        });
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "POST",
                url: '{{url("api/user/crop_traceability")}}/' + crop_traceability_info.id,
                data: {
                    '_method': 'PUT',
                    'crop_variety': data.field.crop_variety,
                    'number_of_plants': data.field.number_of_plants,
                    'start_time': data.field.start_time,
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