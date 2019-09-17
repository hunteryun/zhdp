 <!DOCTYPE html>
 <html>

 <head>
     @include('admin.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
            <input type="hidden" name="id">
            <div class="layui-form-item">
                <label class="layui-form-label">管理名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="管理名称">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">管理密码</label>
                <div class="layui-input-inline">
                    <input type="password" class="layui-input" name="password" autocomplete="off" placeholder="管理密码">
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
        // 获取个人信息
        ajaxLoad2 = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "GET",
            url: '{{url("api/admin/my")}}',
            success: function(result){
                layer.close(ajaxLoad2);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } else {
                    console.log(result.data.name);
                    $("input[name='id']").val(result.data.id);
                    $("input[name='name']").val(result.data.name);
                }
            }
        });
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "PUT",
                url: '{{url("api/admin/my")}}/' + data.field.id,
                data: {
                    '_method': 'PUT',
                    'name': data.field.name,
                    'password': data.field.password,
                },
                success: function(result){
                    layer.close(formLoad);
                    layer.msg(result.msg);
                }
            });
             return false;
         });
     </script>
 </body>

 </html>