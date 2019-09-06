 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">类型名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="类型名称">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">类型长度</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="field_type_length" value="1" lay-verify="required" autocomplete="off" placeholder="类型长度">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">类型默认值</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="default" autocomplete="off" placeholder="类型默认值">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">类型描述</label>
                <div class="layui-input-inline">
                    <textarea type="text" class="layui-textarea" name="desc" placeholder="类型描述"></textarea>
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
        console.log(window.parent.edit_field_type_info);
        var field_type_info =  window.parent.edit_field_type_info;
        //  初始化input
        $("input[name='name']").val(field_type_info.name);
        $("input[name='field_type_length']").val(field_type_info.field_type_length);
        $("input[name='default']").val(field_type_info.default);
        $("textarea[name='desc']").val(field_type_info.desc);
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "POST",
                url: '{{url("api/user/field_type")}}/' + field_type_info.id,
                data: {
                    '_method': 'PUT',
                    'name': data.field.name,
                    'field_type_length': data.field.field_type_length,
                    'default': data.field.default,
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